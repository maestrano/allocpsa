<?php

/**
 * Maestrano map table functions
 *
 * @author root
 */

class MnoSoaEntity extends MnoSoaBaseEntity {    
    public function getUpdates($timestamp)
    {
        MnoSoaLogger::info("start getUpdates (timestamp=" . $timestamp . ")");
        $msg = $this->callMaestrano("GET", "updates" . '/' . $timestamp);
        if (empty($msg)) { return false; }
        MnoSoaLogger::debug("after maestrano call");
        
        if (!empty($msg->organizations) && class_exists('MnoSoaOrganization')) {
            MnoSoaLogger::debug("has organizations");
            foreach ($msg->organizations as $organization) {
                MnoSoaLogger::debug("org id = " . $organization->id);
		try {
        	$mno_org = new MnoSoaOrganization();
        	$mno_org->receive($organization);
		} catch (Exception $e) {
		}
            }
        }
        if (!empty($msg->persons) && class_exists('MnoSoaPerson')) {
            MnoSoaLogger::debug("has persons");
            foreach ($msg->persons as $person) {
                MnoSoaLogger::debug("person id = " . $person->id);
                try {
                    $mno_person = new MnoSoaPerson();
                    $mno_person->receive($person);
                } catch (Exception $e) {
                }
            }
        }
	if (!empty($msg->projects) && class_exists('MnoSoaProject')) {
            MnoSoaLogger::debug("has projects");
            foreach ($msg->projects as $project) {
                MnoSoaLogger::debug("project id = " . $project->id);
                try {
                    $mno_org = new MnoSoaProject();
                    $mno_org->receive($project);
                } catch (Exception $e) {
                }
            }
        }
         
        if (!empty($msg->accounts) && class_exists('MnoSoaAccount')) {
            MnoSoaLogger::debug("has accounts");
            foreach ($msg->accounts as $account) {
                MnoSoaLogger::debug("*******************************************************************************************account id = " . $account->id);
                try {
                    $mno_acc = new MnoSoaAccount();
                    $mno_acc->receive($account);
                } catch (Exception $e) {
                }
            }
        }
        
        if (!empty($msg->items) && class_exists('MnoSoaItem')) {
            MnoSoaLogger::debug("has items");
            foreach ($msg->items as $item) {
                MnoSoaLogger::debug("item id = " . $item->id);
                try {
                    $mno_item = new MnoSoaItem();
                    $mno_item->receive($item);
                } catch (Exception $e) {
                }
            }
        }
         
        MnoSoaLogger::info("successful (timestamp=" . $timestamp . ")");
		return true;
    }
    
    public function getProjectUpdates($timestamp) {
        MnoSoaLogger::info("start timestamp=" . $timestamp);
        $msg = $this->callMaestrano("GET", "updates" . '/' . $timestamp);
        if (empty($msg)) { return false; }
        MnoSoaLogger::debug("after maestrano call");
        
	if (!empty($msg->projects) && class_exists('MnoSoaProject')) {
            MnoSoaLogger::debug("has projects");
            foreach ($msg->projects as $project) {
                MnoSoaLogger::debug("project id = " . $project->id);
                try {
                    $mno_org = new MnoSoaProject();
                    $mno_org->receive($project);
                } catch (Exception $e) {
                }
            }
        }
         
        MnoSoaLogger::info("successful timestamp=" . $timestamp);
		return true;
    }

    public function process_notification($notification)
    {
        $status = false;
        $notification_entity = strtoupper(trim($notification->entity));

        MnoSoaLogger::debug("Notification = ". json_encode($notification));

        switch ($notification_entity) {
            case "PROJECTS":
                if (class_exists('MnoSoaProject')) {
                    $mno_proj = new MnoSoaProject();
                    $status = $mno_proj->receiveNotification($notification);
                }
                break;
            case "PERSONS":
                if (class_exists('MnoSoaPerson')) {
                    $mno_person = new MnoSoaPerson();
                    $status = $mno_person->receiveNotification($notification);
                }
                break;
            case "ORGANIZATIONS":
                if (class_exists('MnoSoaOrganization')) {
                    $mno_org = new MnoSoaOrganization();
                    $status = $mno_org->receiveNotification($notification);
                }
                break;
            case "ACCOUNTS":
                if (class_exists('MnoSoaAccount')) {
                    $mno_acc = new MnoSoaAccount();
                    $status = $mno_acc->receiveNotification($notification);
                }
                break;
            case "ITEMS":
                if (class_exists('MnoSoaItem')) {
                    $mno_item = new MnoSoaItem();
                    $status = $mno_item->receiveNotification($notification);
                }
                break;
        }

        return $status;
    }
}
