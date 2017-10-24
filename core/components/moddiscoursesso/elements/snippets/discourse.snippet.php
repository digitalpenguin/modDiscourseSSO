<?php
$moddiscoursesso = $modx->getService('moddiscoursesso','modDiscourseSSO',$modx->getOption('moddiscoursesso.core_path',null,$modx->getOption('core_path').'components/moddiscoursesso/').'model/moddiscoursesso/',$scriptProperties);
if (!($moddiscoursesso instanceof modDiscourseSSO)) return '';

$loginPage = $modx->getOption('loginPage',$scriptProperties,$modx->getOption('moddiscoursesso.login_page'));

return $moddiscoursesso->authenticateUser($loginPage);
