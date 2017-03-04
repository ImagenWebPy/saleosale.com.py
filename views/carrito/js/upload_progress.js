function upload_image() 
{
  var bar = $('#bar1');
  var percent = $('#percent1');
  $('#frm-paso2').ajaxForm({
    beforeSubmit: function() {
      document.getElementById("progress_div").style.display="block";
      var percentVal = '0%';
      bar.width(percentVal)
      percent.html(percentVal);
    },

    uploadProgress: function(event, position, total, percentComplete) {
      var percentVal = percentComplete + '%';
      bar.width(percentVal)
      percent.html(percentVal);
    },
    
	success: function() {
      var percentVal = '100%';
      bar.width(percentVal)
      percent.html(percentVal);
    },

    complete: function(xhr) {
      if(xhr.responseText)
      {
        //redireccionamos al paso 3
        window.location.href = "http://saleosale.com.py/cart/carrito_canje";
      }
    }
  }); 
}