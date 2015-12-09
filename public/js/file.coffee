$ ->
  #文件上传
  myDropzone = new Dropzone("#my-awesome-dropzone")
  myDropzone.on('complete',->location.reload())

  #发布评论
  $("#comment-form").submit ->
    url = $(this).attr('action')
    if $('#content').val() is ''
      console.log '内容不能为空'
      return false
    $.post url,$(this).serialize(),(data)->
      if data is 'success'
        location.reload()
    return false
  #删除评论
  $('a.delete').click ->
    url = $(this).attr('href')
    $.post url,(data)->
      if data is 'success'
        location.reload()
    return false;
  #添加标签
  $("#tag-form").submit ->
    url = $(this).attr('action')
    if $('#tagName').val() is ''
      console.log '标签内容不能为空'
      return false
    $.post url,$(this).serialize(),(data)->
      if data is 'success'
        location.reload()
    return false
  #增加引用文档
  $('#addReference-form').submit ->
    file2url = $('#addReference').val()
    unless /http:\/\/standard.zhaobing\/standards\/([0-9]+)/.test(file2url)
      console.log file2url
      return false
    file2 = file2url.replace(/http:\/\/standard.zhaobing\/standards\/([0-9]+)/mg, "$1");
    url = $(this).attr('action')+file2
    #    console.log url
    $.post url,$(this).serialize(),(data)->
      if data is 'success'
        location.reload()
      else
        alert data
    return false
  #添加版本
  $('#addRev-form').submit ->
    file2url = $('#addRev').val()
    unless /http:\/\/standard.zhaobing\/standards\/([0-9]+)/.test(file2url)
      console.log file2url
      return false
    file2 = file2url.replace(/http:\/\/standard.zhaobing\/standards\/([0-9]+)/mg, "$1");
    url = $(this).attr('action')+file2
#    console.log url
    $.post url,$(this).serialize(),(data)->
      if data is 'success'
        location.reload()
    return false

  #添加链接
  $('#addLink-form').submit ->
    url = $(this).attr('action')
    if $('#link').val() is ''
      console.log '链接不能够为空'
    $.post url,$(this).serialize(),(data)->
      if data is 'success'
        console.log '添加成功'
        location.reload()
    return false

  #切换摘要的显示
  $('#expand').click ->
    $("#expand").parents('div.abstract').hide()
    $("#collaps").parents('div.abstract').show()
    return false
  $('#collaps').click ->
    $("#expand").parents('div.abstract').show()
    $("#collaps").parents('div.abstract').hide()
    return false


