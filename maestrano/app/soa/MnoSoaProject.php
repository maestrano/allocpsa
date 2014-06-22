<?php

/**
 * Mno Organization Class
 */
class MnoSoaProject extends MnoSoaBaseProject
{
    protected $_local_entity_name = "PROJECTS";
    protected $_local_project_id = null;
    protected $_local_project_owner_id = null;
    protected $_mno_tasklist_id = null;
    
    protected function pushProject() 
    {
        // FETCH PROJECT
        $project_query = "SELECT    projectID as id, projectName as name, projectComments as description, UNIX_TIMESTAMP(dateTargetStart) * 1000 AS start_date, 
                                    projectStatus as status, projectPriority as priority, projectCreatedUser AS project_owner, 
                                    UNIX_TIMESTAMP(dateActualCompletion) * 1000 AS completed_date, UNIX_TIMESTAMP(dateTargetCompletion) * 1000 AS due_date
                          FROM      project
                          WHERE     projectID = '$this->_local_project_id'";
        
        $project = $this->_db->query($project_query);
        if (empty($project)) { return null; }
        $project = (object) $this->_db->next_record();
        
        // PUSH PROJECT DETAILS
        $this->_name = $this->push_set_or_delete_value($project->name);
        $this->_description = $this->push_set_or_delete_value($project->description);
        $this->_start_date = $this->push_set_or_delete_value($project->start_date);
        $this->_due_date = $this->push_set_or_delete_value($project->due_date);
        $this->_completed_date = $this->push_set_or_delete_value($project->completed_date);
        $this->_status = $this->map_project_status_to_mno_format($project->status);
        $this->_priority = $this->push_set_or_delete_value($project->priority);
        
        // PUSH PROJECT OWNER
        $mno_project_owner_user_id = MnoSoaDB::getMnoUserIdByLocalUserId($project->project_owner);
        if (!empty($mno_project_owner_user_id)) { $this->_project_owner = $mno_project_owner_user_id; }
        
        $mno_project_id_obj = MnoSoaDB::getMnoIdByLocalId($this->_local_project_id, "PROJECTS", "PROJECTS");
        $this->_id = (MnoSoaDB::isValidIdentifier($mno_project_id_obj)) ? $mno_project_id_obj->_id : null;
        
        MnoSoaLogger::debug("project=".json_encode($project));
        
        return $this->_id;
    }
    
    protected function pullProject() 
    {
        // INSTANTIATE LOCAL PROJECT OBJECT
        $local_project_obj = new project();
        $local_project_obj->push_to_maestrano = false;        
        
        $local_project_id_obj = MnoSoaDB::getLocalIdByMnoId($this->_id, $this->getMnoEntityName(), $this->getLocalEntityName());
        $name = $this->pull_set_or_delete_value($this->_name);
        $description = $this->pull_set_or_delete_value($this->_description);
        $start_date = $this->map_date_to_local_format($this->_start_date);
        $due_date = $this->map_date_to_local_format($this->_date_date);
        $completed_date = $this->map_date_to_local_format($this->_completed_date);
        $status = $this->map_project_status_to_local_format($this->_status);
        $priority = $this->pull_set_or_delete_value($this->_priority);
        $format_priority = (empty($priority)) ? "'3'" : "'$priority'";
        
        MnoSoaLogger::debug("before project owner");
        
        // PULL PROJECT OWNER
        $this->_local_project_owner_id = $local_project_owner_id = 0;
        if (!empty($this->_project_owner)) {
            $local_project_owner_id = MnoSoaDB::getLocalUserIdByMnoUserId($this->_project_owner);
            MnoSoaLogger::debug("local_project_owner=" . $local_project_owner_id);
            $this->_local_project_owner_id = (!empty($local_project_owner_id)) ? $local_project_owner_id : 0;
        }
        
        // PERSIST PROJECT
        if (MnoSoaDB::isValidIdentifier($local_project_id_obj)) {
            $this->_local_project_id = $local_project_id_obj->_id;
            $project_query = 
                    "UPDATE project "
                  . "SET projectName='$name', projectComments='$description', ";
            if (empty($start_date)) { $project_query .= "dateTargetStart=null, "; } else { $project_query .= "dateTargetStart=FROM_UNIXTIME('$start_date'), "; }
            $project_query .= "projectStatus='$status', "
                  . "projectPriority=$format_priority, projectCreatedUser='$local_project_owner_id', ";
            if (empty($completed_date)) { $project_query .= "dateActualCompletion=null, "; } else { $project_query .= "dateActualCompletion=FROM_UNIXTIME('$completed_date'), "; }
            if (empty($due_date)) { $project_query .= "dateTargetCompletion=null "; } else { $project_query .= "dateTargetCompletion=FROM_UNIXTIME('$due_date') "; }
            $project_query .= "WHERE projectID='$this->_local_project_id'";
            $this->_db->query($project_query);
        } else if (MnoSoaDB::isNewIdentifier($local_project_id_obj)) {
            $format_start_date = (empty($start_date)) ? "null" : "FROM_UNIXTIME('$start_date')";
            $format_completed_date = (empty($completed_date)) ? "null" : "FROM_UNIXTIME('$completed_date')";
            $format_due_date = (empty($due_date)) ? "null" : "FROM_UNIXTIME('$due_date')";
            $project_query = 
                    "INSERT INTO project (projectName, projectComments, dateTargetStart, projectStatus, projectPriority, projectCreatedUser, dateActualCompletion, dateTargetCompletion, currencyTypeID, projectType) "
                  . "VALUES "
                  . "('$name', '$description', $format_start_date, '$status', $format_priority, '$local_project_owner_id', $format_completed_date, $format_due_date, 'USD', 'Project')";
            MnoSoaLogger::debug("project_query=".$project_query);
            $this->_db->query($project_query);
            $this->_local_project_id = $this->_db->get_insert_id();
            MnoSoaDB::addIdMapEntry($this->_local_project_id, $this->getLocalEntityName(), $this->_id, $this->getMnoEntityName());
        }
        
        return true;
    }
    
    protected function pushStakeholders() 
    {       
        $assigned_query =   "SELECT     personID as id, status
                             FROM       projectPerson
                             WHERE      projectID = '$this->_local_project_id' 
                             ORDER BY   projectPersonID ASC ";
        MnoSoaLogger::debug("sql=".$assigned_query);
        
        $local_stakeholders = $this->_db->query($assigned_query);
        if (empty($local_stakeholders)) { return null; }
        
        while ($local_stakeholder = $this->_db->next_record()) {
            MnoSoaLogger::debug("local_stakeholder=".json_encode($local_stakeholder));
            $mno_stakeholder_id = MnoSoaDB::getMnoUserIdByLocalUserId($local_stakeholder['id']);
            $mno_stakholder_status = $this->pull_set_or_delete_value($local_stakeholder['status']);
            if (empty($mno_stakeholder_id) || $mno_stakholder_status === null) { continue; }
            $mno_stakeholders->{$mno_stakeholder_id} = $mno_stakholder_status;
        }
        
        $this->_stakeholders = (!empty($mno_stakeholders)) ? $mno_stakeholders : null;
        
        if (empty($this->_stakeholders)) { return null; }
        
        return true;
    }
    
    protected function pullStakeholders() 
    {    
        // UPSERT STAKEHOLDERS
        if (!empty($this->_stakeholders)) {
            foreach ($this->_stakeholders as $mno_stakeholder_id => $mno_stakeholder_status) {
                $local_stakeholder_id = MnoSoaDB::getLocalUserIdByMnoUserId($mno_stakeholder_id);
                $local_stakeholder_status = $this->pull_set_or_delete_value($mno_stakeholder_status);
                if (empty($local_stakeholder_id) || $local_stakeholder_status===null) { continue; }
                
                $select_assigned_query = "SELECT * FROM projectPerson WHERE projectID='{$this->_local_project_id}' and personID='{$local_stakeholder_id}'";
                $result_select_assigned_query = $this->_db->query($select_assigned_query);
                $num_rows = $this->_db->num_rows($result_select_assigned_query);
                
                if ($num_rows >= 1) {
                    $update_assigned_query = "      UPDATE  projectPerson 
                                                    SET     status='{$local_stakeholder_status}' 
                                                    WHERE   projectID='{$this->_local_project_id}' 
                                                            AND personID='{$local_stakeholder_id}' ";
                    $this->_db->query($update_assigned_query);
                    $select_assigned_query = "
                                                    SELECT  max(projectPersonID) as maxppid
                                                    FROM    projectPerson
                                                    WHERE   projectID='{$this->_local_project_id}' 
                                                            AND personID='{$local_stakeholder_id}' 
                                             ";
                    $max_project_person_id_result = $this->_db->query($select_assigned_query);
                    if (empty($max_project_person_id_result)) { continue; }
                    $max_project_person_id_record = (object) $this->_db->next_record();
                    if (empty($max_project_person_id_result->maxppid)) { continue; }
                    
                    $delete_assigned_query = "DELETE FROM projectPerson WHERE projectPersonID = '{$max_project_person_id_result->maxppid}'";
                    $this->_db->query($delete_assigned_query);
                } else {
                    $insert_assigned_query = "INSERT INTO projectPerson(projectID, personID, roleID, status) VALUES ('{$this->_local_project_id}', '{$local_stakeholder_id}', '1', '{$local_stakeholder_status}')";
                    $this->_db->query($insert_assigned_query);
                }
            }
        }
    }
    
    protected function pushMilestones() 
    {      
        // DO NOTHING
    }
    
    protected function pullMilestones() 
    {
        // DO NOTHING
    }
    
    protected function pushTasklists() 
    {
        $mno_tasklist_id = MnoSoaDB::getLocalIdByMnoId($this->_local_project_id, "TASKLISTS", "TASKLISTS");
        if (!MnoSoaDB::isNewIdentifier($mno_tasklist_id)) { $this->_mno_tasklist_id = $mno_tasklist_id->_id; return; }
        $mno_tasklist_id = MnoSoaDB::getOrCreateMnoId($this->_local_project_id, "TASKLISTS", "TASKLISTS");
        if (!MnoSoaDB::isValidIdentifier($mno_tasklist_id)) { return; }
        $mno_tasklist_id = $mno_tasklist_id->_id;
        $mno_tasklist_name = "General";
        $mno_tasklist_start_date = (string) (time() * 1000);
        
        $mno_tasklist->name = $this->push_set_or_delete_value($mno_tasklist_name);
        $mno_tasklist->description = "Auto generated default tasklist";
        $mno_tasklist->startDate = $this->push_set_or_delete_value($mno_tasklist_start_date);
        $mno_tasklist->status = "INPROGRESS";
        
        $mno_tasklists->{$mno_tasklist_id} = $mno_tasklist;
        
        $this->_mno_tasklist_id = $mno_tasklist_id;
        
        $this->_tasklists = $mno_tasklists;
    }
    
    protected function pullTasklists() 
    {
        // DO NOTHING
    }
    
    protected function pushTasks() 
    {
        $tasks_query =  "
                        SELECT     taskID as id,taskName as name,taskDescription as description,UNIX_TIMESTAMP(dateTargetStart) * 1000 as start_date, 
                                    UNIX_TIMESTAMP(dateTargetCompletion) * 1000 as due_date, mno_tasklist_id, 
                                    taskStatus as status,UNIX_TIMESTAMP(dateActualCompletion) * 1000 AS completed_date, personID 
                        FROM task 
                        WHERE projectID = '$this->_local_project_id' ";
        $this->_db->query($tasks_query);

        while ($local_task = $this->_db->next_record()) {
            MnoSoaLogger::debug("local_task=" . json_encode($local_task));
            
            // TRANSLATE TASK LOCAL ID TO MNO ID
            $local_task_id = $local_task['id'];
            MnoSoaLogger::debug("local_task_id=".$local_task_id);
            $local_task_id_obj = MnoSoaDB::getMnoIdByLocalId($local_task_id, "TASKS", "TASKS");
            $is_new_task = (MnoSoaDB::isNewIdentifier($local_task_id_obj)) ? true : false;
            $mno_task_id = MnoSoaDB::getOrCreateMnoId($local_task_id, "TASKS", "TASKS");
            if (!MnoSoaDB::isValidIdentifier($mno_task_id)) { continue; }
            $mno_task_id = $mno_task_id->_id;
            
            $mno_task = (object) array();
            $mno_task->name = $this->push_set_or_delete_value($local_task['name']);
            $mno_task->description = $this->push_set_or_delete_value($local_task['description']);
            $mno_task->startDate = $this->push_set_or_delete_value($local_task['start_date']);
            $mno_task->dueDate = $this->push_set_or_delete_value($local_task['due_date']);
            $mno_task->completedDate = $this->push_set_or_delete_value($local_task['completed_date']);
            $mno_task->status = $this->map_task_status_to_mno_format($local_task['status']);
            
            if (empty($local_task['mno_tasklist_id'])) {
                $this->pushTasklists();
                $mno_task->tasklist = $this->push_set_or_delete_value($this->_mno_tasklist_id);
            } else {
                $mno_task->tasklist = $this->push_set_or_delete_value($local_task['mno_tasklist_id']);
            }
            
            
            if ($is_new_task) {
                $mno_task->tasklist = $this->push_set_or_delete_value($this->_mno_tasklist_id);
            }
            
            // FETCH ASSIGNEES
            $db = new db_alloc();
            $tasks_assignees_query = "SELECT task_id, person_id, status FROM task_assignees WHERE task_id='$local_task_id'";
            $db->query($tasks_assignees_query);
            
            MnoSoaLogger::debug("tasks_assignees_query=" . json_encode($tasks_assignees_query));
            
            $mno_task_assignees = null;
            
            while ($local_task_assignee = $db->next_record()) {
                $mno_task_assignee = MnoSoaDB::getMnoUserIdByLocalUserId($local_task_assignee['person_id']);
                MnoSoaLogger::debug("local_task_assignee['person_id']=" . $local_task_assignee['person_id'] . " mno_task_assignee=".$mno_task_assignee);
                if (empty($mno_task_assignee)) { continue; }
                $mno_task_assignees->{$mno_task_assignee} = $local_task_assignee['status'];
            }
            
            if (!empty($mno_task_assignees)) {
                $mno_task->assignedTo = $mno_task_assignees;
            } else {
                continue;
            }
            
            MnoSoaLogger::debug("mno_tasks=" . json_encode($mno_tasks));
            
            $mno_tasks->{$mno_task_id} = $mno_task;
        }
        
        $this->_tasks = $mno_tasks;
    }
    
    protected function pullTasks() 
    {
        // UPSERT TASKS
        if (!empty($this->_tasks)) {
            foreach($this->_tasks as $mno_task_id => $task) {
                $local_task_id_obj = MnoSoaDB::getLocalIdByMnoId($mno_task_id, "TASKS", "TASKS");
                $local_task_id = null;
                
                $name = $this->pull_set_or_delete_value($task->name);
                $description = $this->pull_set_or_delete_value($task->description);
                $start_date = $this->map_date_to_local_format($task->startDate);
                $due_date = $this->map_date_to_local_format($task->dueDate);
                $completed_date = $this->map_date_to_local_format($task->completedDate);
                $mno_tasklist_id = $this->pull_set_or_delete_value($task->tasklist);
                
                MnoSoaLogger::debug("after assigning");
                
                if (MnoSoaDB::isValidIdentifier($local_task_id_obj)) {
                    MnoSoaLogger::debug("isValidIdentifier");
                    $local_task_id = $local_task_id_obj->_id;
                    $mno_assignedTo_user_id = $this->map_entity_assignees_to_local_single_entity_assignee($task, $local_task_id, "task_assignees", "task_id", "person_id");
                    $local_assignedTo_user_id = MnoSoaDB::getLocalUserIdByMnoUserId($mno_assignedTo_user_id);
                    if (empty($local_assignedTo_user_id)) { continue; }
                    
                    MnoSoaLogger::debug("before select query");
                    
                    $this->_db->query("SELECT taskStatus FROM task WHERE taskID='$local_task_id'");
                    $current_local_task_status = $this->_db->next_record();
                    
                    $status = $this->map_task_status_to_local_format(
                                        $task->status, 
                                        (!empty($current_local_task_status['taskStatus'])) ? $current_local_task_status['taskStatus'] : null
                              );
                    
                    MnoSoaLogger::debug("before update query");
                    
                    $this->_db->query("SET @bypass_before_update_task = TRUE;");
                    
                    $tasks_query = "UPDATE  task 
                                    SET     taskName='$name', taskDescription='$description', dateTargetStart=FROM_UNIXTIME('$start_date'), dateTargetCompletion=FROM_UNIXTIME('$due_date'), 
                                            taskStatus='$status', personID='$local_assignedTo_user_id', dateActualCompletion=FROM_UNIXTIME('$completed_date'), mno_tasklist_id='$mno_tasklist_id', 
                                            projectID='{$this->_local_project_id}'
                                    WHERE   taskID='$local_task_id'";
                    
                    MnoSoaLogger::debug("prior to query execution");
                    
                    $this->_db->query($tasks_query);
                    
                    $this->_db->query("SET @bypass_before_update_task = FALSE;");
                    
                    MnoSoaLogger::debug("after query execution");
                } else if (MnoSoaDB::isNewIdentifier($local_task_id_obj)) {
                    MnoSoaLogger::debug("isNewIdentifier");
                    $status = $this->map_task_status_to_local_format($task->status, null);
                    $mno_assignedTo_user_id = $this->find_first_active_mno_entity_assignee($task);
                    $local_assignedTo_user_id = MnoSoaDB::getLocalUserIdByMnoUserId($mno_assignedTo_user_id);
                    if (empty($local_assignedTo_user_id)) { continue; }
                    
                    $tasks_query = "INSERT INTO task 
                                    (taskName,taskDescription,dateTargetStart,dateTargetCompletion,taskStatus,personID,dateActualCompletion,mno_tasklist_id,projectID,priority) 
                                    VALUES 
                                    ('$name', '$description', FROM_UNIXTIME('$start_date'), FROM_UNIXTIME('$due_date'), '$status', 
                                     '$local_assignedTo_user_id', FROM_UNIXTIME('$completed_date'), '$mno_tasklist_id', '{$this->_local_project_id}', '3')";
                    
                    $this->_db->query($tasks_query);
                    $local_task_id = $this->_db->get_insert_id();
                    MnoSoaDB::addIdMapEntry($local_task_id, "TASKS", $mno_task_id, "TASKS");
                }
                
                $this->map_assignees_to_local_table($task, $local_task_id, "task_assignees", "task_id", "person_id");
            }
        }
    }
    
    protected function map_entity_assignees_to_local_single_entity_assignee($entity, $local_entity_id, $table_name, $local_entity_id_name, $local_user_id_name)
    {
        $assignees_query =  "SELECT $local_user_id_name "
                          . "FROM $table_name "
                          . "WHERE $local_entity_id_name = '$local_entity_id'";
        
        $this->_db->query($assignees_query);
        $local_assignee = $this->_db->next_record();
        
        $mno_user_id = MnoSoaDB::getMnoUserIdByLocalUserId($local_assignee[$local_user_id_name]);
        
        if (empty($entity->assignedTo)) { return null; }
        if (empty($mno_user_id)) { return $this->find_first_active_mno_entity_assignee($entity); }
        if (empty($entity->assignedTo->{$mno_user_id})) { return null; }
        if ($entity->assignedTo->{$mno_user_id} == 'ACTIVE') { return $mno_user_id; }

        return $this->find_first_active_mno_entity_assignee($entity);
    }
    
    protected function find_first_active_mno_entity_assignee($entity) {
        if (empty($entity->assignedTo)) { return null; }
        $assignedTo = $entity->assignedTo;
        
        foreach ($assignedTo as $mno_assignee_id=>$status) {
            if ($status == 'ACTIVE') {
                return $mno_assignee_id;
            }
        }
        return null;
    }
    
    protected function map_assignees_to_local_table($entity, $local_entity_id, $table_name, $local_entity_id_name, $local_user_id_name)
    {
        foreach ($entity->assignedTo as $mno_assignee_id=>$status) {
            $local_user_id = MnoSoaDB::getLocalUserIdByMnoUserId($mno_assignee_id);
            if (empty($local_user_id)) { continue; }
            
            $assignees_select_query = "SELECT * FROM $table_name WHERE $local_entity_id_name='$local_entity_id' and $local_user_id_name='$local_user_id'";
            $assigness_select_result = $this->_db->query($assignees_select_query);
            $num_rows = $this->_db->num_rows($assigness_select_result);
            
            if ($num_rows >= 1) {
                $assignees_upsert_query = "UPDATE $table_name SET status='$status' WHERE $local_entity_id_name='$local_entity_id' and $local_user_id_name='$local_user_id'";
            } else {
                $assignees_upsert_query = "INSERT INTO $table_name($local_entity_id_name, $local_user_id_name, status) VALUES ('$local_entity_id', '$local_user_id', '$status') ";
            }
            
            $this->_db->query($assignees_upsert_query);
        }
    }
        
    protected function saveLocalEntity($push_to_maestrano, $status) 
    {
        // DO NOTHING
    }
    
    public function getLocalEntityIdentifier() 
    {
        return $this->_local_project_id;
    }
    
    public function setLocalEntityIdentifier($local_identifier)
    {
        $this->_local_project_id = $local_identifier;
    }
    
    public function getLocalEntityByLocalIdentifier($local_id)
    {
        // DO NOTHING
        return null;
    }
    
    public function createLocalEntity()
    {
        return (object) array();
    }
    
    public function map_date_to_local_format($date)
    {
        $date_format = $this->pull_set_or_delete_value($date);
        return (!empty($date_format) && ctype_digit($date_format)) ? (string) ((int) round(intval($date_format)/1000)) : "0";
    }
    
    public function map_project_status_to_mno_format($local_status)
    {
        $local_status_format = $this->push_set_or_delete_value(strtoupper($local_status));
        
        if (empty($local_status_format)) { return null; }
        
        switch ($local_status_format) {
            case "POTENTIAL": return "TODO";
            case "CURRENT": return "INPROGRESS";
            case "ARCHIVED": return "COMPLETED";
            case "DELETED": return "ABANDONED";
        }
        
        return null;
    }
    
    public function map_project_status_to_local_format($mno_status)
    {
        $mno_status_format = $this->pull_set_or_delete_value(strtoupper($mno_status));
        
        if (empty($mno_status_format)) { return "Current"; }
        
        switch ($mno_status_format) {
            case "TODO": return "Potential";
            case "INPROGRESS": return "Current";
            case "COMPLETED": return "Archived";
            case "ABANDONED": return "Deleted";
        }
        
        return "Current";
    }
    
    public function map_task_status_to_mno_format($local_status)
    {
       $local_status_format = $this->push_set_or_delete_value($local_status);
        
        if (empty($local_status_format)) { return null; }
        
        switch ($local_status_format) {
            case "open_notstarted": return "TODO";
            case "open_inprogress": return "INPROGRESS";
            case "pending_info": return "INPROGRESS";
            case "pending_manager": return "INPROGRESS";
            case "pending_client": return "INPROGRESS";
            case "closed_invalid": return "COMPLETED";
            case "closed_duplicate": return "COMPLETED";
            case "closed_incomplete": return "COMPLETED";
            case "closed_complete": return "COMPLETED";
            case "deleted": return "ABANDONED";
        }
        
        return null;
    }
    
    public function map_task_status_to_local_format($mno_status, $current_local_status)
    {
        $mno_status_format = $this->pull_set_or_delete_value(strtoupper($mno_status));
        $current_local_status_format = $this->pull_set_or_delete_value(strtoupper($current_local_status));
        
        if (empty($mno_status_format)) { return "open_inprogress"; }
        if (empty($current_local_status_format)) { return $this->map_task_status_to_local_default($mno_status_format); }
        
        
        switch ($mno_status_format) {
            case "TODO": return $this->choice_of_mno_or_local_task_status($mno_status_format, $current_local_status_format);
            case "INPROGRESS": return $this->choice_of_mno_or_local_task_status($mno_status_format, $current_local_status_format);
            case "COMPLETED": return $this->choice_of_mno_or_local_task_status($mno_status_format, $current_local_status_format);
            case "ABANDONED": return $this->choice_of_mno_or_local_task_status($mno_status_format, $current_local_status_format);
        }
        
        return "ACTIVE";
    }
    
    public function choice_of_mno_or_local_task_status($mno_status, $current_local_status)
    {
        return ($this->is_mno_task_status_same_classification_as_local_value($mno_status, $current_local_status)) ?
                    $current_local_status : $this->map_task_status_to_local_default($mno_status);
    }
    
    public function is_mno_task_status_same_classification_as_local_value($mno_status, $current_local_status)
    {
        return 
        (
                ( $mno_status == "TODO" && $current_local_status == "open_notstarted" ) ||
                ( $mno_status == "INPROGRESS" && in_array($current_local_status, array("pending_info", "pending_manager", "pending_client")) ) ||
                ( $mno_status == "COMPLETED" && in_array($current_local_status, array("closed_invalid", "closed_duplicate", "closed_incomplete", "closed_complete")) ) ||
                ( $mno_status == "ABANDONED" && $current_local_status == "deleted" )
        ) ? true : false;
    }
    
    public function map_task_status_to_local_default($mno_status)
    {
        $mno_status_format = $this->pull_set_or_delete_value(strtoupper($mno_status));
        
        if (empty($mno_status_format)) { return "open_inprogress"; }
        
        switch ($mno_status_format) {
            case "TODO": return "open_notstarted";
            case "INPROGRESS": return "open_inprogress";
            case "COMPLETED": return "closed_complete";
            case "ABANDONED": return "deleted";
        }
        
        return "open_inprogress";
    }
}

?>