
jQuery(function($){
//    var $a = $('.tz_multi_child.Job.isotop_filter .tz_multi_list span').text();

    $('#tz-table-multi .tz_multipurpose_item').each(function (i,el){
        $(this).find('.tz_fieldvalue').attr('name',$field_name+'['+i+']');
        $(this).find('.tz_group_id').attr('name',$field_name+'['+i+']'+'[group]');
    });
    $('.TzMultipurpose.isotope .tz_multi_item ').each(function (i,el){
        var $value = $(this).find('span').text();
//        alert($value);
    });
});