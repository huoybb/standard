$ ->
  #  选择的操作
  $('#fileSelect').click ->
    if $('#fileSelect').is(':checked')
      $('.file_id').prop("checked",true);
    else
      $('.file_id').prop("checked",false);
  #  打标签的操作
  $('#list-tag-form').submit ->
    url = $(this).attr('action')
    $.post url,$(this).serialize(),(data)->
      if data is 'success'
        location.reload()
      if data is 'failed'
        alert '请选择要打标签的条目！'
    return false
  #  删除文件的操作
  $('a.delete').click ->
    url = $(this).attr('href')
    $.post url,(data)->
      if data is 'success'
        location.reload()
    return false;

  $('#combineRevisions').click ->
    url = '/standards/combineRevisions'
    $.post url,$('#list-tag-form').serialize(),(data)->
      if data is 'success'
        location.reload()
      if data is 'failed'
        alert '请选择要打标签的条目！'
    return false;

  $('#deleteItems').click ->
    url = location.href + '/deleteTaggableItems'
    if /http:\/\/standard.zhaobing\/(page\/[0-9]+)?/m.test(location.href) or /http:\/\/standard.zhaobing\/search\/.+/m.test(location.href)
      url = '/standards/deleteSelectedFiles'
    $.post url,$('#list-tag-form').serialize(),(data)->
      if data is 'success'
        location.reload()
      if data is 'failed'
        alert '请选择要打标签的条目！'
    return false
