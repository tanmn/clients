$(function() {
    var jxhr = null,
        last_scroll = null;

    function getWinners(id, options) {
        var target_tab = $('#' + id),
            scroll_holder = target_tab.find('.scroller'),
            scroller = scroll_holder.getNiceScroll(),
            table1 = target_tab.find('table:eq(0) tbody'),
            table2 = target_tab.find('table:eq(1) tbody'),
            topUser = target_tab.find('.winner-thumb.user'),
            topGroup = target_tab.find('.winner-thumb.group'),
            txt_title, txt_desc;

        if (!target_tab.length) return;

        if (jxhr) jxhr.abort();

        if (last_scroll) {
            last_scroll.resize();
        }

        last_scroll = scroller;

        jxhr = $.post(APIS + 'getTopUsers', $.extend({
            type: id
        }, options || {}), function(json) {
            table1.empty();
            table2.empty();
            topUser.hide();
            topGroup.hide();
            scroll_holder.hide();

            if (id == 'daily') {
                $('#txtDate').text(options.date);
            }

            if (!json) {
                scroller.resize();
                return false;
            }

            if ('user' in json) {
                if (json.user.MasterUser.avatar) {
                    topUser.find('img').attr('src', json.user.MasterUser.avatar).show();
                } else {
                    topUser.find('img').hide();
                }

                txt_title = json.user.MasterUser.name || json.user.MasterPoint.number;
                txt_desc = 'Số điện thoại: ' + json.user.MasterPoint.number + '<br />';
                txt_desc += 'Số điểm: ' + json.user.MasterPoint.points + '<br />';

                topUser.find('.title').text(txt_title);
                topUser.find('.description').html(txt_desc);
                topUser.fadeIn().show();
            }

            if ('group' in json) {
                txt_title = json.group.MasterGroup.group_name || 'Group';
                txt_desc = 'Số thành viên: ' + (json.group_members.length || 0) + '<br />';
                txt_desc += 'Số điểm: ' + json.group.MasterPoint.points + '<br />';

                topGroup.find('.title').text(txt_title);
                topGroup.find('.description').html(txt_desc);
                topGroup.fadeIn().show();
            }

            var user_list = (id == 'daily' ? json.users : json.group_members);

            target_tab.find('span.count').text(user_list.length);

            for (var i = 0, l = user_list.length; i < l; i++) {
                var pos = i % 2 == 0 ? table1 : table2,
                    className = i < 10 ? 'winner' : '',
                    data = user_list[i];

                pos.append([
                    '<tr class="' + className + '">',
                    '<td>' + (i + 1) + '</td>',
                    '<td>' + (data.MasterPoint.number || 'No Name') + '</td>',
                    '<td>' + (data.MasterPoint.points || 0) + '</td>',
                    '</tr>'
                ].join(' '));

                pos = null;
            }

            if (user_list.length) {
                scroll_holder.show();
            }

            setTimeout(function() {
                scroller.resize();
            }, 50);
        }, 'json');
    }

    $('.scroller').niceScroll({
        autohidemode: false,
        cursorcolor: '#aae1f7',
        background: '#472d71',
        horizrailenabled: false
    });

    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
        var tab = $(e.target),
            id = tab.attr('href').replace('#', '');

        if (id == 'daily') {
            $('#btnFilter').click();
        } else {
            getWinners(id);
        }
    });

    $('#btnFilter').click(function(e) {
        var target_date = $('#txtFilterDate').val();

        getWinners('daily', {
            date: target_date
        });
        return false;
    });

    $('a[data-toggle="tab"]:eq(0)').click();
});