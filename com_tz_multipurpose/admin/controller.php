<?php
/**
 * Created by PhpStorm.
 * User: Thuong
 * Date: 4/25/14
 * Time: 3:41 PM
 */

defined('_JEXEC') or die;

jimport('joomla.application.component.controller');
if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);
require (JPATH_ADMINISTRATOR.DS.'components'.DS.'com_tz_multipurpose'.DS.'helpers'.DS.'tz_multipurpose.php');
//define ('COM_TZ_MULTIPURPOSE_JVERSION_COMPARE', version_compare(JVERSION,'3.0','ge'));
//define ('COM_TZ_MULTIPURPOSE_ADMIN_HOST_PATH', JURI::base(true).'/components/com_tz_multipurpose');

class TZ_MultipurposeController extends JControllerLegacy {

    protected $default_view = 'groups';

    public function __construct($config = array())
    {
        $this -> input  = JFactory::getApplication() -> input;
        parent::__construct($config);

        // Guess the JText message prefix. Defaults to the option.
        if (empty($this->extension)) {
            $this->extension = JRequest::getCmd('extension', 'com_content');
        }

        // If the joomla's version is more than or equal to 3.0
        $doc    = JFactory::getDocument();
        $doc -> addStyleSheet(COM_TZ_MULTIPURPOSE_ADMIN_HOST_PATH.'/jui/css/styles.css');
        if(!COM_TZ_MULTIPURPOSE_JVERSION_COMPARE){

            JHtml::addIncludePath(JPATH_ADMINISTRATOR.'/components/com_tz_multipurpose/libraries/cms/html');
            tzMULTIPURPOSEimport('cms/html/sidebar');


            $doc -> addScript(COM_TZ_MULTIPURPOSE_ADMIN_HOST_PATH.'/jui/js/jquery.min.js');
            $doc -> addScript(COM_TZ_MULTIPURPOSE_ADMIN_HOST_PATH.'/jui/js/jquery-noconflict.js');
            $doc -> addScript(COM_TZ_MULTIPURPOSE_ADMIN_HOST_PATH.'/jui/js/bootstrap.min.js');
            $doc -> addScript(COM_TZ_MULTIPURPOSE_ADMIN_HOST_PATH.'/jui/js/chosen.jquery.min.js');
            $doc -> addScript(COM_TZ_MULTIPURPOSE_ADMIN_HOST_PATH.'/jui/js/jquery.ui.core.min.js');
            $doc -> addScript(COM_TZ_MULTIPURPOSE_ADMIN_HOST_PATH.'/jui/js/jquery.ui.sortable.min.js');
            $doc -> addScript(COM_TZ_MULTIPURPOSE_ADMIN_HOST_PATH.'/jui/js/sortablelist.js');
            $doc -> addScript(COM_TZ_MULTIPURPOSE_ADMIN_HOST_PATH.'/js/template.js');

            $doc -> addStyleSheet(COM_TZ_MULTIPURPOSE_ADMIN_HOST_PATH.'/jui/css/chosen.css');

        }
    }

    public function display($cachable = false, $urlparams = false)
    {

        // Get the document object.
        $document = JFactory::getDocument();

        // Set the default view name and format from the Request.
        $vName		= $this -> input -> get('view', 'groups');
        $vFormat	= $document->getType();
        $lName		= $this -> input -> get('layout', 'default');
        $id			= $this -> input -> getInt('id');

        // Get and render the view.
        if ($view = $this->getView($vName, $vFormat)) {
            // Get the model for the view.
            $model = $this->getModel($vName, 'TZ_MultipurposeModel', array('name' => $vName . '.' . substr($this->extension, 4)));

            // Push the model into the view (as default).
            $view->setModel($model, true);
            //            if(JRequest::getCmd('task')=='listsfields'){
            //                $this ->
            //            }

            $view->setLayout($lName);

            // Push document object into the view.
            $view->assignRef('document', $document);
            // Load the submenu.

            //CategoriesHelper::addSubmenu($model->getState('filter.extension'));
            $view->display();
        }

        return $this;
    }
}