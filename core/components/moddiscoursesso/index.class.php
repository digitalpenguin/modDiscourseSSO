<?php
require_once dirname(__FILE__) . '/model/moddiscoursesso/moddiscoursesso.class.php';
/**
 * @package moddiscoursesso
 */

abstract class modDiscourseSSOBaseManagerController extends modExtraManagerController {
    /** @var modDiscourseSSO $moddiscoursesso */
    public $moddiscoursesso;
    public function initialize() {
        $this->moddiscoursesso = new modDiscourseSSO($this->modx);

        $this->addCss($this->moddiscoursesso->getOption('cssUrl').'mgr.css');
        $this->addJavascript($this->moddiscoursesso->getOption('jsUrl').'mgr/moddiscoursesso.js');
        $this->addHtml('<script type="text/javascript">
        Ext.onReady(function() {
            modDiscourseSSO.config = '.$this->modx->toJSON($this->moddiscoursesso->options).';
            modDiscourseSSO.config.connector_url = "'.$this->moddiscoursesso->getOption('connectorUrl').'";
        });
        </script>');
        
        parent::initialize();
    }
    public function getLanguageTopics() {
        return array('moddiscoursesso:default');
    }
    public function checkPermissions() { return true;}
}