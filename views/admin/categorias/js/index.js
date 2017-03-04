$(document).ready(function () {
    $("#padre").change(function () {
        var array = $(this).val();
        var arr = array.split('_');
        var url = arr[0];
        var idPadre = arr[1];
        if (url != ''){
            $.ajax({
                url: url + 'admin/loadHijos',
                type: 'post',
                dataType: 'json',
                data: {
                    padre: idPadre
                },
                success: function (data) {
                    $('#divHijos').css('display', 'block');
                    $('#tablaHijos').html('');
                    $('#tablaHijos').html(data);
                }
            }); //END AJAX
        }
    });
});

