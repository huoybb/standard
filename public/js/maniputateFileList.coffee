class fileList
  selectControl:->
    if $('#fileSelect').is(':checked')
      $('.file_id').prop("checked",true);
    else
      $('.file_id').prop("checked",false);
  hasSelectedItem:-> $("input[name='file_id[]']:checked").length > 0
  hasTagName:-> $('#tagName').val() isnt ''
  processReturnValue:(data)->
    if data is 'success'
      location.reload()
    else
      alert data
  isOnIndexPage:-> /http:\/\/standard.zhaobing\/(page\/[0-9]+)?/m.test(location.href)
  isOnSearchPage:-> /http:\/\/standard.zhaobing\/search\/.+/m.test(location.href)

$ ->
  list = new fileList()
  #  选择的操作
  $('#fileSelect').click =>
    list.selectControl()
  #  打标签的操作
  $('#list-tag-form').submit =>
    url = $('#list-tag-form').attr('action')
    if not list.hasSelectedItem()
      alert '请选择条目，不能空'
      return false
    if not list.hasTagName()
      alert '标签不能为空，请填写'
      return false
    $.post url,$('#list-tag-form').serialize(),(data)=>
      list.processReturnValue(data)
    return false
  # 合并版本
  $('#combineRevisions').click =>
    url = '/standards/combineRevisions'
    if not list.hasSelectedItem()
      alert '请选择条目，不能空'
      return false
    $.post url,$('#list-tag-form').serialize(),(data)=>
      list.processReturnValue(data)
    return false;
  #  删除条目
  $('#deleteItems').click =>
    url = location.href + '/deleteTaggableItems'
    if not list.hasSelectedItem()
      alert '请选择条目，不能空'
      return false
    if list.isOnIndexPage() or list.isOnSearchPage()
      url = '/standards/deleteSelectedFiles'
    $.post url,$('#list-tag-form').serialize(),(data)=>
      list.processReturnValue(data)
    return false
