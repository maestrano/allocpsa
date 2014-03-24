<?php

/**
 * Mno Organization Class
 */
class MnoSoaOrganization extends MnoSoaBaseOrganization
{
    protected $_local_entity_name = "client";
    
    // DONE
    protected function pushId() 
    {
        $this->_log->debug(__CLASS__ . '.' . __FUNCTION__ . " start");
	$id = $this->getLocalEntityIdentifier();
	$this->_log->debug(__CLASS__ . '.' . __FUNCTION__ . " localentityidentifier=".$id);
        
	if (!empty($id)) {
	    $this->_log->debug(__CLASS__ . '.' . __FUNCTION__ . " this->_local_entity->id = " . json_encode($id));
	    $mno_id = $this->getMnoIdByLocalId($id);
            
	    if ($this->isValidIdentifier($mno_id)) {
                $this->_log->debug(__CLASS__ . '.' . __FUNCTION__ . " this->getMnoIdByLocalId(id) = " . json_encode($mno_id));
		$this->_id = $mno_id->_id;
	    }
	}
        
        $this->_log->debug(__CLASS__ . '.' . __FUNCTION__ . " end");
    }
    
    // DONE
    protected function pullId() 
    {
        $this->_log->debug(__CLASS__ . '.' . __FUNCTION__ . " start " . $this->_id);
        
	if (!empty($this->_id)) {            
	    $local_id = $this->getLocalIdByMnoId($this->_id);
            $this->_log->debug(__CLASS__ . '.' . __FUNCTION__ . " this->getLocalIdByMnoId(this->_id) = " . json_encode($local_id));
            
	    if ($this->isValidIdentifier($local_id)) {
                $this->_log->debug(__CLASS__ . '.' . __FUNCTION__ . " is STATUS_EXISTING_ID");
                $this->_local_entity = new client();
                $this->_local_entity->set_id($local_id->_id);
                $this->_local_entity->select();
		return constant('MnoSoaBaseEntity::STATUS_EXISTING_ID');
	    } else if ($this->isDeletedIdentifier($local_id)) {
                $this->_log->debug(__CLASS__ . '.' . __FUNCTION__ . " is STATUS_DELETED_ID");
                return constant('MnoSoaBaseEntity::STATUS_DELETED_ID');
            } else {
                $this->_log->debug(__CLASS__ . '.' . __FUNCTION__ . " is STATUS_NEW_ID");
                $this->_local_entity = new client();
                $this->_local_entity->set_value('clientStatus', 'Current');
                $this->pullName();
                $this->_local_entity->save(false);
		return constant('MnoSoaBaseEntity::STATUS_NEW_ID');
	    }
	}
        
        $this->_log->debug(__CLASS__ . '.' . __FUNCTION__ . " return STATUS_ERROR");
        return constant('MnoSoaBaseEntity::STATUS_ERROR');
    }
    
    // DONE
    protected function pushName() 
    {
        $this->_log->debug(__CLASS__ . '.' . __FUNCTION__ . " start ");
        $this->_name = $this->push_set_or_delete_value($this->_local_entity->get_value('clientName'));
	$this->_log->debug(__CLASS__ . '.' . __FUNCTION__ . " end " . $this->_name);
    }
    
    // DONE
    protected function pullName() 
    {
        $this->_log->debug(__CLASS__ . '.' . __FUNCTION__ . " start ");
        $this->_local_entity->set_value('clientName', $this->pull_set_or_delete_value($this->_name));
        $this->_log->debug(__CLASS__ . '.' . __FUNCTION__ . " end ");
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
        $this->_log->debug(__CLASS__ . '.' . __FUNCTION__ . " start ");
        // POSTAL ADDRESS -> POSTAL ADDRESS
        $this->_address->postalAddress->streetAddress = $this->push_set_or_delete_value($this->_local_entity->get_value('clientStreetAddressOne'));
        $this->_address->postalAddress->locality = $this->push_set_or_delete_value($this->_local_entity->get_value('clientSuburbOne'));
        $this->_address->postalAddress->region = $this->push_set_or_delete_value($this->_local_entity->get_value('clientStateOne'));
        $this->_address->postalAddress->postalCode = $this->push_set_or_delete_value($this->_local_entity->get_value('clientPostcodeOne'));
        //$this->_address->postalAddress->country = strtoupper($this->push_set_or_delete_value($this->_local_entity->get_value('clientCountryOne'));
        // STREET ADDRESS -> STREET ADDRESS
        $this->_address->streetAddress->streetAddress = $this->push_set_or_delete_value($this->_local_entity->get_value('clientStreetAddressTwo'));
        $this->_address->streetAddress->locality = $this->push_set_or_delete_value($this->_local_entity->get_value('clientSuburbTwo'));
        $this->_address->streetAddress->region = $this->push_set_or_delete_value($this->_local_entity->get_value('clientStateTwo'));
        $this->_address->streetAddress->postalCode = $this->push_set_or_delete_value($this->_local_entity->get_value('clientPostcodeTwo'));
        //$this->_address->streetAddress->country = strtoupper($this->push_set_or_delete_value($this->_local_entity->get_value('clientCountryTwo'));
        $this->_log->debug(__CLASS__ . '.' . __FUNCTION__ . " end ");
    }
    
    // DONE
    protected function pullAddresses() {
        $this->_log->debug(__CLASS__ . '.' . __FUNCTION__ . " start ");
        $p =& get_cached_table("person");
        error_log("p=" . json_encode($p));
        
        
	// POSTAL ADDRESS -> POSTAL ADDRESS
        $this->_local_entity->set_value('clientStreetAddressOne', $this->pull_set_or_delete_value($this->_address->postalAddress->streetAddress));
        $this->_local_entity->set_value('clientSuburbOne', $this->pull_set_or_delete_value($this->_address->postalAddress->locality));
        $this->_local_entity->set_value('clientStateOne', $this->pull_set_or_delete_value($this->_address->postalAddress->region));
        $this->_local_entity->set_value('clientPostcodeOne', $this->pull_set_or_delete_value($this->_address->postalAddress->postalCode));
        $this->_local_entity->set_value('clientCountryOne', $this->pull_set_or_delete_value($this->mapISO3166ToCountry($this->_address->postalAddress->country)));
        // STREET ADDRESS -> STREET ADDRESS
        $this->_local_entity->set_value('clientStreetAddressTwo', $this->pull_set_or_delete_value($this->_address->streetAddress->streetAddress));
        $this->_local_entity->set_value('clientSuburbTwo', $this->pull_set_or_delete_value($this->_address->streetAddress->locality));
        $this->_local_entity->set_value('clientStateTwo', $this->pull_set_or_delete_value($this->_address->streetAddress->region));
        $this->_local_entity->set_value('clientPostcodeTwo', $this->pull_set_or_delete_value($this->_address->streetAddress->postalCode));
        $this->_local_entity->set_value('clientCountryTwo', $this->pull_set_or_delete_value($this->mapISO3166ToCountry($this->_address->streetAddress->country)));
        $this->_log->debug(__CLASS__ . '.' . __FUNCTION__ . " end ");
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
        $this->_log->debug(__CLASS__ . '.' . __FUNCTION__ . " start ");
        $this->_telephone->voice = $this->push_set_or_delete_value($this->_local_entity->get_value('clientPhoneOne'));
        $this->_telephone->fax = $this->push_set_or_delete_value($this->_local_entity->get_value('clientFaxOne'));
        $this->_log->debug(__CLASS__ . '.' . __FUNCTION__ . " end ");
    }
    
    // DONE
    protected function pullTelephones() {
        $this->_log->debug(__CLASS__ . '.' . __FUNCTION__ . " start ");
        $this->_local_entity->set_value('clientPhoneOne', $this->pull_set_or_delete_value($this->_telephone->voice));
        $this->_local_entity->set_value('clientFaxOne', $this->pull_set_or_delete_value($this->_telephone->fax));
        $this->_log->debug(__CLASS__ . '.' . __FUNCTION__ . " end ");
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
        $this->_log->debug(__CLASS__ . '.' . __FUNCTION__ . " start ");
        // clientCategory = 1 CLIENT -> CUSTOMER
        if ($this->push_set_or_delete_value($this->_local_entity->get_value('clientCategory')) == 1) {   
            $this->_entity->customer = true;
        }
        // clientCategory = 3 SUPPLIER -> SUPPLIER
        if ($this->push_set_or_delete_value($this->_local_entity->get_value('clientCategory')) == 3) {
            $this->_entity->supplier = true;
        }
        // clientCategory = 2/4/5/6/7 VENDOR/CONSULTANT/GOVERNMENT/NON-PROFIT/INTERNAL -> DO NOTHING
        $this->_log->debug(__CLASS__ . '.' . __FUNCTION__ . " end ");
    }
    
    // DONE
    protected function pullEntity() {
        $this->_log->debug(__CLASS__ . '.' . __FUNCTION__ . " start ");
        if ($this->pull_set_or_delete_value($this->_entity->customer) == true) {
            $this->_local_entity->set_value('clientCategory', '1');
        } else if ($this->pull_set_or_delete_value($this->_entity->supplier) == true) {
            $this->_local_entity->set_value('supplier', '3');
        }
        // clientCategory = 2/4/5/6/7 VENDOR/CONSULTANT/GOVERNMENT/NON-PROFIT/INTERNAL -> DO NOTHING
        $this->_log->debug(__CLASS__ . '.' . __FUNCTION__ . " end ");
    }
    
    // DONE
    protected function saveLocalEntity($push_to_maestrano, $status) {
        $this->_log->debug(__CLASS__ . '.' . __FUNCTION__ . " start ");
        
        
        
        $this->_local_entity->save($push_to_maestrano);
        $this->_log->debug(__CLASS__ . '.' . __FUNCTION__ . " end ");
        $p =& get_cached_table("person");
        error_log("p=" . json_encode($p));
    }
    
    // DONE
    public function getLocalEntityIdentifier() {
        return $this->_local_entity->key_field->value;
    }
}

?>