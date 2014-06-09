<?php
/**
 * Created by PhpStorm.
 * User: Thuong
 * Date: 5/7/14
 * Time: 10:49 AM
 */

defined('_JEXEC') or die();
if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);
$document = JFactory::getDocument();
require_once (JPATH_SITE.DS.'modules'.DS.'mod_tz_multipurpose'.DS.'helper.php');
$document->addStyleSheet('modules/mod_tz_multipurpose/css/service.css');
$show_link      = $params -> get('show_link_sv',0);
$font_as        = $params -> get('fontas_sv',0);
$responsive = $params->get('add_css_rps_sv',0);
if($responsive) {
    $document->addStyleSheet('modules/mod_tz_multipurpose/css/tz_style.css');
}
if($font_as == 1) {
    $document->addStyleSheet('modules/mod_tz_multipurpose/css/font-awesome.min.css');
}
$col    = $params -> get('column_sv',4);
$col_table  = $params -> get('column_sv_table',4);
$col_mobile = $params -> get('column_sv_mobile',12);

// select field logo, title, desc
$link_img         = $params->get('link_img_sv', '');

$field_logo       = $params -> get('sv_logo','');
$field_title      = $params -> get('sv_title','');
$field_dsc        = $params -> get('sv_desc','');
$field_font       = $params -> get('sv_fontas','');
$field_logo_arr   = explode(',',$field_logo);
$field_title_arr  = explode(',',$field_title);
$field_dsc_arr    = explode(',',$field_dsc);
$field_font_arr   = explode(',',$field_font);

$m      = 1;
$count_list     = count($list);
$col_display    = floor(12/$col);
$check_bt  = 0;
if($m == $col_display) {
    $check_bt  = 1;
}
?>

<div class="TzMultipurpose service tz-container-fluid <?php echo $moduleclass_sfx; ?>">
    <?php
    foreach($list as $key => $arr) {
        if($m%$col_display == 1 || $check_bt  == 1) {
            echo '<div class="tz-row">';
        }
        echo '<div class="tz_multi_item tz-col-sm-'.$col_table.' tz-col-xs-'.$col_mobile.' tz-col-md-'.$col.'">';
        $id_group       = $arr -> group;
        $list_field_id  = modTZMultipurposeHelper::getFieldGroup($id_group,'');
        $j = 0;
        foreach($list_field_id as $f => $v_id_f){
            $i = 0;
            foreach($arr as $n => $value){
                $a  = (int)$n;
                if($n != 'group' && $a == $v_id_f){
                    if(is_numeric($a)) {
                        if($value != "") {
                            $field = modTZMultipurposeHelper::getField($a);
                            $value_field = $field -> value;
                            $type_field = $field -> type;
                            $id_field   = $field -> id;
                            // type Image
                            if($type_field == 'image' && $font_as == 0){
                                echo '<div class="tz_image '.$field->title.'">';
                                if($show_link == 1 && $link_img != '') {
                                    $link_option = modTZMultipurposeHelper::getlink($arr,$link_img);
                                    $j++;
                                    if($j==1){
                                        echo '<a '.$link_option -> link_o.' href="'.$link_option -> link.'"><img src="'.$value.'" alt="'.$field->title.'" /></a>';
                                    }
                                }else {
                                    echo '<img src="'.$value.'" alt="'.$field->title.'" />';
                                }
                                echo '</div>';
                            }

                            // type radio, checkbox, multipleSelect, select
                            if($type_field == 'radio' || $type_field == 'checkbox' || $type_field == 'multipleSelect' || $type_field == 'select'){
                                $get_value_f = modTZMultipurposeHelper::getFieldValue($value_field,$value,$option_stm);
                                if(isset($get_value_f)){
                                    echo $get_value_f;
                                }
                            }

                            // type textarea, textfield

                            if($type_field == 'textarea' || $type_field == 'textfield'){
                                if($font_as == 1 && in_array($id_field,$field_font_arr)) {
                                    if($show_link == 1 && $link_img != '') {
                                        $link_option = modTZMultipurposeHelper::getlink($arr,$link_img);
                                        $j++;
                                        if($j==1){
                                            echo '<a '.$link_option -> link_o.' href="'.$link_option -> link.'"><i class="'.$value.'"></i></a>';
                                        }
                                    }else {
                                        echo '<i class="'.$value.'"></i>';
                                    }
                                }
                                if(in_array($id_field,$field_dsc_arr)) {
                                    $class_desc = 'tz_multi_desc';
                                    echo '<p class="'.$class_desc.' tz_multi">'.$value.'</p>';
                                }else {
                                    $class_desc = '';
                                }
//                                $link_option = modTZMultipurposeHelper::getlink($arr,$a);
                            }

                            // type link
                            if($type_field == 'link') {
                                $i++;
                                if($i == 1 && in_array($id_field,$field_title_arr)) {
                                    $link_option = modTZMultipurposeHelper::getlink($arr,$a);
                                    if($show_link == 1) {
                                        echo '<div class="tz_link tz_title"><a '.$link_option -> link_o.' href="'.$link_option -> link.'">'.$link_option -> title_link.'</a></div>';
                                        }else {
                                        echo '<div class="tz_link tz_title">'.$link_option -> title_link.'</div>';
                                    }
                                }
                            }
                        }

                    }
                }
            }
        }
        echo '</div>';
        if($m%$col_display == 0 || $check_bt  == 1) {
            echo '</div>';
        }
        $m++;
    }
    if ($m%$col_display != 1 && $check_bt  == 0) echo "</div>";
    ?>
</div>