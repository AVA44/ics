$(function() {
  $('#image_url').on('change', function() {
    if ($(this).val() == '') {
      $('#preview').attr('src', 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==');
    } else {
      let obj = $(this).prop('files')[0];
      let fileReader = new FileReader();
      fileReader.onload = (function() {
        document.getElementById('preview').src = fileReader.result;
      });
      fileReader.readAsDataURL(obj);
    };
  })

  $('.required').on('change', function() {
    let createInput = $(this).val();

    if (typeof createInput == 'undifined') {
      $(this).closest('.create_form_content').addClass('empty_alert');
    } else {
      $(this).closest('.create_form_content').removeClass('empty_alert');
    }
  })

  $('#create_submit').on('click', function() {
    let emptyAlert = $('.empty_alert').length;

    if (emptyAlert == '0') {
      $('#create_form').submit();
    } else {
      alert('入力されていない項目があります！');
    }
  })
})
