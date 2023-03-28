$(function() {
    $('.image_url').on('change', function() {
          let obj = $(this).prop('files')[0];
          let fileReader = new FileReader();
          fileReader.onload = (function() {
              document.getElementById('preview').src = fileReader.result;
          });
          fileReader.readAsDataURL(obj);
    })
})
