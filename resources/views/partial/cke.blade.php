<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
    $(document).ready(function() {
        $('#editor1').summernote({
            height: 500,
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript','fontname']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph','style']],
                ['Insert', ['picture', 'table']],
                ['height', ['height']]
            ]
        });
    });
</script>
<style>
    .note-group-image-url {
        display: none!important;
    }
    .note-modal-content{
        min-height: 250px;
    }
    .note-modal-footer .note-btn{
        background-color: #6b4bf2;
    }
</style>
