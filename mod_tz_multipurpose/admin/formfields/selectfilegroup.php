<?php
/**
 * Created by PhpStorm.
 * User: Thuong
 * Date: 5/7/14
 * Time: 11:31 AM
 */

defined('JPATH_BASE') or die;
include_once (JPATH_BASE) . '/components/com_tz_multipurpose/libraries/core/defines.php';
include_once (JPATH_BASE) . '/components/com_tz_multipurpose/libraries/core/tzmultipurpose.php';

if (!version_compare(JVERSION,'3.0','ge')) {
    JHtml::addIncludePath(JPATH_ADMINISTRATOR.'/components/com_tz_multipurpose/libraries/cms/html');
}
jimport('joomla.form.formfield');
jimport('joomla.html.editor');

JHtml::_('behavior.formvalidation');
JHtml::_('behavior.tooltip');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.framework');
JHtml::_('behavior.modal', 'a.modal');
JHtml::_('bootstrap.tooltip');
class JFormFieldSelectfilegroup extends JFormField {

    protected $type = 'Selectfilegroup';

    // getLabel() left out

    public function getField($field) {
        $db		= JFactory::getDbo();
        $query	= $db->getQuery(true);
        $query -> select('*');
        $query -> from('#__tz_multipurpose_fields');
        $query -> where('id = '.$field);
        $db -> setQuery($query);
        $items = $db -> loadObjectList();

        return $items;
    }
    public function selected($id_f) {
        $selected = '';
        $value = $this -> value;
        if(isset($value)) {
            $arr_value = explode(',',$value);
            foreach ($arr_value as $fid => $value_fid) {
                if($id_f == $value_fid) {
                    $selected = 'selected="selected"';
                }
            }
        }
        return$selected;
    }

    public function getInput() {

        $name = (string)($this -> element['name']);
        $doc = JFactory::getDocument();
        if (!version_compare(JVERSION,'3.0','ge')) {
            $doc->addScript(JUri::root(true) . '/modules/mod_tz_multipurpose/admin/js/jquery-1.9.1.min.js');
            $doc->addScript(JUri::root(true) . '/modules/mod_tz_multipurpose/admin/js/jquery-noconflict.js');
        }
        $doc->addScript(JUri::root(true) . '/modules/mod_tz_multipurpose/admin/js/base64.js');
        $doc->addScript(JUri::root(true) . '/modules/mod_tz_multipurpose/admin/js/jquery-ui-min.js');
        $doc->addScript(JUri::root(true) . '/modules/mod_tz_multipurpose/admin/js/tzmultipurpose.js');
        $doc->addStyleSheet(JUri::root(true) . '/modules/mod_tz_multipurpose/admin/css/style.css');
        $db = JFactory::getDbo();
        $query  = $db -> getQuery(true);
        $query -> select('g.name, f.id, f.title');
        $query -> from('#__tz_multipurpose_fields AS f');
        $query -> join('INNER','#__tz_multipurpose_groupfield AS gf ON f.id=gf.fieldsid');
        $query -> join('INNER','#__tz_multipurpose_groups AS g ON g.id=gf.groupid');
        $db->setQuery($query);
        $items = $db -> loadObjectList();
        $html  = '';
        $html .= '<select multiple="" name="jform[params]['.$name.']" id="jform_params_'.$name.'" style="display: none;" class="chzn-done">';
        $html .= '<optgroup label="---Group Field---" id="jform_params_selectfilegroup__">';

        foreach($items as $key => $value_gf){
            $id_f   = $value_gf -> id;
            $name_g = $value_gf -> name;
            $name_f = $value_gf -> title;
            $select =   $this -> selected($id_f);
            $html .= '<option '.$select.' value="'.$id_f.'">'.$name_g.'_'.$name_f.'</option>';
        }

        $html .= '</optgroup>
                </select>';
        $html .= '<input type="hidden" value="" id="'.$name.'_hidden" name="'.$this->name.'"/>';
        return $html;
    }
}