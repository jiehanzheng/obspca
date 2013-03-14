<?php

class MSSoapClient extends SoapClient {

  function __doRequest($request, $location, $action, $version, $one_way = 0) {
    $body_pattern = '/<env:Body>(.*)<\/env:Body>/';
    preg_match($body_pattern, $request, $matches);
    $body = $matches[1];

    $ns1_fix_pattern = '/<ns1:([\w:]+)>(.*)<\/ns1:\1>/';
    $ns1_fix_replacement = '<\\1>\\2</\\1>';
    $count = 1;
    while ($count) {
      $body = preg_replace($ns1_fix_pattern, $ns1_fix_replacement, $body, -1, $count);
    }

    $body_replacement = "<env:Body>$body</env:Body>";
    $request = preg_replace($body_pattern, $body_replacement, $request, 1);

    $request = preg_replace('/<AdoptableSearch>/', 
                            '<AdoptableSearch xmlns="http://www.petango.com/">',
                            $request, 1);

    print_r($request);

    return parent::__doRequest($request, $location, $action, $version, $one_way);
  }

}

?>