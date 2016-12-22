<?php

##
define('TAB_STR',                                  '. ');

##
define('PeType_UNKNOWN_TAG',                      0);
define('PeType_TAG',                              1);
define('PeType_TEXT',                              2);
define('PeType_CMNT',                              3);
define('PeType_CSS',                              4);
define('PeType_SCRIPT',                            5);

##
define('ClsChrState_NO_ASSESS',                    -1);  // do not assess the close char state
define('ClsChrState_NO',                          0);    // eg. <title>
define('ClsChrState_LEGACY',                      1);    // eg. <br/>
define('ClsChrState_OK',                          2);    // eg. <br />

##
define('OpClState_OPEN',                          0);    // eg. <p>
define('OpClState_CLOSED',                        1);    // eg. </p>
define('OpClState_FORCEDCLOSED',                  2);    // forced closed - eg. !DOCTYPE (used with 'skipContent')
define('OpClState_OPENCLOSED',                    3);    // eg. <img ... ... />
define('OpClState_OPENCLOSED_X',                  4);    // eg. <img ... .../>

##
class C_PageElement {
  public $type;
  public $ocState;    // whether tag is open or closed
  public $text;
  public $tagIndex;
  public $name;
  public $htmlStatus;
  public $errorLevs;
  public $matchingErrorLevs;
  public $matchingElement;
  public $indent;
  public $errors;
  public $attribs;
  public $row, $col;

  public function C_PageElement($type, $closeCharState, $data, $attribs, $row, $col, $errors, $forceClosed=false) {
    $this->type = $type;
    $this->errors = $errors;
    switch ($type) {
      case PeType_CSS:
      case PeType_SCRIPT:
      case PeType_TEXT:
      case PeType_CMNT:
        $this->tagIndex = -1;
        $this->text = $data;
        break;
      case PeType_TAG:
        $this->matchingElement = false;
        if ($data[0] == '/') {
          $name = substr($data, 1);
          $this->ocState = OpClState_CLOSED;
        }
        else {
          $name = $data;
          $this->ocState = OpClState_OPEN;
        }
        if ($forceClosed) $this->ocState = OpClState_FORCEDCLOSED;
        global $htmlDat;
        if (($this->tagIndex = findTagName($name)) === false) {
          global $htmlTagNames, $numHtmlTags;
          $this->tagIndex = $numHtmlTags;
          $hdat = $htmlDat[Tag_UNKNOWN];
          $lcName = strtolower($name);
          $hdat[HtmlDatIx_NAME] = $lcName;
          $htmlDat[$numHtmlTags++] = $hdat;
          $htmlTagNames[] = $lcName;
          $this->type = PeType_UNKNOWN_TAG;
        }
        $this->htmlStatus = $htmlDat[$this->tagIndex][HtmlDatIx_STATUS];
        if ($closeCharState) {
          $this->ocState = ($closeCharState == ClsChrState_LEGACY) ? OpClState_OPENCLOSED_X : OpClState_OPENCLOSED;
        }
        $this->name = $name;
        $this->attribs = new C_Attribs($attribs);
        break;
    }
    $this->row = $row;
    $this->col = $col;
    $this->errorLevs = 0;
  }

  ######################
  public function getOcState() {
    return $this->ocState;
  }
  ######################
  public function getParent() {
    return $this->parentIx;
  }
  ######################
  public function getReqsStartTag() {
    global $htmlDat;
    return $htmlDat[$this->tagIndex][HtmlDatIx_REQ_START_TAG];
  }
  ######################
  public function getReqsEndTag() {
    global $htmlDat;
    return $htmlDat[$this->tagIndex][HtmlDatIx_REQ_END_TAG];
  }
  ######################
  public function getReqsDisplayType() {
    global $htmlDat;
    return $htmlDat[$this->tagIndex][HtmlDatIx_REQ_DISPLAY];
  }
  ######################
  public function getReqsContent() {
    global $htmlDat;
    return $htmlDat[$this->tagIndex][HtmlDatIx_REQ_CONTENT];
  }
  ######################
  public function getStatus() {
    global $htmlDat;
    return $htmlDat[$this->tagIndex][HtmlDatIx_STATUS];
  }
  ######################
  public function show($rowColStr) {
    $row =  $this->row + 1; $col = $this->col + 1;
    switch ($this->type) {
      case PeType_UNKNOWN_TAG:
        $name = $this->name;
        $htmlStatus = $this->htmlStatus;
        $ocState = $this->ocState;
        $attribsStr = $this->attribs->show();
        if ($ocState == OpClState_OPEN) $statusStr = 'INVAL OP';
        else $statusStr = 'INVAL CL';
        showText($rowColStr." "."TAG $statusStr '$name' $attribsStr");
        break;
      case PeType_TEXT:
        showText($rowColStr." ".'TEXT         "'. $this->text.'"');
        break;
      case PeType_CMNT:
        showText($rowColStr." ".'COMMENT      "'. $this->text.'"');
        break;
      case PeType_CSS:
        showText($rowColStr." ".'             "'. $this->text.'"');
        break;
      case PeType_SCRIPT:
        showText($rowColStr." ".'             "'. $this->text.'"');
        break;
      case PeType_TAG:
        $name = $this->name;
        $htmlStatus = $this->htmlStatus;
        $ocState = $this->ocState;
        $attribsStr = $this->attribs->show();
        if ($ocState == OpClState_OPEN) $statusStr = 'OPEN  ';
        elseif ($htmlStatus & Stat_DEPRECATED) $statusStr = 'DEPREC';
        else $statusStr = 'CLOSED';
        showText($rowColStr." "."TAG $statusStr   '$name' $attribsStr");
        break;
    }
  }
  ######################
  public function showRowCol($rowDigits, $colDigits) {
    $str = substr('       '.($this->row + 1), -$rowDigits).','.substr('       '.($this->col + 1), -$colDigits);
    return $str;
  }
  ######################
  public function showNicely() {
    $str = '<span class="tabs">'.str_repeat(TAB_STR, $this->indent).'</span>';
    switch ($this->type) {
      case PeType_UNKNOWN_TAG:
      case PeType_TAG:
        $errLevs = $this->errorLevs | $this->matchingErrorLevs;
        if ($errLevs == 0) {
          $tagBracketsClss = "tagBrackets";
          $tagNameClss = "tagName";
        }
        elseif ($errLevs & ErrLev_ERROR) {
          $tagBracketsClss = "tagBracketsE";
          $tagNameClss = "tagNameE";
        }
        elseif ($errLevs & ErrLev_WARNING) {
          $tagBracketsClss = "tagBracketsW";
          $tagNameClss = "tagNameW";
        }
        elseif ($errLevs & ErrLev_NOTICE) {
          $tagBracketsClss = "tagBracketsN";
          $tagNameClss = "tagNameN";
        }
        elseif ($errLevs & ErrLev_LEGACY) {
          $tagBracketsClss = "tagBracketsL";
          $tagNameClss = "tagNameL";
        }
        elseif ($errLevs & ErrLev_XHTML) {
          $tagBracketsClss = "tagBracketsX";
          $tagNameClss = "tagNameX";
        }
        global $htmlDat;
        $html = $htmlDat[$this->tagIndex];
        switch ($this->ocState) {
          case OpClState_OPEN:
            $str .= '<span class="'.$tagBracketsClss.'">&lt;</span>';
            $str .= '<span class="'.$tagNameClss.'">'.$html[HtmlDatIx_NAME].'</span>';
            $str .= $this->attribs->showNicely($this->errorLevs);
            $str .= '<span class="'.$tagBracketsClss.'">&gt;</span>';
            $str .= "\r\n";
            break;
          case OpClState_CLOSED:
            $str .= '<span class="'.$tagBracketsClss.'">&lt;</span>';
            $str .= '<span class="'.$tagNameClss.'">/'.$html[HtmlDatIx_NAME].'</span>';
            $str .= '<span class="'.$tagBracketsClss.'">&gt;</span>';
            $str .= "\r\n";
            break;
          case OpClState_FORCEDCLOSED:
            $str .= '<span class="'.$tagBracketsClss.'">&lt;</span>';
            $str .= '<span class="'.$tagNameClss.'">'.$html[HtmlDatIx_NAME].'</span>';
            $str .= $this->attribs->showNicely($this->errorLevs);
            $str .= '<span class="'.$tagBracketsClss.'">&gt;</span>';
            $str .= "\r\n";
            break;
          case OpClState_OPENCLOSED:
          case OpClState_OPENCLOSED_X:
            $str .= '<span class="'.$tagBracketsClss.'">&lt;</span>';
            $str .= '<span class="'.$tagNameClss.'">'.$html[HtmlDatIx_NAME].'</span>';
            $str .= $this->attribs->showNicely($this->errorLevs);
            $str .= '<span class="'.$tagNameClss.'"> /</span>';
            $str .= '<span class="'.$tagBracketsClss.'">&gt;</span>';
            $str .= "\r\n";
            break;
        }
        break;
      case PeType_TEXT:
        $str .= '<span class="text">'.$this->text.'</span>';
        $str .= "\r\n";
        break;
      case PeType_CMNT:
        $str .= '<span class="comment">&lt;!-- '.$this->text.' --&gt;</span>';
        $str .= "\r\n";
        break;
      case PeType_CSS:
      case PeType_SCRIPT:
        $str .= $this->text."\r\n";
        break;
    }
    return $str;
  }
}

################################################################################

class C_PageElements {
  public   $arr;
  private  $numElements;
  private  $parentStack;
  private  $continueProcessing;
  private  $indent;
  private  $rowDigits, $colDigits;
  private  $js, $css, $links, $images, $favicon;
  ######################
  public function C_PageElements() {
    $this->continueProcessing = true;
    $this->arr = array();
    $this->numElements = 0;
    $this->indent = 0;
    $this->parentStack = array(0);
    $this->js = array();
    $this->css = array();
    $this->links = array();
    $this->images = array();
    $this->favicon = '';
    $this->add(PeType_TAG, ClsChrState_OK, 'page root', NULL, -1, -1, NULL);
  }
  ######################
  public function add($type, $closeCharState, $data, $attribs, $row, $col, $errors, $forceClosed=false) {
    $element = new C_PageElement($type, $closeCharState, $data, $attribs, $row, $col, $errors, $forceClosed);
    $this->addPreMade($element);
  }
  ######################
  public function addPreMade($element) {
    $element->indent = $this->indent;
    switch ($element->type) {
      case PeType_TEXT:
        // check parent class
        if (($parentIx = array_pop($this->parentStack)) !== NULL) {
          $this->parentStack[] = $parentIx;
          $parentElement = $this->arr[$parentIx];
          $parentTagIx = $parentElement->tagIndex;
          if (elementAllowedInContent(TEXT, $parentTagIx) === false) {
            $msg = "'Text' not allowed in this context.\n"
                 . getAllowedContentStr($parentTagIx)." [line ".($parentElement->row + 1).", column ".($parentElement->col + 1)."].";
            showTextDBG($msg);
            $element->errors[] = array(ErrLev_ERROR | Err_NOT_ALLOWED, $msg); $element->errorLevs |= ErrLev_ERROR;
          }
        }
        break;
      case PeType_UNKNOWN_TAG:
        $msg = "Unknown tag '".$element->name."'.";
        showTextDBG($msg);
        $element->errors[] = array(ErrLev_ERROR | Err_UNKNOWN_TAG, $msg); $element->errorLevs |= ErrLev_ERROR;
      case PeType_TAG:
        $tagIndex = $element->tagIndex;
        $elementIx = $this->numElements;
        switch ($element->ocState) {
          case OpClState_FORCEDCLOSED: case OpClState_OPENCLOSED: case OpClState_OPENCLOSED_X:
            if (getEndTagReq($tagIndex) != TagAllw_REQ) {
              $element->matchingElement = $elementIx;
              break;
            }
            $msg = "Tag '".getTagName($tagIndex, true)."' has been prematurely closed (you must use '".getTagName($tagIndex, true, true)."' to close it).";
            $element->errors[] = array(ErrLev_ERROR | Err_TAG_PREMATURE_CLOSE, $msg); $element->errorLevs |= ErrLev_ERROR;
            $element->ocState = OpClState_OPEN;
            // intended follow-through (which turns it into an open tag)
          case OpClState_OPEN:
            showTextDBG("OPEN ".$element->name);
            // check parent class
            if (($parentIx = array_pop($this->parentStack)) !== NULL) {
              $this->parentStack[] = $parentIx;
              $parentElement = $this->arr[$parentIx];
              $parentTagIx = $parentElement->tagIndex;
              if ($tagIndex < Tag_NUM_TAGS && elementAllowedInContent($tagIndex, $parentTagIx) === false) {
                $msg = "Tag '".getTagName($tagIndex, true)."' not allowed in this context.\n"
                     . getAllowedContentStr($parentTagIx, $parentElement->row, $parentElement->col)
                     . " [line ".($parentElement->row + 1).", column ".($parentElement->col + 1)."].";
                showTextDBG("  ".$msg);
                $element->errors[] = array(ErrLev_ERROR | Err_NOT_ALLOWED, $msg); $element->errorLevs |= ErrLev_ERROR;
              }
            }
            // check whether tag has been deprecated
            if ($element->htmlStatus & Stat_DEPRECATED) {
              $msg = "Tag '".getTagName($tagIndex, true)."' has been deprecated.";
              showTextDBG("  ".$msg);
              $element->errors[] = array(ErrLev_LEGACY | Err_DEPRECATED,$msg); $element->errorLevs |= ErrLev_LEGACY;
            }
            // check whether end tag is forbidden
            if (getEndTagReq($tagIndex) == TagAllw_FBD) {
              // element was not auto closed - fix it and issue warning
              $element->matchingElement = $elementIx;
              $msg = "Tag '".getTagName($tagIndex)."' not formally closed. Use ' /&gt;'";
              showTextDBG("  ".$msg);
              $element->errors[] = array(ErrLev_WARNING | Err_TAG_NOT_CLOSED, $msg); $element->errorLevs |= ErrLev_WARNING;
              $element->ocState = OpClState_OPENCLOSED;
              // tag is not parent-stacked and indent is unchanged
            }
            else {
              $element->matchingElement = false;
              $this->parentStack[] = $elementIx;
              $this->indent++;
            }
            break;
          case OpClState_CLOSED:
            showTextDBG("CLOSE /".$element->name);
            $tmpStack = $this->parentStack;
            while (($parentIx = array_pop($this->parentStack)) !== NULL) {
              $parentElem = &$this->arr[$parentIx];
              showTextDBG("  Checking ".$parentElem->name);
              if ($parentElem->tagIndex == $tagIndex && $parentElem->matchingElement === false) {
                // parent element matches
                $parentElem->matchingElement = $elementIx;
                $element->matchingElement = $parentIx;
                $element->indent = $this->indent = $parentElem->indent;
                showTextDBG("  OPEN tag for ".$element->name." found");
                break;
              }
            }
            if ($parentIx === NULL) {
              $element->matchingElement = false;
              $this->parentStack = $tmpStack;
            }
            break;
          case OpClState_OPENCLOSED_X:
            $msg = "Missing pre-close space character for element '".getTagName($tagIndex, true)."'. Use ' /&gt;'.";
            showTextDBG($msg);
            $element->errors[] = array(ErrLev_XHTML | Err_MISSING_SPACE, $msg); $element->errorLevs |= ErrLev_XHTML;
          case OpClState_OPENCLOSED:
            showTextDBG("OPEN/CLOSE ".$element->name);
            if (getEndTagReq($tagIndex) == TagAllw_REQ) {
              $tagName = getTagName($tagIndex, true);
              $msg = "Tag '{$tagName}' has been prematurely closed (you must use '&lt;/{$tagName}&gt;' to close it).";
              showTextDBG("  ".$msg);
              $element->errors[] = array(ErrLev_ERROR | Err_TAG_PREMATURE_CLOSE, $msg); $element->errorLevs |= ErrLev_ERROR;
            }
            $element->matchingElement = $elementIx;
            break;
        }
    }
    $this->arr[] = $element;
    $this->numElements++;
  }
  ######################
  ## validation is performed after all elements have been found
  public function validate() {
    showTextDBG();
    // identify missing open/close tags
    foreach ($this->arr as $elementIx => &$element) {
      if ($element->type == PeType_TAG) {
        $tagIndex = $element->tagIndex;
        if ($element->matchingElement === false) {
          switch ($element->ocState) {
            case OpClState_OPEN:
              $errLev = getEndTagReq($tagIndex) == TagAllw_OPT ? ErrLev_XHTML : ErrLev_ERROR;
              if ($errLev == ErrLev_XHTML) {
                // end tag is optional
                $element->matchingElement = $elementIx;
              }
              $msg = "Tag '".getTagName($tagIndex, true)."' found without corresponding 'closing' tag.\n";
              $msg.= "Use '".getTagName($tagIndex, true, true)."'.";
              showTextDBG($msg);
              $element->errors[] = array($errLev | Err_MISSING_CLOSE_TAG, $msg); $element->errorLevs |= $errLev;
              break;
            case OpClState_CLOSED:
              $msg = "Closing tag '".getTagName($tagIndex, true, true)."' found without corresponding 'open' tag.";
              showTextDBG($msg);
              $element->errors[] = array(ErrLev_ERROR | Err_MISSING_OPEN_TAG, $msg); $element->errorLevs |= ErrLev_ERROR;
              break;
          }
        }
      }
    } unset($element);

    // find anchors, images, css, favicon and javascript
    foreach ($this->arr as $elementIx => $element) {
      if ($element->type == PeType_TAG) {
        $tagIndex = $element->tagIndex;
        if ($element->ocState !== OpClState_CLOSED) {
          switch ($tagIndex) {
            case Tag_A:  // anchor
              $hRef = $aText = '';
              foreach ($element->attribs->attribs as $att) {
                if ($att->name == 'href') {
                  $hRef = $att->value;
                  break;
                }
              }
              for ($nextElemIx = $elementIx + 1; $nextElemIx < $element->matchingElement; $nextElemIx++) {
                $nextElement = $this->arr[$nextElemIx];
                if ($nextElement->type == PeType_TEXT) {
                  $aText .= $nextElement->text.' ';
                }
              }
              if ($hRef != '') {
                $this->links[] = array($hRef, rtrim($aText));
              }
              break;
            case Tag_IMG:  // image
              $src = $alt = '';
              foreach ($element->attribs->attribs as $att) {
                if ($att->name == 'src') $src = $att->value;
                if ($att->name == 'alt') $alt = $att->value;
              }
              if ($src != '') {
                $this->images[] = array($src, $alt);
              }
              break;
            case Tag_LINK:  // css / favicon
              $rel = $val = '';
              foreach ($element->attribs->attribs as $att) {
                if ($att->name == 'rel') $rel = $att->value;
                if ($att->name == 'href') $val = $att->value;
              }
              $rel = strtolower($rel);
              if ($rel == 'stylesheet' && $val != '') {
                $this->css[] = $val;
              }
              if ($rel == 'shortcut icon' && $val != '') {
                $this->favicon = $val;
              }
              break;
            case Tag_SCRIPT:  // link
              $src = '';
              foreach ($element->attribs->attribs as $att) {
                if ($att->name == 'src') {
                  $src = $att->value;
                  break;
                }
              }
              if ($src != '') {
                $this->js[] = $src;
              }
              break;
          }
        }
      }
    };

    sort($this->js);
    sort($this->css);
    usort($this->links, create_function('$a,$b', '$dif=strcmp($a[0], $b[0]); if ($dif<0) return -1; if ($dif>0) return 1; return 0;'));
    usort($this->images, create_function('$a,$b', '$dif=strcmp($a[0], $b[0]); if ($dif<0) return -1; if ($dif>0) return 1; return 0;'));

    // match up the error levels
    foreach ($this->arr as $ix => &$el) {
      if (($mElIx = $el->matchingElement) > $ix) {
        $el->matchingErrorLevs = $this->arr[$mElIx]->errorLevs;
        $this->arr[$mElIx]->matchingErrorLevs = $el->errorLevs;
      }
    } unset($el);
    // produce the row/column padding string
    $rowHi = $this->arr[$this->numElements - 1]->row + 1;
    $colHi = 0;
    for ($ix = 1; $ix < $this->numElements; $ix++) {
      if (($hi = $this->arr[$ix]->col) > $colHi) $colHi = $hi;
    }
    $colHi = $colHi + 1;
    $this->rowDigits = strlen(strval($rowHi));
    $this->colDigits = strlen(strval($colHi));

    global $tags;
    $tags = new C_TagAnalyser($this);

    // export errors from elements into $err
    $this->exportErrors();
  }
  ######################
  public function getScripts() {
    return $this->js;
  }
  ######################
  public function getNumScripts() {
    return count($this->js);
  }
  ######################
  public function getCss() {
    return $this->css;
  }
  ######################
  public function getNumCss() {
    return count($this->css);
  }
  ######################
  public function getLinks() {
    return $this->links;
  }
  ######################
  public function getNumLinks() {
    return count($this->links);
  }
  ######################
  public function getImages() {
    return $this->images;
  }
  ######################
  public function getNumImages() {
    return count($this->images);
  }
  ######################
  public function getFavicon() {
    return $this->favicon;
  }
  ######################
  public function getNumElements() {
    return $this->numElements;
  }
  ######################
  public function addAttrib($ix, $attrib) {
    $this->arr[$ix]->attribs->add($attrib);
  }
  public function exportErrors() {
    global $allErrors;
    foreach ($this->arr as $el) {
      if ($el->errors != NULL) {
        foreach ($el->errors as $e) {
          $allErrors->add($e[0], $e[1], $el->row, $el->col);
        }
      }
    }
  }
  ######################
  public function show() {
//showText($this->numElements);
    foreach($this->arr as $el) {
       $el->show('['.$el->showRowCol($this->rowDigits, $this->colDigits).']');
    }
  }
  ######################
  public function showNicely($file) {
    if ($handle = fopen($file, 'w')) {
      $str = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'."\r\n";
      $str.= '<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">'."\r\n";
      $str.= "  <head>\r\n";
      $str.= '    <style type="text/css">'."\r\n";
      $str.= "      body {font-size:12pt;color:purple;}\r\n";
      $str.= "      .rowcol {color:silver;}\r\n";
      $str.= "      .rcBrackets {color:gray;}\r\n";
      $str.= "      .tabs {color:silver;}\r\n";
      $str.= "      .comment {color:gray;}\r\n";
      $str.= "      .text {color:purple;}\r\n";
      $str.= "      .rowcol, .rcBrackets {font-size:12pt;}\r\n";
      $str.= "      .comment, .text {font-size:12pt;font-style:oblique;}\r\n";
      $str.= "      .tagBrackets, .tagBracketsE, .tagBracketsW, .tagBracketsN, .tagBracketsL, .tagBracketsX {font-size:12pt;font-weight:bold;}\r\n";
      $str.= "      .tagName, .tagNameE, .tagNameW, .tagNameN, .tagNameL, .tagNameX {font-size:larger;font-weight:bold;}\r\n";
      $str.= "      .attribName, .attribNameE, .attribNameW, .attribNameN, .attribNameL, .attribNameX {font-size:12pt;font-style:oblique;}\r\n";
      $str.= "      .attribValue, .attribValueE, .attribValueW, .attribValueN, .attribValueL, .attribValueX {font-size:12pt;font-style:oblique;}\r\n";
      $str.= "      .tagBrackets, .tagName, .attribName, .attribValue {color:teal;}\r\n";
      $str.= "      .tagBracketsE, .tagNameE, .attribNameE, .attribValueE {color:red;}\r\n";
      $str.= "      .tagBracketsW, .tagNameW, .attribNameW, .attribValueW {color:purple;}\r\n";
      $str.= "      .tagBracketsN, .tagNameN, .attribNameN, .attribValueN {color:purple;}\r\n";
      $str.= "      .tagBracketsL, .tagNameL, .attribNameL, .attribValueL {color:purple;}\r\n";
      $str.= "      .tagBracketsX, .tagNameX, .attribNameX, .attribValueX {color:purple;}\r\n";
      $str.= "    </style>\r\n";
      $str.= "  </head>\r\n";
      $str.= "  <body>\r\n    <pre>\r\n";
      fwrite($handle, $str);
      for ($ix = 1; $ix < $this->numElements; $ix++) {
        $element = $this->arr[$ix];
         $str = '<span class="rcBrackets">[</span>';
         $str.= '<span class="rowcol">'.$element->showRowCol($this->rowDigits, $this->colDigits).'</span>';
         $str.= '<span class="rcBrackets">]</span> ';
         $str.= $element->showNicely();
         fwrite($handle, $str);
      }
      fwrite($handle, "    </pre>\r\n  </body>\r\n</html>\r\n");
      fclose($handle);
     }
  }
}

?>