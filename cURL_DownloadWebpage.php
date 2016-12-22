<?php

// +----------------------------------------------------------------------------------+
// | *****************************************************************
// | ** The cURL PHP extension *must* be installed for this to work **
// | *****************************************************************
// +----------------------------------------------------------------------------------+

define('USER_AGENT',  'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
date_default_timezone_set("Europe/Kiev");

$cURL_InfoResponse = array(
  // Informational 1xx
    100 => "Continue",
    101 => "Switching Protocols",
  // Successful 2xx
    200 => "OK",
    201 => "Created",
    202 => "Accepted",
    203 => "Non-Authoritative Information",
    204 => "No Content",
    205 => "Reset Content",
    206 => "Partial Content",
  // Redirection 3xx
    300 => "Multiple Choices",
    301 => "Moved Permanently",
    302 => "Found",
    303 => "See Other",
    304 => "Not Modified",
    305 => "Use Proxy",
    306 => "(Unused)",
    307 => "Temporary Redirect",
  // Client Error 4xx
    400 => "Bad Request",
    401 => "Unauthorized",
    402 => "Payment Required",
    403 => "Forbidden",
    404 => "Not Found",
    405 => "Method Not Allowed",
    406 => "Not Acceptable",
    407 => "Proxy Authentication Required",
    408 => "Request Timeout",
    409 => "Conflict",
    410 => "Gone",
    411 => "Length Required",
    412 => "Precondition Failed",
    413 => "Request Entity Too Large",
    414 => "Request-URI Too Long",
    415 => "Unsupported Media Type",
    416 => "Requested Range Not Satisfiable",
    417 => "Expectation Failed",
  // Server Error 5xx
    500 => "Internal Server Error",
    501 => "Not Implemented",
    502 => "Bad Gateway",
    503 => "Service Unavailable",
    504 => "Gateway Timeout",
    505 => "HTTP Version Not Supported",
  // My codes 9xx
    900 => "cURL failed to initialise"
);


## +----------------------------------------------------------------------------------+
## |
## +----------------------------------------------------------------------------------+
function cURL_GetResponseStr($status) {
  global $cURL_InfoResponse;
  return $cURL_InfoResponse[$status];
}

## +----------------------------------------------------------------------------------+
## | Use cURL to capture a web page
## +----------------------------------------------------------------------------------+
function cURL_downloadWebpage($url, &$result, $timeout=5) {
  if (($ch = curl_init($url)) === false) return 900;
  curl_setopt($ch, CURLOPT_USERAGENT, USER_AGENT);
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  $result = curl_exec($ch);
  $status = curl_getinfo($ch);
  curl_close($ch);
  return $status['http_code'];
}

?>