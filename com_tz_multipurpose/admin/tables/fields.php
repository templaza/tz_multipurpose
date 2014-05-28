<?php
/**
 * Created by PhpStorm.
 * User: Thuong
 * Date: 4/28/14
 * Time: 6:40 PM
 */

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