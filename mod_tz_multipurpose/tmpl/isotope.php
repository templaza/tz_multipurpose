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
$document->addStyleSheet('modules/mod_tz_multipurpose/css/isotope.css');
$document->addScript('modules/mod_tz_multipurpose/js/tzisotope.js');
$document->addScript('modules/mod_tz_multipurpose/js/isotope.pkgd.min.js');
$list_field_filter  = $params -> get('select_filter_is',0);
$class_iso      = '';
$arr_filter     = explode(',',$list_field_filter);
$showlinkimg    = $params->get('showLinkImg_iso', 0);

?>
<div id="filters">
    <?php
      foreach($arr_filter as $k => $id_filter) {
          $field_filter = modTZMultipurposeHelper::getField($id_filter);
          $value_filter = $field_filter -> value;
          $arr_value_filter = json_decode($value_filter);
          echo '<div class="ui-group">'.
               '<h3>'.$field_filter -> title.'</h3>'.
               '<div class="button-group js-radio-button-group" data-filter-group="'.$field_filter -> title.'">'.
               '<button class="button btn is-checked" data-filter="">Show All</button>';
          foreach($arr_value_filter as $kvf => $value_vf) {
              echo '<button class="button btn" data-filter=".'.$value_vf -> name.'">'.$value_vf -> name.'</button>';
          }
          echo '</div>'.
               '</div>';
      }
    ?>
</div>
<div id="purpose_pagenav" class="purpose_pagenav" data-page-group="pagenav">
</div>
<div class="TzMultipurpose isotope <?php echo $moduleclass_sfx; ?>">
    <?php
    foreach($list as $key => $arr) {
        $value_fis = modTZMultipurposeHelper::getValueFieldsIsotope($arr,$arr_filter);
        echo '<div class="tz_multi_item tz-isotope '.$value_fis.'">';
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

                            // Create div class = tz_description // css position absolute
                            if($type_field != 'image') {
                                $class_ds   = 1;
                            }else {
                                $class_ds   = 0;
                            }

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
                                echo '<p class="tz_flex">'.$value.'</p>';
                            }

                            // type link
                            if($type_field == 'link') {
                                $i++;
                                if($i == 1) {
                                    $link_option = modTZMultipurposeHelper::getlink($arr,$a);
                                    echo '<div class="tz_link tz_flex"><a '.$link_option -> link_o.' href="'.$link_option -> link.'">'.$link_option -> title_link.'</a></div>';
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
<script type="text/javascript">
    var tz_multipurpose_filter_value<?php echo $module -> id;?> = '.page-1';
    var tz_multipurpose_newcolcount<?php echo $module -> id;?> = '1';
    function tz_multipurpose_pagenav<?php echo $module -> id;?>(newColCount,defaultRow,total_item){
        var total_item_per_page =  newColCount*defaultRow;
        var num_page    = Math.ceil(total_item / total_item_per_page);
        var html    = '';
//        jQuery('#purpose_pagenav').html('');
//        if(num_page > 1){
            for(var i=1; i<= num_page; i++){
                if(i == 1){
                    html += '<a class="page-item is_checked" data-page="'+ i +'">'+ i +'</a>';
                }else{
                    html += '<a class="page-item " data-page="'+ i +'">'+ i +'</a>';
                }
            }
            jQuery('#purpose_pagenav').html(html);

            jQuery('.isotope').find('.tz_multi_item').each(function(index,value){
                var item_page_class = Math.ceil((index+1) / total_item_per_page);
                var tzclass   =jQuery(this).attr('class');
                jQuery(this).attr('class',tzclass.replace(/page-[0-9]+/gi,''));
                jQuery(this).addClass('page-'+ item_page_class);
            });

            var tzfiltervalue   = tz_multipurpose_filter_value<?php echo $module -> id;?>.replace('.page-','');
            if(parseInt(tzfiltervalue) > num_page){
                tz_multipurpose_filter_value<?php echo $module -> id;?> = '.page-1';
            }
//        }
    }
    function tz_init(defaultwidth,defaultRow,total){
        var contentWidth    = jQuery('.isotope').width();
        var columnWidth     = defaultwidth;
        var curColCount     = 0;
        var maxColCount     = 0;
        var newColCount     = 0;
        var newColWidth     = 0;
        var featureColWidth = 0;
<!--        var total_item = --><?php //echo count($list)?><!--;-->

        curColCount = Math.floor(contentWidth / columnWidth);

        maxColCount = curColCount + 1;
        if((maxColCount - (contentWidth / columnWidth)) > ((contentWidth / columnWidth) - curColCount)){
            newColCount     = curColCount;
        }
        else{
            newColCount = maxColCount;
        }

        tz_multipurpose_newcolcount<?php echo $module -> id;?>  = newColCount;

//        var total_item_per_page =  newColCount*defaultRow;
//        var num_page    = Math.ceil(total_item / total_item_per_page);
//        var html    = '';
//        for(var i=1; i<= num_page; i++){
//            if(i == 1){
//                html += '<a class="page-item is_checked" data-page="'+ i +'">'+ i +'</a>';
//            }else{
//                html += '<a class="page-item " data-page="'+ i +'">'+ i +'</a>';
//            }
//        jQuery('.isotope').find('.tz_multi_item').each(function(index,value){
//            var item_page_class = Math.ceil((index+1) / total_item_per_page);
//            var tzclass   =jQuery(this).attr('class');
//            jQuery(this).attr('class',tzclass.replace(/page-[0-9]+/gi,''));
//            jQuery(this).addClass('page-'+ item_page_class);
//        });
//        }
//        jQuery('#purpose_pagenav').html(html);
<!--        var tzfiltervalue   = tz_multipurpose_filter_value--><?php //echo $module -> id;?><!--.replace('.page-','');-->
<!--        if(parseInt(tzfiltervalue) > num_page){-->
<!--            tz_multipurpose_filter_value--><?php //echo $module -> id;?><!-- = '.page-1';-->
<!--        }-->

        tz_multipurpose_pagenav<?php echo $module -> id;?>(newColCount,defaultRow,total);



        newColWidth = contentWidth;
        if(newColCount > 1){
            newColWidth = Math.floor(contentWidth / newColCount);
        }


        jQuery('.tz_multi_item').width(newColWidth);
        var $container = jQuery('.isotope');
            $container.isotope({
                masonry:{
                    columnWidth: newColWidth
                },
                filter: tz_multipurpose_filter_value<?php echo $module -> id;?>
            });

    }
</script>

<script type="text/javascript">

    var tz_resizeTimer = null;
    jQuery(window).bind('load resize', function() {
        if (tz_resizeTimer) clearTimeout(tz_resizeTimer);
        tz_resizeTimer = setTimeout("tz_init("+"300,1,<?php echo count($list);?>)", 100);
    });
    jQuery(
        function($) {
        var $container = $('.isotope').isotope({
            itemSelector: '.tz-isotope',
            layoutMode: 'masonry',
            filter: '.page-1'
        });
        var filters = {};
        $('#filters').on( 'click', '.button', function() {
            var $this = $(this);
            var $buttonGroup = $this.parents('.button-group');
            var filterGroup = $buttonGroup.attr('data-filter-group');
            filters[ filterGroup ] = $this.attr('data-filter');
            var filterValue = '';
            var orgfilterValue = '';
            for ( var prop in filters ) {
                filterValue += filters[ prop ];
            }
            orgfilterValue  = filterValue;
            filterValue += tz_multipurpose_filter_value<?php echo $module -> id;?>;
            $container.isotope({ filter: filterValue });
            $container.isotope( 'on', 'layoutComplete', function( isoInstance, laidOutItems ) {
//                if(orgfilterValue.length){
//                   tz_init(300,1,laidOutItems.length);
<!--                }else{-->
                    tz_multipurpose_pagenav<?php echo $module -> id?>(tz_multipurpose_newcolcount<?php echo $module -> id?>,1,laidOutItems.length);
//                $container.isotope({ filter: filterValue });
<!--                }-->
            });
<!--            $container.isotope({-->
<!--                filter: function() {-->
<!--                    // `this` is the item element. Get text of element's .number-->
<!--                    var bool = false;-->
<!--                    var str = jQuery(this).attr('class');-->
<!--                    if(str.indexOf(filterValue.replace('.','')) != -1-->
<!--                        && str.indexOf(tz_multipurpose_filter_value--><?php //echo $module -> id;?><!--.replace('.','')) != -1){-->
<!--                        bool = true;-->
<!--                    }-->
<!--                    // return true to show, false to hide-->
<!--                    return bool;-->
<!--                }-->
<!--            });-->
        });
        $('#purpose_pagenav').on( 'click', '.page-item', function(item) {
            var $this = $(this);
            var $buttonGroup = $this.parents('.button-group');
            var filterGroup = $buttonGroup.attr('data-page-group');
            filters[ filterGroup ] = '.page-'+ $this.attr('data-page');
            var filterValue = '';
            for ( var prop in filters ) {
                filterValue += filters[ prop ];
            }
            jQuery(this).parent().find('.page-item').removeClass('is_checked')
                .end().end().addClass('is_checked');
            tz_multipurpose_filter_value<?php echo $module -> id;?> = filterValue;
            $container.isotope({ filter: filterValue });
        });
        $('.button-group').each( function( i, buttonGroup ) {
            var $buttonGroup = $( buttonGroup );
            $buttonGroup.on( 'click', 'button', function() {
                $buttonGroup.find('.is-checked').removeClass('is-checked');
                $( this ).addClass('is-checked');
            });
        });
    });
</script>