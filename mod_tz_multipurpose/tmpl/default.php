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

?>

<div class="TzMultipurpose <?php echo $moduleclass_sfx; ?>">
    <?php
    foreach($list as $key => $arr) {?><div class="tz_multi_item"><?php
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
                                    echo '<img src="'.$value.'" alt="'.$field->title.'" />';
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
</div>