@inject('form', 'scaffold.form')
@inject('config', 'scaffold.config')

<script>
    var Editors = {};
    Editors.init = {
        ckeditor : function() {
            $('[data-editor="ckeditor"]').ckeditor();
        },
        tinymce: function() {
            tinymce.init({
                selector: 'textarea[data-editor="tinymce"]',
                plugins: [
                    "advlist autolink lists link image charmap print preview anchor",
                    "searchreplace visualblocks code fullscreen",
                    "insertdatetime media table contextmenu paste" // @excluded: "moxiemanager"
                ],
                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
            });
        }
    };
</script>

@if(in_array('ckeditor', $editors = $form->getEditors()))
    <script type="text/javascript" src="{{ asset($config->get('assets_path') . '/plugins/ckeditor/ckeditor.js') }}"></script>
    <script type="text/javascript" src="{{ asset($config->get('assets_path') . '/plugins/ckeditor/adapters/jquery.js') }}"></script>
    <script>Editors.init.ckeditor();</script>
@endif

@if (in_array('tinymce', $editors))
    <script type="text/javascript" src="{{ asset($config->get('assets_path') . '/plugins/tinymce/tinymce.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset($config->get('assets_path') . '/plugins/tinymce/jquery.tinymce.min.js') }}"></script>
    <script>Editors.init.tinymce();</script>
@endif
