$('#fecha_inicio,#fecha_fin').datepicker({
    format: 'dd-mm-yyyy'
});

CKEDITOR.replace('descripcion_corta', {
    toolbar: 'Basic', /* this does the magic */
    uiColor: '#f7f7f7'
});
CKEDITOR.replace('contenido', {
    toolbar: 'Basic', /* this does the magic */
    uiColor: '#f7f7f7'
});
//AGREGAR MAS IMAGENES
$('.add_more').click(function (e) {
    e.preventDefault();
    $(this).before("<input name='imagen[]' type='file' accept='image/jpg,image/jpeg,image/pjpeg,image/x-jps,image/gif,image/png' />");
});