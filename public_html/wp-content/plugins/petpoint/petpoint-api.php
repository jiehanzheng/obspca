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
  private $pointer_loc = -1;


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
    $db_fingerprint = $function_name . '(' . serialize(ksort($params)) . ')';

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
    $xml_tree = new SimpleXMLIterator($response);

    if (isset($xml_tree->XmlNode)) { // a list
      $this->result = $xml_tree;
    } else { // animal detail
      // strip away xml doctype
      $response = preg_replace('/^.+\n/', '', $response);
      $this->result = new SimpleXMLIterator("<ArrayOfXmlNode><XmlNode>$response</XmlNode></ArrayOfXmlNode>");
    }

    $xml_tree->rewind();
  }


  function next() {
    $this->result->next();
    echo "\nnext";
  }

  function rewind() {
    $this->result->rewind();
    echo "\nrewind";
  }

  function has_next() {
    $this->result->next();
    $validity = $this->result->valid();
    $this->result->rewind();
    return $validity;
  }

  function current() {
    return $this->result->current();
  }

}

?>