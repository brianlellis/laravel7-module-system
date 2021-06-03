tinymce.remove('textarea.richTextBox');
tinymce.init({
    selector: 'textarea.richTextBox'
    , plugins: 'print preview paste importcss searchreplace autolink directionality code visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons'
    , menubar: false
    , toolbar: 'undo redo | bold italic underline strikethrough | fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent | table | numlist bullist | forecolor backcolor removeformat | charmap emoticons | link anchor | ltr rtl'
    , toolbar_sticky: true
    , image_advtab: true
    , content_css: '//www.tiny.cloud/css/codepen.min.css'
    , importcss_append: true
    , height: 400
    , file_browser_callback: function(field_name, url, type, win) {
        $('#upload_file').trigger('click');
    }
    , height: 600
    , image_caption: true
    , quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable'
    , noneditable_noneditable_class: "mceNonEditable"
    , toolbar_mode: 'sliding'
    , init_instance_callback: function(editor) {
        if (typeof tinymce_init_callback !== "undefined") {
            tinymce_init_callback(editor);
        }
    }
    , setup: function(editor) {
        if (typeof tinymce_setup_callback !== "undefined") {
            tinymce_setup_callback(editor);
        }
    }
});