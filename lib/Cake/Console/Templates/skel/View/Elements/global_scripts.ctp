<script>
    /* ----- start global google analytics ----- */
    var _gaq = [
        ['_setAccount', 'UA-XXXXX-X'],
        ['_trackPageview']
    ];
    (function(d, t) {
        var g = d.createElement(t),
            s = d.getElementsByTagName(t)[0];
        g.src = '//www.google-analytics.com/ga.js';
        s.parentNode.insertBefore(g, s)
    }(document, 'script'));
    /* ----- start global google analytics ----- */


    /* ----- start facebook page autosize ----- */
    window.fbAsyncInit = function() {
        FB.init({
            appId: '<?php echo $APPID ?>',
            cookie: true,
            xfbml: true,
            oauth: true
        });

        FB.Canvas.setAutoGrow(true);
    };

    (function() {
        var e = document.createElement('script');
        e.async = true;
        e.src = document.location.protocol +
            '//connect.facebook.net/en_US/all.js';
        document.getElementById('fb-root').appendChild(e);
    }());
    /* ----- end facebook page autosize ----- */
</script>