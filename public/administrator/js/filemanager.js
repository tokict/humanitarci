
$(document).ready(function () {
    $('#fileModal').on('show.bs.modal', function (event) {
        modal = $(this);
        invoker = $(event.relatedTarget);
        input = $(invoker).prev('input');
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
            //Opening of modal
            $('#fileModal').find('.modal-body').html(response);
            filemanager.bindEvents();


        });
    },
    bindEvents: function () {
        $("#uploadButton").click(function () {
                $('#fileUpload').trigger("click");
            }
        );

        //Check what mode to activate, file select or not
        if ($(invoker).hasClass("fileSelect")) {
            $('#selectDoneButton').removeClass('hidden');
            $('#selectDoneButton').click(function () {
                filemanager.selectImages()
            });

            //Selecting and saving files to input fields
            var tmpSel = input.val().split(",");
            if (tmpSel.length) {
                $.each(tmpSel, function (index, value) {
                    $("#img_" + value).addClass('file-active');
                })
            }

            $('.file a').click(function () {
                var id = $(this).parent().attr('id').split("_")[1];

                if (selectedFiles.indexOf(id) == -1) {
                    selectedFiles.push(id);
                    $(this).parent().addClass('file-active');
                } else {
                    selectedFiles.splice(selectedFiles.indexOf(id, 1));
                    $(this).parent().removeClass('file-active');
                }
            });
        }

        //We need to reinstantiate it again because it replaces the original element and we lose all bindings
        $('#fileUpload').fileupload(fileUploadSetup);


        $("#sortFiles").change(function(){filemanager.sort($(this).find(":selected").text())});

        //Bind to pagination links
        $(".pagination a").click(function(event){
            event.preventDefault();

            var clickedPage = $(this).text();
            var search = $("#searchFiles").val();
            var folder = $('.folder-name.active').text().trim();
            var sort = $("#sortFiles").find(":selected").val();
            if(clickedPage == "«"){
                clickedPage = 1+"";
            }
            if(clickedPage == "»"){
                clickedPage = paginator.lastPage+"";
            }

            filemanager.call('/admin/file/open/' + folder, {sort: sort, search: search, filterType: filterType, clickedPage:clickedPage}, function (response) {

                $('#fileModal').find('.modal-body').html(response.responseText);
                filemanager.bindEvents();
               });

        });

        $(".file-control").click(function(event){
            event.preventDefault();
            var filter = $(this).data('filter');

            filemanager.filter(filter);
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
        var title = img.find(".file_title").val();
        var description = img.find(".file_description").val();

        $.ajax({
            url: '/admin/file/edit/' + id,
            type: "post",
            dataType: 'json',
            data: {
                title: title,
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
    },
    selectImages: function () {
        var join = selectedFiles.join(',');
        input.val(join);

        $('.file').removeClass('file-active');
        $('.selectDoneButton').addClass("hidden");
        selectedFiles = [];
        $('#fileModal').modal('toggle');

    },
    filter: function (type) {
        filterType = type;

        var sort = $("#sortFiles").find(":selected").val();
        var search = $("#searchFiles").val();
        var folder = $('.folder-name.active').text().trim();

        this.call('/admin/file/open/' + folder, {sort: sort, search: search, filterType: type}, function (response) {
            $('#fileModal').find('.modal-body').html(response.responseText);
            filemanager.bindEvents();
        });

    },
    sort: function (value) {

        var search = $("#searchFiles").val();
        var folder = $('.folder-name.active').text().trim();

        this.call('/admin/file/open/' + folder, {sort: value, search: search, filterType: filterType}, function (response) {
            $('#fileModal').find('.modal-body').html(response);
            filemanager.bindEvents();
        });

    },
    search: function () {
        var search = $("#searchFiles").val();
        var folder = $('.folder-name.active').text().trim();
        var sort = $("#sortFiles").find(":selected").val();

        this.call('/admin/file/open/' + folder, {sort: sort, search: search, filterType: filterType}, function (response) {
            $('#fileModal').find('.modal-body').html(response);
            $("#searchFiles").val(search);
            filemanager.bindEvents();
        });
    },
    call: function (url, params, callback) {
        //Is it from paginator clicking?
        if(params.hasOwnProperty("page") == false){
            params.page = params.clickedPage;
            delete params.clickedPage;
        }else{
            params.page = page;
        }

         $.ajax({
                url: url,
                data: params,
                dataType: 'json'

            }
        ).always(function (response) {
            callback(response);

        });

    }
}


