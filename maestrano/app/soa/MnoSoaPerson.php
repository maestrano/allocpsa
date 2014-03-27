<?php

/**
 * Mno Organization Class
 */
class MnoSoaPerson extends MnoSoaBasePerson
{
    protected $_local_entity_name = "clientContact";
    
    // DONE
    protected function pushId() 
    {
        $this->_log->debug(__CLASS__ . '.' . __FUNCTION__ . " start");
	$id = $this->getLocalEntityIdentifier();
	
	if (!empty($id)) {
	    $mno_id = $this->getMnoIdByLocalId($id);

	    if ($this->isValidIdentifier($mno_id)) {
                $this->_log->debug(__FUNCTION__ . " this->getMnoIdByLocalId(id) = " . json_encode($mno_id));
		$this->_id = $mno_id->_id;
	    }
	}
        $this->_log->debug(__CLASS__ . '.' . __FUNCTION__ . " end");
    }
    
    // DONE
    protected function pullId() 
    {
        $this->_log->debug(__CLASS__ . '.' . __FUNCTION__ . " start");
	if (!empty($this->_id)) {
	    $local_id = $this->getLocalIdByMnoId($this->_id);
            $this->_log->debug(__FUNCTION__ . " this->getLocalIdByMnoId(this->_id) = " . json_encode($local_id));
	    
	    if ($this->isValidIdentifier($local_id)) {
                $this->_local_entity = new clientContact();
                $this->_local_entity->set_id($local_id->_id);
                $this->_local_entity->select();
                $this->_log->debug(__CLASS__ . '.' . __FUNCTION__ . " is STATUS_EXISTING_ID");
		return constant('MnoSoaBaseEntity::STATUS_EXISTING_ID');
	    } else if ($this->isDeletedIdentifier($local_id)) {
                $this->_log->debug(__CLASS__ . '.' . __FUNCTION__ . " is STATUS_DELETED_ID");
                return constant('MnoSoaBaseEntity::STATUS_DELETED_ID');
            } else {
                $this->_local_entity = new clientContact();
                $this->_local_entity->set_value('clientContactActive', 'Current');
                $this->pullName();
                $this->pullRole();
                $this->_local_entity->save(false);
		return constant('MnoSoaBaseEntity::STATUS_NEW_ID');
	    }
	}
        $this->_log->debug(__CLASS__ . '.' . __FUNCTION__ . " return STATUS_ERROR");
        return constant('MnoSoaBaseEntity::STATUS_ERROR');
    }
    
    protected function pushName() {
        $this->_log->debug(__CLASS__ . '.' . __FUNCTION__ . " start ");
        $this->_name->familyName = $this->push_set_or_delete_value($this->_local_entity->get_value("clientContactName"));
        $this->_log->debug(__CLASS__ . '.' . __FUNCTION__ . " end ");
    }
    
    
    
    protected function pullName() {
        $this->_log->debug(__CLASS__ . '.' . __FUNCTION__ . " start ");
        $this->_local_entity->set_value("clientContactName", $this->pull_set_or_delete_value($this->_name->familyName));
        $this->_log->debug(__CLASS__ . '.' . __FUNCTION__ . " end ");
    }
    
    protected function pushBirthDate() {
        // DO NOTHING
    }
    
    protected function pullBirthDate() {
        // DO NOTHING
    }
    
    protected function pushGender() {
	// DO NOTHING
    }
    
    protected function pullGender() {
	// DO NOTHING
    }
    
    protected function pushAddresses() {
        $this->_log->debug(__CLASS__ . '.' . __FUNCTION__ . " start ");
        // POSTAL ADDRESS -> POSTAL ADDRESS
        $this->_address->work->postalAddress->streetAddress = $this->push_set_or_delete_value($this->_local_entity->get_value('clientContactStreetAddress'));
        $this->_address->work->postalAddress->locality = $this->push_set_or_delete_value($this->_local_entity->get_value('clientContactSuburb'));
        $this->_address->work->postalAddress->region = $this->push_set_or_delete_value($this->_local_entity->get_value('clientContactState'));
        $this->_address->work->postalAddress->postalCode = $this->push_set_or_delete_value($this->_local_entity->get_value('clientContactPostcode'));
        $this->_address->work->postalAddress->country = strtoupper($this->push_set_or_delete_value($this->_local_entity->get_value('clientContactCountry')));
        $this->_log->debug(__CLASS__ . '.' . __FUNCTION__ . " end ");
    }
    
    protected function pullAddresses() {
        $this->_log->debug(__CLASS__ . '.' . __FUNCTION__ . " start ");
		// POSTAL ADDRESS -> POSTAL ADDRESS
        $this->_local_entity->set_value('clientContactStreetAddress', $this->pull_set_or_delete_value($this->_address->work->postalAddress->streetAddress));
        $this->_local_entity->set_value('clientContactSuburb', $this->pull_set_or_delete_value($this->_address->work->postalAddress->locality));
        $this->_local_entity->set_value('clientContactState', $this->pull_set_or_delete_value($this->_address->work->postalAddress->region));
        $this->_local_entity->set_value('clientContactPostcode', $this->pull_set_or_delete_value($this->_address->work->postalAddress->postalCode));
        $this->_local_entity->set_value('clientContactCountry', $this->pull_set_or_delete_value($this->_address->work->postalAddress->country));
        $this->_log->debug(__CLASS__ . '.' . __FUNCTION__ . " end ");
    }
    
    protected function pushEmails() {
        $this->_log->debug(__CLASS__ . '.' . __FUNCTION__ . " start ");
        $this->_email->emailAddress = $this->push_set_or_delete_value($this->_local_entity->get_value('clientContactEmail'));
        $this->_log->debug(__CLASS__ . '.' . __FUNCTION__ . " end ");
    }
    
    protected function pullEmails() {
        $this->_log->debug(__CLASS__ . '.' . __FUNCTION__ . " start ");
        $this->_local_entity->set_value('clientContactEmail', $this->pull_set_or_delete_value($this->_email->emailAddress));
        $this->_log->debug(__CLASS__ . '.' . __FUNCTION__ . " end ");
    }
    
    
    protected function pushTelephones() {
        $this->_log->debug(__CLASS__ . '.' . __FUNCTION__ . " start ");        
        $this->_telephone->work->voice = $this->push_set_or_delete_value($this->_local_entity->get_value('clientContactPhone'));
        $this->_telephone->home->mobile = $this->push_set_or_delete_value($this->_local_entity->get_value('clientContactMobile'));
        $this->_telephone->work->fax = $this->push_set_or_delete_value($this->_local_entity->get_value('clientContactFax'));
        $this->_log->debug(__CLASS__ . '.' . __FUNCTION__ . " end ");
    }
    
    protected function pullTelephones() {
        $this->_log->debug(__CLASS__ . '.' . __FUNCTION__ . " start ");
        $this->_local_entity->set_value('clientContactPhone', $this->pull_set_or_delete_value($this->_telephone->work->voice));
        $this->_local_entity->set_value('clientContactMobile', $this->pull_set_or_delete_value($this->_telephone->home->mobile));
        $this->_local_entity->set_value('clientContactFax', $this->pull_set_or_delete_value($this->_telephone->work->fax));
        $this->_log->debug(__CLASS__ . '.' . __FUNCTION__ . " end ");
    }
    
    protected function pushWebsites() {
	// DO NOTHING
    }
    
    protected function pullWebsites() {
	// DO NOTHING
    }
    
    protected function pushEntity() {
        // DO NOTHING
    }
    
    protected function pullEntity() {
        // DO NOTHING
    }
    
    protected function pushCreditCard() {
        // DO NOTHING
    }
    
    protected function pullCreditCard() {
        // DO NOTHING
    }
    
    protected function pushRole() {
        $this->_log->debug(__CLASS__ . '.' . __FUNCTION__ . " start ");
        
        $local_org_id = $this->_local_entity->get_value('clientID');
        
        if (!empty($local_org_id)) {
            $mno_org_id = $this->getMnoIdByLocalIdName($local_org_id, "client");

			if ($this->isValidIdentifier($mno_org_id)) {    
		            $this->_log->debug("is valid identifier");
			$this->_role->organization->id = $mno_org_id->_id;
		        } else if ($this->isDeletedIdentifier($mno_org_id)) {
		            $this->_log->debug(__FUNCTION__ . " deleted identifier");
		            // do not update
		            return;
			} else {
		            $this->_log->debug("before contacts find by id=" . json_encode($local_org_id));
		            $org_contact = new client();
		            $org_contact->set_id($local_id->_id);
		            $org_contact->select();
		            $this->_log->debug("after contacts find by id=" . json_encode($local_org_id));
		            
		            $organization = new MnoSoaOrganization($this->_db, $this->_log);		
		            $organization->send($org_contact);
		            $this->_log->debug("after mno soa organization send");
		            
		            $mno_org_id = $this->getMnoIdByLocalIdName($local_org_id, "client");
		            
		            if ($this->isValidIdentifier($mno_org_id)) {
		                $this->_role->organization->id = $mno_org_id->_id;
                	}
			}
		} else {
            $this->_role = (object) array();
        }
        
        $this->_log->debug(__CLASS__ . '.' . __FUNCTION__ . " end ");
    }
    
    protected function pullRole() {
        $this->_log->debug(__CLASS__ . '.' . __FUNCTION__ . " start ");
        if (empty($this->_role->organization->id)) {
            // EXCEPTION - PERSON (CLIENT CONTACT) MUST BE RELATED TO AN ORGANIZATION (CLIENT)
            throw new Exception("MNO_000: Message not persisted - person must be related to an organization (MNOID=" . $this->_id . ")");
        } else {
            $local_id = $this->getLocalIdByMnoIdName($this->_role->organization->id, "organizations");
            if ($this->isValidIdentifier($local_id)) {
                $this->_log->debug(__FUNCTION__ . " local_id = " . json_encode($local_id));
                $this->_local_entity->set_value('clientID', $local_id->_id);
            } else if ($this->isDeletedIdentifier($local_id)) {
                // do not update
                return;
            } else {
                $notification->entity = "organizations";
                $notification->id = $this->_role->organization->id;
                $organization = new MnoSoaOrganization($this->_db, $this->_log);		
                $organization->receiveNotification($notification);
                $this->_local_entity->set_value('clientID', $organization->getLocalEntityIdentifier());
            }
        }
        $this->_log->debug(__CLASS__ . '.' . __FUNCTION__ . " end ");
    }
    
    protected function saveLocalEntity($push_to_maestrano, $status) {
        $this->_log->debug(__CLASS__ . '.' . __FUNCTION__ . " start ");
        $this->_local_entity->save($push_to_maestrano);
        $this->_log->debug(__CLASS__ . '.' . __FUNCTION__ . " end ");
    }
    
    public function getLocalEntityIdentifier() {
        return $this->_local_entity->key_field->value;
    }
}

?>