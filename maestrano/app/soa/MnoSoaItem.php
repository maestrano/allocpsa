<?php

/**
 * Mno Organization Class
 */
class MnoSoaItem extends MnoSoaBaseItem
{
    protected $_local_entity_name = "PRODUCT";
    protected $_local_item_id = null;
    
    protected function pushItem()
    {
        // PUSH ID
        $id = $this->getLocalEntityIdentifier();
        if (empty($id)) { return; }
        $mno_id = MnoSoaDB::getMnoIdByLocalId($id, $this->getLocalEntityName(), $this->getMnoEntityName());
        $this->_id = (MnoSoaDB::isValidIdentifier($mno_id)) ? $mno_id->_id : null;
        
        $item_query = "SELECT 
                            prod.productCode as code,
                            prod.productName as name, prod.description as description, prod.productTypeID as type, prod.productUnit as unit,
                            (prod.sellPrice/100) as salePrice, prod.sellPriceCurrencyTypeID as saleCurrency, prod.productActive as status, 
                  
                            prodCostActive.productCostID as activePurchaseProductCostID,
                            (prodCostActive.amount/100) as activePurchasePrice, prodCostActive.currencyTypeID as activePurchaseCurrency, 
                            prodCostActive.productCostActive as activePurchaseStatus
                  FROM      product prod 
                            LEFT OUTER JOIN productCost prodCostActive 
                            ON  prod.productID = prodCostActive.productID AND 
                                prodCostActive.productCostID = (SELECT max(productCostID) FROM productCost WHERE productID = '$this->_local_item_id' and productCostActive = 1)
                  WHERE prod.productID = '$id'";
        
        $item = $this->_db->query($item_query);
        if (empty($item)) { return null; }
        $item = (object) $this->_db->next_record();

        // PUSH CODE
        $this->_code = $this->push_set_or_delete_value($item->code);
        // PUSH NAME
        $this->_name = $this->push_set_or_delete_value($item->name);
        // PUSH DESCRIPTION
        $this->_description = $this->push_set_or_delete_value($item->description);
        // PUSH TYPE
        $this->_type = $this->push_set_or_delete_value($item->type);
        // PUSH UNIT
        $this->_unit = $this->push_set_or_delete_value($item->unit);
        // PUSH SALE->PRICE
        $this->_sale->price = $this->push_set_or_delete_value($item->salePrice);
        // PUSH SALE->CURRENCY
        $this->_sale->currency = $this->push_set_or_delete_value($item->saleCurrency);
        // PUSH PURCHASE->PRICE
        $this->_purchase->price = $this->push_set_or_delete_value($item->activePurchasePrice);
        // PUSH PURCHASE->CURRENCY
        $this->_purchase->currency = $this->push_set_or_delete_value($item->activePurchaseCurrency);
        // PUSH STATUS
        $this->_status = $this->mapStatusToMnoFormat($item->status);
    }
    
    protected function pullItem()
    {
        // PULL ID
        if (empty($this->_id)) { return constant('MnoSoaBaseEntity::STATUS_ERROR'); }
        $local_id = MnoSoaDB::getLocalIdByMnoId($this->_id, $this->getMnoEntityName(), $this->getLocalEntityName());
        if (MnoSoaDB::isDeletedIdentifier($local_id)) { return constant('MnoSoaBaseEntity::STATUS_DELETED_ID'); }
        
        // PULL CODE
        $code = $this->pull_set_or_delete_value($this->_code);
        // PULL NAME
        $name = $this->pull_set_or_delete_value($this->_name);
        // PULL DESCRIPTION
        $description = $this->pull_set_or_delete_value($this->_description);
        // PULL TYPE
        $type = $this->pull_set_or_delete_value($this->_type);
        // PULL UNIT
        $unit = $this->pull_set_or_delete_value($this->_unit);
        // PULL SALE PRICE/CURRENCY
        $salePrice = floor(floatval($this->pull_set_or_delete_value($this->_sale->price, 0)) * 100);
        $saleCurrency = $this->pull_set_or_delete_value($this->_sale->currency);
        // PULL PURCHASE PRICE/CURRENCY
        $purchasePrice = floor(floatval($this->pull_set_or_delete_value($this->_purchase->price, 0)) * 100);
        $purchaseCurrency = $this->pull_set_or_delete_value($this->_purchase->currency);
        // PULL STATUS
        $status = $this->mapStatusToLocalFormat($this->_status);
        // UPDATE ITEM
        if (MnoSoaDB::isValidIdentifier(($local_id))) { 
            $return_status = constant('MnoSoaBaseEntity::STATUS_EXISTING_ID');
            $this->_local_item_id = $local_id->_id;
            
            $item_query = " UPDATE product
                            SET productCode='$code', productName='$name', description='$description', productTypeID='$type', productUnit='$unit', 
                                sellPrice='$salePrice', sellPriceCurrencyTypeID='$saleCurrency', productActive='$status'
                            WHERE productID = '$this->_local_item_id'";
            $this->_db->query($item_query);
        // INSERT ITEM
        } else {
            $return_status = constant('MnoSoaBaseEntity::STATUS_NEW_ID');
            
            $item_query = " INSERT product
                            (productCode, productName, sellPrice, sellPriceCurrencyTypeID, sellPriceIncTax, description, comment, productActive, productTypeID, productUnit)
                            VALUES
                            ('$code', '$name', '$salePrice', '$saleCurrency', '0', '$description', '', '$status', '$type', '$unit')
                            ";
            $this->_db->query($item_query);
            $this->_local_item_id = $this->_db->get_insert_id();
            MnoSoaDB::addIdMapEntry($this->_local_item_id, $this->getLocalEntityName(), $this->_id, $this->getMnoEntityName());
        }
        
        // PULL PURCHASE PRICE/CURRENCY/STATUS
        if (!empty($this->_purchase)) {
            $product_cost_query = "SELECT productCostID FROM productCost WHERE productID='$this->_local_item_id' AND productCostActive='1'";
            $product_cost = $this->_db->query($product_cost_query);
            if (!empty($product_cost)) { 
                $product_cost = (object) $this->_db->next_record();
                if (!empty($product_cost)) {
                    $product_cost_id = $product_cost->productCostID;
                }
            }
            
            // UPDATE PURCHASE PRICE
            if (!empty($product_cost_id)) {
                $update_query = "   UPDATE productCost
                                    SET productID = '$this->_local_item_id', amount='$purchasePrice', currencyTypeID='$purchaseCurrency', productCostActive='1'
                                    WHERE productCostID='$product_cost_id'
                                ";
                $this->_db->query($update_query);
            // INSERT PURCHASE PRICE
            } else {
                $insert_query = " INSERT productCost 
                                  (productID, tfID, amount, currencyTypeID, isPercentage, description, tax, productCostActive)
                                  VALUES
                                  ('$this->_local_item_id', '1', '$purchasePrice', '$purchaseCurrency', '0', NULL, NULL, '1')
                                ";                
                $this->_db->query($insert_query);
            }
        } else {
        // RESET 
            $update_query = "UPDATE productCost SET productCostActive='0' WHERE productID='$this->_local_item_id'";
            $this->_db->query($update_query);
        }
        
        return $return_status;
    }
    
    protected function saveLocalEntity($push_to_maestrano, $status) {
        // DO NOTHING
    }
    
    public function setLocalEntityIdentifier($local_identifier)
    {
        $this->_local_item_id = $local_identifier;
    }
    
    public function getLocalEntityIdentifier() {
        return $this->_local_item_id;
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