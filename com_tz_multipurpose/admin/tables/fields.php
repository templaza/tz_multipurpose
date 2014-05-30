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

defined('_JEXEC') or die('Restricted access');

class TableFields extends JTable
{
    /** @var int Primary key */
    var $id 				= 0;
    var $title 				= null;
    var $type		        = null;
    var $value		        = null;
    var $ordering   		= null;
    var $published			= null;
    var $description		= null;

    function __construct(&$db) {
        parent::__construct('#__tz_multipurpose_fields','id',$db);

    }
}