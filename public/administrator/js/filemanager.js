var modal;
$(document).ready(function(){
    $('#fileModal').on('show.bs.modal', function (event) {
         modal = $(this);
        filemanager.openFolder('campaigns');

    })


});

var filemanager = {
    openFolder : function(folder){
        console.log('Opening folder: '+folder);
        $.ajax({
            url: '/admin/file/open/'+folder
        }).success(function(response){

            modal.find('.modal-body').html(response)
            $("#uploadButton").click(function() {
                    $('#fileUpload').trigger('click');
                }
            );

            $('#fileUpload').fileupload({
                dataType: 'json',
                singleFileUploads: true,
                limitMultiFileUploadSize: 1000000,
                sequentialUploads: true,
                progressInterval: 1000,
                add: function (e, data) {
                    data.context = $('<p/>').text('Uploading...').appendTo($("#uploadButton"));
                    data.submit();
                },
                progressall: function (e, data) {
                    var progress = parseInt(data.loaded / data.total * 100, 10);
                    $('#progress .bar').css(
                        'width',
                        progress + '%'
                    );
                },
                done: function (e, data) {
                    data.context.text('Upload finished.');
                }
            });
        });
    }
}