$(function(){
    'use strict';
    // Switch Between Login & Signup
    $('.login-page h1 span').click(function () {
        $(this).addClass('selected').siblings().removeClass('selected');
        $('.login-page form').hide();
        $('.' + $(this).data('class')).fadeIn(100);
    });
    // Hide Placeholder On Form Focus
    $('[placeholder]').focus(function () {
        $(this).attr('data-text', $(this).attr('placeholder'));
        $(this).attr('placeholder', '');
    }).blur(function () {
        $(this).attr('placeholder', $(this).attr('data-text'));
    });
    // Confirmation Message On Button
    $('.confirm').click(function () {
        return confirm('Are You Sure?');
    });
    $('.live').keyup(function () {
        $($(this).data('class')).text($(this).val());
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
});
