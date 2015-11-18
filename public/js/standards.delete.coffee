$ ->
  $('a.delete').click ->
    url = $(this).attr('href')
    $.post url,(data)->
      if data is 'success'
        location.reload()
    return false;