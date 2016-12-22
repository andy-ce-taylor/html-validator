<?php

require "htmlTags.php";
require "C_Attribs.php";
require "url.php";

define('PState_TEXT',              0);  // TEXT
define('PState_TAG_NAME',          1);
define('PState_ATTRIBS',           2);  // attributes after tag name
define('PState_ATTRIB_NAME',       3);
define('PState_ATTRIB_NAME_SPC',   4);
define('PState_ATTRIB_VAL',        5);
define('PState_ATTRIB_VAL_EQU',    6);
define('PState_PLINGTAG_NAME',     7);
define('PState_COMMENT',           8);

define('SPACE_CHR',              ' ');
define('BOM_STR',              '﻿');
##
class C_HtmlParser {
//public   $file;
  public   $webpage;
  private  $numElements;
  private  $state;
  private  $skipChars;
  private  $numChars;
  private  $closeCharState;
  private  $reparseChar;
  private  $buf;
  private  $attribs;
  private  $attribName;
  private  $attribValue;
  private  $value;
  private  $errors;
  private  $comment;
  private  $outerQuote;
  private  $mtags;
  private  $row, $col;
  private  $elRow, $elCol;
  private  $atNameRow, $atNameCol;
  private  $atValueRow, $atValueCol;

  public function C_HtmlParser($url) {
    global $pageElements;
    if (($status = cURL_downloadWebpage($url, $this->webpage, SysInfo_HIGH_SPEED_INTERNET ? 5 : 20)) != 200) {
      $statusStr = cURL_GetResponseStr($status);
      showError("Unable to download '$url'.\r\nResult = '$statusStr'.");
    }
////$this->webpage = file_get_contents("TEST\cURL__Test.dat");
////showText("Num bytes = ".strlen($this->webpage));


//$rootFolder = resolve_url($url, $newUrl);

    if (substr($this->webpage, 0, 3) == BOM_STR) $this->webpage = substr($this->webpage, 3); // remove BOM
    $this->webpage = str_replace_all('  ', ' ', $this->webpage).' ';
    $this->buf = $this->outerQuote = $this->skipChars = '';
    $this->row = $this->col = 0; $this->elRow = $this->elCol = 0;
    $chM3 = $chM2 = $chM1 = $ch = SPACE_CHR;
    $this->reparseChar = false;
    $this->closeCharState = ClsChrState_NO;
//  $this->file = array();
    $this->errors = NULL;
    $this->state = PState_TEXT;
    $this->numChars = strlen($this->webpage) - 1;
    $nonSpaceChar = $nonSpaceCharM1 = '';
    $cntrlR = $newLine = false;
    $lineStartPos = 0;

    ## Parse raw HTML
    for ($ix = 0; $ix < $this->numChars; $ix++) {
      if ($this->skipChars != '') { // quickly skip <!DOCTYPE>, <script> and <style> data
        $ix = $this->skipContent($ix);
        $this->buf = '';
        $this->errors = NULL;
        $this->skipChars = '';
        $this->state = PState_TEXT;
        continue;
      }

      if ($this->closeCharState != ClsChrState_NO_ASSESS && $nonSpaceChar == '/') {
        $this->closeCharState = ($nonSpaceCharM1 == SPACE_CHR) ? ClsChrState_OK : ClsChrState_LEGACY;
      }
      else $this->closeCharState = ClsChrState_NO;

      // read the next character
      $ch = $this->webpage[$ix]; $chP1 = $this->webpage[$ix + 1];

      switch ($ch) {
        case "\r": $cntrlR = true; continue;
        case "\n": $ch = SPACE_CHR; $newLine = true; break;
        default: $cntrlR = false;
      }
      switch ($this->state) {
        case PState_TEXT:              $this->Pstatefn_TEXT($ch, $chP1); break;
        case PState_TAG_NAME:          $this->PStateFn_TAG_NAME($ch); break;
        case PState_ATTRIBS:           $this->PStateFn_ATTRIBS($ch); break;
        case PState_ATTRIB_NAME:       $this->PStateFn_ATTRIB_NAME($ch); break;
        case PState_ATTRIB_NAME_SPC:   $this->PStateFn_ATTRIB_NAME_SPC($ch); break;
        case PState_ATTRIB_VAL:        $this->PStateFn_ATTRIB_VAL($ch); break;
        case PState_ATTRIB_VAL_EQU:    $this->PStateFn_ATTRIB_VAL_EQU($ch); break;
        case PState_PLINGTAG_NAME:     $this->PStateFn_PLINGTAG_NAME($ch, $chM1); break;
        case PState_COMMENT:           $this->PStateFn_COMMENT($ch, $chM1, $chM2); break;
      }
      // update column id and previous characters
      $chM3 = $chM2; $chM2 = $chM1; $chM1 = $ch;
      if ($ch != SPACE_CHR) {
        $nonSpaceChar = $ch;
        $nonSpaceCharM1 = $chM2;
      }
      $this->col++;
      if ($newLine) {
        // update the row number
//      $this->file[$this->row] = substr($this->webpage, $lineStartPos, $ix - $lineStartPos - ($cntrlR ? 1 : 0));
        $lineStartPos = $ix + 1;
        $ch = $chM1 = $chM2 = $chM3 = SPACE_CHR;
        $cntrlR = false;
        $this->row++;
        $this->col = 0;
        $newLine = false;
      }
      if ($this->reparseChar) { // allows a character to be re-parsed
        // restore condition to as it was before the character was parsed
        if ($chM2 == "\r") $cntrlR = true; else $this->col--;
        if ($chM1 == "\n") $row--;
        $ch = $chM1; $chM1 = $chM2; $chM2 = $chM3; $chM3 = SPACE_CHR;
        if ($this->closeCharState != ClsChrState_NO_ASSESS) {
          $nonSpaceChar = $chM1;
          $nonSpaceCharM1 = $chM2;
        }
        $ix--;
        $this->reparseChar = false;
      }
    }
    $buf = trim(str_replace_all('  ', ' ', $this->buf));
    if ($buf != '') {
      $pageElements->add(PeType_TEXT, 0, $buf, NULL, $this->elRow, $this->elCol, $this->errors);
      $this->errors = NULL;
    }
  }
  #################################################################
  public function getNumElements() {
    return $this->numElements;
  }
  #################################################################
  private function skipContent($ix) {
    if (($pos = stripos($this->webpage, $this->skipChars, $ix)) !== false) {
      global $pageElements;
      $this->atValueRow = $this->row; $this->atValueCol = $this->col;
      $rawData = substr($this->webpage, $ix, $pos - $ix);
      $this->elRow = $this->row;
      $numCRs = substr_count($rawData, "\n");
      if (($lastCR = strrpos($rawData, "\n")) !== false) {
        $this->col = strlen($rawData) - $lastCR - 1;
      }
      // calculate the attrib row/col values
      $leadingData = substr($rawData, 0, strlen($rawData) - strlen(ltrim($rawData)));
      $leadingDataLen = strlen($leadingData);
      if (($numLeadingCRs = substr_count($leadingData, "\n")) > 0) {
        $this->atValueCol = $leadingDataLen - strrpos($leadingData, "\n") - 1;
        $this->atValueRow += $numLeadingCRs;
      }
      else {
        $this->atValueCol += $leadingDataLen;
      }
      $this->row += $numCRs;
      $data = trim(str_replace_all('  ', ' ', str_replace(array("\r","\n"), ' ', $rawData)));
      if ($this->skipChars == '>') { // !DOCTYPE
        $attr = array(new C_Attrib(NULL_ATTRIB_NAME, $data, $this->atNameRow, $this->atNameCol, $this->atValueRow, $this->atValueCol));
        $pageElements->add(PeType_TAG, OpClState_FORCEDCLOSED, '!DOCTYPE', $attr, $this->elRow, $this->elCol, $this->errors, true);
        return $pos + strlen($this->skipChars) - 1;
      }
      $elemType = $this->skipChars == '</style>' ? PeType_CSS : PeType_SCRIPT;
      $data = str_replace(array('&','&&amp','<','>'), array('&amp;','&amp;','&lt;','&gt;'), $data);
      $pageElements->add($elemType, OpClState_FORCEDCLOSED, $data, NULL, $this->atValueRow, $this->atValueCol, $this->errors);
      return $pos - 1;
    }
    return $ix;
  }

  #################################################################
  private function PStateFn_TEXT($ch, $chP1) {
    if ($ch == '<') {
      if ($chP1 != ' ' && !ctype_digit($chP1)) {
        $buf = trim(str_replace_all('  ', ' ', $this->buf));
        if ($buf != '') {
          global $pageElements;
          $pageElements->add(PeType_TEXT, 0, $buf, NULL, $this->elRow, $this->elCol, $this->errors);
        }
        $this->buf = '';
        $this->errors = NULL;
        $this->elRow = $this->row; $this->elCol = $this->col;
        $this->state = PState_TAG_NAME;
        return;
      }
      $msg = "Character '&lt;' should not be used within text [line ".($this->row + 1).", col ".($this->col + 1)."]<br />";
      $msg.= "Use '&amp;lt;' instead.";
      $this->errors[] = array(ErrLev_NOTICE | Err_USE_HTML_ENTITY, $msg);
      $ch = '&lt;';
    }
    elseif ($ch == '>') {
      $msg = "Character '&gt;' should not be used within text [line ".($this->row + 1).", col ".($this->col + 1)."]<br />";
      $msg.= "Use '&amp;gt;' instead.";
      $this->errors[] = array(ErrLev_NOTICE | Err_USE_HTML_ENTITY, $msg);
      $ch = '&gt;';
    }
    elseif ($ch == '&' && $chP1 == SPACE_CHR) {
      $msg = "Character '&amp;' should not be used within text [line ".($this->row + 1).", col ".($this->col + 1)."]<br />";
      $msg.= "Use '&amp;amp;' instead.";
      $this->errors[] = array(ErrLev_NOTICE | Err_USE_HTML_ENTITY, $msg);
      $ch = '&gt;';
    }
    if ($this->buf == ''){
      $this->elRow = $this->row; $this->elCol = $this->col;
    }
    $this->buf .= $ch;
  }
  #################################################################
  private function PStateFn_PLINGTAG_NAME($ch, $chM1) {
    if ($chM1 == '!') {
      if ($ch == 'd' || $ch == 'D') { // tag = <!DOCTYPE>
        $this->buf = "!$ch";
        $this->state = PState_TAG_NAME;
      }
      return;
    }
    // treat '<!' as beginning of comment
    $this->comment = '';
    $this->state = PState_COMMENT;
    return;
  }
  #################################################################
  private function PStateFn_COMMENT($ch, $chM1, $chM2) {
    if ($ch == '>' && $chM1 == '-' && $chM2 == '-') {
      if ($this->comment != '--') {
        $text = trim(str_replace_all('  ', ' ', substr($this->comment, 0, -2)));
        if (strlen($text)) {
          $text = str_replace(array('&','&&amp','<','>'), array('&amp;','&amp;','&lt;','&gt;'), $text);
          global $pageElements;
          $pageElements->add(PeType_CMNT, 0, $text, NULL, $this->elRow, $this->elCol, $this->errors);
        }
      }
      $this->buf = '';
      $this->errors = NULL;
      $this->state = PState_TEXT;
      return;
    }
    if ($this->comment == '') {
      $this->elRow = $this->row; $this->elCol = $this->col;
    }
    $this->comment .= $ch;
  }
  #################################################################
  private function PStateFn_TAG_NAME($ch) {
    if (ctype_alpha($ch) || (($this->buf == 'h' || $this->buf == '/h') && strpos('123456', $ch) !== false) || ($this->buf == '' && $ch == '/')) {
      $this->buf .= $ch;
      return;
    }
    if ($this->buf == '' && $ch == '!') {
      $this->state = PState_PLINGTAG_NAME;
      return;
    }
    if ($ch == '>') { // tag complete - let pState_ATTRIBS deal with it
      $this->reparseChar = true;
      $this->state = PState_ATTRIBS;
      return;
    }
    if ($ch == ' ' && $this->buf != '') {
      // tag name complete - attribs or closing sequence follow
      if (strtolower($this->buf) == "!doctype") {
        $this->skipChars = '>';
        $this->state = PState_TEXT;
      }
      else {
        $this->attribs = array();
        $this->state = PState_ATTRIBS;
      }
      return;
    }
    if ($this->closeCharState) {
      $this->attribs = array();
      $this->state = PState_ATTRIBS;
      return;
    }
    // unexpected character
  }
  #################################################################
  private function PStateFn_ATTRIBS($ch) {
    if (ctype_alpha($ch)) {
      $this->attribName = '';
      $this->reparseChar = true;
      $this->state = PState_ATTRIB_NAME;
      return;
    }
    switch ($ch) {
      case '>': // tag name complete
        $pe = new C_PageElement(PeType_TAG, $this->closeCharState, $this->buf, array(), $this->elRow, $this->elCol, $this->errors);
        if ($pe->ocState == OpClState_OPEN) {
          $name = strtolower($pe->name);
          if ($name == 'script') $this->skipChars = '</script>';
          elseif ($name == 'style') $this->skipChars = '</style>';
        }
        global $pageElements;
        $pageElements->addPreMade($pe);
        $this->buf = '';
        $this->errors = NULL;
        $this->state = PState_TEXT;
        break;
      case '/':
      case SPACE_CHR:
        break;
      default:
        $msg = "Unexpected character '{$ch}' found [line ".($this->row + 1).", col ".($this->col + 1)."]";
        $this->errors[] = array(ErrLev_ERROR | Err_UNEXPECTED_CHAR, $msg);
        break;
    }
  }
  #################################################################
  private function PStateFn_ATTRIB_NAME($ch) {
    if (ctype_alpha($ch) || $ch == '-' || $ch == ':') {
      if ($this->attribName == '') {
        $this->atNameRow = $this->row;
        $this->atNameCol = $this->col;
      }
      $this->attribName .= $ch;
      return;
    }
    switch ($ch) {
      case '=':
        $this->attribValue = '';
        $this->state = PState_ATTRIB_VAL_EQU;
        break;
      case ' ':
        $this->state = PState_ATTRIB_NAME_SPC;
        break;
      case '/':
        break;
      case '>': // tag name complete
        if ($this->attribName != '') {
          $this->attribs[] = new C_Attrib($this->attribName, '', $this->atNameRow, $this->atNameCol, $this->atValueRow, $this->atValueCol);
          $this->attribName = '';
        }
        $pe = new C_PageElement(PeType_TAG, $this->closeCharState, $this->buf, $this->attribs, $this->elRow, $this->elCol, $this->errors);
        if ($pe->ocState == OpClState_OPEN) {
          $name = strtolower($pe->name);
          if ($name == 'script') $this->skipChars = '</script>';
          elseif ($name == 'style') $this->skipChars = '</style>';
        }
        $this->state = PState_TEXT;
        global $pageElements;
        $pageElements->addPreMade($pe);
        $this->attribs = array();
        $this->buf = '';
        $this->errors = NULL;
        break;
      default:
//showText("I am here!");exit();
        $this->value = '';
        $this->state = PState_ATTRIBS;
    }
  }
  #################################################################
  private function PStateFn_ATTRIB_NAME_SPC($ch) {
    switch ($ch) {
      case ' ':
        break;
      case '=':
        $this->attribValue = '';
        $this->state = PState_ATTRIB_VAL_EQU;
        break;
      default:
        if ($this->attribName != '') {
          $this->attribs[] = new C_Attrib($this->attribName, '', $this->atNameRow, $this->atNameCol, $this->atValueRow, $this->atValueCol);
          $this->attribName = '';
        }
        $this->reparseChar = true;
        $this->state = PState_ATTRIB_NAME;
        break;
    }
  }
  #################################################################
  private function PStateFn_ATTRIB_VAL_EQU($ch) {
    switch ($ch) {
      case "'": case '"':
        $this->outerQuote = $ch;
        $this->attribValue = '';
        $this->state = PState_ATTRIB_VAL;
        return;
      case SPACE_CHR:
        return;
    }
    if ($ch != '>') {
      $this->outerQuote = '';
      $this->attribValue = '';
      $this->reparseChar = true;
      $this->state = PState_ATTRIB_VAL;
      return;
    }
    $msg = "Unexpected character '{$ch}' found [line ".($this->row + 1).", col ".($this->col + 1)."]";
    $this->errors[] = array(ErrLev_ERROR | Err_UNEXPECTED_CHAR, $msg);
    $this->state = PState_ATTRIBS;
  }
  #################################################################
  private function PStateFn_ATTRIB_VAL($ch) {
    if ($ch == $this->outerQuote || ($this->outerQuote == '' && ($ch == '>' || $ch == ' '))) {
      $this->attribs[] = new C_Attrib($this->attribName, $this->attribValue, $this->atNameRow, $this->atNameCol, $this->atValueRow, $this->atValueCol);
      $this->closeCharState = ClsChrState_NO_ASSESS;
      if ($ch == '>') $this->reparseChar = true;
      $this->attribName = '';
      $this->state = PState_ATTRIB_NAME;
      return;
    }
    if ($this->attribValue == '') {
      $this->atValueRow = $this->row;
      $this->atValueCol = $this->col;
    }
    $this->attribValue .= $ch;
  }
}

?>