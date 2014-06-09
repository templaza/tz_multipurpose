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
$document->addStyleSheet('modules/mod_tz_multipurpose/css/progresbars.css');
$document -> addScript('modules/mod_tz_multipurpose/js/jquery.easypiechart.min.js');

$responsive = $params->get('add_css_rps_pb',0);
if($responsive) {
    $document->addStyleSheet('modules/mod_tz_multipurpose/css/tz_style.css');
}

$scaleColor = 'false';
if($params -> get('scaleColor_ps')){
    $scaleColor = '"'.$params -> get('scaleColor_ps').'"';
}
if($params -> get('textColor_ps')){
    $document -> addStyleDeclaration('#TzMultipurpose'.$module -> id.'{ color: '.$params -> get('textColor_ps').';}');
    $document -> addStyleDeclaration('#TzMultipurpose'.$module -> id.' .percent{ color: '.
        $params -> get('textColor_ps').';}');
}

$get_field_id   = $params -> get('select_field_pb','');

$col    = $params -> get('column_pb',4);
$col_table  = $params -> get('column_pb_table',4);
$col_mobile = $params -> get('column_pb_mobile',12);

$m      = 1;
$count_list     = count($list);
$col_display    = floor(12/$col);
$check_bt  = 0;
if($m == $col_display) {
    $check_bt  = 1;
}
?>

<div class="TzMultipurpose container-fluid <?php echo $moduleclass_sfx; ?>" id="TzMultipurpose<?php echo $module -> id;?>">
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
                            $id_field    = $field -> id;
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
                                if($get_field_id == $id_field) {
                                    $value_ps  = modTZMultipurposeHelper::getValueFields($arr,$get_field_id);
                                    echo '<div class="chart" data-percent="'.$value_ps.'">'.
                                            '<div class="chart-inner">'.
                                                '<p class="percent">'.$value.'</p>'.
                                            '</div>'.
                                         '</div>';
                                }else {
                                    echo '<p class="title">'.$value.'</p>';
                                }
                            }

                            // type link
                            if($type_field == 'link') {
                                $i++;
                                if($i == 1) {
                                    $link_option = modTZMultipurposeHelper::getlink($arr,$a);
                                    echo '<div class="tz_link"><a '.$link_option -> link_o.' href="'.$link_option -> link.'">'.$link_option -> title_link.'</a></div>';
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
    #TzStatistic'.$module -> id.'.TzStatistic .chart{
        width: '.$params -> get('size',110).'px;
        height: '.$params -> get('size',110).'px;
    }
');

$document -> addScriptDeclaration('
    var chartfunc'.$module -> id.'   = function(){
        var rtop    = jQuery("#TzMultipurpose'.$module -> id.' .chart").offset().top,
            wheight = jQuery(this).height(),
            wtop    = jQuery(this).scrollTop() + wheight/3;

        if((jQuery(this).scrollTop() >= (rtop - wheight/1.2)) && (jQuery(this).scrollTop() <= ((rtop + wheight/3)*2))){
            jQuery("#TzMultipurpose'.$module -> id.' .chart").easyPieChart({
                easing: "'.$params -> get('easing_ps','defaultEasing').'",
                trackColor: "'.$params -> get('trackColor_ps','#f9f9f9').'",
                barColor: "'.$params -> get('barColor_ps','#ef1e25').'",
                scaleColor:'.$scaleColor.',
                lineWidth:'.$params -> get('lineWidth_ps',3).',
                size: '.$params -> get('size_ps',110).',
                lineCap: "'.$params -> get('lineCap_ps','butt').'",
                rotate: '.$params -> get('rotate_ps',0).',
                animate: {
                    duration: '.$params -> get('duration_ps',1000).',
                    enabled: '.$params -> get('animate_ps',1).'
                },
                onStart: function(from, to){},
                onStep: function(from, to, percent) {
                    jQuery(this.el).find(".percent").text(Math.round(percent));
                },
                onStop: function(from, to){}
            });
		}
    }

    jQuery(window).load(function(){
        chartfunc'.$module -> id.'();
    });
');
?>