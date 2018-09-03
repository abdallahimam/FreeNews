$(function(){
    
    'use strict';

    $('[placeholder]').focus(function(){
        $(this).attr('data-text', $(this).attr('placeholder'));
        $(this).attr('placeholder', '');
    }).blur(function(){
        $(this).attr('placeholder', $(this).attr('data-text'));
    });

    $('input').each(function(){
        if ($(this).attr('required') == 'required') {
            $(this).after('<span class="astric">*</span>');
        }
    });
    $('textarea').each(function(){
        if ($(this).attr('required') == 'required') {
            $(this).after('<span class="astric">*</span>');
        }
        $(this).attr('rows', 'auto');
        $(this).css('height', 'auto');
        $(this).height(this.scrollHeight - 1);
    });
    $('textarea').on('change keydown keyup paste cut', function(){
        $(this).attr('rows', 'auto');
        $(this).css('height', 'auto');
        $(this).height(this.scrollHeight - 1);
    });
    
    $('select').each(function(){
        if ($(this).attr('required') == 'required') {
            $(this).after('<span class="astric-select">*</span>');
        }
    });

    $('.confirm').click(function(){
        return confirm('Are you sure?');
    });

    $('.main-category .main-card .edit-card h5').click(function(){
        $(this).next('.full-view').fadeToggle("slow", "linear");
    });

    $('.main-category .main-card .option .view span').click(function() {
        $(this).addClass('active').siblings('span').removeClass('active');
        if ($(this).data('view') == 'full') {
            $('.main-category .main-card .edit-card .full-view').fadeIn();
        } else {
            $('.main-category .main-card .edit-card .full-view').fadeOut();
        }
    });

    $('form').submit(function(event) {

    });

    $('input.edit-comment:button').click(function (event1) {
        var value = $(this).prev('div').children('textarea').val();
        $(this).prev('div').children('textarea').attr('old', value);
        if ($(this).attr('value') == 'Edit') {
            $('.textarea-g').each(function(){
                if ($(this).attr('current') == 'c') {
                    $(this).attr('readonly', 'readonly');
                    $(this).val($(this).attr('old'));
                    $(this).removeAttr('old');
                    $(this).parent('div').next('input').attr('type', 'button').attr('value', 'Edit');
                }
            });
            $(this).prev('div').children('textarea').removeAttr('readonly').attr('current', 'c');
            $(this).attr('value', 'Update');
            $(this).click(function(event2){
                if ($(this).attr('value') == 'Update') {
                    $(this).attr('type', 'submit');
                }
            });
            event1.preventDefault();
        }
    });
});
