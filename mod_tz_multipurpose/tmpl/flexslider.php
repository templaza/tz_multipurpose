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
if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);
$document = JFactory::getDocument();
require_once (JPATH_SITE.DS.'modules'.DS.'mod_tz_multipurpose'.DS.'helper.php');
$document->addStyleSheet('modules/mod_tz_multipurpose/css/style.css');
$document->addStyleSheet('modules/mod_tz_multipurpose/css/flexslider.css');
$document->addScript('modules/mod_tz_multipurpose/js/jquery.flexslider.js');
if (version_compare(JVERSION, '3.0', '<=')) :
    $document->addScript('modules/mod_tz_multipurpose/js/jquery-1.9.1.min.js');
endif;

$layout = $params -> get('layout','default');
$id_field_avd   = $params -> get('flex_sgf','');

$showlinkimg = $params->get('showLinkImg_flex', 0);
$link_img    = $params->get('link_img_flex', '');


?>
<div class="TzMultipurpose">
    <div id="slider" class="flexslider">
        <ul class="slides">
            <?php
            foreach($list as $key => $arr) {?>
                <li class="tz_multi_item"><?php
                    $id_group       = $arr -> group;
                    $list_field_id  = modTZMultipurposeHelper::getFieldGroup($id_group,$id_field_avd);
                    $i = 0;
                    $j = 0;
                    foreach($list_field_id as $f => $v_id_f){
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
                    ?>
                </li><?php
            }
            ?>
            <?php if ($params->get('navigation') == 1): ?>

            <?php endif; ?>
        </ul>
    </div>
    <div id="carousel" class="flexslider">
        <ul class="slides">
            <?php
            foreach($list as $key => $arr) {?>
                <li class="tz_multi_item"><?php
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
                                    $type_field = $field -> type;
                                    if($type_field != 'link') {
                                        ?><div class="tz_multi_child <?php echo $field->title;?>">
                                        <?php
                                        if($type_field == 'image'){
                                            ?>
                                            <img src="<?php echo $value;?>" alt="<?php echo $field->title;?>" />
                                        <?php
                                        }
                                        ?>
                                        </div>
                                    <?php
                                    }
                                }

                            }
                        }
                    }
                }
                ?>
                </li><?php
            }
            ?>
            <?php if ($params->get('navigation') == 1): ?>

            <?php endif; ?>
        </ul>
    </div>
</div>

<script type="text/javascript">
    jQuery(window).load(function(){
        jQuery('#carousel').flexslider({
            animation: "slide",
            controlNav: false,
            animationLoop: false,
            slideshow: false,
            itemWidth: 210,
            itemMargin: 5,
            asNavFor: '#slider'
        });

        jQuery('#slider').flexslider({
            animation: "slide",
            controlNav: false,
            animationLoop: false,
            slideshow: false,
            sync: "#carousel"
        });
    });
</script>