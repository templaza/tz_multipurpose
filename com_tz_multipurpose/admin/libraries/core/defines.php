<?php
/*------------------------------------------------------------------------

# TZ MULTIPURPOSE Extension

# ------------------------------------------------------------------------

# author    DuongTVTemPlaza

# copyright Copyright (C) 2013 templaza.com. All Rights Reserved.

# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL

# Websites: http://www.templaza.com

# Technical Support:  Forum - http://templaza.com/Forum

-------------------------------------------------------------------------*/

// No direct access
defined('_JEXEC') or die;

define('COM_TZ_MULTIPURPOSE','com_tz_MULTIPURPOSE');
define ('COM_TZ_MULTIPURPOSE_ADMIN_HOST_PATH', JURI::base(true).'/components/'.COM_TZ_MULTIPURPOSE);
define ('COM_TZ_MULTIPURPOSE_LIBRARIES', dirname(dirname(dirname(__FILE__.'/libraries'))));
define ('COM_TZ_MULTIPURPOSE_ADMIN_PATH', dirname(dirname(dirname(__FILE__))));
define ('COM_TZ_MULTIPURPOSE_JVERSION_COMPARE', version_compare(JVERSION,'3.0','ge'));

if(!COM_TZ_MULTIPURPOSE_JVERSION_COMPARE && !DIRECTORY_SEPARATOR){
    define('DIRECTORY_SEPARATOR','\\');
}

if(file_exists(JPATH_ADMINISTRATOR.'/components/com_tz_MULTIPURPOSE/tz_MULTIPURPOSE.xml')){
    define('COM_TZ_MULTIPURPOSE_VERSION',JFactory::getXML(JPATH_ADMINISTRATOR.'/components/com_tz_MULTIPURPOSE/tz_MULTIPURPOSE.xml')->version);
}elseif(file_exists(JPATH_ADMINISTRATOR.'/components/com_tz_MULTIPURPOSE/manifest.xml')){
    define('COM_TZ_MULTIPURPOSE_VERSION',JFactory::getXML(JPATH_ADMINISTRATOR.'/components/com_tz_MULTIPURPOSE/manifest.xml')->version);
}