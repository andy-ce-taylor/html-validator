<?php


define('MTag_META_HE',        1000);
define('MTag_META_UNKNOWN',    2000);

$pageInfo = array();
// recommended meta tags
define('PageInfo_TITLE',                            0);      $pageInfo[] = array(Tag_TITLE,    'title',                      array());
define('PageInfo_META_CONTENT_LANGUAGE',            1);      $pageInfo[] = array(MTag_META_HE,  'content-language',          array());
define('PageInfo_META_CONTENT_TYPE',                2);      $pageInfo[] = array(MTag_META_HE,  'content-type',              array());
define('PageInfo_META_DESCRIPTION',                 3);      $pageInfo[] = array(Tag_META,      'description',               array());
define('PageInfo_META_LANGUAGE',                    4);      $pageInfo[] = array(Tag_META,      'language',                  array());

// optional meta tags
define('PageInfo_META_ABSTRACT',                    5);      $pageInfo[] = array(Tag_META,      'abstract',                  array());
define('PageInfo_META_AUTHOR',                      6);      $pageInfo[] = array(Tag_META,      'author',                    array());
define('PageInfo_META_COPYRIGHT',                   7);      $pageInfo[] = array(Tag_META,      'copyright',                 array());
define('PageInfo_META_DESIGNER',                    8);      $pageInfo[] = array(Tag_META,      'designer',                  array());
define('PageInfo_META_GOOGLE_SITE_VERIFICATION',    9);      $pageInfo[] = array(Tag_META,      'google-site-verification',  array());
define('PageInfo_META_GOOGLEBOT',                   10);    $pageInfo[] = array(Tag_META,      'googlebot',                  array());
define('PageInfo_META_KEYWORDS',                    11);    $pageInfo[] = array(Tag_META,      'keywords',                   array());
define('PageInfo_META_MSN',                         12);    $pageInfo[] = array(Tag_META,      'msnbot',                     array());
define('PageInfo_META_PRAGMA',                      13);    $pageInfo[] = array(MTag_META_HE,  'pragma',                     array());
define('PageInfo_META_TITLE',                       14);    $pageInfo[] = array(Tag_META,      'title',                      array());
define('PageInfo_META_X_UA_COMPATIBLE',             15);    $pageInfo[] = array(MTag_META_HE,  'x-ua-compatible',            array());

// not recommended meta tags
define('PageInfo_META_CONTENT_SCRIPT_TYPE',         16);    $pageInfo[] = array(MTag_META_HE,  'content-script-type',        array());
define('PageInfo_META_CONTENT_STYLE_TYPE',          17);    $pageInfo[] = array(MTag_META_HE,  'content-style-type',         array());
define('PageInfo_META_DISTRIBUTION',                18);    $pageInfo[] = array(Tag_META,      'distribution',               array());
define('PageInfo_META_EXPIRES',                     19);    $pageInfo[] = array(MTag_META_HE,  'expires',                    array());
define('PageInfo_META_FRESHBOT',                    20);    $pageInfo[] = array(Tag_META,      'freshbot',                   array());
define('PageInfo_META_GENERATOR',                   21);    $pageInfo[] = array(Tag_META,      'generator',                  array());
define('PageInfo_META_GOOGLE',                      22);    $pageInfo[] = array(Tag_META,      'google',                     array());
define('PageInfo_META_PUBLISHER',                   23);    $pageInfo[] = array(Tag_META,      'publisher',                  array());
define('PageInfo_META_RATING',                      24);    $pageInfo[] = array(Tag_META,      'rating',                     array());
define('PageInfo_META_REFRESH',                     25);    $pageInfo[] = array(MTag_META_HE,  'refresh',                    array());
define('PageInfo_META_REPLY_TO',                    26);    $pageInfo[] = array(Tag_META,      'reply-to',                   array());
define('PageInfo_META_RESOURCE_TYPE',               27);    $pageInfo[] = array(Tag_META,      'resource-type',              array());
define('PageInfo_META_REVISIT_AFTER',               28);    $pageInfo[] = array(Tag_META,      'revisit-after',              array());
define('PageInfo_META_ROBOTS',                      29);    $pageInfo[] = array(Tag_META,      'robots',                     array());
define('PageInfo_META_SET_COOKIE',                  30);    $pageInfo[] = array(MTag_META_HE,  'set-cookie',                 array());
define('PageInfo_META_SUBJECT',                     31);    $pageInfo[] = array(Tag_META,      'subject',                    array());

// the jury's out
define('PageInfo_META_CACHE_CONTROL',               32);    $pageInfo[] = array(MTag_META_HE,  'cache-control',              array());
define('PageInfo_META_CLASSIFICATION',              33);    $pageInfo[] = array(Tag_META,      'classification',             array());
define('PageInfo_META_COVERAGE',                    34);    $pageInfo[] = array(Tag_META,      'coverage',                   array());
define('PageInfo_META_EXT_CACHE',                   35);    $pageInfo[] = array(MTag_META_HE,  'ext-cache',                  array());
define('PageInfo_META_GEO_PLACENAME',               36);    $pageInfo[] = array(Tag_META,      'geo-placename',              array()); // Free Text place name
define('PageInfo_META_GEO_POSITION',                37);    $pageInfo[] = array(Tag_META,      'geo-position',               array()); // Latitude;Longitude in decimal degrees using the WGS84 datum
define('PageInfo_META_GEO_REGION',                  38);    $pageInfo[] = array(Tag_META,      'geo-region',                 array()); // Geographic regions from ISO3166-2
define('PageInfo_META_HTDIG_KEYWORDS',              39);    $pageInfo[] = array(Tag_META,      'htdig-keywords',             array());
define('PageInfo_META_HTDIG_NOINDEX',               40);    $pageInfo[] = array(Tag_META,      'htdig-noindex',              array());
define('PageInfo_META_IMAGE_TOOLBAR',               41);    $pageInfo[] = array(MTag_META_HE,  'imagetoolbar',               array());
define('PageInfo_META_FORMATTER',                   42);    $pageInfo[] = array(Tag_META,      'formatter',                  array());
define('PageInfo_META_LAST_MODIFIED',               43);    $pageInfo[] = array(MTag_META_HE,  'last-modified',              array());
define('PageInfo_META_NO_EMAIL_COLLECTION',         44);    $pageInfo[] = array(Tag_META,      'no-email-collection',        array());
define('PageInfo_META_PICS_LABEL',                  45);    $pageInfo[] = array(MTag_META_HE,  'pics-label',                 array());
define('PageInfo_META_PROG_ID',                     46);    $pageInfo[] = array(Tag_META,      'progid',                     array());
define('PageInfo_META_WINDOW_TARGET',               47);    $pageInfo[] = array(MTag_META_HE,  'window-target',              array());
define('PageInfo_META_VARY',                        48);    $pageInfo[] = array(MTag_META_HE,  'vary',                       array());
define('PageInfo_META_VW96_OBJECT_TYPE',            49);    $pageInfo[] = array(Tag_META,      'vw96.objecttype',            array());

// UNKNOWN - must be the last in the list
define('PageInfo_META_UNKNOWN',                     50);    $pageInfo[] = array(MTag_META_UNKNOWN, array());

#####################################################################################################################################################################

class C_TagAnalyser {
  private $pageInfo;

  #############################
  public function C_TagAnalyser($pageElements) {
    global $pageInfo;
    $this->pageInfo = $pageInfo;
    $elements = $pageElements->arr;
    $numElements = count($elements);
    for ($ix = 0; $ix < $numElements; $ix++) {
      $el = &$elements[$ix];
      if ($el->type == PeType_TAG) {
        if ($el->tagIndex == Tag_TITLE) $this->processTag_TITLE($elements, $ix);
        elseif ($el->tagIndex == Tag_META) $this->processTag_META($el);
      }
    }
  }
  #############################
  private function processTag_TITLE($elems, $ix) {
    if ($elems[$ix]->ocState != OpClState_OPEN) return;
    $nextEl = $elems[$ix + 1];
    if ($nextEl->type = PeType_TEXT) {
      $this->pageInfo[PageInfo_TITLE][2][] = array('title', $nextEl->text);
    }
  }
  #############################
  private function processTag_META(&$el) {
    $attributes = $el->attribs;
    $metaTagName = '';
    $numAttribs = $attributes->getNumAttribs();
    foreach ($attributes->attribs as $att) {
      if ($att->name == 'name' || $att->name == 'http-equiv') {
        $metaTagName = $att->value;
        break;
      }
    }
    if ($metaTagName == '') { // missing 'name' or 'http-equiv' attribute
      $msg = "Missing 'name=' or 'http-equiv=' attribute in meta tag.";
      $el->errors[] = array(ErrLev_ERROR | Err_MISSING_NAME_HE_ATTRIB, $msg); $el->errorLevs |= ErrLev_ERROR;
      return;
    }
    foreach ($attributes->attribs as $att) {
      $iName = strtolower($att->value);
      foreach($this->pageInfo as &$pi) {
        if (($pi[0] == Tag_META && $att->name == 'name')
        ||  ($pi[0] == MTag_META_HE && $att->name == 'http-equiv')) {
          if ($pi[1] == $iName) {
            foreach ($attributes->attribs as $att2) {
              if ($att2->name == 'content') {
                $pi[2][] = array($att->value, $att2->value);
                return;
              }
            }
          }
        }
      }
    }
    // unknown meta tag
    $content = '';
    $pi = &$this->pageInfo[PageInfo_META_UNKNOWN];
    foreach ($attributes->attribs as $att) {
      if ($att->name == 'content') {
        $content = $att->value;
        $pi[1][] = array($metaTagName, $content);
        break;
      }
    }
    if ($content == '') {
      $msg = "Unknown meta tag - missing 'content' attribute.";
    }
    else {
      $msg = "Unknown meta tag '".$metaTagName."'.";
    }
    $el->errors[] = array(ErrLev_NOTICE | Err_UNKNOWN_META_TAG, $msg); $el->errorLevs |= ErrLev_NOTICE;
  }
  #############################
  public function showTag($piIx) {
    $pInfo = $this->pageInfo[$piIx];
    $tag = $pInfo[0];
    $str = '';
    switch ($tag) {
      case Tag_TITLE:
        if (count($pInfo[2])) {
          foreach ($pInfo[2] as $att) {
            $str .= $att[0]." = '".$att[1]."', ";
          }
        }
        break;
      case Tag_META: case MTag_META_HE:
        if (count($pInfo[2])) {
          foreach ($pInfo[2] as $att) {
            $str .= $att[0]." = '".$att[1]."', ";
          }
        }
        break;
      case MTag_META_UNKNOWN:
        if (count($pInfo[1])) {
          foreach ($pInfo[1] as $att) {
            $str .= $att[0]." = '".$att[1]."', ";
          }
        }
        break;
    }
    if ($str != '') showText(rtrim($str, ', '));
  }
  #############################
  public function show() {
    foreach($this->pageInfo as $ix => $pi) {
      $this->showTag($ix);
    }
  }
}

?>