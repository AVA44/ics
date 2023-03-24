$(function() {
  $('.destroy_choice').on('click', function() {
      let id = $(this).closest('td').prevAll('.id').val();
      let name = $(this).closest('td').prevAll('.name').text();
      let category = $(this).closest('td').prevAll('.category').text();


      $('.destroy_field').append('<p class="destroy_inventory">' + id + ' ' + name + ' ' +  category + '</p> <hr/>');
      $('.destroy_form').append('<input type="hidden" name="destroy[]" value="' + id + '"/>');
  });

  $('.destroy_submit').on('click', function() {
      $('.destroy_form').submit();
  })
})
