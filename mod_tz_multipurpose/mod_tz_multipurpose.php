<?php
/**
 * Created by PhpStorm.
 * User: Thuong
 * Date: 5/7/14
 * Time: 10:40 AM
 */
defined('_JEXEC') or die();


require_once dirname(__FILE__).'/helper.php';

$list            = modTZMultipurposeHelper::getList($params);

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

$option_stm = $params->get('tz_multi_stm',2);

require JModuleHelper::getLayoutPath('mod_tz_multipurpose',$params -> get('layout','default'));
