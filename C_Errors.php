<?php

define('ErrLev_ERROR',                0x01);
define('ErrLev_WARNING',              0x02);
define('ErrLev_NOTICE',                0x04);
define('ErrLev_LEGACY',                0x08);
define('ErrLev_XHTML',                0x10);

define('ErrLev_NUM_LEVELS',            5);
define('ErrLev_MASK',                  0x00FF);

define('Err_UNKNOWN_TAG',              0x0100);    // tag is unknown
define('Err_UNKNOWN_META_TAG',        0x0200);    // meta tag is unknown
define('Err_MISSING_SPACE',            0x0300);    // space character missing before close /
define('Err_UNEXPECTED_CHAR',          0x0400);    // an unexpected character was encountered
define('Err_MISSING_NAME_HE_ATTRIB',  0x0500);    // missing 'name' or 'http-equiv' attribute
define('Err_MISSING_OPEN_TAG',        0x0600);    // 'close' tag found without corresponding 'open' tag
define('Err_MISSING_CLOSE_TAG',        0x0700);    // 'open' tag found without corresponding 'close' tag
define('Err_TAG_NOT_CLOSED',          0x0800);    // tag not closed - eg. <br>
define('Err_TAG_PREMATURE_CLOSE',      0x0900);    // tag prematurely closed - eg. <body />
define('Err_NOT_ALLOWED',              0x0A00);    // tag not allowed in this context
define('Err_DEPRECATED',              0x0B00);    // tag has been deprecated
define('Err_USE_HTML_ENTITY',          0x0C00);    // use of html entity recommended in text

define('Err_MASK',                    0xFF00);


##
class C_Error {
  public $errLev;
  public $errNum;
  public $msg;
  public $row, $col;

  #############################
  public function C_Error($err, $msg, $row, $col) {
    $this->errLev = $err & ErrLev_MASK;
    $this->errNum = $err & Err_MASK;
    $this->msg = $msg;
    $this->row = $row;
    $this->col = $col;
  }
}


#################################################################

class C_Errors {
  private $arr;
  private $numErrors;

  #############################
  public function C_Errors() {
    $this->arr = array();
    $this->numErrors = 0;
  }
  #############################
  public function add($err, $msg, $row, $col) {
    $this->arr[] = new C_Error($err, $msg, $row, $col);
    $this->numErrors++;
  }
  #############################
  public function getNumErrors() {
    return $this->numErrors;
  }
  #############################
  public function show() {
//    usort($this->arr, 'sortErrLev');
    $errInfo = array(
      ErrLev_ERROR => 0,
      ErrLev_WARNING => 0,
      ErrLev_NOTICE => 0,
      ErrLev_LEGACY => 0,
      ErrLev_XHTML => 0
    );
    foreach ($this->arr as $err) {
      $errInfo[$err->errLev]++;
    }
    $errors = array();
    foreach($errInfo as $ix => $ei) {
      if ($ei) {
        foreach ($this->arr as $err) {
          if ($err->errLev == $ix) $errors[] = $err;
        }
        break;
      }
    }

    usort($errors, 'sortRowCol');
    foreach ($errors as $err) {
//    foreach ($this->arr as $err) {
      switch ($err->errLev) {
        case ErrLev_ERROR:    $errStr = "ERROR"; break;
        case ErrLev_WARNING:  $errStr = "WARNING"; break;
        case ErrLev_NOTICE:    $errStr = "NOTICE"; break;
        case ErrLev_LEGACY:    $errStr = "LEGACY"; break;
        case ErrLev_XHTML:    $errStr = "XHTML (Recommendation)"; break;
      }
      $errStr .= " - on line ".($err->row + 1).", column ".($err->col + 1)."\n".$err->msg;
      showText($errStr."\n");
    }
  }
}

###############################################################
function sortErrLev($a, $b) {
  $dif = $a->errLev - $b->errLev;
  if ($dif < 0) return -1;
  if ($dif > 0) return 1;
  return 0;
}
#################
function sortRowCol($a, $b) {
  $dif = $a->row - $b->row;
  if ($dif < 0) return -1;
  if ($dif > 0) return 1;
  $dif = $a->col - $b->col;
  if ($dif < 0) return -1;
  if ($dif > 0) return 1;
  return 0;
}

?>