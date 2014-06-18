<?php

/**
 * Mno Organization Class
 */
class MnoSoaAccount extends MnoSoaBaseAccount
{
    protected $_local_entity_name = "TF";
    protected $_local_account_id = null;
    
    protected function pushAccount()
    {
        // PUSH ID
        $id = $this->getLocalEntityIdentifier();
        if (empty($id)) { return; }
        $mno_id = MnoSoaDB::getMnoIdByLocalId($id, $this->getLocalEntityName(), $this->getMnoEntityName());
        $this->_id = (MnoSoaDB::isValidIdentifier($mno_id)) ? $mno_id->_id : null;
        
        $account_query = "  SELECT tf.tfCode as code, tf.tfName as name, tf.tfComments as description, tf.accountTypeID as classification, tf.tfActive as status
                            FROM tf
                            WHERE tf.tfID='$id'
                         ";
        $account = $this->_db->query($account_query);
        if (empty($account)) { return null; }
        $account = (object) $this->_db->next_record();
        
        // PUSH CODE
        $this->_code = $this->push_set_or_delete_value($account->code);
        // PUSH NAME
        $this->_name = $this->push_set_or_delete_value($account->name);
        // PUSH DESCRIPTION
        $this->_description = $this->push_set_or_delete_value($account->description);
        // PUSH CLASSIFICATION
        $this->_classification = $this->push_set_or_delete_value($account->classification);
        // PUSH STATUS
        $this->_status = $this->mapStatusToMnoFormat($account->status);
    }
    
    protected function pullAccount()
    {
        // PULL ID
        if (empty($this->_id)) { return constant('MnoSoaBaseEntity::STATUS_ERROR'); }
        $local_id = MnoSoaDB::getLocalIdByMnoId($this->_id, $this->getMnoEntityName(), $this->getLocalEntityName());
        if (MnoSoaDB::isDeletedIdentifier($local_id)) { return constant('MnoSoaBaseEntity::STATUS_DELETED_ID'); }
        
        // DETERMINE RETURN STATUS
        $return_status = (MnoSoaDB::isValidIdentifier(($local_id))) ? constant('MnoSoaBaseEntity::STATUS_EXISTING_ID') : constant('MnoSoaBaseEntity::STATUS_NEW_ID');
        // PULL CODE
        $code = $this->pull_set_or_delete_value($this->_code);
        // PULL NAME
        $name = $this->pull_set_or_delete_value($this->_name);
        // PULL DESCRIPTION
        $description = $this->pull_set_or_delete_value($this->_description);
        // PULL CLASSIFICATION
        $classification = $this->pull_set_or_delete_value($this->_classification);
        // PULL STATUS
        $status = $this->mapStatusToLocalFormat($this->_status);
        
        if (MnoSoaDB::isValidIdentifier(($local_id))) { 
            $this->_local_account_id = $local_id->_id;
            
            $item_query = " UPDATE tf
                            SET tfCode = '$code', tfName='$name', tfComments='$description', accountTypeID='$classification', tfActive='$status'
                            WHERE tfID = '$this->_local_account_id'";
            $this->_db->query($item_query);
        // INSERT ITEM
        } else {
            $return_status = constant('MnoSoaBaseEntity::STATUS_NEW_ID');
            
            $item_query = " INSERT tf
                            (tfCode, tfName, tfComments, accountTypeID, tfActive)
                            VALUES
                            ('$code', '$name', '$description', '$classification', '$status')
                            ";
            $this->_db->query($item_query);
            $this->_local_account_id = $this->_db->get_insert_id();
            MnoSoaDB::addIdMapEntry($this->_local_account_id, $this->getLocalEntityName(), $this->_id, $this->getMnoEntityName());
        }
        
        return $return_status;
    }
    
    // DONE
    protected function saveLocalEntity($push_to_maestrano, $status) {
        // DO NOTHING
    }
    
    public function setLocalEntityIdentifier($local_identifier)
    {
        $this->_local_account_id = $local_identifier;
    }
    
    // DONE
    public function getLocalEntityIdentifier() {
        return $this->_local_account_id;
    }
    
    protected function mapStatusToMnoFormat($local_status) 
    {
        switch ($local_status) {
            case 0: return "INACTIVE";
            case 1: return "ACTIVE";
        }
        
        return "INACTIVE";
    }
    
    protected function mapStatusToLocalFormat($mno_status)
    {
        $mno_status_format = $this->pull_set_or_delete_value($mno_status);
        switch($mno_status_format) {
            case "INACTIVE": return 0;
            case "ACTIVE": return 1;
        }
        return 0;
    }
}

?>