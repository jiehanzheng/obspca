<?php

class PetPoint_API {

  /**
   * API Base, with a trailing slash
   */
  const API_BASE = "http://qag.petpoint.com/webservices/wsadoption.asmx/";

  /**
   * Cache TTL (in minutes)
   */
  const CACHE_TTL = 30;


  private $results;
  private $pointer_loc = 0;


  function __construct($operation, $params) {
    global $wpdb;

    // define function-specific stuff
    switch ($operation) {
      case "search":
      case "AdoptableSearch":
        $function_name = "AdoptableSearch";
        $keys_allowed = array('authkey', 'speciesID', 'sex', 'ageGroup', 
                              'location', 'site', 'onHold', 'orderBy', 
                              'primaryBreed', 'secondaryBreed', 'specialNeeds', 
                              'noDogs', 'noCats', 'noKids', 'stageID');
        break;
      case "detail":
      case "AdoptableDetails":
        $function_name = "AdoptableDetails";
        $keys_allowed = array('authkey', 'animalID');
        break;
      default:
        $up = new Exception("Unexpected \$operation: $operation.");
        throw $up;  // ha ha
    }

    // remove illegal items
    $params = array_intersect_key($params, array_flip($keys_allowed));

    // delete invalid cache
    $ttl = $this::CACHE_TTL;
    $rows_affected = $wpdb->query("DELETE FROM {$wpdb->prefix}petpoint_cache 
                                   WHERE `retrieved_at` < TIMESTAMPADD(MINUTE, -$ttl, NOW())");

    echo "<!-- petpoint: removed $rows_affected outdated cache entries. -->\n";

    // if a valid cache exists, use it and don't request
    ksort($params);
    $db_fingerprint = $function_name . '(' . serialize($params) . ')';

    if (strlen($db_fingerprint) >= 255) {
      $up = new Exception('params are too long.');
      throw $up;  // ha ha
    }

    if ($cached_data = $wpdb->get_var($wpdb->prepare("SELECT data
                                                      FROM {$wpdb->prefix}petpoint_cache
                                                      WHERE query = %s",
                                                     $db_fingerprint))) {
      echo "<!-- petpoint: cache hit: $db_fingerprint -->\n";
      $response = $cached_data;
    } else {
      echo "<!-- petpoint: CACHE MISSED -->\n";

      // add authkey
      if ( ! $params['authkey'] = get_option('petpoint_authkey') ) {
        $up = new Exception("No authkey was set on Settings -> Media page.");
        throw $up;  // ha ha
      }
      
      // merge with default array
      $params = array_merge(array_fill_keys($keys_allowed, ''), $params);

      // prepare request
      $ch = curl_init($this::API_BASE . $function_name);
      curl_setopt($ch, CURLOPT_POST, TRUE);
      curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
      curl_setopt($ch, CURLOPT_USERAGENT, "Jiehan-WP-PetPoint-API/0.1");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
      curl_setopt($ch, CURLOPT_TIMEOUT, 30);

      // perform request
      if ( ! $response = curl_exec($ch) ) {
        $up = new Exception("Unable to communicate with PetPoint server: "
                            . curl_error($ch));
        throw $up;  // ha ha
      }

      // cache result
      $wpdb->insert($wpdb->prefix . "petpoint_cache", 
                    array("query" => $db_fingerprint,
                          "data" => $response));

      // free up res
      curl_close($ch);
    }

    // parse it
    try {
      $xml_tree = new SimpleXMLIterator($response);
    } catch (Exception $e) {
      $wpdb->query($wpdb->prepare("DELETE FROM {$wpdb->prefix}petpoint_cache 
                                   WHERE `query` = %s",
                                  $db_fingerprint));
      throw new Exception("fucked up");
    }

    if (isset($xml_tree->XmlNode)) { // a list
      $this->results = $xml_tree;
    } else { // animal detail
      // strip away xml doctype
      $response = preg_replace('/^.+\n/', '', $response);
      $this->results = new SimpleXMLIterator("<ArrayOfXmlNode><XmlNode>$response</XmlNode></ArrayOfXmlNode>");
    }

    $this->results->rewind();
  }


  function next() {
    $this->results->next();
    $this->pointer_loc++;
  }

  function rewind() {
    $this->results->rewind();
    $this->pointer_loc--;
  }

  function has_next() {
    if ($this->pointer_loc + 1 < $this->results->count())
      return true;
    return false;
  }

  function current() {
    return $this->results->current()->children()->children();
  }

  function current_trimmed() {
    return trim($this->current());
  }

  function dump() {
    $pet = $this->current();
    var_dump($pet);
  }

  function get_image() {
    $pet = $this->current();
    if (isset($pet->Photo1)) return trim($pet->Photo1);
    return trim($pet->Photo);
  }

  function get_image2() {
    $pet = $this->current();
    return trim($pet->Photo2);
  }

  function get_image3() {
    $pet = $this->current();
    return trim($pet->Photo3);
  }

  function get_id() {
    $pet = $this->current();
    if (isset($pet->animalID)) return trim($pet->animalID);
    return trim($pet->ID);
  }

  function get_name() {
    $pet = $this->current();
    return trim($pet->AnimalName);
  }

  function get_species() {
    $pet = $this->current();
    return trim($pet->Species);
  }

  function get_breed() {
    $pet = $this->current();
    return trim($pet->PrimaryBreed);
  }

  function get_secondary_breed() {
    $pet = $this->current();
    return trim($pet->SecondaryBreed);
  }

  function get_color() {
    $pet = $this->current();
    return trim($pet->PrimaryColor);
  }

  function get_secondary_color() {
    $pet = $this->current();
    return trim($pet->SecondaryColor);
  }

}

?>