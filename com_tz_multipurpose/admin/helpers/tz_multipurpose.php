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

///controller call --- Submenu

class TZ_Multipurpose
{
    public static function addSubmenu($vName) {

        $class  = 'JHtmlSidebar';
        if(!COM_TZ_MULTIPURPOSE_JVERSION_COMPARE){
            $class  = 'JSubMenuHelper';
        }
        call_user_func_array($class.'::addEntry',array(JText::_('COM_TZ_MULTIPURPOSE_SUBMENU_GROUPS'),
                'index.php?option=com_tz_multipurpose&view=groups',
                $vName == 'groups'));

        call_user_func_array($class.'::addEntry',array(JText::_('COM_TZ_MULTIPURPOSE_SUBMENU_FIELDS'),
                'index.php?option=com_tz_multipurpose&view=fields',
                $vName == 'fields'));
    }
}