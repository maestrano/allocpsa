<?php

/**
 * Maestrano map table functions
 *
 * @author root
 */

class MnoSoaDB extends MnoSoaBaseDB {
    /**
    * Update identifier map table
    * @param  	string 	local_id                Local entity identifier
    * @param    string  local_entity_name       Local entity name
    * @param	string	mno_id                  Maestrano entity identifier
    * @param	string	mno_entity_name         Maestrano entity name
    *
    * @return 	boolean Record inserted
    */
    
    public function addIdMapEntry($local_id, $local_entity_name, $mno_id, $mno_entity_name) {	
        $this->_log->debug(__CLASS__ . ' ' . __FUNCTION__ . " start");
	// Fetch record
	$query = prepare("INSERT INTO mno_id_map (mno_entity_guid, mno_entity_name, app_entity_id, app_entity_name, db_timestamp) VALUES "
                                      . "('%s', '%s', '%s', '%s', UTC_TIMESTAMP)"
                         , $mno_id
                         , strtoupper($mno_entity_name)
                         , $local_id
                         , strtoupper($local_entity_name));	
        $this->_db->query($query);
        $id = $this->_db->get_insert_id();
        
        $this->_log->debug("addIdMapEntry query = ".$query);
        
        if (empty($id)) {
            return false;
        } 
        
        return true;
    }
    
    /**
    * Get Maestrano GUID when provided with a local identifier
    * @param  	string 	local_id                Local entity identifier
    * @param    string  local_entity_name       Local entity name
    *
    * @return 	boolean Record found	
    */
    public function getMnoIdByLocalIdName($local_id, $local_entity_name)
    {
        $this->_log->debug(__CLASS__ . ' ' . __FUNCTION__ . " start");
        $mno_entity = null;
        
	// Fetch record
	$query = prepare("SELECT mno_entity_guid, mno_entity_name, deleted_flag from mno_id_map where app_entity_id='%s' and app_entity_name='%s'"
                          , $local_id
                          , strtoupper($local_entity_name));
        
        $this->_db->query($query);
        
        $row = $this->_db->next_record();
                
	// Return id value
	if ($row) {
            $mno_entity_guid = trim($row["mno_entity_guid"]);
            $mno_entity_name = trim($row["mno_entity_name"]);
            $deleted_flag = trim($row["deleted_flag"]);
            
            if (!empty($mno_entity_guid) && !empty($mno_entity_name)) {
                $mno_entity = (object) array (
                    "_id" => $mno_entity_guid,
                    "_entity" => $mno_entity_name,
                    "_deleted_flag" => $deleted_flag
                );
            }
	}
        
        $this->_log->debug(__CLASS__ . ' ' . __FUNCTION__ . "returning mno_entity = ".json_encode($mno_entity));
	return $mno_entity;
    }
    
    public function getLocalIdByMnoIdName($mno_id, $mno_entity_name)
    {
        $this->_log->debug(__CLASS__ . ' ' . __FUNCTION__ . " start");
	$local_entity = null;
        
	// Fetch record
	$query = prepare("SELECT app_entity_id, app_entity_name, deleted_flag from mno_id_map where mno_entity_guid='%s' and mno_entity_name='%s'"
                          , $mno_id
                          , strtoupper($mno_entity_name));

        $this->_db->query($query);
        
        $row = $this->_db->next_record();
        
	// Return id value
	if ($row) {
            $app_entity_id = trim($row["app_entity_id"]);
            $app_entity_name = trim($row["app_entity_name"]);
            $deleted_flag = trim($row["deleted_flag"]);
            
            if (!empty($app_entity_id) && !empty($app_entity_name)) {
                $local_entity = (object) array (
                    "_id" => $app_entity_id,
                    "_entity" => $app_entity_name,
                    "_deleted_flag" => $deleted_flag
                );
            }
	}
	
        $this->_log->debug(__CLASS__ . ' ' . __FUNCTION__ . "returning mno_entity = ".json_encode($local_entity));
	return $local_entity;
    }
    
    public function deleteIdMapEntry($local_id, $local_entity_name) 
    {
        $this->_log->debug(__CLASS__ . ' ' . __FUNCTION__ . " start");
        // Logically delete record
        $query = prepare("UPDATE mno_id_map SET deleted_flag=1 WHERE app_entity_id='%s' and app_entity_name='%s'"
                        , $local_id
                        , strtoupper($local_entity_name));
        $this->_db->query($query);
        
        $this->_log->debug("deleteIdMapEntry query = ".$query);
        
        return true;
    }
}

?>