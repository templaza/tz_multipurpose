<?php

jimport('joomla.application.component.modellist');

defined('_JEXEC') or die();

if( $_REQUEST["name"] )
{
    $name = $_REQUEST['name'];

    $db     = $this -> getDbo();
    $query  = $db -> getQuery(true);
    $query -> select('f.*');
    $query -> from('#__tz_multipurpose_fields AS f');
    $query -> join('LEFT','#__tz_multipurpose_groupfield AS x ON f.id=x.fieldsid');
    $query -> join('INNER','#__tz_multipurpose_groups AS fg ON fg.id=x.groupid');

}