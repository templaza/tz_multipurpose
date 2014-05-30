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

defined('JPATH_BASE') or die;

jimport('joomla.form.formfield');
jimport('joomla.html.editor');

JHtml::_('behavior.formvalidation');
JHtml::_('behavior.tooltip');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.framework');
JHtml::_('behavior.modal', 'a.modal');
JHtml::_('bootstrap.tooltip');
class JFormFieldTzMultipurpose extends JFormField {

    protected $type = 'TzMultipurpose';

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

    public function getInput() {
        $doc = JFactory::getDocument();
        if (!version_compare(JVERSION,'3.0','ge')) {
            $doc->addScript(JUri::root(true) . '/modules/mod_tz_multipurpose/admin/js/jquery-1.9.1.min.js');
            $doc->addScript(JUri::root(true) . '/modules/mod_tz_multipurpose/admin/js/jquery-noconflict.js');
        }
        $doc->addScript(JUri::root(true) . '/modules/mod_tz_multipurpose/admin/js/jquery-ui-min.js');
        $doc->addScript(JUri::root(true) . '/modules/mod_tz_multipurpose/admin/js/tzmultipurpose.js');
        $doc->addStyleSheet(JUri::root(true) . '/modules/mod_tz_multipurpose/admin/css/style.css');
        $db = JFactory::getDbo();
        $query  = $db -> getQuery(true);
        $query -> select('*');
        $query -> from('#__tz_multipurpose_groups');
        $db->setQuery($query);
        $items = $db -> loadObjectList();

        $value_item = 0;
        $html = '';
        $html .= '<a class="btn_add">'.JText::_('TZ_MULTIPURPOSE_ADD_NEW').'</a>';
//        $html .= '<a class="btn_data">'.JText::_('TZ_MULTIPURPOSE_ADD_NEW').'</a>';

        $html .= '<label id="select-lbl" name="tz_select_group">'.JText::_('MOD_TZ_MULTIPURPOSE_SELECT_GROUP_LABEL').'</label>';
        $html .= '<select id="tz_select_group" name="tz_select_group">';
//        $html .= '<option value="">Select Group Fields</option>';
//        foreach($items as $item) {
//            $html .= '<option value="'.$item -> id.'" >'.$item -> name.'</option>';
//        }
        $html .= '</select>';

        /// code get html field
        $html = $html.' <div class="control-group fields">';
        $html = $html.'<div id="tz-form-multipurpose" class="tz_form_multi"></div>';
        $html = $html.'</div>';


        ////// save html
        $html = $html.' <div class="control-group save">';
        $html = $html.'<button class="btn btn-success" type="button" id="' . $this->prefix . 'button_save">' . JText::_('JAPPLY') . '</button>';
        $html = $html.'<button class="btn" type="button" id="' . $this->prefix . 'button_cancel">' . JText::_('MOD_TZ_MULTIPURPOSE_RESET') . '</button>';
        $html = $html.' </div>';

//        $html = $html.'<div id="tz-table-multipurpose" class="tz_table_multi"></div>';
        $html = $html.'<div id="tz-table-multi" class="tz_table_multi">';
        $value  = $this -> value;
        if($value) {
            foreach($value as $key => $item) {
                $html .='<div class="tz_multipurpose_item">';
                $arr        = (array)$item;
                $group_id   = $arr['group'];
                $html .= '<div class="move tz_group_id">Move</div>';
                $html .= '<div class="edit tz_group_id" name="" value="'.$group_id.'">Edit</div>';
                $html .= '<input class="tz_group_id" type="hidden" name="" value="'.$group_id.'">';
                $html .= '<div class="delete tz_group_id" name="" value="'.$group_id.'">Delete</div>';
                foreach($arr as $n => $value_field) {
                    $html .='<div class="tz_item_child">';
                        if($n != 'group'){
                            if(is_numeric($n)) {
                                $field = $this -> getField($n);
                                foreach($field as $key => $value) {
                                    $html .='<div class="tz_field_name" data-id="'.$n.'">'.$value->title.'</div>';
                                    $html .='<div class="tz_field_value">'.$value_field;
                                    $html .='<input class="tz_fieldvalue data-id'.$n.'" type="hidden" value="'.$value_field.'" data-id="'.$n.'">';
                                    $html .='</div>';
                                }
                            }else {
                                $id_field_link = (int)$n;
                                $field = $this -> getField($id_field_link);
                                foreach($field as $key => $value) {
                                    $html .='<div class="tz_field_name" data-id="'.$n.'">'.$value->title.'</div>';
                                    $html .='<div class="tz_field_value">'.$value_field;
                                    $html .='<input class="tz_fieldvalue data-id'.$n.'" type="hidden" value="'.$value_field.'" data-id="'.$n.'">';
                                    $html .='</div>';
                                }
                            }
                        }
                    $html .='</div>';
                }
                $html .='</div>';
            }
        }
        $html = $html.'</div>';
        $html = $html.'<input type="hidden" id="tz_multi_hidden" name="'.$this->name.'"/>';
        return $html;
    }
}