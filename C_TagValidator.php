<?php

class C_TagValidator {
  private $pageInfo;

  #############################
  public function C_TagValidator($pHtml) {
    $numElements = $pHtml->numPageElements;
    for ($ix = 0; $ix < $numElements; $ix++) {
      $el = $pHtml->pageElements->elements[$ix];
//    PeType_TEXT
//    PeType_TAG
//    PeType_CMNT
      if ($el->type == PeType_TAG) {
        switch ($el->ocState) {
          case OpClState_OPEN:
//            $el->parent =
            break;
          case OpClState_CLOSED:
          case OpClState_OPENCLOSED:
          case OpClState_FORCEDCLOSED:
        }

        switch ($el->tagIndex) {
        }
      }
    }
  }
}

?>