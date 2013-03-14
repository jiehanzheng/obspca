<?php
/*
Plugin Name: The PetPoint Loop
Description: Provide WordPress Loop-like interface to PetPoint SOAP APIs.
Version: 0.1
Author: jiehanzheng
Author URI: http://jiehan.org/
License: MIT
*/

require 'petpoint-soap.php';

$petpoint = new PetPoint_SOAP("qnt7b4wrdmn86kr3py7dwgsrlcjl1sd6tshkwrkvyydeu87n1a",
                             "search",
                             array("orderBy" => "ID",
                                   "speciesID" => "1"));


function petpoint_get_functions() {
  global $petpoint;

  $petpoint->get_functions();
}

?>