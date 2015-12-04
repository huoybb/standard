$ ->
#文件上传
  myDropzone = new Dropzone("#my-awesome-dropzone")
  myDropzone.on('complete',->location.reload())