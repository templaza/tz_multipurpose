<?php
/*------------------------------------------------------------------------

# TZ MULTIPURPOSE Extension

# ------------------------------------------------------------------------

# author    DuongTVTemPlaza

# copyright Copyright (C) 2012 templaza.com. All Rights Reserved.

# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL

# Websites: http://www.templaza.com

# Technical Support:  Forum - http://templaza.com/Forum

-------------------------------------------------------------------------*/

// No direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');
JHtml::addIncludePath(JPATH_ADMINISTRATOR.'/components/com_tz_multipurpose/helpers');

class TZ_MultipurposeViewFields extends JViewLegacy
{
    protected $items        = null;
    protected $state        = null;
    protected $pagination   = null;
    protected $sidebar      = null;

    public function display($tpl = null){

        $this -> items      = $this -> get('Items');
        $this -> state      = $this -> get('State');
        $this -> pagination = $this -> get('Pagination');

        $this -> addToolbar();

        TZ_Multipurpose::addSubmenu('fields');
        $this->sidebar = JHtmlSidebar::render();

        parent::display($tpl);
    }

    protected function addToolbar(){
        $doc    = JFactory::getDocument();
        $bar    = JToolBar::getInstance();

        JToolBarHelper::title(JText::_('COM_TZ_MULTIPURPOSE_FIELDS_MANAGER'));
        JToolBarHelper::addNew('field.add');
        JToolBarHelper::editList('field.edit');
        JToolBarHelper::divider();
        JToolBarHelper::publish('fields.publish');
        JToolBarHelper::unpublish('fields.unpublish');
        JToolBarHelper::deleteList(JText::_('COM_TZ_MULTIPURPOSE_QUESTION_DELETE'),'fields.delete');

        $fieldsType = array('textfield' => JText::_('COM_TZ_MULTIPURPOSE_TEXT_FIELD'),
            'textarea' => JText::_('COM_TZ_MULTIPURPOSE_TEXTAREA'),
            'select' => JText::_('COM_TZ_MULTIPURPOSE_DROP_DOWN_SELECTION'),
            'multipleSelect' => JText::_('COM_TZ_MULTIPURPOSE_MULTI_SELECT_LIST'),
            'radio' => JText::_('COM_TZ_MULTIPURPOSE_RADIO_BUTTONS'),
            'checkbox' => JText::_('COM_TZ_MULTIPURPOSE_CHECK_BOX'),
            'link' => JText::_('COM_TZ_MULTIPURPOSE_LINK'));

        $groupModel = JModelLegacy::getInstance('Groups','TZ_MultipurposeModel');

        $state = array( 'P' => JText::_('JPUBLISHED'), 'U' => JText::_('JUNPUBLISHED'));

    }


    protected function getSortFields()
    {
        return array('f.ordering' => JText::_('JGRID_HEADING_ORDERING'),
            'a.state' => JText::_('JSTATUS'),
            'f.title' => JText::_('COM_TZ_MULTIPURPOSE_HEADING_TITLE'),
            'x.groupid' => JText::_('COM_TZ_MULTIPURPOSE_HEADING_GROUP'),
            'f.type' => JText::_('COM_TZ_MULTIPURPOSE_HEADING_TYPE'),
            'f.published' => JText::_('JSTATUS'),
            'f.id' => JText::_('JGRID_HEADING_ID'));
    }
}