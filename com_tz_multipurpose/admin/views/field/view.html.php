<?php
/**
 * Created by PhpStorm.
 * User: Thuong
 * Date: 4/28/14
 * Time: 10:00 AM
 */


defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.components.view');



class TZ_MultipurposeViewField extends JViewLegacy
{
    protected $item     = null;
    protected $groups   = null;

    function display($tpl = null){
        $this -> item   = $this -> get('Item');
        $groupModel = JModelLegacy::getInstance('Groups','TZ_MultipurposeModel',array('ignore_request' => true));
        $groupModel -> setState('filter_order','name');
        $groupModel -> setState('filter_order_Dir','ASC');
        $this -> groups = $groupModel -> getItems();

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

        JToolBarHelper::title(JText::sprintf('COM_TZ_MULTIPURPOSE_FIELDS_MANAGER','<small><small>'
            .JText::_(($isNew)?'COM_MULTIPURPOSE_PAGE_ADD_GROUP':'COM_MULTIPURPOSE_PAGE_EDIT_GROUP')
            .'</small></small>'));
        JToolBarHelper::apply('field.apply');
        JToolBarHelper::save('field.save');
        JToolBarHelper::save2new('field.save2new');
        JToolBarHelper::cancel('field.cancel',JText::_('JTOOLBAR_CLOSE'));

        JToolBarHelper::divider();

    }
}
