<?php

$_publicFolder = '../@public/';

if (!defined('SYSINFO_FILE')) define('SYSINFO_FILE', $_publicFolder.'~sysInfo.php');
if (!defined('SysInfo_AVAILABLE')) {
  if (defined('SYSINFO_FILE') && file_exists(SYSINFO_FILE)) require SYSINFO_FILE;
  else {
    define('SysInfo_LOCALHOST_IP',        '192.168');
    define('SysInfo_AVAILABLE',            false);
    define('SysInfo_SERVER_NAME',          $_SERVER["SERVER_NAME"]);
    define('SysInfo_LOCALHOST',            SysInfo_SERVER_NAME=='localhost'||substr(SysInfo_SERVER_NAME,0,7)==SysInfo_LOCALHOST_IP);
    define('SysInfo_SELF_NAME',            $_SERVER['PHP_SELF']);
    define('SysInfo_SELF_BASENAME',        basename(SysInfo_SELF_NAME));
    define('UsrInfo_TIME',                $_SERVER["REQUEST_TIME"]);
    define('UsrInfo_IP',                  $_SERVER["REMOTE_ADDR"]);
    define('UsrInfo_AGENT',                $_SERVER["HTTP_USER_AGENT"]);
    define('SysInfo_HIGH_SPEED_INTERNET',  true);
    define('SysInfo_OS',                  '');
    define('SysInfo_OS_BITS',              0);
  }
}

?>