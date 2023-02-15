<script type="text/javascript">
    $(document).ready(function () {
        $('#q').keyup(function () {
            // Search text
            var text = $(this).val();
            // Hide all content class element
            $('.search-body').hide();
            // Search
            $('.search-body').each(function () {

                if ($(this).text().indexOf("" + text + "") != -1) {
                    $(this).closest('.search-body').show();
                }
            });
        });
    });
</script>