// name1 : $this -> element['name']
// name2 : $element['name']

function jInsertFieldValue(value, id) {
    var old_id = document.id(id).value;
    if (old_id != id) {
        var elem = document.id(id)
        elem.value = value;
        elem.fireEvent("change");
    }

}

jQuery(function($){
    $( "#tz-table-multi" ).sortable();
    $( "#tz-table-multi" ).disableSelection();

    // function add new -> select group

    $(".btn_add").parent(".controls").css({
        "margin-left" : "0px"
    });

    $('.btn_add').click(function(){
        jQuery('#tz_select_group, #select-lbl').css({
            display: 'block'
        });
        jQuery.get(
            "index.php?option=com_tz_multipurpose&view=fields&task=groups.seletcgroup",
            function(data) {
                jQuery('#tz_select_group').html(data);
                SqueezeBox.initialize({});
                SqueezeBox.assign($$('a.modal'), {
                    parse: 'rel'
                });
                SqueezeBox.initialize({});
                SqueezeBox.assign($$('a.modal-button'), {
                    parse: 'rel'
                });
            }
        );
    });

    window.addEvent('domready', function() {
        jQuery('#tz_select_group').on('change', function(){
            var $this = jQuery(this),
                $value = $this.val();
            if($value !=null) {
                jQuery('#button_save, #button_cancel').css({
                    opacity: 1
                });
                jQuery('#tz_select_group, #select-lbl, .control-group.fields, .control-group.save, #button_save, #button_cancel').css({
                    display: 'block'
                });
            }
            jQuery.get(
                "index.php?option=com_tz_multipurpose&view=fields&task=fields.ajax",
                { name: $value },
                function(data) {
                    jQuery('#tz-form-multipurpose').html(data);
                    SqueezeBox.initialize({});
                    SqueezeBox.assign($$('a.modal'), {
                        parse: 'rel'
                    });
                    SqueezeBox.initialize({});
                    SqueezeBox.assign($$('a.modal-button'), {
                        parse: 'rel'
                    });
                }
            );
        });

        /// function btn_add
        jQuery('.btn_add').click(function(){
            jQuery('.btn_add').css({
                display: 'none'
            });
            jQuery('.control-group.fields').css({
                display: 'none'
            });
        });

        var functionedit    = function($this){

            jQuery('#tz_select_group, #select-lbl, .control-group.save, .control-group.fields, #button_save, #button_cancel').css({
                display: 'block',
                opacity: 1
            });
            jQuery('.btn_add').css("display","none");
            var $value      = $this.attr('value'),
                $item       = $($this).parent(),
                $item_c     = $($item).find('.tz_item_child');
            $($item).addClass(' ing');
            // item      = tz_multipurpose_item
            // $item_c   = tz_item_child
            jQuery.get(
                "index.php?option=com_tz_multipurpose&view=fields&task=groups.getselectgroup",
                { name: $value },
                function(data) {
                    var $json   = $.parseJSON(data);
                    var $select = $json.select;
                    var $field  = $json.field;
                    jQuery('#tz_select_group').html($select);
                    jQuery('#tz-form-multipurpose').html($field);
                    SqueezeBox.initialize({});
                    SqueezeBox.assign($$('a.modal'), {
                        parse: 'rel'
                    });
                    SqueezeBox.initialize({});
                    SqueezeBox.assign($$('a.modal-button'), {
                        parse: 'rel'
                    });
                    for(var $i = 0; $i < $item_c.length; $i++){
                        var $v          = $($item_c[$i]).find('.tz_fieldvalue').attr('value'); // get value tz_item_child > input hidden tz_fieldvalue
                        var $dataid     = $($item_c[$i]).find('.tz_fieldvalue').attr('data-id'); // get id field tz_item_child > input hidden tz_fieldvalue
                        var $field      = "#tz_multi_"+$dataid;
                        var $field_type  = $($field).attr('field-type');
                        if($field_type=='radio'){
                            var $item_radio     = $($field).find('.radio'); // find input class radio => input
                            var $count_item     = $($item_radio).length; //count input class radio
                            for(var $j = 0; $j < $count_item; $j++) {
                                var $v_r = $($item_radio[$j]).attr('value'); // $v_r: value radio input
                                if($v_r == $v){
                                    $($item_radio[$j]).prop('checked', true);
                                }
                            }
                        }else if($field_type=='checkbox') {
                            var $item_checkbox   = $($field).find('.checkbox'); // find input class radio => input
                            var $count_item      = $($item_checkbox).length; //count input class radio
                            for(var $j = 0; $j < $count_item; $j++) {
                                var $v_r = $($item_checkbox[$j]).attr('value'); // $v_r: value radio input
                                var $arr = $v.split(',');
                                for(var $n = 0; $n < $arr.length; $n++){
                                    if($v_r == $arr[$n]){
                                        $($item_checkbox[$j]).prop('checked', true);
                                    }
                                }
                            }
                        }else if($field_type=='multipleSelect') {
                            var $item_multi   = $($field).find('.tz_multiselect');
                            var $count_item      = $($item_multi).length; //count input class radio
                            for(var $j = 0; $j < $count_item; $j++) {
                                var $v_r = $($item_multi[$j]).attr('value'); // $v_r: value radio input
                                var $arr = $v.split(',');
                                for(var $n = 0; $n < $arr.length; $n++){
                                    if($v_r == $arr[$n]){
                                        $($item_multi[$j]).prop('selected', true);
                                    }
                                }
                            }
                        }else {
                            $($field).val($v);
                        }
                    }
                }
            );
        };

        var functiondelete  = function($this){
            var $item       = $($this).parent('.tz_multipurpose_item');
            $item.remove();
        };


        $('.edit').click(function(){
            var $this   = jQuery(this);
            functionedit($this);
        });

        $('.delete').click(function(){
            var $this   =   jQuery(this);
            functiondelete($this);
        });

        // each
        jQuery('#button_cancel').click(function(){
            jQuery('#tz_select_group, #select-lbl, .control-group.fields, .control-group.save, #button_save, #button_cancel').css({
                display: 'none'
            });
            jQuery('.btn_add').css({
                display: 'block'
            });
            $('div').removeClass('ing');
        });
        jQuery('#button_save').click(function(){
            jQuery('#tz_select_group, #select-lbl, .control-group.save, .control-group.fields, #button_save, #button_cancel').css({
                display: 'none'
            });
            jQuery('.btn_add').css({
                display: 'block'
            });
            var $a = jQuery('#tz-form-multipurpose .tz_multi_field').serializeArray();
            var value_check = '';
            if($('#tz-form-multipurpose .tz_multi_field').hasClass('radio')) {
                value_check = $('input[type=radio]:checked', '.tz_multi_field').val();
            }
            var booleanVlaueIsChecked=false;
            if(value_check)
            {
                booleanVlaueIsChecked=true;
            }

            if (($a.length == 0) && (booleanVlaueIsChecked == false)) {
                return false;
            }
            var $tz_multipurpose_item = $("<div></div>").addClass('tz_multipurpose_item').appendTo('#tz-table-multi');
            var $tz_move_group = $('<div>Move</div>').addClass('move tz_group_id').appendTo($tz_multipurpose_item);
            var $tz_edit_group = $('<div value="'+$('#tz_select_group').val()+'" name="">Edit</div>').addClass('edit tz_group_id').appendTo($tz_multipurpose_item);
            var $tz_hiddenfield_groupid = $('<input type="hidden" value="'+$('#tz_select_group').val()+'" name="" />').addClass('tz_group_id').appendTo($tz_multipurpose_item);
            var $tz_delete_group = $('<div value="'+$('#tz_select_group').val()+'" name="">Delete</div>').addClass('delete tz_group_id').appendTo($tz_multipurpose_item);
            if($.trim($(".tz_multipurpose_item.ing").html())!=''){
                $('.tz_multipurpose_item.ing').find('.tz_item_child').remove();
                $('#tz-form-multipurpose .tz_multi_field').each(function (i,el){
                    if($(this).hasClass('radio')) {
                        var value = $('input[type=radio]:checked', '.tz_multi_field').val();
                        var $tz_item_child = $("<div></div>").addClass('tz_item_child').appendTo('.tz_multipurpose_item.ing');
                        var $tz_field_name = $('<div>'+$(this).attr('field-name')+'</div>').addClass('tz_field_name').attr('data-id',$(this).attr('name')).appendTo($tz_item_child);
                        var $tz_field_value = $("<div>"+value+"</div>").addClass('tz_field_value').appendTo($tz_item_child);
                        var $tz_hiddenfield_value = $('<input type="hidden" value="'+value+'" />').addClass('tz_fieldvalue data-id'+$(this).attr('name')).attr('data-id',$(this).attr('name')).appendTo($tz_field_value);
                    }else if($(this).hasClass('checkbox')) {
                        var chk_value = '';
                        $('.checkbox:checked').each(function() {
                            chk_value += $(this).val() + ",";
                        });
                        chk_value =  chk_value.slice(0,-1);
                        var $tz_item_child = $("<div></div>").addClass('tz_item_child').appendTo('.tz_multipurpose_item.ing');
                        var $tz_field_name = $('<div>'+$(this).attr('field-name')+'</div>').addClass('tz_field_name').attr('data-id',$(this).attr('name')).appendTo($tz_item_child);
                        var $tz_field_value = $("<div>"+chk_value+"</div>").addClass('tz_field_value').appendTo($tz_item_child);
                        var $tz_hiddenfield_value = $('<input type="hidden" value="'+chk_value+'" />').addClass('tz_fieldvalue data-id'+$(this).attr('name')).attr('data-id',$(this).attr('name')).appendTo($tz_field_value);
                    }else{
                        var $tz_item_child = $("<div></div>").addClass('tz_item_child').appendTo('.tz_multipurpose_item.ing');
                        var $tz_field_name = $('<div>'+$(this).attr('field-name')+'</div>').addClass('tz_field_name').attr('data-id',$(this).attr('name')).appendTo($tz_item_child);
                        var $tz_field_value = $("<div>"+$(this).val()+"</div>").addClass('tz_field_value').appendTo($tz_item_child);
                        var $tz_hiddenfield_value = $('<input type="hidden" value="'+$(this).val()+'" />').addClass('tz_fieldvalue data-id'+$(this).attr('name')).attr('data-id',$(this).attr('name')).appendTo($tz_field_value);
                    }
                });
                $('div').removeClass('ing');
                $('.tz_multipurpose_item:last-child').remove();
            }else{
                $('#tz-form-multipurpose .tz_multi_field').each(function (i,el){
                    if($(this).hasClass('radio')) {
                        var value = $('input[type=radio]:checked', '.tz_multi_field').val();
                        var $tz_item_child = $("<div></div>").addClass('tz_item_child').appendTo($tz_multipurpose_item);
                        var $tz_field_name = $('<div>'+$(this).attr('field-name')+'</div>').addClass('tz_field_name').attr('data-id',$(this).attr('name')).appendTo($tz_item_child);
                        var $tz_field_value = $("<div>"+value+"</div>").addClass('tz_field_value').appendTo($tz_item_child);
                        var $tz_hiddenfield_value = $('<input type="hidden" value="'+value+'" />').addClass('tz_fieldvalue data-id'+$(this).attr('name')).attr('data-id',$(this).attr('name')).appendTo($tz_field_value);
                    }else if($(this).hasClass('checkbox')) {
                        var chk_value = '';
                        $('.checkbox:checked').each(function() {
                            chk_value += $(this).val() + ",";
                        });
                        chk_value =  chk_value.slice(0,-1);
                        var $tz_item_child = $("<div></div>").addClass('tz_item_child').appendTo($tz_multipurpose_item);
                        var $tz_field_name = $('<div>'+$(this).attr('field-name')+'</div>').addClass('tz_field_name').attr('data-id',$(this).attr('name')).appendTo($tz_item_child);
                        var $tz_field_value = $("<div>"+chk_value+"</div>").addClass('tz_field_value').appendTo($tz_item_child);
                        var $tz_hiddenfield_value = $('<input type="hidden" value="'+chk_value+'" />').addClass('tz_fieldvalue data-id'+$(this).attr('name')).attr('data-id',$(this).attr('name')).appendTo($tz_field_value);
                    }else {
                        var $tz_item_child = $("<div></div>").addClass('tz_item_child').appendTo($tz_multipurpose_item);
                        var $tz_field_name = $('<div>'+$(this).attr('field-name')+'</div>').addClass('tz_field_name').attr('data-id',$(this).attr('name')).appendTo($tz_item_child);
                        var $tz_field_value = $("<div>"+$(this).val()+"</div>").addClass('tz_field_value').appendTo($tz_item_child);
                        var $tz_hiddenfield_value = $('<input type="hidden" value="'+$(this).val()+'" />').addClass('tz_fieldvalue data-id'+$(this).attr('name')).attr('data-id',$(this).attr('name')).appendTo($tz_field_value);
                    }
                });
            }

            $('.delete').click(function(){
                var $this   =   jQuery(this);
                functiondelete($this);
            });

            $('.edit').click(function(){
                var $this   = jQuery(this);
                functionedit($this);
            });

        });

    });

//    $('.btn_data').click(function() {
//
//        var $field_name =   $('#tz_multi_hidden').attr('name')
//        $('#tz-table-multi .tz_multipurpose_item').each(function (i,el){
//            $(this).find('.tz_fieldvalue').attr('name',$field_name+'['+i+']');
//            $(this).find('.tz_group_id').attr('name',$field_name+'['+i+']'+'[group]');
//        });
//        $('#tz-table-multi .tz_fieldvalue').each(function (i, el) {
//            var $name   =   $(this).attr('name');
//            var $dataid   =   $(this).attr('data-id');
//
//            $(this).attr('name',$(this).attr('name')+'['+$(this).attr('data-id')+']');
//        });
//        var $value_sgf  = $('#jform_params_selectfilegroup').val();
//        $('#selectfilegroup_hidden').val($value_sgf);
//
//    })

    document.adminForm.onsubmit = function(){
        var $field_name =   $('#tz_multi_hidden').attr('name')
        $('#tz-table-multi .tz_multipurpose_item').each(function (i,el){
            $(this).find('.tz_fieldvalue').attr('name',$field_name+'['+i+']');
            $(this).find('.tz_group_id').attr('name',$field_name+'['+i+']'+'[group]');
        });
        $('#tz-table-multi .tz_fieldvalue').each(function (i, el) {
            var $name   =   $(this).attr('name');
            var $dataid   =   $(this).attr('data-id');
            $(this).attr('name',$(this).attr('name')+'['+$(this).attr('data-id')+']');
        });
        // Carousel
        var $value_lf_cr  = $('#jform_paramslink_img_cr').val();
        $('#link_img_cr_hidden').val($value_lf_cr);
        // Flex slider
        var $value_lf_flex  = $('#jform_paramslink_img_flex').val();
        $('#link_img_flex_hidden').val($value_lf_flex);
        var $value_sgf_flex = $('#jform_params_flex_sgf').val();
        $('#flex_sgf_hidden').val($value_sgf_flex);
        // Isotope
        var $value_slf_is  = $('#jform_params_select_filter_is').val(); // select field for filter isotope
        $('#select_filter_is_hidden').val($value_slf_is);
        // Progress Bars
        var $value_s_pb  = $('#jform_params_selectpb').val(); // select field for filter isotope
        $('#selectpb_hidden').val($value_s_pb);
        // Pricing Table
        var $value_prt_sgf  = $('#jform_params_prt_sgf_title').val(); // select field for title
        $('#prt_sgf_title_hidden').val($value_prt_sgf);
        var $value_sgf_pri  = $('#jform_params_prt_sgf_pri').val(); // select field for price
        $('#prt_sgf_pri_hidden').val($value_sgf_pri);
        var $value_prt_sgf_link  = $('#jform_params_prt_sgf_link').val(); // select field for link
        $('#prt_sgf_link_hidden').val($value_prt_sgf_link);
        // Our Team
        var $value_us_sgf_social  = $('#jform_params_ut_social').val(); // select field for link
        $('#ut_social_hidden').val($value_us_sgf_social);
        var $value_us_sgf_name  = $('#jform_params_ut_name').val(); // select field for name
        $('#ut_name_hidden').val($value_us_sgf_name);
        var $value_us_sgf_desc  = $('#jform_params_ut_desc').val(); // select field for name
        $('#ut_desc_hidden').val($value_us_sgf_desc);
        // Our Team Carousel
        var $value_us_sgf_scort  = $('#jform_params_ut_social_cort').val(); // select field for link
        $('#ut_social_cort_hidden').val($value_us_sgf_scort);
        var $value_us_sgf_ncort  = $('#jform_params_ut_name_cort').val(); // select field for name
        $('#ut_name_cort_hidden').val($value_us_sgf_ncort);
        var $value_us_sgf_dcort  = $('#jform_params_ut_desc_cort').val(); // select field for name
        $('#ut_desc_cort_hidden').val($value_us_sgf_dcort);
        // Service
        var $value_lf_sv  = $('#jform_paramslink_img_sv').val(); // select link
        $('#link_img_sv_hidden').val($value_lf_sv);
        var $value_sv_sgf_font  = $('#jform_params_sv_fontas').val(); // select field for font
        $('#sv_fontas_hidden').val($value_sv_sgf_font);
        var $value_sv_sgf_logo  = $('#jform_params_sv_logo').val(); // select field for logo
        $('#sv_logo_hidden').val($value_sv_sgf_logo);
        var $value_sv_sgf_title  = $('#jform_params_sv_title').val(); // select field for title
        $('#sv_title_hidden').val($value_sv_sgf_title);
        var $value_sv_sgf_desc  = $('#jform_params_sv_desc').val(); // select field for desc
        $('#sv_desc_hidden').val($value_sv_sgf_desc);
        // Service carousel
        var $value_lf_svcr  = $('#jform_paramslink_img_svcr').val(); // select link
        $('#link_img_svcr_hidden').val($value_lf_svcr);
        var $value_svcr_sgf_font  = $('#jform_params_sv_fontas_cr').val(); // select field for font
        $('#sv_fontas_cr_hidden').val($value_svcr_sgf_font);
        var $value_svcr_sgf_logo  = $('#jform_params_sv_logo_cr').val(); // select field for logo
        $('#sv_logo_cr_hidden').val($value_svcr_sgf_logo);
        var $value_crsv_sgf_title  = $('#jform_params_sv_title_cr').val(); // select field for title
        $('#sv_title_cr_hidden').val($value_crsv_sgf_title);
        var $value_svcr_sgf_desc  = $('#jform_params_sv_desc_cr').val(); // select field for desc
        $('#sv_desc_cr_hidden').val($value_svcr_sgf_desc);
        $('#tz_multi_hidden').remove();
    };
});
