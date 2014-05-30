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

defined('_JEXEC') or die();
jimport('joomla.application.component.modellist');

class TZ_MultipurposeModelFields extends JModelList{
    public function __construct($config = array()){
        parent::__construct($config);
    }

    public function populateState($ordering = null, $direction = null){

        parent::populateState('id','desc');

        $app        = JFactory::getApplication();
        $context    = 'com_tz_multipurpose.fields';

        $state  = $app -> getUserStateFromRequest($context.'filter_state','filter_state',null,'string');
        $this -> setState('filter_state',$state);
        $search  = $app -> getUserStateFromRequest($context.'.filter_search','filter_search',null,'string');
        $this -> setState('filter_search',$search);
        $order  = $app -> getUserStateFromRequest($context.'.filter_order','filter_order','name','string');
        $this -> setState('filter_order',$order);
        $orderDir  = $app -> getUserStateFromRequest($context.'.filter_order_Dir','filter_order_Dir','asc','string');
        $this -> setState('filter_order_Dir',$orderDir);
    }

    protected function getListQuery(){
        $db     = $this -> getDbo();
        $query  = $db -> getQuery(true);
        $query -> select('f.*');
        $query -> from('#__tz_multipurpose_fields AS f');
        $query -> join('LEFT','#__tz_multipurpose_groupfield AS x ON f.id=x.fieldsid');
        $query -> join('INNER','#__tz_multipurpose_groups AS fg ON fg.id=x.groupid');

        if($search = $this -> getState('filter_search'))
            $query -> where('title LIKE '.$db -> quote('%'.$search.'%'));

        switch ($this -> getState('filter_state')){
            default:
                $query -> where('published>=0');
                break;
            case 'P':
                $query -> where('published=1');
                break;
            case 'U':
                $query -> where('published=0');
                break;
        }

        if($filter_group = $this -> getState('filter_group')){
            if($filter_group!=-1){
                $query -> where('x.groupid ='.$filter_group);
            }
        }

        if($filter_type = $this -> getState('filter_type')){
            $query -> where('f.type='.$db -> quote($filter_type));
        }

        $query -> group('f.id');

        if($order = $this -> getState('filter_order','f.id')){
            $query -> order($order.' '.$this -> getState('filter_order_Dir','DESC'));
        }
        return $query;
    }

    public function getItems(){
        if($items = parent::getItems()){
            $groupModel = JModelLegacy::getInstance('Groups','TZ_MultipurposeModel');
            if($groups = $groupModel -> getItemsContainFields()){
                foreach($items as $item){
                    if(isset($groups[$item -> id])){
                        $item -> groupname  = $groups[$item -> id];
                    }
                }
            }
            return $items;
        }
    }

    // Get fields group with type array[key=groupid] = groupname
    public function getItemsArray(){
        $db     = $this -> getDbo();
        $db -> setQuery($this -> getListQuery());

        if($items = $db -> loadObjectList()){
            foreach($items as $item){
                $list[$item -> id]  = $item -> name;
            }
            return $list;
        }
        return array();
    }

    public function renderImg($src,$width = null,$height = null,$crop = null,$title = null,$alt = null,$attribute = null){
        $_width     = null;
        $_height    = null;
        $_crop      = null;
        if($width)
            $_width  = '&width='.$width;
        if($height)
            $_height = '&height='.$height;
        if($crop)
            $_crop = '&cropratio='.$crop;
        if($title)
            $title  = ' title="'.$title.'"';
        if($alt)
            $alt    = ' alt="'.$alt.'"';

        if($width || $height){
            $src    = JURI::root().'components/com_tz_multipurpose/image.php?image='.$src.$_width.$_height.$_crop;
        }

        $html   = '<img src="'.$src.'"'.$title.$alt.$attribute.'>';

        return $html;
    }

    public function renderDropDown($name,$rows,$selected=null,$id_field,$type,$id=null,$multiple=null,$size=null,$javascript=null,$prefix='@[{(&*_'){
        $multiple   = ($multiple)?' multiple = "multiple"':'';
        $size       = ($size)?$size:'1';
        $id     = ($id)?' id = "'.$id.'"':'';
        $html   = '<label>'.$name.'</label>';
        $html  .= '<select class="tz_multi_field tz_multiselect" '.$multiple.' field-type="'.$type.'" name="'.$id_field.'" id="tz_multi_'.$id_field.'" field-name="'.$name.'" >';
        $str    = '';
        if(count($rows)){
            foreach($rows as $row){
                if($multiple){
                    if($selected){
                        if(count($selected)>0){
                            foreach($selected as $item){
                                if(isset($item -> fieldsid) && (($item -> fieldsid) == ($row -> fieldsid)) && (($item -> value)==($row -> name))){
                                    $_selected   = ' selected="selected"';
                                    break;
                                }
                                else
                                    $_selected  = '';
                            }
                        }
                    }
                    else
                        $_selected   = '';
                }
                else{
                    if($selected){
                        if(isset($row -> fieldsid) && isset($selected[0] -> fieldsid) && ($row -> name == $selected[0] -> value) && ($row -> fieldsid == $selected[0] -> fieldsid))
                            $_selected  = ' selected="selected"';
                        else
                            $_selected  = '';
                    }
                    else
                        $_selected  = '';
                }
                $str .= '<option class="tz_multiselect"  value="'.$row -> name.'" data-id="'.$row -> value.'"'
                    .($_selected).'>'
                    .$row -> name.'</option>';
            }
        }
        $html   .= $str
            .'</select>';
        return $html;
    }

    public function renderRadio($name,$rows,$checked=null,$id_field,$type,$id=null,$javascript=null
        ,$image=false,$imageWidth=null,$imageHeight = null,$imageCrop = null,$prefix='@[{(&*_'){
        $html   = '<label>'.$name.'</label>';
        $html  .= '<div class="tz_multi_field radio" field-type="'.$type.'" name="'.$id_field.'" id="tz_multi_'.$id_field.'" field-name="'.$name.'">';
        $str    = '';
        $id     = ($id)?' id="'.$id.'"':'';
        if(count($rows)>0){
            foreach($rows as $row){
                if(!empty($row -> name) or !empty($row -> value)){}
                if($checked){
                    if(count($checked)>0){
                        foreach($checked as $item){
                            if(isset($item -> fieldsid) && ($item -> fieldsid == ($row -> fieldsid)) && (($item -> value) == ($row -> name))){
                                $_checked   = ' checked="checked"';
                                break;
                            }
                            else
                                $_checked   = '';
                        }
                    }
                }
                else
                    $_checked   = '';
                if($image != false){
                    if(isset($row -> image) && !empty($row -> image)){
                        $str    .= ArticleHTML::renderImg(JURI::root().$row -> image,$imageWidth,$imageHeight,$imageCrop);
                    }
                }
                $str      .= '<label>'.$row -> name.'</label>';
                $str      .='<input class="radio" type="radio" name="'.$name.'"'
                    .' value="'.$row -> name.'" data-id="'.$row -> value.'" /><br />';
            }
        }
        $html   .= $str.'</div>';

        return $html;
    }

    public function renderCheckBox($name,$rows,$id=null,$checked=null,$id_field,$type,$javascript=null
        ,$image=false,$imageWidth=null,$imageHeight = null,$imageCrop = null,$prefix='@[{(&*_'){
        $html   = '<label>'.$name.'</label>';
        $html  .= '<div class="tz_multi_field checkbox" field-type="'.$type.'" name="'.$id_field.'" id="tz_multi_'.$id_field.'" field-name="'.$name.'">';
        $str    = '';
        $id     = ($id)?' id="'.$id.'"':'';
        if(count($rows)>0){
            foreach($rows as $row){
                if($checked){
                    if(count($checked)>0){
                        foreach($checked as $item){
                            if(isset($item -> fieldsid) && ($item -> fieldsid) == ($row -> fieldsid) && ($item -> value) == ($row -> name)){
                                $_checked   = ' checked="checked"';
                                break;
                            }
                            else
                                $_checked   = '';
                        }
                    }
                }
                else
                    $_checked   = '';
                if($image != false){
                    if(isset($row -> image) && !empty($row -> image)){
                        $str    .= $this -> renderImg(JURI::root().$row -> image,$imageWidth,$imageHeight,$imageCrop);
                    }
                }
                $str      .= '<label>'.$row -> name.'</label>';
                $str      .= '<input class="checkbox" type="checkbox" name="'.$name.'"'
                    .' value="'.$row -> name.'" data-id="'.$row -> value.'" /><br />';
            }
        }
        $html   .= $str.'</div>';

        return $html;
    }

    public function renderLink($name,$text=null,$url=null,$target=null,$id_field){
        $target = ($target)?$target:'_self';
        $url    = (isset($url) && $url!=null)?$url:'';

        $html   = '<div class="link">';
        $html  .= '<label>'.JText::_('COM_TZ_MULTIPURPOSE_TEXT').'</label>'
            .'<input id="tz_multi_'.$id_field.'_text" type="text" name="'.$id_field.'_text" class="tz_multi_field"
                    value="'.$text.'" field-name="Text Link" >';
        $html  .= '<label>'.JText::_('COM_TZ_MULTIPURPOSE_URL').'</label>'
            .'<input id="tz_multi_'.$id_field.'_link" type="text" name="'.$id_field.'_link" class="tz_multi_field"
                    value="'.$url.'" field-name="Url">';
        $html  .= '<label>'.JText::_('COM_TZ_MULTIPURPOSE_OPEN_IN').'</label>'
            .'<select id="tz_multi_'.$id_field.'_open" class="tz_multi_field" name="'.$id_field.'_open" field-name="Open in">'
            .'<option value="Same Window" '.(($target=='_self')?' selected="selected"':'').'>'
            .JText::_('COM_TZ_MULTIPURPOSE_SAME_WINDOW')
            .'</option>'
            .'<option value="New Window" '.(($target=='_blank')?' selected="selected"':'').'>'
            .JText::_('COM_TZ_MULTIPURPOSE_NEW_WINDOW')
            .'</option>'
            .'</select>';
        $html   .= '</div>';

        return $html;
    }

    public function image($getname,$id_field,$type,$iframe,$param) {

        foreach($param as $key => $value){
            $value_img = $value -> image;
        }
        $html ='<label>'.$getname.'</label>';
        $html .='
            <div class="controls">
                <div class="fltlft">
                    <input type="text" readonly="readonly" value="'.$value_img.'" id="tz_multi_'.$id_field.'"
                    name="'.$id_field.'" field-name="'.$getname.'" field-type="'.$type.'" class="tz_multi_field" aria-invalid="false"></div>
                <div class="button2-left">
                    <div class="blank">
                        <a rel="{handler: '.$iframe.', size: {x: 800, y: 500}}"
                         href="index.php?option=com_media&amp;view=images&amp;tmpl=component&amp;asset=com_modules&amp;author=&amp;fieldid=tz_multi_'.$id_field.'&amp;folder=" title="Select" class="modal btn">
                    Select</a>
                    </div>
                </div>
            </div>';
        return $html;
    }

    function checktype($type,$getname,$id_field,$value,$name,$param,$fieldEdits) {
        $html = '';
        $iframe = "'iframe'";
        switch ($type){
            case 'textfield':
                $html = $html.'<label>'.$getname.'</label>';
                $html = $html.'<input type="text" field-type="'.$type.'" field-name="'.$getname.'" name="'.$id_field.'" value="'.$value.'" id="tz_multi_'.$id_field.'" class="tz_multi_field">';
                break;
            case 'textarea':
                $html = $html.'<label>'.$getname.'</label>';
                $html = $html.'<textarea field-type="'.$type.'" field-name="'.$getname.'" name="'.$id_field.'" value="'.$value.'" id="tz_multi_'.$id_field.'" class="tz_multi_field">'.$value.'</textarea>';
                break;
            case 'select':
                $html .= $this -> renderDropDown($name,$param,$fieldEdits,$id_field,$type);
                break;
            case 'multipleSelect':
                $html .= $this -> renderDropDown($name,$param,$fieldEdits,$id_field,$type,'','true');
                break;
            case 'radio':
                $html .= $this -> renderRadio($name,$param,$fieldEdits,$id_field,$type);
                break;
            case 'checkbox':
                $html .= $this -> renderCheckBox($name,$param,'',$fieldEdits,$id_field,$type);
                break;
            case 'link':
                $url    = null;
                $target = null;

                if($fieldEdits){
                    $linkValue  = htmlspecialchars_decode($fieldEdits[0]->value);
                    $text = $linkValue;
                    $url  = $param[0] -> value;
                    if(preg_match('/>.*</i',$linkValue,$a))
                        if(isset($a[0])) {
                            $text   = $a[0];
                            $text   = str_replace('>','',$text);
                            $text   = str_replace('<','',$text);
                        }
                }
                else{
                    $text   = $param[0] -> name;
                    $target = $param[0] -> target;
                    $url    = str_replace('http://','',$param[0] -> value);
                }
                $html   .= $this -> renderLink($name,$text,$url,$target,$id_field);
                $html   .= '<input type="hidden" name="tz_link_hidden[]" value="'.$id_field.'">';
                break;
            case 'file':
            case 'date':
            case 'image':

                $html   .= $this -> image($getname,$id_field,$type,$iframe,$param);

//                $html = $html.'<label>'.$getname.'</label>';
//                $html = $html.'
//                        <div class="controls">
//                            <div class="fltlft">
//	                            <input type="text" readonly="readonly" value="" id="tz_multi_'.$id_field.'"
//	                            name="'.$id_field.'" field-name="'.$getname.'" field-type="'.$type.'" class="tz_multi_field" aria-invalid="false"></div>
//                            <div class="button2-left">
//	                            <div class="blank">
//		                            <a rel="{handler: '.$iframe.', size: {x: 800, y: 500}}"
//		                             href="index.php?option=com_media&amp;view=images&amp;tmpl=component&amp;asset=com_modules&amp;author=&amp;fieldid=tz_multi_'.$id_field.'&amp;folder=" title="Select" class="modal">
//                                Select</a>
//	                            </div>
//                            </div>
//                        </div>';
                break;
            default:
                $html = $html.'';
                break;
        }
        return $html;
    }

    public function getFields($name) {
        $db     = $this -> getDbo();
        $query  = $db -> getQuery(true);
        $query -> select('f.*');
        $query -> from('#__tz_multipurpose_fields AS f');
        $query -> join('LEFT','#__tz_multipurpose_groupfield AS x ON f.id=x.fieldsid');
        $query -> join('INNER','#__tz_multipurpose_groups AS fg ON fg.id=x.groupid');
        $query -> where('fg.id = '.$name);
        $query->order('f.ordering ASC');
        $db -> setQuery($query);
        $items = $db -> loadObjectList();
        $list = array();
        $html = '';
        foreach($items as $key=>$item){
            $id_field       = $item -> id;
            $type           = $item -> type;
            $getname        = $item -> title;
            $field_value    = $item -> value;
            $param  = str_replace('[','',$item -> value);
            $param  = str_replace(']','',$param);
            $param  = str_replace('},{','}/////{',$param);
            $param  = explode('/////',$param);
//            var_dump($param);        //=> array: value
            $j = 0;
            $_fieldEdits = null;
            for($i=0;$i<count($param);$i++){
                $param[$i]  = json_decode($param[$i]);
                $param[$i] -> fieldsid  = $item -> id;
                $_fieldEdits[$j] = new stdClass();
                $_fieldEdits[$j] -> value = $param[$i] -> name;
                $j++;
            }
            if(isset($_fieldEdits)){
                $fieldEdits = $_fieldEdits;
            }
            $value  = null;
            if($fieldEdits) {
                foreach($fieldEdits as $item){
                    if(($type == 'textfield') || ($type == 'textarea')){
                        $value  = $item -> value;
                    }
                }
            }
            $name           = str_replace(" ","",$getname);
            $html .= $this->checktype($type,$getname,$id_field,$value,$name,$param,$fieldEdits);
        }
        return $html;
    }

    public function getField($field_id) {
        $db         = $this -> getDbo();
        $query      = $db   -> getQuery(true);
        $query      -> select('*');
        $query      ->from('#__tz_multipurpose_fields');
        $query      -> where('id='.$field_id);
        $db -> setQuery($query);
        $items = $db -> loadObjectList();
        return $items;
    }

    public function saveModuleField() {
        $i = 0;
        $count_item = 0;
        if($_REQUEST['count_item']) {
            $count_item = $_REQUEST['count_item'];
        }
//        var_dump($count_item);
        $param = '{"'.$count_item.'":{';
        if( $_REQUEST["name"] ) {
            $name       = $_REQUEST['name'];
            $count_field = count($name);
            foreach($name as $key => $item) {
                $i ++;
                $field_id       = $item[name]; /// get id field;
                $field_vualue   = $item[value];
                $items = $this -> getField($field_id);

                $title = $items[0]->title;
                $type  = $items[0]->type;
                $param = $param.'"'.$title.'":{"Type":"'.$type.'","value":"'.$field_vualue.'"}';
                if($i <= ($count_field-1)){
                    $param .= ',';
                }else {
                    $param .='}}';
                }
            }
            return $param;
        }

    }
}