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
    if $("input[name='file_id[]']:checked").length is 0
      alert '请选择条目，不能空'
      return false
    if $('#tagName').val() is ''
      alert '标签不能为空，请填写'
      return false
    $.post url,$(this).serialize(),(data)->
      if data is 'success'
        location.reload()
      else
        alert data
    return false
  # 合并版本
  $('#combineRevisions').click ->
    url = '/standards/combineRevisions'
    if $("input[name='file_id[]']:checked").length is 0
      alert '请选择条目，不能空'
      return false
    $.post url,$('#list-tag-form').serialize(),(data)->
      if data is 'success'
        location.reload()
      else
        alert data
    return false;
  #  删除条目
  $('#deleteItems').click ->
    url = location.href + '/deleteTaggableItems'
    if $("input[name='file_id[]']:checked").length is 0
      alert '请选择条目，不能空'
      return false
    if /http:\/\/standard.zhaobing\/(page\/[0-9]+)?/m.test(location.href) or /http:\/\/standard.zhaobing\/search\/.+/m.test(location.href)
      url = '/standards/deleteSelectedFiles'
    $.post url,$('#list-tag-form').serialize(),(data)->
      if data is 'success'
        location.reload()
      else
        alert data
    return false
