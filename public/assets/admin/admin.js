$( document ).ready(function() {
    $('.find-file').on('click', function() {

        var dataFor = $(this).attr('data-for');
        console.log(dataFor);

        $('<div id="editor" />').dialogelfinder({
            url : '/admin/filemanager/connector',
            getFileCallback: function(file) {
                $('#editor').dialogelfinder('close');
                //$('#editor').closest('.elfinder').val(file.path);
                var filePath = file.path;
                console.log(filePath);
                var filePath = '/'+filePath.replace(/\\/g,'/');
                $(dataFor).val(filePath);
                console.log(filePath);
            }
        });

    });
});