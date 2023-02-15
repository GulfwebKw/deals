<script src="{{ asset('/site_assets/js/popper.js') }}"></script>
<script src="{{ asset('/site_assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('/site_assets/js/ajax-mail.js') }}"></script>
<script src="{{ asset('/site_assets/js/plugins.js') }}"></script>
<script src="{{ asset('/site_assets/js/main.js') }}"></script>

@if(!empty($settings->google_analytics))
    {!!$settings->google_analytics!!}
@endif

<script>
    (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r; i[r] = i[r] || function () {
            (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date(); a = s.createElement(o),
            m = s.getElementsByTagName(o)[0]; a.async = 1; a.src = g; m.parentNode.insertBefore(a, m)
    })(window, document, 'script', '../www.google-analytics.com/analytics.js', 'ga');

    ga('create', 'UA-49990145-1', 'auto');
    ga('send', 'pageview');
</script>