(function($){
    $.validator.setDefaults({
        errorClass: 'invalid',
        errorPlacement: function (error, element) {
            element.next("label").attr("data-error", error.contents().text());
            if($('#'+$(element).attr('id')).val() == '')
            {
                $('label[for="'+$(element).attr('id')+'"]').addClass("active");
            }
        }
    });
})(jQuery);