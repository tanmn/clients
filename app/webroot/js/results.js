$(function() {
    var jxhr = null;

    function getWinners(id, options){
        var target_tab = $('#' + id),
            scroller = target_tab.find('.scroller').getNiceScroll(),
            table1 = target_tab.find('table:eq(0) tbody'),
            table2 = target_tab.find('table:eq(1) tbody');

        if (!target_tab.length) return;

        if (jxhr) jxhr.abort();

        scroller.resize();

        jxhr = $.post(APIS + 'getTopUsers', $.extend({
            type: id
        }, options || {}), function(json) {
            table1.empty();
            table2.empty();

            if (!(json && json.length)) {
                scroller.resize();
                return false;
            }

            for (var i = 0, l = json.length; i < l; i++) {
                var pos = i % 2 == 0 ? table1 : table2,
                    className = i < 10 ? 'winner' : '',
                    data = json[i];

                pos.append([
                    '<tr class="' + className + '">',
                    '<td>' + (i + 1) + '</td>',
                    '<td>' + (data.MasterPoint.number || 'No Name') + '</td>',
                    '<td>' + (data.MasterPoint.points || 0) + '</td>',
                    '</tr>'
                ].join(' '));

                pos = null;
            }

            setTimeout(function() {
                scroller.resize();
            }, 50);
        }, 'json');
    }

    $('.scroller').niceScroll({
        autohidemode: true,
        cursorcolor: '#aae1f7',
        background: '#472d71',
        horizrailenabled: false
    });

    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
        var tab = $(e.target),
            id = tab.attr('href').replace('#', '');

        getWinners(id);
    });

    $('a[data-toggle="tab"]:eq(0)').click();

    $('#btnFilter').click(function(e){
        var target_date = $('#txtFilterDate').val();

        $('#txtDate').text(target_date);

        getWinners('daily', {date: target_date});
        return false;
    });
});