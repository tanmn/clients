$(function() {
    var is_open = false;

    $('#Results').hide();
    $('#ResultHolder').hide();

    function isPhone(phone) {
        return (/^(\+84|0)\d{9,10}$/).test(phone);
    }

    function getHotline(phone) {
        $.post(APIS + 'getHotline', {
            'phone': phone
        }, function(json) {
            if (json && 'MasterHotline' in json) {
                $('#txtHotline').addClass('active').val(json.MasterHotline.hotline);
            }
        }, 'json').always(function() {
            $('#txtPhone').prop('disabled', false);
            $('#btnGetHotline').prop('disabled', false);
        });
    }

    function getStats() {
        $('#ResultHolder .result-list').addClass('loading').find('> li').show().css('visibility', 'hidden');

        $.post(APIS + 'getStats', {}, function(json) {
            if (!json) return fail();

            $('#ResultHolder .result-list > li').hide();

            var i, l, element, has_data = false;

            if ('groups' in json && json.groups.length) {
                var TopGroups = $('#TopGroups > li');

                for (i = 0, l = json.groups.length; i < l; i++) {
                    element = TopGroups.eq(i);
                    element.find('.name').text(json.groups[i].MasterGroup.group_name || 'No name');
                    element.find('.points').text(json.groups[i].MasterPoint.points || 0);
                    element.css({
                        'visibility': ''
                    }).hide().fadeIn().show();

                    has_data = true;
                }
            }

            if ('users' in json && json.users.length) {
                var TopUsers = $('#TopUsers > li');

                for (i = 0, l = json.users.length; i < l; i++) {
                    element = TopUsers.eq(i);
                    element.find('.name').text(json.users[i].MasterPoint.number || 'No name');
                    element.find('.points').text(json.users[i].MasterPoint.points || 0);
                    element.css({
                        'visibility': ''
                    }).hide().fadeIn().show();

                    has_data = true;
                }
            }

            if (!has_data) {
                fail();
            }

        }, 'json').fail(fail).always(function() {
            $('#ResultHolder .result-list').removeClass('loading');
        });

        function fail() {
            $('#ResultHolder').slideUp();
        }
    }

    function getPoints(phone) {
        $('#txtPoints').val('...');

        $.post(APIS + 'getUserPoints', {
            'phone': phone
        }, function(json) {
            if (!json) return fail();

            $('#txtPoints').removeClass('error').val(json);
        }, 'json').fail(fail).always(function() {
            $('#txtTargetPhone').prop('disabled', false);
            $('#btnGetPoints').prop('disabled', false);
        });

        function fail() {
            $('#txtPoints').addClass('error').val('0');
        }
    }

    $('#btnGetHotline').click(function(e) {
        var phone = $.trim($('#txtPhone').val());

        if (!phone) {
            alert('Vui lòng nhập số điện thoại của bạn.');
            $('#txtPhone').focus();
            return false;
        }

        if (!isPhone(phone)) {
            alert('Số điện thoại bạn nhập không hợp lệ.');
            $('#txtPhone').focus();
            return false;
        }

        $('#txtHotline').removeClass('active');
        $('#txtPhone').prop('disabled', true);
        $('#btnGetHotline').prop('disabled', true);

        getHotline(phone);

        return false;
    });

    $('#btnGetPoints').click(function(e) {
        var phone = $.trim($('#txtTargetPhone').val());

        if (!phone) {
            alert('Vui lòng nhập số điện thoại của bạn.');
            $('#txtTargetPhone').focus();
            return false;
        }

        if (!isPhone(phone)) {
            alert('Số điện thoại bạn nhập không hợp lệ.');
            $('#txtTargetPhone').focus();
            return false;
        }

        $('#txtTargetPhone').prop('disabled', true);
        $('#btnGetPoints').prop('disabled', true);

        getPoints(phone);

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
        if (is_open) {
            $('#ResultHolder').slideUp();;
            $('#Results').fadeOut();
        } else {
            $('#Results').fadeIn().show();
            $('#ResultHolder').slideDown().show();

            getStats();
        }

        is_open = !is_open;
        return false;
    });

    $('#btnQrCode').attr('rel', 'gallery').fancybox({
        padding: 0,
        autoSize: true,
        closeClick: false,
        openEffect: 'none',
        closeEffect: 'none',
    });
});
