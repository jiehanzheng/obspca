<?php

require 'ms-soap-client.php';

class PetPoint_SOAP {

  function __construct($authKey, $operation, $params) {
    switch ($operation) {
      case "search":
      case "AdoptableSearch":
        $function_name = "AdoptableSearch";
        $keys_allowed = array('authkey', 'speciesID', 'sex', 'ageGroup', 
                              'location', 'site', 'onHold', 'orderBy', 
                              'primaryBreed', 'secondaryBreed', 'specialNeeds', 
                              'noDogs', 'noCats', 'noKids');
        break;
      case "detail":
      case "AdoptableDetails":
        $function_name = "AdoptableDetails";
        $keys_allowed = array('authkey', 'animalID');
        break;
      default:
        $up = new Exception("Unexpected $operation: " + $operation);
        throw $up;  // ha ha
    }

    // remove illegal
    $params = array_intersect_key($params, array_flip($keys_allowed));
    
    // merge
    $params = array_merge(array_fill_keys($keys_allowed, ''), $params);


  }
}

?>