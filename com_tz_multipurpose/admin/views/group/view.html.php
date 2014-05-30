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

jimport('joomla.application.components.view');



class TZ_MultipurposeViewgroup extends JViewLegacy
{
    protected $item = null;

    function display($tpl = null){
        $this -> item   = $this -> get('Item');

        $editor = JFactory::getEditor();
        $this -> assign('editor',$editor);
        $this -> addToolbar();
        parent::display($tpl);
    }

    protected function addToolbar(){
        JRequest::setVar('hidemainmenu',true);

        $bar    = JToolBar::getInstance();
        $doc    = JFactory::getDocument();

        $isNew  = ($this -> item -> id == 0);

        JToolBarHelper::title(JText::sprintf('COM_TZ_MULTIPURPOSE_GROUPS_MANAGER','<small><small>'
            .JText::_(($isNew)?'COM_MULTIPURPOSE_PAGE_ADD_GROUP':'COM_MULTIPURPOSE_PAGE_EDIT_GROUP')
            .'</small></small>'));
        JToolBarHelper::apply('group.apply');
        JToolBarHelper::save('group.save');
        JToolBarHelper::save2new('group.save2new');
        JToolBarHelper::cancel('group.cancel',JText::_('JTOOLBAR_CLOSE'));

        JToolBarHelper::divider();

    }
}
