$ ->
  #文件上传
  myDropzone = new Dropzone("#my-awesome-dropzone")
  myDropzone.on('complete',->location.reload())

  #删除评论，这里其实是有重复的
  $('a.delete').click ->
    url = $(this).attr('href')
    $.post url,(data)->
      if data is 'success'
        location.reload()
    return false;

