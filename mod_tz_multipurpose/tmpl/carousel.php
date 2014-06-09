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
$document->addStyleSheet('modules/mod_tz_multipurpose/css/owl.carousel.css');
$document->addStyleSheet('modules/mod_tz_multipurpose/css/owl.theme.css');
$document->addScript('modules/mod_tz_multipurpose/js/owl.carousel.js');
if (version_compare(JVERSION, '3.0', '<=')) :
    $document->addScript('modules/mod_tz_multipurpose/js/jquery-1.9.1.min.js');
endif;

$showlinkimg = $params->get('showLinkImg_cr', 0);
$link_img    = $params->get('link_img_cr', '');

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


if ($params->get('autoPlay', 1)):
    $options->autoPlay = 'true';
endif;

if ($params->get('stopOnHover', 1)):
    $options->stopOnHover = 'true';
endif;

if ($params->get('singleItem', 1)):
    $options->singleItem = 'true';
endif;

if ($params->get('rewindNav', 1)):
    $options->rewindNav = 'true';
endif;

if ($params->get('pagination', 1)):
    $options->pagination = 'true';
endif;

if ($params->get('paginationNumbers', 1)):
    $options->paginationNumbers = 'true';
endif;

if ($params->get('itemsScaleUp', 1)):
    $options->itemsScaleUp = 'true';
endif;

if ($params->get('items', 5)):
    $options->items = $params->get('items', 5);
endif;

if ($params->get('slideSpeed', 200)):
    $options->slideSpeed = $params->get('slideSpeed', 200);
endif;

if ($params->get('paginationSpeed', 800)):
    $options->paginationSpeed = $params->get('paginationSpeed', 800);
endif;

if ($params->get('rewindSpeed', 1000)):
    $options->rewindSpeed = $params->get('rewindSpeed', 1000);
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

                                if($type_field != 'link') {
                                    ?><div class="tz_multi_child <?php echo $field->title;?>">
                                    <?php
                                    if($type_field == 'image'){
                                        if($showlinkimg == 1 && $link_img != '') {
                                            $link_option = modTZMultipurposeHelper::getlink($arr,$link_img);
                                            $j++;
                                            if($j==1){
                                                 echo '<a '.$link_option -> link_o.' href="'.$link_option -> link.'"><img src="'.$value.'" alt="'.$field->title.'" /></a>';
                                            }
                                        }else {
                                            echo '<img src="'.$value.'" alt="'.$field->title.'" />';
                                        }
                                    }elseif($type_field == 'radio' || $type_field == 'checkbox' || $type_field == 'multipleSelect' || $type_field == 'select'){
                                        $get_value_f = modTZMultipurposeHelper::getFieldValue($value_field,$value,$option_stm);
                                        if(isset($get_value_f)){
                                            echo $get_value_f;
                                        }
                                    }else{
                                        echo $value;
                                    }
                                    ?>
                                    </div>
                                <?php
                                }else {
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