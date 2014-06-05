// JavaScript Document
$(function() {
	$(document).ready(function() {
        $("#showtop").click(function(){
            $("#dstop").toggle();
        });

        $(".dropdown-toggle").click(function(){
            $(".dropdown-menu").toggle();
        });
        $("#submit").click(function () {
            $(".qrcode").show();
        });
        $("a.youtube").YouTubePopup({ autoplay: 0 });


    });
    $('.scrollrule').niceScroll({
        autohidemode: false,
        cursorcolor: '#aae1f7',
        background: '#472d71',
        horizrailenabled: false,
        railpadding: {
            top: '30px',
            right: 0,
            left: 0,
            bottom: '30px'
        }
    });


});
