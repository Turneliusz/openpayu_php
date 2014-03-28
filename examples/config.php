<?php
//namespace OpenPayuSdk\Examples\V2;

/**
 * OpenPayU
 *
 * @copyright  Copyright (c) 2013 PayU
 * @license    http://opensource.org/licenses/LGPL-3.0  Open Software License (LGPL 3.0)
 *
 * http://www.payu.com
 * http://openpayu.com
 * http://twitter.com/openpayu
 *
 */

namespace OpenPayuSdk\Examples;
use OpenPayuSdk\OpenPayu\OpenPayU_Configuration;

OpenPayU_Configuration::setEnvironment('custom','https://secure.payu.te2');
OpenPayU_Configuration::setMerchantPosId('38699');
OpenPayU_Configuration::setPosAuthKey('sdgxjX5'); //??
OpenPayU_Configuration::setClientId('38699'); //??
OpenPayU_Configuration::setClientSecret('43a85986d580ba39de9f48d58c858354'); //??
OpenPayU_Configuration::setSignatureKey('43a85986d580ba39de9f48d58c858354');
OpenPayU_Configuration::setApiVersion(2); //??
OpenPayU_Configuration::setDataFormat('json');
OpenPayU_Configuration::setHashAlgorithm('MD5');

$country = 'api/';
$service = 'v2/';

/* path for example files*/
$dir = explode(basename(dirname(__FILE__)) . '/', $_SERVER['SCRIPT_NAME']);
$directory = $dir[0] . basename(dirname(__FILE__));
$url = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? 'https://' : 'http://') . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . $dir[0];

define('HOME_DIR', $url);
define('EXAMPLES_DIR', HOME_DIR . 'examples/');