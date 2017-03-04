$(document).ready(function () {
    $("#select-destacados").change(function () {
        var array = $('#select-destacados').val();
        var arr = array.split('_');
        var idSeccion = arr[0];
        var url = arr[1];
        if (idSeccion > 0) {
            $.ajax({
                url: url + 'admin/loadProductosSeccion',
                type: 'post',
                dataType: 'json',
                data: {
                    seccion: idSeccion
                },
                success: function (data) {
                    $('#productos').css('display', 'block');
                    $('#displayTable').html('');
                    $('#displayTable').html(data);
                }
            }); //END AJAX
        }
    });
});