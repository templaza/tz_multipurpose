<?php
/*------------------------------------------------------------------------

# TZ Portfolio Extension

# ------------------------------------------------------------------------

# author    DuongTVTemPlaza

# copyright Copyright (C) 2012 templaza.com. All Rights Reserved.

# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL

# Websites: http://www.templaza.com

# Technical Support:  Forum - http://templaza.com/Forum

-------------------------------------------------------------------------*/

defined('_JEXEC') or die;

$option         = JRequest::getCmd('option','com_tz_multipurpose');
$view           = JRequest::getCmd('view','groups');
$task           = JRequest::getCmd('task',null);



include_once dirname(__FILE__) . '/libraries/core/defines.php';
include_once dirname(__FILE__) . '/libraries/core/tzmultipurpose.php';


$controller	= JControllerLegacy::getInstance('TZ_Multipurpose');

$controller->execute(JFactory::getApplication()->input->get('task'));

$controller->redirect();
