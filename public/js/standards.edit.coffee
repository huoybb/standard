$ ->
  $("#edit").submit ->
    $.post location.href,$("#edit").serialize(),(data)->
      if data is 'success'
        location.href = document.referrer
      else
        alert('内容不能够为空')
    false