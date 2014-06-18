<?php

/**
 * Mno Organization Class
 */
class MnoSoaPerson extends MnoSoaBasePerson
{
    protected $_local_entity_name = "clientContact";
    
    // DONE
    public function pushId() 
    {
	$id = $this->getLocalEntityIdentifier();
	
	if (!empty($id)) {
	    $mno_id = MnoSoaDB::getMnoIdByLocalId($id, $this->_local_entity_name, "PERSONS");

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
            $local_id = MnoSoaDB::getLocalIdByMnoId($this->_id, "PERSONS", $this->_local_entity_name);
            MnoSoaLogger::debug("this->getLocalIdByMnoId(this->_id) = " . json_encode($local_id));
	    
	    if (MnoSoaDB::isValidIdentifier($local_id)) {
                $this->_local_entity = new clientContact();
                $this->_local_entity->set_id($local_id->_id);
                $this->_local_entity->select();
                MnoSoaLogger::debug("is STATUS_EXISTING_ID");
		return constant('MnoSoaBaseEntity::STATUS_EXISTING_ID');
	    } else if (MnoSoaDB::isDeletedIdentifier($local_id)) {
                MnoSoaLogger::debug("is STATUS_DELETED_ID");
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
        MnoSoaLogger::debug("return STATUS_ERROR");
        return constant('MnoSoaBaseEntity::STATUS_ERROR');
    }
    
    protected function pushName() {
        $this->_name->familyName = $this->push_set_or_delete_value($this->_local_entity->get_value("clientContactName"));
    }
    
    
    
    protected function pullName() {
        $this->_local_entity->set_value("clientContactName", $this->pull_set_or_delete_value($this->_name->familyName));
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
        // POSTAL ADDRESS -> POSTAL ADDRESS
        $this->_address->work->postalAddress->streetAddress = $this->push_set_or_delete_value($this->_local_entity->get_value('clientContactStreetAddress'));
        $this->_address->work->postalAddress->locality = $this->push_set_or_delete_value($this->_local_entity->get_value('clientContactSuburb'));
        $this->_address->work->postalAddress->region = $this->push_set_or_delete_value($this->_local_entity->get_value('clientContactState'));
        $this->_address->work->postalAddress->postalCode = $this->push_set_or_delete_value($this->_local_entity->get_value('clientContactPostcode'));
        $this->_address->work->postalAddress->country = strtoupper($this->push_set_or_delete_value($this->_local_entity->get_value('clientContactCountry')));
    }
    
    protected function pullAddresses() {
	// POSTAL ADDRESS -> POSTAL ADDRESS
        $this->_local_entity->set_value('clientContactStreetAddress', $this->pull_set_or_delete_value($this->_address->work->postalAddress->streetAddress));
        $this->_local_entity->set_value('clientContactSuburb', $this->pull_set_or_delete_value($this->_address->work->postalAddress->locality));
        $this->_local_entity->set_value('clientContactState', $this->pull_set_or_delete_value($this->_address->work->postalAddress->region));
        $this->_local_entity->set_value('clientContactPostcode', $this->pull_set_or_delete_value($this->_address->work->postalAddress->postalCode));
        $this->_local_entity->set_value('clientContactCountry', $this->pull_set_or_delete_value($this->_address->work->postalAddress->country));
    }
    
    protected function pushEmails() {
        $this->_email->emailAddress = $this->push_set_or_delete_value($this->_local_entity->get_value('clientContactEmail'));
    }
    
    protected function pullEmails() {
        $this->_local_entity->set_value('clientContactEmail', $this->pull_set_or_delete_value($this->_email->emailAddress));
    }
    
    
    protected function pushTelephones() {
        $this->_telephone->work->voice = $this->push_set_or_delete_value($this->_local_entity->get_value('clientContactPhone'));
        $this->_telephone->home->mobile = $this->push_set_or_delete_value($this->_local_entity->get_value('clientContactMobile'));
        $this->_telephone->work->fax = $this->push_set_or_delete_value($this->_local_entity->get_value('clientContactFax'));
    }
    
    protected function pullTelephones() {
        $this->_local_entity->set_value('clientContactPhone', $this->pull_set_or_delete_value($this->_telephone->work->voice));
        $this->_local_entity->set_value('clientContactMobile', $this->pull_set_or_delete_value($this->_telephone->home->mobile));
        $this->_local_entity->set_value('clientContactFax', $this->pull_set_or_delete_value($this->_telephone->work->fax));
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
        $local_org_id = $this->_local_entity->get_value('clientID');
        
        if (!empty($local_org_id)) {
            $mno_org_id = MnoSoaDB::getMnoIdByLocalId($local_org_id, "CLIENT", "ORGANIZATIONS");

            if (MnoSoaDB::isValidIdentifier($mno_org_id)) {    
                MnoSoaLogger::debug("is valid identifier");
            $this->_role->organization->id = $mno_org_id->_id;
            } else if (MnoSoaDB::isDeletedIdentifier($mno_org_id)) {
                MnoSoaLogger::debug("deleted identifier");
                // do not update
                return;
            } else {
                MnoSoaLogger::debug("before contacts find by id=" . json_encode($local_org_id));
                $org_contact = new client();
                $org_contact->set_id($local_id->_id);
                $org_contact->select();
                MnoSoaLogger::debug("after contacts find by id=" . json_encode($local_org_id));

                $organization = new MnoSoaOrganization($this->_db, $this->_log);		
                    $status = $organization->send($org_contact);
                MnoSoaLogger::debug("after mno soa organization send");

                if ($status) {
                    $mno_org_id = MnoSoaDB::getMnoIdByLocalId($local_org_id, "CLIENT", "ORGANIZATIONS");

                    if (MnoSoaDB::isValidIdentifier($mno_org_id)) {
                        $this->_role->organization->id = $mno_org_id->_id;
                    }
                }
            }
        } else {
            $this->_role = (object) array();
        }
    }
    
    protected function pullRole() {
        if (empty($this->_role->organization->id)) {
            // EXCEPTION - PERSON (CLIENT CONTACT) MUST BE RELATED TO AN ORGANIZATION (CLIENT)
            throw new Exception("MNO_000: Message not persisted - person must be related to an organization (MNOID=" . $this->_id . ")");
        } else {
            $local_org_id = MnoSoaDB::getLocalIdByMnoId($this->_role->organization->id, "ORGANIZATIONS", "CLIENT");
            if (MnoSoaDB::isValidIdentifier($local_org_id)) {
                MnoSoaLogger::debug("local_id = " . json_encode($local_org_id));
                $this->_local_entity->set_value('clientID', $local_org_id->_id);
            } else if (MnoSoaDB::isDeletedIdentifier($local_org_id)) {
                // do not update
                return;
            } else {
                $notification->entity = "organizations";
                $notification->id = $this->_role->organization->id;
                $organization = new MnoSoaOrganization($this->_db, $this->_log);		
                $status = $organization->receiveNotification($notification);
		if ($status) {
                    $this->_local_entity->set_value('clientID', $organization->getLocalEntityIdentifier());
		}
            }
        }
    }
    
    protected function saveLocalEntity($push_to_maestrano, $status) {
        $this->_local_entity->save($push_to_maestrano);
    }
    
    public function getLocalEntityIdentifier() {
        return $this->_local_entity->key_field->value;
    }
}

?>