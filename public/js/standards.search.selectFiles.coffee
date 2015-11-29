$ ->
  $('#fileSelect').click ->
    if $('#fileSelect').is(':checked')
      $('.file_id').prop("checked",true);
#      console.log 'on'
    else
      $('.file_id').prop("checked",false);
#      console.log 'off'