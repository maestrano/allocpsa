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

  function check_optional_client_exists() {
    global $clientID;
    return $clientID;
  }

  function show_client_contacts() {
    global $TPL;
    global $clientID;

    $TPL["clientContact_clientID"] = $clientID;

    if ($_POST["clientContact_delete"] && $_POST["clientContactID"]) {
      $clientContact = new clientContact();
      $clientContact->set_id($_POST["clientContactID"]);
      $clientContact->delete();
    }

    $client = new client();
    $client->set_id($clientID);
    $client->select();

    // other contacts
    $query = prepare("SELECT * 
                        FROM clientContact
                       WHERE clientID=%d    
                    ORDER BY clientContactActive DESC, primaryContact DESC, clientContactName", $clientID);

    $db = new db_alloc();
    $db->query($query);
    while ($db->next_record()) {
      $clientContact = new clientContact();
      $clientContact->read_db_record($db);

      if ($_POST["clientContact_edit"] && $_POST["clientContactID"] == $clientContact->get_id()) {
        continue;
      }


      $pc = "";
      if ($clientContact->get_value("primaryContact")) {
        $pc = " [Primary]";
      }

      $vcard_img = "icon_vcard.png";
      $clientContact->get_value("clientContactActive") or $vcard_img = "icon_vcard_faded.png";

      $vcard = '<a href="'.$TPL["url_alloc_client"].'clientContactID='.$clientContact->get_id().'&get_vcard=1"><img style="vertical-align:middle; padding:3px 6px 3px 3px;border: none" src="'.$TPL["url_alloc_images"].$vcard_img.'" alt="Download VCard" ></a>';

      $col1 = array();
      $clientContact->get_value('clientContactName') and $col1[] = "<h2 style='margin:0px; display:inline;'>".$vcard.$clientContact->get_value('clientContactName',DST_HTML_DISPLAY)."</h2>".$pc;
      $clientContact->get_value('clientContactStreetAddress') and $col1[] = $clientContact->get_value('clientContactStreetAddress',DST_HTML_DISPLAY);

      $clientContact->get_value('clientContactSuburb') || $clientContact->get_value('clientContactState') || $clientContact->get_value('clientContactPostcode') and
      $col1[] = $clientContact->get_value('clientContactSuburb',DST_HTML_DISPLAY).' '.$clientContact->get_value('clientContactState',DST_HTML_DISPLAY)." ".$clientContact->get_value('clientContactPostcode',DST_HTML_DISPLAY);

      $clientContact->get_value('clientContactCountry') and $col1[] = $clientContact->get_value('clientContactCountry',DST_HTML_DISPLAY);


      // find some gpl icons!
      #$ico_e = "<img src=\"".$TPL["url_alloc_images"]."/icon_email.gif\">";
      #$ico_p = "<img src=\"".$TPL["url_alloc_images"]."/icon_phone.gif\">";
      #$ico_m = "<img src=\"".$TPL["url_alloc_images"]."/icon_mobile.gif\">";
      #$ico_f = "<img src=\"".$TPL["url_alloc_images"]."/icon_fax.gif\">";

      $ico_e = "E: ";
      $ico_p = "P: ";
      $ico_m = "M: ";
      $ico_f = "F: ";

      $col2 = array();
      $email = $clientContact->get_value("clientContactEmail",DST_HTML_DISPLAY);
      $email = str_replace("<","",$email);
      $email = str_replace(">","",$email);
      $email = str_replace("&lt;","",$email);
      $email = str_replace("&gt;","",$email);

      $userName = $clientContact->get_value('clientContactName', DST_HTML_DISPLAY);
      if ($userName) {
          $mailto = '"' . $userName . '" <' . $email . ">";
      } else {
          $mailto = $email;
      }
      $email and $col2[] = $ico_e."<a href='mailto:".rawurlencode($mailto)."'>".$email."</a>";

      $phone = $clientContact->get_value('clientContactPhone',DST_HTML_DISPLAY);
      $phone and $col2[] = $ico_p.$phone;

      $mobile = $clientContact->get_value('clientContactMobile',DST_HTML_DISPLAY);
      $mobile and $col2[] = $ico_m.$mobile;

      $fax = $clientContact->get_value('clientContactFax',DST_HTML_DISPLAY);
      $fax and $col2[] = $ico_f.$fax;

      if ($clientContact->get_value("clientContactActive")) {
        $class_extra = " loud";
      } else {
        $class_extra = " quiet";
      }

      $buttons = '<nobr>
      <button type="submit" name="clientContact_delete" value="1" class="delete_button">Delete<i class="icon-trash"></i></button>
      <button type="submit" name="clientContact_edit" value="1"">Edit<i class="icon-edit"></i></button>
      </nobr>';

      $rtn[] =  '<form action="'.$TPL["url_alloc_client"].'" method="post">';
      $rtn[] =  '<input type="hidden" name="clientContactID" value="'.$clientContact->get_id().'">';
      $rtn[] =  '<input type="hidden" name="clientID" value="'.$clientID.'">';
      $rtn[] =  '<div class="panel'.$class_extra.' corner">';
      $rtn[] =  '<table width="100%" cellspacing="0" border="0">';
      $rtn[] =  '<tr>';
      $rtn[] =  '  <td width="25%" valign="top"><span class="nobr">'.implode('</span><br><span class="nobr">',$col1).'</span>&nbsp;</td>';
      $rtn[] =  '  <td width="20%" valign="top"><span class="nobr">'.implode('</span><br><span class="nobr">',$col2).'</span>&nbsp;</td>';
      $rtn[] =  '  <td width="50%" align="left" valign="top">'.nl2br($clientContact->get_value('clientContactOther',DST_HTML_DISPLAY)).'&nbsp;</td>';
      $rtn[] =  '  <td align="right" class="right nobr">'.$buttons.'</td>';
      $rtn[] =  '  <td align="right" class="right nobr" width="1%">'.page::star("clientContact",$clientContact->get_id()).'</td>';
      $rtn[] =  '</tr>';
      $rtn[] =  '</table>';
      $rtn[] =  '</div>';
      $rtn[] =  '<input type="hidden" name="sessID" value="'.$TPL["sessID"].'">';
      $rtn[] =  '</form>';

    }

    if (is_array($rtn)) { 
      $TPL["clientContacts"] = implode("\n",$rtn);
    } 
    if ($_POST["clientContact_edit"] && $_POST["clientContactID"]) {
      $clientContact = new clientContact();
      $clientContact->set_id($_POST["clientContactID"]);
      $clientContact->select();
      $clientContact->set_values("clientContact_");
      if ($clientContact->get_value("primaryContact")) {
        $TPL["primaryContact_checked"] = " checked";
      }
      if ($clientContact->get_value("clientContactActive")) {
        $TPL["clientContactActive_checked"] = " checked";
      }
    } else if ($rtn) {
      $TPL["class_new_client_contact"] = "hidden";
    }

    if (!$_POST["clientContactID"] || $_POST["clientContact_save"]) {
      $TPL["clientContactActive_checked"] = " checked";
    }

    include_template("templates/clientContactM.tpl");
  }

  function show_attachments() {
    global $clientID;
    util_show_attachments("client",$clientID);
  }
 
  function show_comments() {
    global $clientID;
    global $TPL;
    global $client;
    $TPL["commentsR"] = comment::util_get_comments("client",$clientID);
    $TPL["commentsR"] and $TPL["class_new_comment"] = "hidden";
    $interestedPartyOptions = $client->get_all_parties();
    $interestedPartyOptions = interestedParty::get_interested_parties("client",$client->get_id()
                                                                     ,$interestedPartyOptions);
    $TPL["allParties"] = $interestedPartyOptions or $TPL["allParties"] = array();
    $TPL["entity"] = "client";
    $TPL["entityID"] = $client->get_id();
    $TPL["clientID"] = $client->get_id();

    $commentTemplate = new commentTemplate();
    $ops = $commentTemplate->get_assoc_array("commentTemplateID","commentTemplateName","",array("commentTemplateType"=>"client"));
    $TPL["commentTemplateOptions"] = "<option value=\"\">Comment Templates</option>".page::select_options($ops);
    include_template("../comment/templates/commentM.tpl");
  }

  function show_invoices() {
    $current_user = &singleton("current_user");
    global $clientID;

    $_FORM["showHeader"] = true;
    $_FORM["showInvoiceNumber"] = true;
    $_FORM["showInvoiceClient"] = true;
    $_FORM["showInvoiceName"] = true;
    $_FORM["showInvoiceAmount"] = true;
    $_FORM["showInvoiceAmountPaid"] = true;
    $_FORM["showInvoiceDate"] = true;
    $_FORM["showInvoiceStatus"] = true;
    $_FORM["clientID"] = $clientID;

    // Restrict non-admin users records  
    if (!$current_user->have_role("admin")) {
      $_FORM["personID"] = $current_user->get_id();  
    }

    $rows = invoice::get_list($_FORM);
    echo invoice::get_list_html($rows,$_FORM);
  }

  
  function countryList($list_name) {
     return '<select name="'.$list_name.'" id="'.$list_name.'">
     <option value=""></option>
     <option value="AF">Afghanistan</option>
     <option value="AX">Aland Islands</option>
     <option value="AL">Albania</option>
     <option value="DZ">Algeria</option>
     <option value="AS">American Samoa</option>
     <option value="AD">Andorra</option>
     <option value="AO">Angola</option>
     <option value="AI">Anguilla</option>
     <option value="AQ">Antarctica</option>
     <option value="AG">Antigua and Barbuda</option>
     <option value="AR">Argentina</option>
     <option value="AM">Armenia</option>
     <option value="AW">Aruba</option>
     <option value="AU">Australia</option>
     <option value="AT">Austria</option>
     <option value="AZ">Azerbaijan</option>
     <option value="BS">Bahamas</option>
     <option value="BH">Bahrain</option>
     <option value="BD">Bangladesh</option>
     <option value="BB">Barbados</option>
     <option value="BY">Belarus</option>
     <option value="BE">Belgium</option>
     <option value="BZ">Belize</option>
     <option value="BJ">Benin</option>
     <option value="BM">Bermuda</option>
     <option value="BT">Bhutan</option>
     <option value="BO">Bolivia, Plurinational State of</option>
     <option value="BQ">Bonaire, Saint Eustatius and Saba</option>
     <option value="BA">Bosnia and Herzegovina</option>
     <option value="BW">Botswana</option>
     <option value="BV">Bouvet Island</option>
     <option value="BR">Brazil</option>
     <option value="IO">British Indian Ocean Territory</option>
     <option value="BN">Brunei Darussalam</option>
     <option value="BG">Bulgaria</option>
     <option value="BF">Burkina Faso</option>
     <option value="BI">Burundi</option>
     <option value="KH">Cambodia</option>
     <option value="CM">Cameroon</option>
     <option value="CA">Canada</option>
     <option value="CV">Cape Verde</option>
     <option value="KY">Cayman Islands</option>
     <option value="CF">Central African Republic</option>
     <option value="TD">Chad</option>
     <option value="CL">Chile</option>
     <option value="CN">China</option>
     <option value="CX">Christmas Island</option>
     <option value="CC">Cocos (Keeling) Islands</option>
     <option value="CO">Colombia</option>
     <option value="KM">Comoros</option>
     <option value="CG">Congo</option>
     <option value="CD">Congo, The Democratic Republic of the</option>
     <option value="CK">Cook Islands</option>
     <option value="CR">Costa Rica</option>
     <option value="CI">Cote d\'Ivoire</option>
     <option value="HR">Croatia</option>
     <option value="CU">Cuba</option>
     <option value="CW">Curacao</option>
     <option value="CY">Cyprus</option>
     <option value="CZ">Czech Republic</option>
     <option value="DK">Denmark</option>
     <option value="DJ">Djibouti</option>
     <option value="DM">Dominica</option>
     <option value="DO">Dominican Republic</option>
     <option value="EC">Ecuador</option>
     <option value="EG">Egypt</option>
     <option value="SV">El Salvador</option>
     <option value="GQ">Equatorial Guinea</option>
     <option value="ER">Eritrea</option>
     <option value="EE">Estonia</option>
     <option value="ET">Ethiopia</option>
     <option value="FK">Falkland Islands (Malvinas)</option>
     <option value="FO">Faroe Islands</option>
     <option value="FJ">Fiji</option>
     <option value="FI">Finland</option>
     <option value="FR">France</option>
     <option value="GF">French Guiana</option>
     <option value="PF">French Polynesia</option>
     <option value="TF">French Southern Territories</option>
     <option value="GA">Gabon</option>
     <option value="GM">Gambia</option>
     <option value="GE">Georgia</option>
     <option value="DE">Germany</option>
     <option value="GH">Ghana</option>
     <option value="GI">Gibraltar</option>
     <option value="GR">Greece</option>
     <option value="GL">Greenland</option>
     <option value="GD">Grenada</option>
     <option value="GP">Guadeloupe</option>
     <option value="GU">Guam</option>
     <option value="GT">Guatemala</option>
     <option value="GG">Guernsey</option>
     <option value="GN">Guinea</option>
     <option value="GW">Guinea-Bissau</option>
     <option value="GY">Guyana</option>
     <option value="HT">Haiti</option>
     <option value="HM">Heard Island and McDonald Islands</option>
     <option value="VA">Holy See (Vatican City State)</option>
     <option value="HN">Honduras</option>
     <option value="HK">Hong Kong</option>
     <option value="HU">Hungary</option>
     <option value="IS">Iceland</option>
     <option value="IN">India</option>
     <option value="ID">Indonesia</option>
     <option value="IR">Iran, Islamic Republic of</option>
     <option value="IQ">Iraq</option>
     <option value="IE">Ireland</option>
     <option value="IM">Isle of Man</option>
     <option value="IL">Israel</option>
     <option value="IT">Italy</option>
     <option value="JM">Jamaica</option>
     <option value="JP">Japan</option>
     <option value="JE">Jersey</option>
     <option value="JO">Jordan</option>
     <option value="KZ">Kazakhstan</option>
     <option value="KE">Kenya</option>
     <option value="KI">Kiribati</option>
     <option value="KP">Korea, Democratic People\'s Republic of</option>
     <option value="KR">Korea, Republic of</option>
     <option value="KW">Kuwait</option>
     <option value="KG">Kyrgyzstan</option>
     <option value="LA">Lao People\'s Democratic Republic</option>
     <option value="LV">Latvia</option>
     <option value="LB">Lebanon</option>
     <option value="LS">Lesotho</option>
     <option value="LR">Liberia</option>
     <option value="LY">Libyan Arab Jamahiriya</option>
     <option value="LI">Liechtenstein</option>
     <option value="LT">Lithuania</option>
     <option value="LU">Luxembourg</option>
     <option value="MO">Macao</option>
     <option value="MK">Macedonia, The Former Yugoslav Republic of</option>
     <option value="MG">Madagascar</option>
     <option value="MW">Malawi</option>
     <option value="MY">Malaysia</option>
     <option value="MV">Maldives</option>
     <option value="ML">Mali</option>
     <option value="MT">Malta</option>
     <option value="MH">Marshall Islands</option>
     <option value="MQ">Martinique</option>
     <option value="MR">Mauritania</option>
     <option value="MU">Mauritius</option>
     <option value="YT">Mayotte</option>
     <option value="MX">Mexico</option>
     <option value="FM">Micronesia, Federated States of</option>
     <option value="MD">Moldova, Republic of</option>
     <option value="MC">Monaco</option>
     <option value="MN">Mongolia</option>
     <option value="ME">Montenegro</option>
     <option value="MS">Montserrat</option>
     <option value="MA">Morocco</option>
     <option value="MZ">Mozambique</option>
     <option value="MM">Myanmar</option>
     <option value="NA">Namibia</option>
     <option value="NR">Nauru</option>
     <option value="NP">Nepal</option>
     <option value="NL">Netherlands</option>
     <option value="NC">New Caledonia</option>
     <option value="NZ">New Zealand</option>
     <option value="NI">Nicaragua</option>
     <option value="NE">Niger</option>
     <option value="NG">Nigeria</option>
     <option value="NU">Niue</option>
     <option value="NF">Norfolk Island</option>
     <option value="MP">Northern Mariana Islands</option>
     <option value="NO">Norway</option>
     <option value="PS">Occupied Palestinian Territory</option>
     <option value="OM">Oman</option>
     <option value="PK">Pakistan</option>
     <option value="PW">Palau</option>
     <option value="PA">Panama</option>
     <option value="PG">Papua New Guinea</option>
     <option value="PY">Paraguay</option>
     <option value="PE">Peru</option>
     <option value="PH">Philippines</option>
     <option value="PN">Pitcairn</option>
     <option value="PL">Poland</option>
     <option value="PT">Portugal</option>
     <option value="PR">Puerto Rico</option>
     <option value="QA">Qatar</option>
     <option value="RE">Reunion</option>
     <option value="RO">Romania</option>
     <option value="RU">Russian Federation</option>
     <option value="RW">Rwanda</option>
     <option value="BL">Saint Barthelemy</option>
     <option value="SH">Saint Helena, Ascension and Tristan da Cunha</option>
     <option value="KN">Saint Kitts and Nevis</option>
     <option value="LC">Saint Lucia</option>
     <option value="MF">Saint Martin (French part)</option>
     <option value="PM">Saint Pierre and Miquelon</option>
     <option value="VC">Saint Vincent and The Grenadines</option>
     <option value="WS">Samoa</option>
     <option value="SM">San Marino</option>
     <option value="ST">Sao Tome and Principe</option>
     <option value="SA">Saudi Arabia</option>
     <option value="SN">Senegal</option>
     <option value="RS">Serbia</option>
     <option value="SC">Seychelles</option>
     <option value="SL">Sierra Leone</option>
     <option value="SG">Singapore</option>
     <option value="SX">Sint Maarten (Dutch part)</option>
     <option value="SK">Slovakia</option>
     <option value="SI">Slovenia</option>
     <option value="SB">Solomon Islands</option>
     <option value="SO">Somalia</option>
     <option value="ZA">South Africa</option>
     <option value="GS">South Georgia and the South Sandwich Islands</option>
     <option value="ES">Spain</option>
     <option value="LK">Sri Lanka</option>
     <option value="SD">Sudan</option>
     <option value="SR">Suriname</option>
     <option value="SJ">Svalbard and Jan Mayen</option>
     <option value="SZ">Swaziland</option>
     <option value="SE">Sweden</option>
     <option value="CH">Switzerland</option>
     <option value="SY">Syrian Arab Republic</option>
     <option value="TW">Taiwan, Province of China</option>
     <option value="TJ">Tajikistan</option>
     <option value="TZ">Tanzania, United Republic of</option>
     <option value="TH">Thailand</option>
     <option value="TL">Timor-Leste</option>
     <option value="TG">Togo</option>
     <option value="TK">Tokelau</option>
     <option value="TO">Tonga</option>
     <option value="TT">Trinidad and Tobago</option>
     <option value="TN">Tunisia</option>
     <option value="TR">Turkey</option>
     <option value="TM">Turkmenistan</option>
     <option value="TC">Turks and Caicos Islands</option>
     <option value="TV">Tuvalu</option>
     <option value="UG">Uganda</option>
     <option value="UA">Ukraine</option>
     <option value="AE">United Arab Emirates</option>
     <option value="GB">United Kingdom</option>
     <option value="US">United States</option>
     <option value="UM">United States Minor Outlying Islands</option>
     <option value="UY">Uruguay</option>
     <option value="UZ">Uzbekistan</option>
     <option value="VU">Vanuatu</option>
     <option value="VE">Venezuela, Bolivarian Republic of</option>
     <option value="VN">Viet Nam</option>
     <option value="VG">Virgin Islands, British</option>
     <option value="VI">Virgin Islands, U.S.</option>
     <option value="WF">Wallis and Futuna</option>
     <option value="EH">Western Sahara</option>
     <option value="YE">Yemen</option>
     <option value="ZM">Zambia</option>
     <option value="ZW">Zimbabwe</option>
</select>';
  }


$client = new client();
$clientID = $_POST["clientID"] or $clientID = $_GET["clientID"];


if ($_POST["save"]) {
  if (!$_POST["clientName"]) {
    alloc_error("Please enter a Client Name.");
  }
  $client->read_globals();
  $client->set_value("clientModifiedTime", date("Y-m-d"));
  $clientID = $client->get_id();
  $client->set_values("client_");

  if (!$client->get_id()) {
    // New client.
    $client->set_value("clientCreatedTime", date("Y-m-d"));
    $new_client = true;
  }

  if (!$TPL["message"]) {
    $client->save();
    $clientID = $client->get_id();
    $client->set_values("client_");
  }
  
} else if ($_POST["save_attachment"]) {
  move_attachment("client",$clientID);
  alloc_redirect($TPL["url_alloc_client"]."clientID=".$clientID."&sbs_link=attachments");

} else if ($_GET["get_vcard"]) {
  $clientContact = new clientContact();
  $clientContact->set_id($_GET["clientContactID"]);
  $clientContact->select();
  $clientContact->output_vcard();
  return;
} else {

  if ($_POST["delete"]) {
    $client->read_globals();
    $client->delete();
    alloc_redirect($TPL["url_alloc_clientList"]);
  } else {
    $client->set_id($clientID);
    $client->select();
  }

  $client->set_values("client_");
}

$m = new meta("clientStatus");
$clientStatus_array = $m->get_assoc_array("clientStatusID","clientStatusID");
$TPL["clientStatusOptions"] = page::select_options($clientStatus_array, $client->get_value("clientStatus"));

$clientCategories = config::get_config_item("clientCategories") or $clientCategories = array();
foreach ($clientCategories as $k => $v) {
  $cc[$v["value"]] = $v["label"];
}
$TPL["clientCategoryOptions"] = page::select_options($cc,$client->get_value("clientCategory"));
$client->get_value("clientCategory") and $TPL["client_clientCategoryLabel"] = $cc[$client->get_value("clientCategory")];


// client contacts
if ($_POST["clientContact_save"] || $_POST["clientContact_delete"]) {

  $clientContact = new clientContact();
  $clientContact->read_globals();

  if ($_POST["clientContact_save"]) {
    #$clientContact->set_value('clientID', $_POST["clientID"]);
    $clientContact->save();
  }

  if ($_POST["clientContact_delete"]) {
    $clientContact->delete();
  }
}

if (!$clientID) {
  $TPL["message_help"][] = "Create a new Client by inputting the Client Name and other details and clicking the Create New Client button.";
  $TPL["main_alloc_title"] = "New Client - ".APPLICATION_NAME;
  $TPL["clientSelfLink"] = "New Client";
} else {
  $TPL["main_alloc_title"] = "Client " . $client->get_id() . ": " . $client->get_name()." - ".APPLICATION_NAME;
  $TPL["clientSelfLink"] = sprintf("<a href=\"%s\">%d %s</a>", $client->get_url(), $client->get_id(), $client->get_name(array("return"=>"html")));
}


if ($current_user->have_role("admin")) {
  $TPL["invoice_links"].= "<a href=\"".$TPL["url_alloc_invoice"]."clientID=".$clientID."\">New Invoice</a>";
}

$projectListOps = array("showProjectType"=>true
                       ,"clientID"=>$client->get_id()
                       );

$TPL["projectListRows"] = project::get_list($projectListOps);

$TPL["client_clientPostalAddress"] = $client->format_address("postal");
$TPL["client_clientStreetAddress"] = $client->format_address("street");
$TPL["clientCountryOne_List"] = countryList("clientCountryOne");
$TPL["clientCountryTwo_List"] = countryList("clientCountryTwo");
$TPL["clientContactCountry_List"] = countryList("clientContactCountry");

include_template("templates/clientM.tpl");




?>
