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
CREATE TRIGGER `after_insert_task` AFTERINSERT ON `task`
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
DELETE FROM currencyType;
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('AED','د.إ','United Arab Emirates dirham','11200',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('AFN','؋','Afghan afghani','100',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('ALL','L','Albanian lek','200',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('AMD','դր.','Armenian dram','7350',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('ANG','ƒ','Netherlands Antillean guilder','9600',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('AOA','Kz','Angolan kwanza','400',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('ARS','$','Argentine peso','550',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('AWG','ƒ','Aruban florin','650',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('AZN','m','Azerbaijani manat','850',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('BAM','KM','Bosnia and Herzegovina convertible mark','1500',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('BBD','$','Barbadian dollar','1050',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('BDT','৳','Bangladeshi taka','1000',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('BGN','лв','Bulgarian lev','1800',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('BHD','.د.ب','Bahraini dinar','950',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('BIF','Fr','Burundian franc','1950',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('BMD','$','Bermudian dollar','1300',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('BND','$','Brunei dollar','9500',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('BOB','Bs.','Bolivian boliviano','1400',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('BRL','R$','Brazilian real','1600',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('BSD','$','Bahamian dollar','900',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('BTN','Nu.','Bhutanese ngultrum','1350',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('BWP','P','Botswana pula','1550',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('BYR','Br','Belarusian ruble','1100',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('BZD','$','Belize dollar','1200',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('CDF','Fr','Congolese franc','2600',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('CHF','Fr','Swiss franc','6200',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('CLP','$','Chilean peso','2350',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('CNY','¥','Chinese yuan','2400',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('COP','$','Colombian peso','2500',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('CRC','₡','Costa Rican colón','2750',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('CUC','$','Cuban convertible peso','2900',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('CVE','?','Cape Verdean escudo','2150',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('CZK','Kč','Czech koruna','3050',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('DJF','Fr','Djiboutian franc','3150',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('DKK','kr','Danish krone','3750',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('DOP','$','Dominican peso','3250',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('DZD','د.ج','Algerian dinar','300',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('EEK','kr','Estonian kroon','3600',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('EGP','ج.م','Egyptian pound','3400',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('ERN','Nfk','Eritrean nakfa','3550',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('ETB','Br','Ethiopian birr','3650',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('FJD','$','Fijian dollar','3800',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('FKP','£','Falkland Islands pound','3700',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('GEL','ლ','Georgian lari','4100',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('GHS','₵','Ghanaian cedi','4200',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('GIP','£','Gibraltar pound','4250',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('GMD','D','Gambian dalasi','4050',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('GNF','Fr','Guinean franc','4500',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('GTQ','Q','Guatemalan quetzal','4400',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('GYD','$','Guyanese dollar','4600',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('HKD','$','Hong Kong dollar','4750',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('HNL','L','Honduran lempira','4700',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('HRK','kn','Croatian kuna','2850',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('HTG','G','Haitian gourde','4650',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('HUF','Ft','Hungarian forint','4800',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('IDR','Rp','Indonesian rupiah','4950',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('ILS','₪','Israeli new sheqel','8200',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('INR','?','Indian rupee','4900',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('IQD','ع.د','Iraqi dinar','5050',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('IRR','﷼','Iranian rial','5000',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('ISK','kr','Icelandic króna','4850',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('JMD','$','Jamaican dollar','5300',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('JOD','د.ا','Jordanian dinar','5450',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('JPY','¥','Japanese yen','5350',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('KES','Sh','Kenyan shilling','5550',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('KGS','лв','Kyrgyzstani som','5850',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('KHR','៛','Cambodian riel','2000',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('KMF','Fr','Comorian franc','2550',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('KPW','₩','North Korean won','5650',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('KRW','₩','South Korean won','5700',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('KWD','د.ك','Kuwaiti dinar','5800',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('KYD','$','Cayman Islands dollar','2200',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('KZT','₸','Kazakhstani tenge','5500',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('LAK','₭','Lao kip','5900',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('LBP','ل.ل','Lebanese pound','6000',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('LKR','Rs','Sri Lankan rupee','10100',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('LRD','$','Liberian dollar','6100',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('LSL','L','Lesotho loti','6050',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('LTL','Lt','Lithuanian litas','6250',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('LVL','Ls','Latvian lats','5950',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('LYD','ل.د','Libyan dinar','6150',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('MAD','د.م.','Moroccan dirham','7250',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('MDL','L','Moldovan leu','7000',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('MGA','Ar','Malagasy ariary','6450',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('MKD','ден','Macedonian denar','6400',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('MMK','K','Myanma kyat','1900',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('MNT','₮','Mongolian tögrög','7100',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('MOP','P','Macanese pataca','6350',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('MRO','UM','Mauritanian ouguiya','6800',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('MUR','₨','Mauritian rupee','6850',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('MVR','ރ.','Maldivian rufiyaa','6600',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('MWK','MK','Malawian kwacha','6500',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('MXN','$','Mexican peso','6900',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('MYR','RM','Malaysian ringgit','6550',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('MZN','MTn','Mozambican metical','7300',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('NAD','$','Namibian dollar','7400',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('NGN','₦','Nigerian naira','7800',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('NIO','C$','Nicaraguan córdoba','7700',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('NOK','kr','Norwegian krone','8000',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('NPR','₨','Nepalese rupee','7500',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('OMR','ر.ع.','Omani rial','8050',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('PAB','B/.','Panamanian balboa','8250',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('PEN','S/.','Peruvian nuevo sol','8400',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('PGK','K','Papua New Guinean kina','8300',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('PHP','₱','Philippine peso','8450',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('PKR','₨','Pakistani rupee','8100',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('PLN','zł','Polish złoty','8550',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('PYG','₲','Paraguayan guaraní','8350',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('QAR','ر.ق','Qatari riyal','8650',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('RON','L','Romanian leu','8700',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('RSD','дин.','Serbian dinar','9350',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('RUB','р.','Russian ruble','10000',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('RWF','Fr','Rwandan franc','8800',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('SAR','ر.س','Saudi riyal','9250',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('SBD','$','Solomon Islands dollar','9750',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('SCR','₨','Seychellois rupee','9400',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('SDG','£','Sudanese pound','10150',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('SEK','kr','Swedish krona','10300',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('SHP','£','Saint Helena pound','8900',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('SLL','Le','Sierra Leonean leone','9450',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('SOS','Sh','Somali shilling','9800',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('SRD','$','Surinamese dollar','10200',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('STD','Db','São Tomé and Príncipe dobra','9200',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('SVC','₡','Salvadoran colón','3450',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('SYP','ل.س','Syrian pound','10400',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('SZL','L','Swazi lilangeni','10250',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('THB','฿','Thai baht','10600',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('TJS','ЅМ','Tajikistani somoni','10500',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('TMM','m','Turkmenistani manat','10950',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('TND','د.ت','Tunisian dinar','10850',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('TOP','T$','Tongan paʻanga','10700',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('TRY','₤','Turkish lira','7900',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('TTD','$','Trinidad and Tobago dollar','10750',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('TWD','$','New Taiwan dollar','10450',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('TZS','Sh','Tanzanian shilling','10550',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('UAH','₴','Ukrainian hryvnia','11150',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('UGX','Sh','Ugandan shilling','11100',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('UYU','$','Uruguayan peso','11350',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('UZS','лв','Uzbekistani som','11400',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('VEF','Bs F','Venezuelan bolívar','11550',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('VND','₫','Vietnamese đồng','11600',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('VUV','Vt','Vanuatu vatu','11450',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('WST','T','Samoan tala','9100',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('XAF','Fr','Central African CFA franc','2050',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('XCD','$','East Caribbean dollar','9050',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('XOF','Fr','West African CFA franc','9300',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('XPF','Fr','CFP franc','7600',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('YER','﷼','Yemeni rial','11750',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('ZAR','R','South African rand','9900',true,2);
INSERT INTO currencyType (currencyTypeID,currencyTypeLabel,currencyTypeName,currencyTypeSeq,currencyTypeActive, numberToBasic) VALUES ('ZMK','ZK','Zambian kwacha','11800',true,2);


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