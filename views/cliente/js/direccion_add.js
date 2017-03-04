$(document).ready(function () {
    $("#id_departamento").change(function () {
        var id = $("#id_departamento").val();
        $('#id_ciudad').html('');
        $.ajax({
            method: "POST",
            url: "http://saleosale.com.py/cliente/getCities",
            data: {id: id}
        })
                .done(function (msg) {
                    $('#id_ciudad').html(msg);
                });
    });
});
