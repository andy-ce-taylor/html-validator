<?php

define('URL_TO_CHECK',  'http://localhost/Golden-Sands-Bulgaria/');

//define('DEBUG',  true);

date_default_timezone_set('Europe/London');
error_reporting(E_ALL);
ini_set("memory_limit", "32M");
set_time_limit(0);

require "config.php";
require "utils.php";
require "cURL_DownloadWebpage.php";
require "C_Timer.php";
require "C_Errors.php";
require "C_HtmlParser.php";
require "C_PageElements.php";
require "C_TagValidator.php";
require "C_TagAnalyser.php";

## start the timer
global $mtimer;
global $allErrors;
global $pHtml;
global $pageElements;
global $tags;
global $scripts;
global $css;
global $links;
global $images;
global $favicon;

$mtimer = new C_Timer();

$allErrors = new C_Errors();

$pageElements = new C_PageElements();

## parse the web page
$pHtml = new C_HtmlParser(URL_TO_CHECK);

// validate elements
$pageElements->validate();

showText("Website tokenization completed in ".$mtimer->getElapsedTimeStr());
showText("Peak memory usage is ".$mtimer->getMemUsageStr());

showText();
showText('SCRIPTS ('.$pageElements->getNumScripts().')');
$scripts = $pageElements->getScripts(); foreach ($scripts as $scp) showText('"'.$scp.'"');

showText();
showText('CSS ('.$pageElements->getNumCss().')');
$css = $pageElements->getCss(); foreach ($css as $cs) showText('"'.$cs.'"');

showText();
showText('LINKS ('.$pageElements->getNumLinks().')');
$links = $pageElements->getLinks(); foreach ($links as $lnk) showText('"'.$lnk[0].'" "'.$lnk[1].'"');

showText();
showText('IMAGES ('.$pageElements->getNumImages().')');
$images = $pageElements->getImages(); foreach ($images as $img) showText('"'.$img[0].'" "'.$img[1].'"');

showText();
showText('FAVICON');
$favicon = $pageElements->getFavicon(); showText('"'.$favicon.'"');
showText();

showText();
$pageElements->show();
showText();

$pageElements->showNicely('test.html');

if ($allErrors->getNumErrors()) $allErrors->show();
##

$tags->show();

##
showText("");
showText("Done!");

?>