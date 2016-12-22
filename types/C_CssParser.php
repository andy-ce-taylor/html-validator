<?php

require "htmlTags.php";
require "C_PageElement.php";
require "C_Attrib.php";
require "url.php";

define('PState_TEXT',            0);  // TEXT
define('PState_TAG_NAME',        1);
define('PState_ATTRIBS',        2);  // attributes after tag name
define('PState_ATTRIB_NAME',    3);
define('PState_ATTRIB_VAL',      4);
define('PState_ATTRIB_VAL_QTE',  5);
define('PState_PLINGTAG_NAME',  6);
define('PState_COMMENT',        7);

define('SPACE_CHR',              ' ');

##
class C_Parser {
  public  $file;
  public  $webpage;
  public  $pageElementsAr;
  private  $state;
  private  $skipChars;
  private  $numChars;
  private $reparseChar;
  private  $buf;
  private  $attribs;
  private  $attribName;
  private  $attribValue;
  private  $value;
  private  $pageElement;
  private $comment;
  private  $outerQuote;
  private  $chM1, $chM2, $chM3;
  private  $row, $col;
  private  $elRow, $elCol;
  private  $atNameRow, $atNameCol;
  private  $atValueRow, $atValueCol;

  public function C_Parser($url) {
$url = 'http://localhost/+ATP-Turkey/index.php';
    if (($status = cURL_downloadWebpage($url, $webpage, SysInfo_HIGH_SPEED_INTERNET ? 5 : 20)) != 200) {
      $statusStr = cURL_GetResponseStr($status);
      showError("Unable to download '$url'.\r\nResult = '$statusStr'.");
    }
//    $webpage = file_get_contents("cURL_Test.dat");
    // initialise
showText($url);


//    $rootFolder = parse_url($url, PHP_URL_PATH);
$rootFolder = resolve_url($url);

print_r($rootFolder); exit();

    $this->webpage = str_replace_all('  ', ' ', $webpage);
    $this->pageElementsAr = array();
    $this->buf = 'XXX';
    $this->reparseChar = false;
    $this->row = $this->col = 0; $this->elRow = $this->elCol = 0;
    $this->outerQuote = '';
    $this->skipChars = '';
    $this->chM1 = $this->chM2 = $this->chM3 = SPACE_CHR;
    $cntrlR = false;
    $lineStartPos = 0;
    $newLine = false;
    $this->file = array();
    $this->state = PState_TEXT;
    $this->numChars = strlen($this->webpage);

    ## Stage 1 - parse each character
    for ($ix = 0; $ix < $this->numChars; $ix++) {
      if ($this->reparseChar) { // allows a character to be re-parsed
        // restore condition to as it was before the character was parsed
        if ($this->chM2 == "\r") $cntrlR = true; else $this->col--;
        if ($this->chM1 == "\n") $row--;
        $ch = $this->chM1; $this->chM1 = $this->chM2; $this->chM2 = $this->chM3; $this->chM3 = SPACE_CHR;
        $ix -= 2;
        $this->reparseChar = false;
        continue;
      }
      if ($this->skipChars != '') { // quickly skip <!DOCTYPE>, <script> and <style> data
        $ix = $this->skipContent($ix);
        $this->buf = 'XXX';
        $this->skipChars = '';
        $this->state = PState_TEXT;
        continue;
      }
      // read the next character
      $ch = $this->webpage[$ix];
      switch ($ch) {
        case "\r": $cntrlR = true; continue;
        case "\n": $ch = SPACE_CHR; $newLine = true; break;
        default: $cntrlR = false;
      }
      switch ($this->state) {
        case PState_TEXT:            $this->Pstatefn_Text($ch); break;
        case PState_TAG_NAME:        $this->PStateFn_TAG_NAME($ch); break;
        case PState_ATTRIBS:        $this->PStateFn_ATTRIBS($ch); break;
        case PState_ATTRIB_NAME:    $this->PStateFn_ATTRIB_NAME($ch); break;
        case PState_ATTRIB_VAL:      $this->PStateFn_ATTRIB_VAL($ch); break;
        case PState_ATTRIB_VAL_QTE:  $this->PStateFn_ATTRIB_VAL_QTE($ch); break;
        case PState_PLINGTAG_NAME:  $this->PStateFn_PLINGTAG_NAME($ch); break;
        case PState_COMMENT:        $this->PStateFn_COMMENT($ch); break;
      }
      // update column id and previous characters
      $this->chM3 = $this->chM2; $this->chM2 = $this->chM1; $this->chM1 = $ch;
      $this->col++;
      if ($newLine) {
        // update the row number
        $this->file[$this->row++] = substr($this->webpage, $lineStartPos, $ix - $lineStartPos - ($cntrlR ? 1 : 0));
        $lineStartPos = $ix + 1;
        $ch = $this->chM1 = $this->chM2 = $this->chM3 = SPACE_CHR;
        $cntrlR = false;
        $this->col = 0;
        $newLine = false;
      }
    }

    ## Stage 2 - parse CSS
    foreach ($this->pageElementsAr as $el) {
      if ($el->type == PeType_TAG && $el->tagIndex == Tag_STYLE && !$el->closed) {
        // found <style> element
        //
      }
    }
  }

  #################################################################
  private function skipContent($ix) {
    if (($pos = stripos($this->webpage, $this->skipChars, $ix)) !== false) {
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
      switch ($this->skipChars) {
        case '>': // !DOCTYPE
          $attr = array(new C_Attrib(NULL_ATTRIB_NAME, $data, $this->atNameRow, $this->atNameCol, $this->atValueRow, $this->atValueCol));
          $this->pageElementsAr[] = new C_PageElement(PeType_TAG, '!DOCTYPE', $attr, $this->elRow, $this->elCol, true);
          return $pos + strlen($this->skipChars) - 1;
        case '</script>':
        case '</style>':
          $attr = new C_Attrib(NULL_ATTRIB_NAME, $data, $this->atNameRow, $this->atNameCol, $this->atValueRow, $this->atValueCol);
          $this->pageElementsAr[count($this->pageElementsAr) - 1]->attribs[] = $attr;
          return $pos - 1;
      }
    }
    else showtext("Can't find skip characters: '".$this->skipChars."'.");
    return $ix;
  }

  #################################################################
  private function PStateFn_TEXT($ch) {
    if ($ch == '<') {
      $buf = trim(str_replace_all('  ', ' ', $this->buf));
      if ($buf != '') {
        $this->pageElementsAr[] = new C_PageElement(PeType_TEXT, $buf, NULL, $this->elRow, $this->elCol);
      }
      $this->buf = 'XXX';
      $this->elRow = $this->row; $this->elCol = $this->col;
      $this->state = PState_TAG_NAME;
      return;
    }
    if ($this->buf == ''){
      $this->elRow = $this->row; $this->elCol = $this->col;
    }
    $this->buf .= $ch;
  }
  #################################################################
  private function PStateFn_PLINGTAG_NAME($ch) {
    if ($this->chM1 == '!') {
      if ($ch == 'd' || $ch == 'D') { // tag = <!DOCTYPE>
        $this->buf = "!$ch";
        $this->state = PState_TAG_NAME;
      }
      return;
    }
    if ($this->chM1 == '-' && $ch == '-') {
      $this->comment = '';
      $this->state = PState_COMMENT;
      return;
    }
    // unknown tag
    $this->pageElementsAr[] = new C_PageElement(PeType_TAG, $this->buf.$ch, array(), $this->elRow, $this->elCol);
    $this->buf = 'XXX';
    $this->state = PState_TEXT;
  }
  #################################################################
  private function PStateFn_COMMENT($ch) {
    if ($ch == '>' && $this->chM1 == '-' && $this->chM2 == '-') {
      if ($this->comment != '--') {
        $text = trim(str_replace_all('  ', ' ', substr($this->comment, 0, -2)));
        if (strlen($text)) {
          $this->pageElementsAr[] = new C_PageElement(PeType_CMNT, $text, NULL, $this->elRow, $this->elCol);
        }
      }
      $this->buf = 'XXX';
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
    if (ctype_alpha($ch) || ($this->buf == 'h' && strpos('123456', $ch) !== false) || ($this->buf == '' && $ch == '/')) {
      $this->buf .= $ch;
      return;
    }
    if ($this->buf == '' && $ch == '!') {
      $this->state = PState_PLINGTAG_NAME;
      return;
    }
    if ($ch == '>') { // tag complete
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
    }
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
        $pe = new C_PageElement(PeType_TAG, $this->buf, array(), $this->elRow, $this->elCol);
        if ($pe->end == TagAllw_FBD && $this->chM1 == '/') {
          $pe->closed = true;
          if ($this->chM2 != SPACE_CHR) {
            // record an error if being strict - should have space before />
          }
        }
        if (!$pe->closed) {
          $name = strtolower($pe->name);
          if ($name == 'script') $this->skipChars = '</script>';
          elseif ($name == 'style') $this->skipChars = '</style>';
        }
        $this->pageElementsAr[] = $pe;
        $this->buf = 'XXX';
        $this->state = PState_TEXT;
        break;
      case '/':
      case SPACE_CHR:
        break;
      default:
        showText("Unexpected character '$ch' (".$this->col.",".$this->row.")");
        break;
    }
  }
  #################################################################
  private function PStateFn_ATTRIB_NAME($ch) {
    if (ctype_alpha($ch) || $ch == ':') {
      if ($this->attribName == '') {
        $this->atNameRow = $this->row;
        $this->atNameCol = $this->col;
      }
      $this->attribName .= $ch;
      $this->state = PState_ATTRIB_NAME;
      return;
    }
    switch ($ch) {
      case '=':
        $this->attribValue = '';
        $this->state = PState_ATTRIB_VAL_QTE;
        break;
      case ' ':
        if ($this->attribName != '') {
          $this->attribs[] = new C_Attrib($this->attribName, '', $this->atNameRow, $this->atNameCol, $this->atValueRow, $this->atValueCol);
          $this->attribName = '';
        }
        break;
      case '/':
        break;
      case '>': // tag name complete
        if ($this->attribName != '') {
          $this->attribs[] = new C_Attrib($this->attribName, '', $this->atNameRow, $this->atNameCol, $this->atValueRow, $this->atValueCol);
          $this->attribName = '';
        }
        $pe = new C_PageElement(PeType_TAG, $this->buf, $this->attribs, $this->elRow, $this->elCol);
        if ($pe->end == TagAllw_FBD && $this->chM1 == '/') {
          $pe->closed = true;
          if ($this->chM2 != SPACE_CHR) {
            // record an error if being strict - should have space before />
          }
        }
        $this->pageElementsAr[] = $pe;
        $this->attribs = array();
        $this->buf = 'XXX';
        $name = strtolower($pe->name);
        if ($name == 'script') $this->skipChars = '</script>';
        elseif ($name == 'style') $this->skipChars = '</style>';
        else $this->state = PState_TEXT;
        break;
      default:
        $this->value = '';
        $this->state = PState_ATTRIBS;
    }
  }
  #################################################################
  private function PStateFn_ATTRIB_VAL_QTE($ch) {
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
    // unexpected character
    $this->state = PState_ATTRIBS;
  }
  #################################################################
  private function PStateFn_ATTRIB_VAL($ch) {
    if ($ch == $this->outerQuote || ($this->outerQuote == '' && ($ch == '>' || $ch == ' '))) {
      // attribute value complete
      if ($this->chM1 == '/' && $ch == '>') {
        $this->attribValue = substr($this->attribValue, 0, -1);
        $this->reparseChar = true;
      }
      else {
        $this->attribs[] = new C_Attrib($this->attribName, $this->attribValue, $this->atNameRow, $this->atNameCol, $this->atValueRow, $this->atValueCol);
        $this->attribName = '';
        if ($ch == '>') $this->reparseChar = true;
      }
      $this->state = PState_ATTRIB_NAME;
      return;
    }
    if ($this->attribValue == '') {
      $this->atValueRow = $this->row;
      $this->atValueCol = $this->col;
    }
    $this->attribValue .= $ch;
    $this->state = PState_ATTRIB_VAL;
  }
}

?>