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
$document->addStyleSheet('modules/mod_tz_multipurpose/css/style.css');
$document->addStyleSheet('modules/mod_tz_multipurpose/css/pricingtable.css');

$responsive = $params->get('add_css_rps_prt',0);
if($responsive) {
    $document->addStyleSheet('modules/mod_tz_multipurpose/css/tz_style.css');
}

$field_title    = $params -> get('prt_sgf_title','');
$field_pri      = $params -> get('prt_sgf_pri','');
$field_link     = $params -> get('prt_sgf_link','');

// COLOR OPTION
$color_title    = $params -> get('prt_color_title','#FF6F00');
$color_head     = $params -> get('prt_color_head','#34383B');
$color_button   = $params -> get('prt_color_button','#FF6F00');
$color_border_b = $params -> get('prt_color_border_button','#FF6F00');
$size_border_b  = $params -> get('prt_size_border_button','#FF6F00');
$color_text_b   = $params -> get('prt_color_text_button','#FFFFFF');
$color_price    = $params -> get('prt_color_price','#BFCDD8');
$color_head_hv  = $params -> get('prt_color_head_hv','#BFCDD8');
$color_item     = $params -> get('prt_color_item','#A0A0A0');

$col    = $params -> get('column_prt',4);
$col_table  = $params -> get('column_prt_table',4);
$col_mobile = $params -> get('column_prt_mobile',12);

$m      = 1;
$count_list     = count($list);
$col_display    = floor(12/$col);
$check_bt  = 0;

if($m == $col_display) {
    $check_bt  = 1;
}

?>

<div class="TzMultipurpose pricing container-fluid <?php echo $moduleclass_sfx; ?>">
    <?php
    foreach($list as $key => $arr) {
        if($m%$col_display == 1 || $check_bt  == 1) {
            echo '<div class="row">';
        }
        echo '<div class="tz_multi_item tz-col-sm-'.$col_table.' tz-col-xs-'.$col_mobile.' tz-col-md-'.$col.'">';
        $id_group       = $arr -> group;
        $list_field_id  = modTZMultipurposeHelper::getFieldGroup($id_group,'');
        $i = 0;
        foreach($list_field_id as $f => $v_id_f){
            foreach($arr as $n => $value){
                $a  = (int)$n;
                if($n != 'group' && $a == $v_id_f){
                    if(is_numeric($a)) {
                        if($value != "") {
                            $field = modTZMultipurposeHelper::getField($a);
                            $value_field = $field -> value;
                            $type_field  = $field -> type;
                            $field_id    = $field -> id;
                            // type Image
                            if($type_field == 'image'){
                                echo '<div class="tz_multi_child '.$field->title.'">';
                                if($showlinkimg == 1 && $link_img != '') {
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
                                if($field_id == $field_title){
                                    echo '<div class="pri_title">'.
                                            '<p class="title">'.$value.'</p>'.
                                         '</div>';
                                }
                                if($field_id == $field_pri){
                                    echo '<div class="pri">'.
                                        '<p>'.$value.'</p>'.
                                        '</div>';
                                }
                                if($field_id != $field_title && $field_id != $field_pri && $field_id != $field_link) {
                                    echo '<p class="pri_item">'.$value.'</p>';
                                }
                            }

                            // type link
                            if($type_field == 'link') {
                                $i++;
                                if($i == 1) {
                                    $link_option = modTZMultipurposeHelper::getlink($arr,$a);
                                    echo '<div class="tz_link pricing"><a class="btn" '.$link_option -> link_o.' href="'.$link_option -> link.'">'.$link_option -> title_link.'</a></div>';
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

<?php
$document -> addStyleDeclaration('
    .pri_title, .pri {
        background: '.$color_head.';
    }
    .pri_title p {
        color: '.$color_title.';
    }
    .pricing .btn {
        background: '.$color_button.';
        border: '.$size_border_b.'px solid '.$color_border_b.';
        color: '.$color_text_b.';
    }
    .pri {
        color: '.$color_price.';
    }
    .pricing .tz_multi_item:hover .pri_title, .pricing .tz_multi_item:hover .pri {
        background: '.$color_head_hv.';
    }
    .pri_item {
        color: '.$color_item.';
    }
');
?>