<?php
/**
 * Created by PhpStorm.
 * User: Thuong
 * Date: 4/25/14
 * Time: 3:40 PM
 */

defined('_JEXEC') or die;

$option         = JRequest::getCmd('option','com_tz_multipurpose');
$view           = JRequest::getCmd('view','groups');
$task           = JRequest::getCmd('task',null);



include_once dirname(__FILE__) . '/libraries/core/defines.php';
include_once dirname(__FILE__) . '/libraries/core/tzmultipurpose.php';


$controller	= JControllerLegacy::getInstance('TZ_Multipurpose');

$controller->execute(JFactory::getApplication()->input->get('task'));

$controller->redirect();
