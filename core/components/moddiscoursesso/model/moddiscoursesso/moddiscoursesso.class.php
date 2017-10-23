<?php
require __DIR__ . '/../libs/discourse-php/vendor/autoload.php';

/**
 * The main modDiscourseSSO service class.
 *
 * @package moddiscoursesso
 */
class modDiscourseSSO {
    public $modx = null;
    public $namespace = 'moddiscoursesso';
    public $cache = null;
    public $options = array();
    public $ssoHelper = null;

    public function __construct(modX &$modx, array $options = array()) {
        $this->modx =& $modx;
        $this->namespace = $this->getOption('namespace', $options, 'moddiscoursesso');

        $corePath = $this->getOption('core_path', $options, $this->modx->getOption('core_path', null, MODX_CORE_PATH) . 'components/moddiscoursesso/');
        $assetsPath = $this->getOption('assets_path', $options, $this->modx->getOption('assets_path', null, MODX_ASSETS_PATH) . 'components/moddiscoursesso/');
        $assetsUrl = $this->getOption('assets_url', $options, $this->modx->getOption('assets_url', null, MODX_ASSETS_URL) . 'components/moddiscoursesso/');

        $this->ssoHelper = new Cviebrock\DiscoursePHP\SSOHelper();

        /* loads some default paths for easier management */
        $this->options = array_merge(array(
            'namespace' => $this->namespace,
            'corePath' => $corePath,
            'modelPath' => $corePath . 'model/',
            'chunksPath' => $corePath . 'elements/chunks/',
            'snippetsPath' => $corePath . 'elements/snippets/',
            'templatesPath' => $corePath . 'templates/',
            'assetsPath' => $assetsPath,
            'assetsUrl' => $assetsUrl,
            'jsUrl' => $assetsUrl . 'js/',
            'cssUrl' => $assetsUrl . 'css/',
            'connectorUrl' => $assetsUrl . 'connector.php'
        ), $options);

        $this->modx->addPackage('moddiscoursesso', $this->getOption('modelPath'));
        $this->modx->lexicon->load('moddiscoursesso:default');
    }

    /**
     * Get a local configuration option or a namespaced system setting by key.
     *
     * @param string $key The option key to search for.
     * @param array $options An array of options that override local options.
     * @param mixed $default The default value returned if the option is not found locally or as a
     * namespaced system setting; by default this value is null.
     * @return mixed The option value or the default value specified.
     */
    public function getOption($key, $options = array(), $default = null) {
        $option = $default;
        if (!empty($key) && is_string($key)) {
            if ($options != null && array_key_exists($key, $options)) {
                $option = $options[$key];
            } elseif (array_key_exists($key, $this->options)) {
                $option = $this->options[$key];
            } elseif (array_key_exists("{$this->namespace}.{$key}", $this->modx->config)) {
                $option = $this->modx->getOption("{$this->namespace}.{$key}");
            }
        }
        return $option;
    }

    public function authenticateUser() {

        $secret = $this->modx->getOption('moddiscoursesso.secret');
        $this->ssoHelper->setSecret( $secret );

        // load the payload passed in by Discourse
        $payload = $_GET['sso'];
        $signature = $_GET['sig'];

        // validate the payload
        if (!($this->ssoHelper->validatePayload($payload,$signature))) {
            // invalid, deny
            header("HTTP/1.1 403 Forbidden");
            echo("Bad SSO request");
            die();
        }

        $nonce = $this->ssoHelper->getNonce($payload);

        $user = $this->modx->getUser();
        if (!$user) return '';
        $profile = $user->getOne('Profile');

        if (!$profile) return '';
        $userId = $user->get('id');
        $userEmail = $profile->get('email');

        $userUsername = $user->get('username');
        $userFullName = $profile->get('fullname');

        $extraParameters = array(
            'username' => $userUsername,
            'name'     => $userFullName
        );

        // build query string and redirect back to the Discourse site
        $query = $this->ssoHelper->getSignInString($nonce, $userId, $userEmail, $extraParameters);
        header('Location: '.$this->modx->getOption('moddiscoursesso.scheme').'://'.$this->modx->getOption('moddiscoursesso.host').'/session/sso_login?' . $query);
        exit(0);

    }
}