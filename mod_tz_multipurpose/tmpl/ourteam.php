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
$document->addStyleSheet('modules/mod_tz_multipurpose/css/ourteam.css');

$font_as        = $params -> get('fontas_ot',0);
$responsive = $params->get('add_css_rps_ut',0);
if($responsive) {
    $document->addStyleSheet('modules/mod_tz_multipurpose/css/tz_style.css');
}
if($font_as == 1) {
    $document->addStyleSheet('modules/mod_tz_multipurpose/css/font-awesome.min.css');
}

$field_name       = $params -> get('ut_name','');
$field_dsc        = $params -> get('ut_desc','');
$field_social     = $params -> get('ut_social','');
$field_social_arr = explode(',',$field_social);

// column bootstrap
$col        = $params -> get('column_ut',4);
$col_table  = $params -> get('column_ut_table',4);
$col_mobile = $params -> get('column_ut_mobile',12);

$m      = 1;
$count_list     = count($list);
$col_display    = floor(12/$col);
$check_bt  = 0;
if($m == $col_display) {
    $check_bt  = 1;
}
?>

<div class="TzMultipurpose tz-container-fluid <?php echo $moduleclass_sfx; ?>">
    <?php
    foreach($list as $key => $arr) {
        if($m%$col_display == 1 || $check_bt  == 1) {
            echo '<div class="tz-row">';
        }
        echo '<div class="tz_multi_item tz-col-sm-'.$col_table.' tz-col-xs-'.$col_mobile.' tz-col-md-'.$col.'">'.
             '<div class="ourteam">';

        $id_group           = $arr -> group;
        $list_field_id      = modTZMultipurposeHelper::getFieldGroup($id_group,'');
        $count_list_field   = count($list_field_id);
        $socialFields       = null;
        $i1 = 0;
        $j  = 0;
        $j1 = 0;
        foreach($list_field_id as $f => $v_id_f){
            $i = 0;
            $j1++;
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
                            if($type_field == 'image'){
                                echo '<div class="tz_multi_image"><img src="'.$value.'" alt="'.$field->title.'" /></div>';
                            }

                            // div class ourteam_desc

                            if($type_field != 'image' && $i1 == 0) {
                                echo '<div class="ourteam_desc">';
                                $i1++;
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
                                if($field_name == $id_field) {
                                    $class_name = 'tz_multi_name';
                                }else {
                                    $class_name = '';
                                }
                                if($field_dsc == $id_field) {
                                    $class_desc = 'tz_multi_desc';
                                }else {
                                    $class_desc = '';
                                }
                                echo '<p class="'.$class_desc.' tz_multi '.$class_name.'">'.$value.'</p>';
                            }

                            // type link
                            if($type_field == 'link') {
                                $i++;
                                if($i == 1 && in_array($id_field,$field_social_arr)) {
                                    if($j == 0){
                                        echo '<div class="link_social">';
                                    }
                                    $j++;
                                    $link_option = modTZMultipurposeHelper::getlink($arr,$a);
                                    if($font_as == 1) {
                                        echo '<a '.$link_option -> link_o.' href="'.$link_option -> link.'"><i class="'.$link_option -> title_link.'"></i></a>';
                                    }else {
                                        echo '<a '.$link_option -> link_o.' href="'.$link_option -> link.'"><img src="'.$link_option -> img.'" alt="'.$link_option -> title_link.'"></a>';
                                    }
                                    if(isset($list_field_id[$f + 1])){
                                        if(!empty($list_field_id[$f + 1])){
                                            $field2 = modTZMultipurposeHelper::getField($list_field_id[$f + 1]);
                                            if($field2 -> type != 'link'){
                                                echo '</div>';
                                            }
                                        }
                                    }else{
                                        echo '</div>';
                                    }
                                }

                            }

                            if($j1 == $count_list_field) {
                                echo '</div>'; // end div ourteam_desc
                                $j1 = 0;
                            }
                        }

                    }
                }
            }
        }
        echo '</div>';
        echo '</div>';
        if($m%$col_display == 0 || $check_bt  == 1) {
            echo '</div>';
        }
        $m++;
    }
    if ($m%$col_display != 1 && $check_bt  == 0) echo "</div>";
    ?>
</div>