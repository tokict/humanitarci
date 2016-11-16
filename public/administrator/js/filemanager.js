var modal;
var dir;
$(document).ready(function () {
    $('#fileModal').on('show.bs.modal', function (event) {
        modal = $(this);

        filemanager.openFolder('campaigns');

    })
});
var fileUploadSetup = {
    dataType: 'json',
    singleFileUploads: false,
    limitMultiFileUploadSize: 1000000,
    sequentialUploads: false,
    progressInterval: 500,
    add: function (e, data) {
        data.submit();
    },
    progressall: function (e, data) {
        var progress = parseInt(data.loaded / data.total * 100, 10);
        $('#progress .progress-bar').css(
            'width',
            progress + '%'
        );
        $('#progress .sr-only').html(
            progress + '% complete'
        );
    },
    done: function (e, data) {
        $.ajax({
            url: '/admin/file/open/' + dir
        }).success(function (response) {
            modal.find('.modal-body').html(response);
            //Rebind events
            $("#uploadButton").click(function () {
                    $('#fileUpload').trigger("click");
                }
            );
            $('#fileUpload').fileupload(fileUploadSetup);
        });

    }
};

var filemanager = {
    openFolder: function (folder) {
        dir = folder;
        $.ajax({
            url: '/admin/file/open/' + folder
        }).success(function (response) {


            modal.find('.modal-body').html(response)
            $("#uploadButton").click(function () {
                $('#fileUpload').trigger("click");
                }
            );


            $('#fileUpload').fileupload(fileUploadSetup);
        });
    },
    deleteImage: function (id) {

        $.ajax({
            url: '/admin/file/delete/' + id
        }).success(function (response) {
            if (response.success) {
                $("#img_" + id).parent().remove();
            } else {
                console.log("Error deleting file");
            }
        });
    },
    editImage: function (id) {

        var img = $("#img_" + id);

        img.find(".file_title_current").addClass('hidden');
        img.find(".file_description_current").addClass('hidden');
        img.find(".controls1").addClass('hidden');

        img.find(".file_title").removeClass('hidden');
        img.find(".file_description").removeClass('hidden');
        img.find(".controls2").removeClass('hidden');

    },
    cancelEditImage: function (id) {
        var img = $("#img_" + id);

        img.find(".file_title_current").removeClass('hidden');
        img.find(".file_description_current").removeClass('hidden');
        img.find(".controls1").removeClass('hidden');

        img.find(".file_title").addClass('hidden');
        img.find(".file_description").addClass('hidden');
        img.find(".controls2").addClass('hidden');

    },
    saveEditImage: function (id) {
        var img = $("#img_" + id);
        var title =  img.find(".file_title").val();
        var description =  img.find(".file_description").val();

        $.ajax({
            url: '/admin/file/edit/' + id,
            type: "post",
            dataType: 'json',
            data: {
                title : title,
                description: description
            }
        }).success(function (response) {
            if (response.success) {
                img.find(".file_title_current").html(title);
                img.find(".file_description_current").html(description);

                img.find(".file_title_current").removeClass('hidden');
                img.find(".file_description_current").removeClass('hidden');
                img.find(".controls1").removeClass('hidden');

                img.find(".file_title").addClass('hidden');
                img.find(".file_description").addClass('hidden');
                img.find(".controls2").addClass('hidden');

            } else {
                console.log("Error editing file");
            }
        });
    }
}


