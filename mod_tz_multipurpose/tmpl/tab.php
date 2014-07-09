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
$id_m    = $module->id;

require_once (JPATH_SITE.DS.'modules'.DS.'mod_tz_multipurpose'.DS.'helper.php');
$document->addStyleSheet('modules/mod_tz_multipurpose/css/tab.css');
$document->addScript('modules/mod_tz_multipurpose/js/jquery.timetabs.min.js');

$tab_head = $params->get('tab_head',0);
$tab_desc = $params->get('tab_desc',0);
$dt_dd = 'dt';
$tab_width = $params->get('tm_tab_width',0);
$tab_height = $params->get('tm_tab_height',0);
if(is_numeric($tab_width)) {
    $tab_width = $tab_width.'px';
}else {
    $tab_width = 'auto';
}
if(is_numeric($tab_height)) {
    $tab_height = $tab_height.'px';
}else {
    $tab_height = 'auto';
}
$style = 'dd.tz_multi_child {'
    . 'width: '.$tab_width.';'
    . 'height: '.$tab_height.';'
. '}';
$document->addStyleDeclaration($style);
// option animated
$animated = $params->get('tab_animated','Fade');
$animated_spend = $params->get('tm_tab_spend_animated','500');
$animated_delay = $params->get('tm_tab_delay','500');

?>

<dl class="tabs" id="tabs_<?php echo $id_m;?>">
<?php
foreach($list as $key => $arr) {
    $id_group       = $arr -> group;
    $list_field_id  = modTZMultipurposeHelper::getFieldGroup($id_group,'');
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
                        if($type_field != 'link') {
                            if($tab_head == $id_field) {
                                $dt_dd  = 'dt';
                            }else{
                                $dt_dd  = 'dd';
                            }
                            ?>
                            <<?php echo $dt_dd;?> class="tz_multi_child <?php echo $field->title;?>">
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
                            </<?php echo $dt_dd;?>>
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
}
?>
</dl>
<script type="text/javascript">
    jQuery(document).ready(function(){

        jQuery('dl#tabs_<?php echo $id_m?>').addClass('enabled').timetabs({
            defaultIndex: 0,
            interval: '<?php echo $animated_delay;?>',
            continueOnMouseLeave: true,
            animated: '<?php echo $animated;?>',
            animationSpeed: '<?php echo $animated_spend;?>'
        });
    });
</script>


