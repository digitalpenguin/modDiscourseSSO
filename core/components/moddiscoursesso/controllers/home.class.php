<?php
require_once dirname(dirname(__FILE__)) . '/index.class.php';
/**
 * Loads the home page.
 *
 * @package moddiscoursesso
 * @subpackage controllers
 */
class modDiscourseSSOHomeManagerController extends modDiscourseSSOBaseManagerController {
    public function process(array $scriptProperties = array()) {

    }
    public function getPageTitle() { return $this->modx->lexicon('moddiscoursesso'); }
    public function loadCustomCssJs() {
    
    }

}