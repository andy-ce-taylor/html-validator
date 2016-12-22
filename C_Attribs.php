<?php

define('NULL_ATTRIB_START',        '*');
define('NULL_ATTRIB_NAME',        NULL_ATTRIB_START.'NULL ATTRIB*');

global $attribNameClss, $attribValueClss;

class C_Attrib {
  public $name;
  public $value;
  public $nameRow, $nameCol;
  public $valueRow, $valueCol;

  public function C_Attrib($name, $value, $nRow, $nCol, $vRow, $vCol) {
    if ($name[0] == NULL_ATTRIB_START) {
      $nRow = $nCol = -1;
    }
    $this->name = strtolower($name);
    $this->value = $value;
    $this->nameRow = $nRow;
    $this->nameCol = $nCol;
    $this->valueRow = $vRow;
    $this->valueCol = $vCol;
  }
  ######################
  public function show() {
    $attNameRow = $this->nameRow + 1;
    $attNameCol = $this->nameCol + 1;
    $attValueRow = $this->valueRow + 1;
    $attValueCol = $this->valueCol + 1;
    if ($this->name[0] != NULL_ATTRIB_START) $str = "'".$this->name."'($attNameRow,$attNameCol)";
    else $str = '';
    if ($this->value != '') $str .= "='".$this->value."'($attValueRow,$attValueCol)";
    return $str;
  }
  ######################
  public function showNicely() {
    global $attribNameClss, $attribValueClss;
    if ($this->name[0] == NULL_ATTRIB_START) {
      $str = '<span class="'.$attribValueClss.'">'.$this->value.'</span>';
    }
    else {
      $str = '<span class="'.$attribNameClss.'">'.$this->name.'</span>';
      $str.= '="';
      if ($this->value == '') {
        $str.= '<span class="'.$attribNameClss.'">'.$this->name.'</span>';
      }
      else {
        $str.= '<span class="'.$attribValueClss.'">'.$this->value.'</span>';
      }
      $str.= '"';
    }
    return $str;
  }
}

#####################################################################
class C_Attribs {
  public  $attribs;
  private  $numAttribs;

  public function C_Attribs($ar) {
    $this->attribs = $ar == NULL ? array() : $ar;
    $this->numAttribs = count($this->attribs);
  }
  ######################
  public function add($attrib) {
    $this->attribs[] = $attrib;
    $this->numAttribs++;
  }
  ######################
  public function getNumAttribs() {
    return $this->numAttribs;
  }
  public function show() {
    $str = '';
    foreach ($this->attribs as $at) {
      $str .= $at->show().', ';
    }
    return rtrim($str, ', ');
  }
  ######################
  public function showNicely($errLevs) {
    global $attribNameClss, $attribValueClss;
    if ($errLevs == 0) {
      $attribNameClss = "attribName";
      $attribValueClss = "attribValue";
    }
    elseif ($errLevs & ErrLev_ERROR) {
      $attribNameClss = "attribNameE";
      $attribValueClss = "attribValueE";
    }
    elseif ($errLevs & ErrLev_WARNING) {
      $attribNameClss = "attribNameW";
      $attribValueClss = "attribValueW";
    }
    elseif ($errLevs & ErrLev_NOTICE) {
      $attribNameClss = "attribNameN";
      $attribValueClss = "attribValueN";
    }
    elseif ($errLevs & ErrLev_LEGACY) {
      $attribNameClss = "attribNameL";
      $attribValueClss = "attribValueL";
    }
    elseif ($errLevs & ErrLev_XHTML) {
      $attribNameClss = "attribNameX";
      $attribValueClss = "attribValueX";
    }
    $str = ' ';
    for ($ix = 0; $ix < $this->numAttribs; $ix++) {
      $str .= $this->attribs[$ix]->showNicely().' ';
    }
    return rtrim($str);
  }
}

?>