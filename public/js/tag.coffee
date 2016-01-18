$ ->
  #文件上传
  myDropzone = new Dropzone("#my-awesome-dropzone")
  myDropzone.on('complete',->location.reload())

  reStr = 'http:\/\/'+location.host+'\/tags\/([0-9]+)'
  regex = new RegExp(reStr, "mg");

  #删除评论，这里其实是有重复的
  $('a.delete').click ->
    url = $(this).attr('href')
    $.post url,(data)->
      if data is 'success'
        location.reload()
    return false;

  #增加引用文档
  $('#addReference-form').submit ->
    file2url = $('#addReference').val()
    unless regex.test(file2url)
      console.log file2url
      return false
    file2 = file2url.replace(regex, "$1");
    url = $(this).attr('action')+file2
    #    console.log url
    $.post url,$(this).serialize(),(data)->
      if data is 'success'
        location.reload()
      else
        alert data
    return false

