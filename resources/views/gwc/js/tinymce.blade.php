<script src="{{url('admin_assets/assets/plugins/custom/tinymce/tinymce.min.js')}}" type="text/javascript"></script>

<script>
    jQuery(document).ready(function() {
        tinymce.init({
            selector: '.kt-tinymce-4',
            valid_children : "+body[style|script]",
            extended_valid_elements : "script[src|async|defer|type|charset]",
            plugins: 'code visualblocks print preview powerpaste searchreplace autolink directionality advcode visualblocks visualchars fullscreen image link media mediaembed template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount tinymcespellchecker a11ychecker imagetools textpattern help formatpainter permanentpen pageembed tinycomments mentions linkchecker',
            toolbar: 'code formatselect | bold italic strikethrough forecolor backcolor permanentpen formatpainter | link image media pageembed | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent | removeformat | addcomment',
            image_advtab: true,
            content_css: [
            ],
            importcss_append: true,
            height: 400,
            template_cdate_format: '[CDATE: %m/%d/%Y : %H:%M:%S]',
            template_mdate_format: '[MDATE: %m/%d/%Y : %H:%M:%S]',
            image_caption: true,
            spellchecker_dialog: true,
            spellchecker_whitelist: [],
            tinycomments_mode: 'embedded',
            content_style: ''
        });
        
    });
</script>