<?php

// recursive string replace
function str_replace_all($search, $replace, $subject) {
  while (strpos($subject, $search) !== false) {
    $subject = str_replace($search, $replace, $subject);
  }
  return $subject;
}

//
function showText($text='', $nbsp=true, $tabs=0, $nl=true, $check=true) {
//echo $text."<br />";return;
//$nbsp = false;
  if ($text != '') {
    $text = str_replace('  ', '  ', $text);
    if ($nbsp) $text = str_replace('  ', '&nbsp;&nbsp;', $text);
    $text = str_replace_all('<!--&nbsp;', '<!--', $text);
    $text = str_replace_all('&nbsp;-->', '-->', $text);
    $text = str_replace(array('<!--', '-->'), '', $text);
    if ($check) $text = str_replace('~@~', ' ', $text);
    $text = str_replace("\n", '<br />', $text);
    $text = '<span style="font-family:courier;">'.$text.'</span>';
    echo $text;
  }
  if ($nl) echo "<br />";
  if ($nl) echo "\r\n";
  @ob_flush();
  flush();
  usleep(50);
}

//
function showTextDBG($text='', $nbsp=true, $tabs=0, $nl=true, $check=true) {
  if (defined('DEBUG') && DEBUG) showText($text, $nbsp, $tabs, $nl, $check);
}

//
function showWarning($text='', $nbsp=true, $tabs=0, $nl=true) {
  showText('<span~@~style="color:purple;"><b>WARNING:</b> '.$text.'</span>', $nbsp, $tabs, $nl, true);
}

//
function showError($text="", $nbsp=true, $tabs=0, $nl=true) {
  showText('<span~@~style="color:red;"><b>ERROR:</b> '.$text.'</span>', $nbsp, $tabs, $nl, true);
  exit();
}

?>