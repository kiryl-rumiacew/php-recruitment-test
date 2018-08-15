$(function() {

    $(".linkCheckbox").change(function() {
        $.post('varnish_ajax', {
            varnish: $(this).data('varnish'),
            website: $(this).data('website'),
            enable: this.checked,
        }, function (response) {

        }, 'json');
    });

});
