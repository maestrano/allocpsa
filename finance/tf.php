<?php

/*
 * Copyright (C) 2006-2011 Alex Lance, Clancy Malcolm, Cyber IT Solutions
 * Pty. Ltd.
 * 
 * This file is part of the allocPSA application <info@cyber.com.au>.
 * 
 * allocPSA is free software: you can redistribute it and/or modify it
 * under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or (at
 * your option) any later version.
 * 
 * allocPSA is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 * FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public
 * License for more details.
 * 
 * You should have received a copy of the GNU Affero General Public License
 * along with allocPSA. If not, see <http://www.gnu.org/licenses/>.
*/

require_once("../alloc.php");

function show_person_list($template) {
  global $TPL;
  global $tf;
  $db = new db_alloc();
  $TPL["person_buttons"] = '
        <button type="submit" name="person_delete" value="1" class="delete_button">Delete<i class="icon-trash"></i></button>
        <button type="submit" name="person_save" value="1" class="save_button">Save<i class="icon-ok-sign"></i></button>';

  $tfID = $tf->get_id();

  if ($tfID) {
    $query = prepare("SELECT * from tfPerson WHERE tfID=%d", $tfID);
    $db->query($query);
    while ($db->next_record()) {
      $tfPerson = new tfPerson();
      $tfPerson->read_db_record($db);
      $tfPerson->set_values("person_");
      $person = $tfPerson->get_foreign_object("person");
      $TPL["person_username"] = $person->get_value("username");
      include_template($template);
    }
  }
}

function show_new_person($template) {
  global $TPL;
  $TPL["person_buttons"] = '
        <button type="submit" name="person_save" value="1" class="save_button">Add<i class="icon-plus-sign"></i></button>';

  $tfPerson = new tfPerson();
  $tfPerson->set_values("person_");
  include_template($template);
}

function show_person_options() {
  global $TPL;
  echo page::select_options(person::get_username_list($TPL["person_personID"]), $TPL["person_personID"]);
}

$db = new db_alloc();
$tf = new tf();

$tfID = $_GET["tfID"] or $tfID = $_POST["tfID"];
if ($tfID) {
  $tf->set_id($tfID);
  $tf->select();
} else {
  $tf_is_new = true;
}

if ($_POST["save"]) {
  $tf->read_globals();

  if ($_POST["isActive"]) {
    $tf->set_value("tfActive", 1);
  } else {
    $tf->set_value("tfActive", 0);
  }

  if ($tf->get_value("tfName") == "") {
    alloc_error("You must enter a name.");
  } else if ($tf->get_value("tfCode") == "") {
    alloc_error("You must enter a code.");
  } else {

    if (!$tf->get_id()) {
      $db = new db_alloc();
      $q = prepare("SELECT count(*) AS tally FROM tf WHERE tfName = '%s'",$tf->get_value("tfName"));
      $db->query($q);
      $db->next_record();
      $tf_is_taken = $db->f("tally");
    }

    if ($tf_is_taken) {
      alloc_error("That TF name is taken, please choose another.");
    } else {
      $tf->set_value("tfComments",rtrim($tf->get_value("tfComments")));
      $tf->save();
      $TPL["message_good"][] = "Your TF has been saved.";
      $tf_is_new and $TPL["message_help"][] = "Please now add the TF Owners who are allowed to access this TF.";
    }
  }


} else {

  if ($_POST["delete"]) {
    $tf->delete();
    alloc_redirect($TPL["url_alloc_tfList"]);
    exit();
  }
}

if ($_POST["person_save"] || $_POST["person_delete"]) {

  $tfPerson = new tfPerson();
  $tfPerson->read_globals();
  $tfPerson->read_globals("person_");
  if (!$_POST["person_personID"]) {
    alloc_error("Please select a person from the dropdown list.");
  } else if ($_POST["person_save"]) {
    $tfPerson->save();
    $TPL["message_good"][] = "Person added to TF.";
  } else if ($_POST["person_delete"]) {
    $tfPerson->delete();
  }
}


$tf->set_values();


$accountTypesOps = array("Asset"=>array(
                                            "Bank"=>array(
                                                                            "ASSET_BANK_CASHONHAND"=>"Cash on hand",
                                                                            "ASSET_BANK_CHECKING"=>"Checking",
                                                                            "ASSET_BANK_MONEYMARKET"=>"Money market",
                                                                            "ASSET_BANK_RENTSHELDINTRUST"=>"Rents held in trust",
                                                                            "ASSET_BANK_SAVINGS"=>"Savings",
                                                                            "ASSET_BANK_TRUSTACCOUNTS"=>"Trust accounts"
                                                         ), 
                                            "Other current asset"=>array(
                                                                            "ASSET_OTHERCURRENTASSET_ALLOWANCEFORBADDEBTS"=>"Allowance for bad debts",
                                                                            "ASSET_OTHERCURRENTASSET_DEVELOPMENTCOSTS"=>"Development costs",
                                                                            "ASSET_OTHERCURRENTASSET_EMPLOYEECASHADVANCES"=>"Employee cash advances",
                                                                            "ASSET_OTHERCURRENTASSET_OTHERCURRENTASSETS"=>"Other current assets",
                                                                            "ASSET_OTHERCURRENTASSET_INVENTORY"=>"Inventory",
                                                                            "ASSET_OTHERCURRENTASSET_INVESTMENT_MORTGAGEREALESTATELOANS"=>"Investment - Mortgage real estate loans",
                                                                            "ASSET_OTHERCURRENTASSET_INVESTMENT_OTHER"=>"Investment - Other",
                                                                            "ASSET_OTHERCURRENTASSET_INVESTMENT_TAXEXEMPTSECURITIES"=>"Investment - Tax exempt securities",
                                                                            "ASSET_OTHERCURRENTASSET_INVESTMENT_USGOVERNMENTOBLIGATIONS"=>"Investment - US government obligations",
                                                                            "ASSET_OTHERCURRENTASSET_LOANSTOOFFICERS"=>"Loans to officers",
                                                                            "ASSET_OTHERCURRENTASSET_LOANSTOOTHERS"=>"Loans to others",
                                                                            "ASSET_OTHERCURRENTASSET_LOANSTOSTOCKHOLDERS"=>"Loans to stockholders",
                                                                            "ASSET_OTHERCURRENTASSET_PREPAIDEXPENSES"=>"Prepaid expenses",
                                                                            "ASSET_OTHERCURRENTASSET_RETAINAGE"=>"Retainage",
                                                                            "ASSET_OTHERCURRENTASSET_UNDEPOSITEDFUNDS"=>"Undeposited Funds"    
                                                                        ), 
                                            "Fixed asset"=>array(
                                                                            "ASSET_FIXEDASSET_ACCUMULATEDDEPLETION"=>"Accumulated depletion",
                                                                            "ASSET_FIXEDASSET_ACCUMULATEDDEPRECIATION"=>"Accumulated depreciation",
                                                                            "ASSET_FIXEDASSET_DEPLETABLEASSETS"=>"Depletable assets",
                                                                            "ASSET_FIXEDASSET_FURNITUREANDFIXTURES"=>"Furniture and fixtures",
                                                                            "ASSET_FIXEDASSET_LAND"=>"Land",
                                                                            "ASSET_FIXEDASSET_LEASEHOLDIMPROVEMENTS"=>"Leasehold improvements",
                                                                            "ASSET_FIXEDASSET_OTHERFIXEDASSETS"=>"Other fixed assets",
                                                                            "ASSET_FIXEDASSET_ACCUMULATEDAMORTIZATION"=>"Accumulated amortization",
                                                                            "ASSET_FIXEDASSET_BUILDINGS"=>"Buildings",
                                                                            "ASSET_FIXEDASSET_INTANGIBLEASSETS"=>"Intangible assets",
                                                                            "ASSET_FIXEDASSET_MACHINERYANDEQUIPMENT"=>"Machinery and equipment",
                                                                            "ASSET_FIXEDASSET_VEHICLES"=>"Vehicles"
                                                                ), 
                                            "Other asset"=>array(
                                                                            "ASSET_OTHERASSET_LEASEBUYOUT"=>"Lease Buyout",
                                                                            "ASSET_OTHERASSET_OTHERLONGTERMASSETS"=>"Other long term assets",
                                                                            "ASSET_OTHERASSET_SECURITYDEPOSITS"=>"Security deposits",
                                                                            "ASSET_OTHERASSET_ACCUMULATEDAMORTIZATIONOFOTHERASSETS"=>"Accumulated amortization of other assets",
                                                                            "ASSET_OTHERASSET_GOODWILL"=>"Goodwill",
                                                                            "ASSET_OTHERASSET_LICENSES"=>"Licenses",
                                                                            "ASSET_OTHERASSET_ORGANIZATIONALCOSTS"=>"Organizational costs"
                                                                ), 
                                            "Accounts receivable"=>array(
                                                                            "ASSET_ACCOUNTSRECEIVABLE_ACCOUNTSRECEIVABLE"=>"Accounts receivable"
                                                                        )
                                       ),
                         "Equity"=>array(
                                            "Equity"=>array(
                                                                            "EQUITY_EQUITY_OPENINGBALANCEEQUITY"=>"Opening balance equity",
                                                                            "EQUITY_EQUITY_PARTNERSEQUITY"=>"Partners equity",
                                                                            "EQUITY_EQUITY_RETAINEDEARNINGS"=>"Retained earnings",
                                                                            "EQUITY_EQUITY_ACCUMULATEDADJUSTMENT"=>"Accumulated adjustment",
                                                                            "EQUITY_EQUITY_OWNERSEQUITY"=>"Owners equity",
                                                                            "EQUITY_EQUITY_PAIDINCAPITALORSURPLUS"=>"Paid in capital or surplus",
                                                                            "EQUITY_EQUITY_PARTNERCONTRIBUTIONS"=>"Partner contributions",
                                                                            "EQUITY_EQUITY_PARTNERDISTRIBUTIONS"=>"Partner distributions",
                                                                            "EQUITY_EQUITY_PREFERREDSTOCK"=>"Preferred stock",
                                                                            "EQUITY_EQUITY_COMMONSTOCK"=>"Common stock",
                                                                            "EQUITY_EQUITY_TREASURYSTOCK"=>"Treasury stock"
                                                           )
                                        ), 
                         "Expense"=>array (
                                            "Expense"=>array(
                                                                            "EXPENSE_EXPENSE_ADVERTISINGPROMOTIONAL"=>"Advertising promotional",
                                                                            "EXPENSE_EXPENSE_BADDEBTS"=>"Bad debts",
                                                                            "EXPENSE_EXPENSE_BANKCHARGES"=>"Bank charges",
                                                                            "EXPENSE_EXPENSE_CHARITABLECONTRIBUTIONS"=>"Charitable contributions",
                                                                            "EXPENSE_EXPENSE_ENTERTAINMENT"=>"Entertainment",
                                                                            "EXPENSE_EXPENSE_ENTERTAINMENTMEALS"=>"Entertainment meals",
                                                                            "EXPENSE_EXPENSE_EQUIPMENTRENTAL"=>"Equipment rental",
                                                                            "EXPENSE_EXPENSE_GLOBALTAXEXPENSE"=>"Global tax expense",
                                                                            "EXPENSE_EXPENSE_INSURANCE"=>"Insurance",
                                                                            "EXPENSE_EXPENSE_INTERESTPAID"=>"Interest paid",
                                                                            "EXPENSE_EXPENSE_LEGALPROFESSIONALFEES"=>"Legal professional fees",
                                                                            "EXPENSE_EXPENSE_OFFICEGENERALADMINISTRATIVEEXPENSES"=>"Office general administrative expenses",
                                                                            "EXPENSE_EXPENSE_OTHERMISCELLANEOUSSERVICECOST"=>"Other miscellaneous service cost",
                                                                            "EXPENSE_EXPENSE_PROMOTIONALMEALS"=>"Promotional meals",
                                                                            "EXPENSE_EXPENSE_RENTORLEASEOFBUILDINGS"=>"Rent or lease of buildings",
                                                                            "EXPENSE_EXPENSE_REPAIRMAINTENANCE"=>"Repair maintenance",
                                                                            "EXPENSE_EXPENSE_SHIPPINGFREIGHTDELIVERY"=>"Shipping freight delivery",
                                                                            "EXPENSE_EXPENSE_SUPPLIESMATERIALS"=>"Supplies materials",
                                                                            "EXPENSE_EXPENSE_TRAVEL"=>"Travel",
                                                                            "EXPENSE_EXPENSE_TRAVELMEALS"=>"Travel meals",
                                                                            "EXPENSE_EXPENSE_UTILITIES"=>"Utilities",
                                                                            "EXPENSE_EXPENSE_AUTO"=>"Auto",
                                                                            "EXPENSE_EXPENSE_COSTOFLABOR"=>"Cost of labor",
                                                                            "EXPENSE_EXPENSE_DUESSUBSCRIPTIONS"=>"Dues subscriptions",
                                                                            "EXPENSE_EXPENSE_PAYROLL_EXPENSES"=>"Payroll expenses",
                                                                            "EXPENSE_EXPENSE_TAXESPAID"=>"Taxes paid"
                                                            ),
                                            "Other expense"=>array(
                                                                            "EXPENSE_OTHEREXPENSE_DEPRECIATION"=>"Depreciation",
                                                                            "EXPENSE_OTHEREXPENSE_EXCHANGEGAINORLOSS"=>"Exchange gain or loss",
                                                                            "EXPENSE_OTHEREXPENSE_OTHERMISCELLANEOUSEXPENSE"=>"Other miscellaneous expense",
                                                                            "EXPENSE_OTHEREXPENSE_PENALTIESSETTLEMENTS"=>"Penalties settlements",
                                                                            "EXPENSE_OTHEREXPENSE_AMORTIZATION"=>"Amortization"
                                                                  ),
                                            "Cost of goods sold"=>array(
                                                                            "EXPENSE_COSTOFGOODSSOLD_EQUIPMENTRENTALCOS"=>"Equipment rental cost of sales",
                                                                            "EXPENSE_COSTOFGOODSSOLD_OTHERCOSTSOFSERVICECOS"=>"Other costs of service cost of sales",
                                                                            "EXPENSE_COSTOFGOODSSOLD_SHIPPINGFREIGHTDELIVERYCOS"=>"Shipping freight delivery cost of sales",
                                                                            "EXPENSE_COSTOFGOODSSOLD_SUPPLIESMATERIALSCOGS"=>"Supplies materials cost of goods sold",
                                                                            "EXPENSE_COSTOFGOODSSOLD_COSTOFLABORCOS"=>"Cost of labor cost of goods sold"
                                                                       )
                                          ),
                         "Liability"=>array (
                                            "Accounts payable"=>array(
                                                                            "LIABILITY_ACCOUNTSPAYABLE_ACCOUNTSPAYABLE"=>"Accounts payable"
                                                                     ),
                                            "Credit card"=>array(
                                                                            "LIABILITY_CREDITCARD_CREDITCARD"=>"Credit card"
                                                                ),
                                            "Long term liability"=>array(
                                                                            "LIABILITY_LONGTERMLIABILITY_NOTESPAYABLE"=>"Notes payable",
                                                                            "LIABILITY_LONGTERMLIABILITY_OTHERLONGTERMLIABILITIES"=>"Other long term liabilities",
                                                                            "LIABILITY_LONGTERMLIABILITY_SHAREHOLDERNOTESPAYABLE"=>"Shareholder notes payable"
                                                                        ),
                                            "Other current liability"=>array(
                                                                            "LIABILITY_OTHERCURRENTLIABILITY_DIRECTDEPOSITPAYABLE"=>"Direct deposit payable",
                                                                            "LIABILITY_OTHERCURRENTLIABILITY_LINEOFCREDIT"=>"Line of credit",
                                                                            "LIABILITY_OTHERCURRENTLIABILITY_LOANPAYABLE"=>"Loan payable",
                                                                            "LIABILITY_OTHERCURRENTLIABILITY_GLOBALTAXPAYABLE"=>"Global tax payable",
                                                                            "LIABILITY_OTHERCURRENTLIABILITY_GLOBALTAXSUSPENSE"=>"Global tax suspense",
                                                                            "LIABILITY_OTHERCURRENTLIABILITY_OTHERCURRENTLIABILITIES"=>"Other current liabilities",
                                                                            "LIABILITY_OTHERCURRENTLIABILITY_PAYROLLCLEARING"=>"Payroll clearing",
                                                                            "LIABILITY_OTHERCURRENTLIABILITY_PAYROLLTAXPAYABLE"=>"Payroll tax payable",
                                                                            "LIABILITY_OTHERCURRENTLIABILITY_PREPAIDEXPENSESPAYABLE"=>"Prepaid expenses payable",
                                                                            "LIABILITY_OTHERCURRENTLIABILITY_RENTSINTRUSTLIABILITY"=>"Rents in trust liability",
                                                                            "LIABILITY_OTHERCURRENTLIABILITY_TRUSTACCOUNTSLIABILITIES"=>"Trust accounts liabilities",
                                                                            "LIABILITY_OTHERCURRENTLIABILITY_FEDERALINCOMETAXPAYABLE"=>"Federal income tax payable",
                                                                            "LIABILITY_OTHERCURRENTLIABILITY_INSURANCEPAYABLE"=>"Insurance payable",
                                                                            "LIABILITY_OTHERCURRENTLIABILITY_SALESTAXPAYABLE"=>"Sales tax payable",
                                                                            "LIABILITY_OTHERCURRENTLIABILITY_STATELOCALINCOMETAXPAYABLE"=>"State local income tax payable"
                                                                            )
                                            ), 
                         "Revenue"=>array(
                                            "Income"=>array(
                                                                            "REVENUE_INCOME_NONPROFITINCOME"=>"Non profit income",
                                                                            "REVENUE_INCOME_OTHERPRIMARYINCOME"=>"Other primary income",
                                                                            "REVENUE_INCOME_SALESOFPRODUCTINCOME"=>"Sales of product income",
                                                                            "REVENUE_INCOME_SERVICEFEEINCOME"=>"Service fee income",
                                                                            "REVENUE_INCOME_DISCOUNTSREFUNDSGIVEN"=>"Discounts refunds given"
                                                           ),
                                            "Other income"=>array(
                                                                            "REVENUE_OTHERINCOME_DIVIDENDINCOME"=>"Dividend income",
                                                                            "REVENUE_OTHERINCOME_INTERESTEARNED"=>"Interest earned",
                                                                            "REVENUE_OTHERINCOME_OTHERINVESTMENTINCOME"=>"Other investment income",
                                                                            "REVENUE_OTHERINCOME_OTHERMISCELLANEOUSINCOME"=>"Other miscellaneous income",
                                                                            "REVENUE_OTHERINCOME_TAXEXEMPTINTEREST"=>"Tax exempt interest"
                                                                 )
                                         )
                      );

$TPL["accountTypeOptions"] = page::select_account_type_option_groups($accountTypesOps,$tf->get_value("accountTypeID"));
$TPL["accountTypeID"] = $tf->get_value("accountTypeID");


$TPL["tfModifiedTime"] = $tf->get_value("tfModifiedTime");
if ($tf->get_value("tfModifiedUser")) {
  $TPL["tfModifiedUser"] = person::get_fullname($tf->get_value("tfModifiedUser"));
}

$tf->get_value("tfActive") || !$tf->get_id() and $TPL["tfIsActive"] = " checked";

$TPL["main_alloc_title"] = "Edit TF - ".APPLICATION_NAME;

if (!$tf->get_id()) {
  $TPL["message_help"][] = "Enter the details below and click the Save button to create a new Tagged Fund. 
                            <br><br>A Tagged Fund or TF, is like a sort of bank account within allocPSA. 
                            It contains transactions which track the transfer of monies.";
}

include_template("templates/tfM.tpl");


?>
