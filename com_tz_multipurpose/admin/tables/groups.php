<?php
/**
 * Created by PhpStorm.
 * User: Thuong
 * Date: 4/28/14
 * Time: 6:40 PM
 */

defined('_JEXEC') or die('Restricted access');

class TableGroups extends JTable
{
    /** @var int Primary key */
    var $id 				= 0;
    /** @var string */
    var $name 				= null;
    /** @var string*/
    var $description		= null;

    function __construct(&$db) {
        parent::__construct('#__tz_multipurpose_groups','id',$db);

    }
}