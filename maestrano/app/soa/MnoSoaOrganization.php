<?php

/**
 * Mno Organization Class
 */
class MnoSoaOrganization extends MnoSoaBaseOrganization
{
    protected $_local_entity_name = "client";
    
    // DONE
    public function pushId() 
    {
	$id = $this->getLocalEntityIdentifier();
	MnoSoaLogger::debug("localentityidentifier=".$id);
        
	if (!empty($id)) {
	    MnoSoaLogger::debug("this->_local_entity->id = " . json_encode($id));
	    $mno_id = MnoSoaDB::getMnoIdByLocalId($id, $this->_local_entity_name, "ORGANIZATIONS");
            
	    if (MnoSoaDB::isValidIdentifier($mno_id)) {
                MnoSoaLogger::debug("this->getMnoIdByLocalId(id) = " . json_encode($mno_id));
		$this->_id = $mno_id->_id;
	    }
	}        
    }
    
    // DONE
    public function pullId() 
    {
	if (!empty($this->_id)) {
            $local_id = MnoSoaDB::getLocalIdByMnoId($this->_id, "ORGANIZATIONS", $this->_local_entity_name);
            MnoSoaLogger::debug("this->getLocalIdByMnoId(this->_id) = " . json_encode($local_id));
            
	    if (MnoSoaDB::isValidIdentifier($local_id)) {
                MnoSoaLogger::debug("is STATUS_EXISTING_ID");
                $this->_local_entity = new client();
                $this->_local_entity->set_id($local_id->_id);
                $this->_local_entity->select();
		return constant('MnoSoaBaseEntity::STATUS_EXISTING_ID');
	    } else if (MnoSoaDB::isDeletedIdentifier($local_id)) {
                MnoSoaLogger::debug("is STATUS_DELETED_ID");
                return constant('MnoSoaBaseEntity::STATUS_DELETED_ID');
            } else {
                MnoSoaLogger::debug("is STATUS_NEW_ID");
                $this->_local_entity = new client();
                $this->_local_entity->set_value('clientStatus', 'Current');
                $this->pullName();
                $this->_local_entity->save(false);
		return constant('MnoSoaBaseEntity::STATUS_NEW_ID');
	    }
	}
        
        MnoSoaLogger::debug("return STATUS_ERROR");
        return constant('MnoSoaBaseEntity::STATUS_ERROR');
    }
    
    // DONE
    protected function pushName() 
    {
        $this->_name = $this->push_set_or_delete_value($this->_local_entity->get_value('clientName'));
    }
    
    // DONE
    protected function pullName() 
    {
        $this->_local_entity->set_value('clientName', $this->pull_set_or_delete_value($this->_name));
    }
    
    // DONE
    protected function pushIndustry() {
	// DO NOTHING
    }
    
    // DONE
    protected function pullIndustry() {
	// DO NOTHING
    }
    
    // DONE
    protected function pushAnnualRevenue() {
	// DO NOTHING
    }
    
    // DONE
    protected function pullAnnualRevenue() {
	// DO NOTHING
    }
    
    // DONE
    protected function pushCapital() {
        // DO NOTHING
    }
    
    // DONE
    protected function pullCapital() {
        // DO NOTHING
    }
    
    // DONE
    protected function pushNumberOfEmployees() {
	// DO NOTHING
    }
    
    // DONE
    protected function pullNumberOfEmployees() {
       // DO NOTHING
    }
    
    // DONE
    protected function pushAddresses() {
        // POSTAL ADDRESS -> POSTAL ADDRESS
        $this->_address->postalAddress->streetAddress = $this->push_set_or_delete_value($this->_local_entity->get_value('clientStreetAddressOne'));
        $this->_address->postalAddress->locality = $this->push_set_or_delete_value($this->_local_entity->get_value('clientSuburbOne'));
        $this->_address->postalAddress->region = $this->push_set_or_delete_value($this->_local_entity->get_value('clientStateOne'));
        $this->_address->postalAddress->postalCode = $this->push_set_or_delete_value($this->_local_entity->get_value('clientPostcodeOne'));
        $this->_address->postalAddress->country = strtoupper($this->push_set_or_delete_value($this->_local_entity->get_value('clientCountryOne')));
        // STREET ADDRESS -> STREET ADDRESS
        $this->_address->streetAddress->streetAddress = $this->push_set_or_delete_value($this->_local_entity->get_value('clientStreetAddressTwo'));
        $this->_address->streetAddress->locality = $this->push_set_or_delete_value($this->_local_entity->get_value('clientSuburbTwo'));
        $this->_address->streetAddress->region = $this->push_set_or_delete_value($this->_local_entity->get_value('clientStateTwo'));
        $this->_address->streetAddress->postalCode = $this->push_set_or_delete_value($this->_local_entity->get_value('clientPostcodeTwo'));
        $this->_address->streetAddress->country = strtoupper($this->push_set_or_delete_value($this->_local_entity->get_value('clientCountryTwo')));
    }
    
    // DONE
    protected function pullAddresses() {
        // POSTAL ADDRESS -> POSTAL ADDRESS
        $this->_local_entity->set_value('clientStreetAddressOne', $this->pull_set_or_delete_value($this->_address->postalAddress->streetAddress));
        $this->_local_entity->set_value('clientSuburbOne', $this->pull_set_or_delete_value($this->_address->postalAddress->locality));
        $this->_local_entity->set_value('clientStateOne', $this->pull_set_or_delete_value($this->_address->postalAddress->region));
        $this->_local_entity->set_value('clientPostcodeOne', $this->pull_set_or_delete_value($this->_address->postalAddress->postalCode));
        $this->_local_entity->set_value('clientCountryOne', $this->pull_set_or_delete_value($this->_address->postalAddress->country));
        // STREET ADDRESS -> STREET ADDRESS
        $this->_local_entity->set_value('clientStreetAddressTwo', $this->pull_set_or_delete_value($this->_address->streetAddress->streetAddress));
        $this->_local_entity->set_value('clientSuburbTwo', $this->pull_set_or_delete_value($this->_address->streetAddress->locality));
        $this->_local_entity->set_value('clientStateTwo', $this->pull_set_or_delete_value($this->_address->streetAddress->region));
        $this->_local_entity->set_value('clientPostcodeTwo', $this->pull_set_or_delete_value($this->_address->streetAddress->postalCode));
        $this->_local_entity->set_value('clientCountryTwo', $this->pull_set_or_delete_value($this->_address->streetAddress->country));
    }
    
    // DONE
    protected function pushEmails() {
        // DO NOTHING
    }
    
    // DONE
    protected function pullEmails() {
        // DO NOTHING
    }
    
    // DONE
    protected function pushTelephones() {
        $this->_telephone->voice = $this->push_set_or_delete_value($this->_local_entity->get_value('clientPhoneOne'));
        $this->_telephone->fax = $this->push_set_or_delete_value($this->_local_entity->get_value('clientFaxOne'));
    }
    
    // DONE
    protected function pullTelephones() {
        $this->_local_entity->set_value('clientPhoneOne', $this->pull_set_or_delete_value($this->_telephone->voice));
        $this->_local_entity->set_value('clientFaxOne', $this->pull_set_or_delete_value($this->_telephone->fax));
    }
    
    // DONE
    protected function pushWebsites() {
        // DO NOTHING
    }
    
    // DONE
    protected function pullWebsites() {
        // DO NOTHING
    }
    
    // DONE
    protected function pushEntity() {
        // clientCategory = 1 CLIENT -> CUSTOMER
        if ($this->push_set_or_delete_value($this->_local_entity->get_value('clientCategory')) == 1) {   
            $this->_entity->customer = true;
        }
        // clientCategory = 3 SUPPLIER -> SUPPLIER
        if ($this->push_set_or_delete_value($this->_local_entity->get_value('clientCategory')) == 3) {
            $this->_entity->supplier = true;
        }
        // clientCategory = 2/4/5/6/7 SUPPLIER/CONSULTANT/GOVERNMENT/NON-PROFIT/INTERNAL -> DO NOTHING
    }
    
    // DONE
    protected function pullEntity() {
        if ($this->pull_set_or_delete_value($this->_entity->customer) == true) {
            $this->_local_entity->set_value('clientCategory', '1');
        } else if ($this->pull_set_or_delete_value($this->_entity->supplier) == true) {
            $this->_local_entity->set_value('clientCategory', '3');
        }
        // clientCategory = 2/4/5/6/7 SUPPLIER/CONSULTANT/GOVERNMENT/NON-PROFIT/INTERNAL -> DO NOTHING
    }
    
    // DONE
    protected function saveLocalEntity($push_to_maestrano, $status) {
        $this->_local_entity->save($push_to_maestrano);
    }
    
    // DONE
    public function getLocalEntityIdentifier() {
        return $this->_local_entity->key_field->value;
    }
}

?>