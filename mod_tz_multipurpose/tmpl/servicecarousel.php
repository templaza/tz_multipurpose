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
$document->addStyleSheet('modules/mod_tz_multipurpose/css/owl.carousel.css');
$document->addStyleSheet('modules/mod_tz_multipurpose/css/owl.theme.css');
$document->addScript('modules/mod_tz_multipurpose/js/owl.carousel.js');
if (version_compare(JVERSION, '3.0', '<=')) :
    $document->addScript('modules/mod_tz_multipurpose/js/jquery-1.9.1.min.js');
endif;
$show_link      = $params -> get('show_link_svcr',0);
$font_as        = $params -> get('fontas_svcr',0);

if($font_as == 1) {
    $document->addStyleSheet('modules/mod_tz_multipurpose/css/font-awesome.min.css');
}

// select field logo, title, desc
$link_img         = $params->get('link_img_svcr', '');

$field_logo       = $params -> get('sv_logo_cr','');
$field_title      = $params -> get('sv_title_cr','');
$field_dsc        = $params -> get('sv_desc_cr','');
$field_font       = $params -> get('sv_fontas_cr','');
$field_logo_arr   = explode(',',$field_logo);
$field_title_arr  = explode(',',$field_title);
$field_dsc_arr    = explode(',',$field_dsc);
$field_font_arr   = explode(',',$field_font);

$options = new stdClass();

//Default Option
$options->autoPlay = 'false';
$options->stopOnHover = 'false';
$options->singleItem = 'false';
$options->rewindNav = 'false';
$options->pagination = 'false';
$options->paginationNumbers = 'false';
$options->itemsScaleUp = 'false';

$options->items = 0;
$options->slideSpeed = 0;
$options->paginationSpeed = 0;
$options->rewindSpeed = 0;

if ($params->get('autoPlay_sv', 1)):
    $options->autoPlay = 'true';
endif;

if ($params->get('stopOnHover_sv', 1)):
    $options->stopOnHover = 'true';
endif;

if ($params->get('singleItem_sv', 1)):
    $options->singleItem = 'true';
endif;

if ($params->get('rewindNav_sv', 1)):
    $options->rewindNav = 'true';
endif;

if ($params->get('pagination_sv', 1)):
    $options->pagination = 'true';
endif;

if ($params->get('paginationNumbers_sv', 1)):
    $options->paginationNumbers = 'true';
endif;

if ($params->get('itemsScaleUp_sv', 1)):
    $options->itemsScaleUp = 'true';
endif;

if ($params->get('items_sv', 5)):
    $options->items = $params->get('items_sv', 5);
endif;


if ($params->get('slideSpeed_sv', 200)):
    $options->slideSpeed = $params->get('slideSpeed_sv', 200);
endif;

if ($params->get('paginationSpeed_sv', 800)):
    $options->paginationSpeed = $params->get('paginationSpeed_sv', 800);
endif;

if ($params->get('rewindSpeed_sv', 1000)):
    $options->rewindSpeed = $params->get('rewindSpeed_sv', 1000);
endif;
?>

<div class="TzMultipurpose">
    <div id="TzMultipurpose<?php echo $module -> id;?>" class="owl-carousel owl-theme<?php echo $moduleclass_sfx; ?>">
        <?php
        foreach($list as $key => $arr) {?><div class="tz_multi_item"><?php
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
                                }
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
            ?></div><?php
        }
        ?>
        <?php if ($params->get('navigation') == 1): ?>

        <?php endif; ?>
    </div>

    <?php if ($params->get('navigation') == 1): ?>
        <div class="tz_mulri_pn">
            <a id="tz_mulri_p<?php echo $module->id; ?>" class="sb-navigation-left"></a>
            <a id="tz_mulri_n<?php echo $module->id; ?>" class="sb-navigation-right"></a>
        </div>
    <?php endif; ?>
</div>

<script type="text/javascript">
    jQuery(document).ready(function () {
        var owl = jQuery("#TzMultipurpose<?php echo $module -> id;?>");
        owl.owlCarousel({
            // Most important owl features
            items : <?php echo $options->items;?>,
            itemsDesktop: [1199, <?php echo ( round($options->items /1.224));?>],
            itemsDesktopSmall: [979, <?php echo ( round($options->items /1.563));?>],
            itemsTablet: [768, <?php
                             $c_item = round($options->items /2.503);
                             if($c_item == 0) {
                                echo 1;
                             }else {
                                echo ( round($options->items /2.503));
                             }
                            ?>],
            itemsMobile: [479, 1],
            slideSpeed:<?php echo $options -> slideSpeed;?>,
            paginationSpeed:<?php echo $options -> paginationSpeed; ?>,
            rewindSpeed:<?php echo  $options -> rewindSpeed;?>,
            autoPlay:<?php echo   $options -> autoPlay; ?>,
            stopOnHover: <?php echo  $options-> stopOnHover;?>,
            singleItem:<?php echo   $options -> singleItem;?>,
            rewindNav:<?php echo $options->rewindNav;?>,
            pagination:<?php echo   $options -> pagination;?>,
            paginationNumbers:<?php echo $options -> paginationNumbers; ?>,
            itemsScaleUp:<?php echo  $options -> itemsScaleUp;?>
        });
        // Custom Navigation Events
        jQuery("#tz_mulri_n<?php echo $module->id; ?>").click(function () {

            owl.trigger('owl.next');
        })
        jQuery("#tz_mulri_p<?php echo $module->id; ?>").click(function () {
            owl.trigger('owl.prev');
        })
    });
</script>