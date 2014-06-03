$(function() {
    function getHotline(phone) {
        $.post(APIS + 'getHotline', {
            'phone': phone
        }, function(json) {
            if (json && 'MasterHotline' in json) {
                $('#txtHotline').addClass('active').val(json.MasterHotline.hotline);
            }
        }, 'json').always(function() {
            $('#txtPhone').prop('disabled', false);
        });
    }

    $('#btnGetHotline').click(function(e) {
        var phone = $.trim($('#txtPhone').val());

        if (!phone) {
            alert('Vui lòng nhập số điện thoại của bạn.');
            return false;
        }

        $('#txtHotline').removeClass('active');
        $('#txtPhone').prop('disabled', true);

        getHotline(phone);

        return false;
    });

    $('#openYoutube').fancybox({
        maxWidth: 800,
        maxHeight: 600,
        fitToView: true,
        width: '70%',
        height: '70%',
        autoSize: true,
        closeClick: false,
        openEffect: 'none',
        closeEffect: 'none',
        helpers: {
            media: {}
        },
        wrapCSS: {
            'padding': '0'
        }
    });

    $('#openResults').click(function(e) {

        return false;
    });
});
