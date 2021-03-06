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

$sess->Destroy();
$url = $TPL["url_alloc_index"];

// Hook:Maestrano
// Load Maestrano
//require realpath(dirname(__FILE__)) . '../maestrano/app/init/base.php';
$maestrano = MaestranoService::getInstance();
if ($maestrano->isSsoEnabled()) {
  header("Location: " . $maestrano->getSsoLogoutUrl());
} else {
  alloc_redirect($url);
}

?>
