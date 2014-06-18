<?php

function push_project_to_maestrano($local_project_id)
{
    
    MnoSoaLogger::debug("local_project_id=" . $local_project_id);
    
    if (empty($local_project_id)) { return; }
    
    try {
        $maestrano = MaestranoService::getInstance();
        if (!$maestrano->isSoaEnabled() or !$maestrano->getSoaUrl()) { return; }

        $mno_proj=new MnoSoaProject();
        $mno_proj->setLocalEntityIdentifier($local_project_id);
        $mno_proj->send(null);
    } catch (Exception $ex) {
        // DO NOTHING
        MnoSoaLogger::debug("error=" . $ex->getMessage());
        MnoSoaLogger::debug("trace=" . json_encode($ex->getTrace()));
    }
}

function push_product_to_maestrano($local_product_id)
{
    MnoSoaLogger::debug("local_product_id=$local_product_id");
    
    if (empty($local_product_id)) { return; }
    
    try {
        $maestrano = MaestranoService::getInstance();
        if (!$maestrano->isSoaEnabled() or !$maestrano->getSoaUrl()) { return; }

        $mno_prod=new MnoSoaItem();
        $mno_prod->setLocalEntityIdentifier($local_product_id);
        $mno_prod->send(null);
    } catch (Exception $ex) {
        // DO NOTHING
        MnoSoaLogger::debug("error=" . $ex->getMessage());
        MnoSoaLogger::debug("trace=" . json_encode($ex->getTrace()));
    }
}

function push_account_to_maestrano($local_account_id)
{
    MnoSoaLogger::debug("local_account_id=$local_account_id");
    
    if (empty($local_account_id)) { return; }
    
    try {
        $maestrano = MaestranoService::getInstance();
        if (!$maestrano->isSoaEnabled() or !$maestrano->getSoaUrl()) { return; }

        $mno_acc=new MnoSoaAccount();
        $mno_acc->setLocalEntityIdentifier($local_account_id);
        $mno_acc->send(null);
    } catch (Exception $ex) {
        // DO NOTHING
        MnoSoaLogger::debug("error=" . $ex->getMessage());
        MnoSoaLogger::debug("trace=" . json_encode($ex->getTrace()));
    }
}

?>

