ALTER TABLE  `projectPerson` ADD  `status` VARCHAR( 255 ) NOT NULL DEFAULT 'ACTIVE';
INSERT INTO `projectStatus` (projectStatusID, projectStatusSeq, projectStatusActive) VALUES ('Deleted',4,false);
INSERT INTO `taskStatus` (taskStatusID, taskStatusLabel, taskStatusColour, taskStatusSeq, taskStatusActive) VALUES ("deleted"  ,"Deleted" ,"#e0e0e0", 95,true);
ALTER TABLE  `task` ADD  `mno_tasklist_id` VARCHAR( 255 ) DEFAULT NULL;

SET @bypass_before_update_task = FALSE;

--
-- CREATE task_assignees
--
CREATE TABLE IF NOT EXISTS `task_assignees` (
  `task_id` int(10) NOT NULL,
  `person_id` int(10) NOT NULL,
  `status` varchar(255) NOT NULL,
  UNIQUE KEY `unique_task_person` (`task_id`,`person_id`)
);

--
-- Triggers `task`
--
DROP TRIGGER IF EXISTS `export_task_assignees_delete`;
DELIMITER //
CREATE TRIGGER `export_task_assignees_delete` AFTER DELETE ON `task`
 FOR EACH ROW BEGIN
    IF EXISTS (SELECT * FROM task_assignees WHERE task_id=OLD.taskID and person_id=OLD.personID) AND (OLD.personID IS NOT NULL) THEN
	BEGIN
	UPDATE task_assignees SET status='INACTIVE' WHERE task_id=OLD.taskID and person_id=OLD.personID;
	END;
    ELSEIF (OLD.personID IS NOT NULL) THEN
	BEGIN
	INSERT INTO task_assignees(task_id, person_id, status) VALUES (OLD.taskID, OLD.personID, 'INACTIVE');
	END;
    END IF;
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `after_insert_task`;
DELIMITER //
CREATE TRIGGER `after_insert_task` AFTER INSERT ON `task`
 FOR EACH ROW BEGIN
    call update_search_index("task",NEW.taskID);
    IF EXISTS (SELECT * FROM task_assignees WHERE task_id=NEW.taskID and person_id=NEW.personID) AND (NEW.personID IS NOT NULL) THEN 
	BEGIN
	UPDATE task_assignees SET status='ACTIVE' WHERE task_id=NEW.taskID and person_id=NEW.personID;
	END;
    ELSEIF (NEW.personID IS NOT NULL) THEN
	BEGIN
	INSERT INTO task_assignees(task_id, person_id, status) VALUES (NEW.taskID, NEW.personID, 'ACTIVE');
	END;
    END IF;
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `after_update_task`;
DELIMITER //
CREATE TRIGGER `after_update_task` AFTER UPDATE ON `task`
 FOR EACH ROW BEGIN
  IF (@bypass_before_update_task = FALSE) THEN 
     BEGIN
  
        call alloc_log("task", OLD.taskID, "taskName",             OLD.taskName,             NEW.taskName);
        call alloc_log("task", OLD.taskID, "taskDescription",      OLD.taskDescription,      NEW.taskDescription);
        call alloc_log("task", OLD.taskID, "priority",             OLD.priority,             NEW.priority);
        call alloc_log("task", OLD.taskID, "timeLimit",            OLD.timeLimit,            NEW.timeLimit);
        call alloc_log("task", OLD.taskID, "timeBest",             OLD.timeBest,             NEW.timeBest);
        call alloc_log("task", OLD.taskID, "timeWorst",            OLD.timeWorst,            NEW.timeWorst);
        call alloc_log("task", OLD.taskID, "timeExpected",         OLD.timeExpected,         NEW.timeExpected);
        call alloc_log("task", OLD.taskID, "dateTargetStart",      OLD.dateTargetStart,      NEW.dateTargetStart);
        call alloc_log("task", OLD.taskID, "dateActualStart",      OLD.dateActualStart,      NEW.dateActualStart);
        call alloc_log("task", OLD.taskID, "projectID",            OLD.projectID,            NEW.projectID);
        call alloc_log("task", OLD.taskID, "parentTaskID",         OLD.parentTaskID,         NEW.parentTaskID);
        call alloc_log("task", OLD.taskID, "taskTypeID",           OLD.taskTypeID,           NEW.taskTypeID);
        call alloc_log("task", OLD.taskID, "personID",             OLD.personID,             NEW.personID);
        call alloc_log("task", OLD.taskID, "managerID",            OLD.managerID,            NEW.managerID);
        call alloc_log("task", OLD.taskID, "estimatorID",          OLD.estimatorID,          NEW.estimatorID);
        call alloc_log("task", OLD.taskID, "duplicateTaskID",      OLD.duplicateTaskID,      NEW.duplicateTaskID);
        call alloc_log("task", OLD.taskID, "dateTargetCompletion", OLD.dateTargetCompletion, NEW.dateTargetCompletion);
        call alloc_log("task", OLD.taskID, "dateActualCompletion", OLD.dateActualCompletion, NEW.dateActualCompletion);
        call alloc_log("task", OLD.taskID, "taskStatus",           OLD.taskStatus,           NEW.taskStatus);
        call update_search_index("task",NEW.taskID);

        IF NOT (NEW.personID <=> OLD.personID) THEN BEGIN
          IF EXISTS (SELECT * FROM task_assignees WHERE task_id=OLD.taskID and person_id=OLD.personID) AND (OLD.personID IS NOT NULL) THEN
              BEGIN
              UPDATE task_assignees SET status='INACTIVE' WHERE task_id=OLD.taskID and person_id=OLD.personID;
              END;
          ELSEIF (OLD.personID IS NOT NULL) THEN
              BEGIN
             INSERT INTO task_assignees(task_id, person_id, status) VALUES (OLD.taskID, OLD.personID, 'INACTIVE');
              END;
          END IF;
          IF EXISTS (SELECT * FROM task_assignees WHERE task_id=NEW.taskID and person_id=NEW.personID) AND (NEW.personID IS NOT NULL) THEN 
              BEGIN
              UPDATE task_assignees SET status='ACTIVE' WHERE task_id=NEW.taskID and person_id=NEW.personID;
              END;
          ELSEIF (NEW.personID IS NOT NULL) THEN
              BEGIN
             INSERT INTO task_assignees(task_id, person_id, status) VALUES (NEW.taskID, NEW.personID, 'ACTIVE');
              END;
          END IF;
        END;
        END IF;
   END;
   END IF;
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `before_update_task`;
DELIMITER //
CREATE TRIGGER `before_update_task` BEFORE UPDATE ON `task`
 FOR EACH ROW BEGIN
  IF (@bypass_before_update_task = FALSE) THEN 
    BEGIN
        call check_edit_task(OLD.projectID);

        IF (neq(@in_change_task_status,1) AND neq(OLD.taskStatus,NEW.taskStatus)) THEN
          call alloc_error('Must use: call change_task_status(taskID,status)');
        END IF;

        SET NEW.taskID = OLD.taskID;
        SET NEW.creatorID = OLD.creatorID;
        SET NEW.dateCreated = OLD.dateCreated;
        SET NEW.taskModifiedUser = personID();

        IF (empty(NEW.taskStatus)) THEN
          SET NEW.taskStatus = OLD.taskStatus;
        END IF;

        IF (empty(NEW.taskStatus)) THEN
          SET NEW.taskStatus = 'open_notstarted';
        END IF;

        IF (NEW.taskStatus = 'open_inprogress' AND neq(NEW.taskStatus, OLD.taskStatus) AND empty(NEW.dateActualStart)) THEN
          SET NEW.dateActualStart = current_date();
        END IF;

        IF ((SUBSTRING(NEW.taskStatus,1,4) = 'open' OR SUBSTRING(NEW.taskStatus,1,4) = 'pend')) THEN
          SET NEW.closerID = NULL;  
          SET NEW.dateClosed = NULL;  
          SET NEW.dateActualCompletion = NULL;  
          SET NEW.duplicateTaskID = NULL;  
        ELSEIF (SUBSTRING(NEW.taskStatus,1,6) = 'closed' AND neq(NEW.taskStatus, OLD.taskStatus)) THEN
          IF (empty(NEW.dateActualStart)) THEN SET NEW.dateActualStart = current_date(); END IF;
          IF (empty(NEW.dateClosed)) THEN SET NEW.dateClosed = current_timestamp(); END IF;
          IF (empty(NEW.closerID)) THEN SET NEW.closerID = personID(); END IF;
          SET NEW.dateActualCompletion = current_date();
        END IF;

        IF (NEW.personID AND neq(NEW.personID, OLD.personID)) THEN
          SET NEW.dateAssigned = current_timestamp();
        ELSEIF (empty(NEW.personID)) THEN
          SET NEW.dateAssigned = NULL;
        END IF;

        IF (NEW.closerID AND neq(NEW.closerID, OLD.closerID)) THEN
          SET NEW.dateClosed = current_timestamp();
        ELSEIF (empty(NEW.closerID)) THEN
          SET NEW.dateClosed = NULL;
        END IF;

        IF ((neq(NEW.timeWorst, OLD.timeWorst) OR neq(NEW.timeBest, OLD.timeBest) OR neq(NEW.timeExpected, OLD.timeExpected))
        AND empty(NEW.estimatorID)) THEN
          SET NEW.estimatorID = personID();
        END IF;

        IF (empty(NEW.timeWorst) AND empty(NEW.timeBest) AND empty(NEW.timeExpected)) THEN
          SET NEW.estimatorID = NULL;
        END IF;
    END;
    END IF;
END
//

--
-- Modify table tf
--
ALTER TABLE tf ADD accountTypeID varchar(255) NOT NULL;
ALTER TABLE tf ADD tfCode varchar(255) NOT NULL;

--
-- Modify table product
--
ALTER TABLE product ADD productTypeID varchar(255) NOT NULL;
ALTER TABLE product ADD productUnit varchar(255) NOT NULL;
ALTER TABLE product ADD productCode varchar(255) NOT NULL;

--
-- Currencies
--
UPDATE currencyType SET currencyTypeActive=true, numberToBasic=2;

--
-- Account
--
UPDATE tf SET accountTypeID = "REVENUE_INCOME_OTHERPRIMARYINCOME", tfName = "AllocPSA Main Funds" WHERE tfName = "Main Funds";
UPDATE tf SET accountTypeID = "REVENUE_INCOME_OTHERPRIMARYINCOME", tfName = "AllocPSA Incoming Funds" WHERE tfName = "Incoming Funds";
UPDATE tf SET accountTypeID = "EXPENSE_EXPENSE_OTHERMISCELLANEOUSSERVICECOST", tfName = "AllocPSA Outgoing Funds" WHERE tfName = "Outgoing Funds";
UPDATE tf SET accountTypeID = "EXPENSE_EXPENSE_OTHERMISCELLANEOUSSERVICECOST", tfName = "AllocPSA Expense Funds" WHERE tfName = "Expense Funds";
UPDATE tf SET accountTypeID = "LIABILITY_OTHERCURRENTLIABILITY_SALESTAXPAYABLE", tfName = "AllocPSA Tax Funds" WHERE tfName = "Tax Funds";
UPDATE tf SET accountTypeID = "REVENUE_INCOME_OTHERPRIMARYINCOME", tfName = "AllocPSA My Funds" WHERE tfName = "My Funds";

--
-- Announcement
--
DELETE FROM announcement WHERE announcementID = 1;