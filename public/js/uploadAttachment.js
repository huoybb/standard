// Generated by CoffeeScript 1.9.1
(function() {
  $(function() {
    var myDropzone;
    myDropzone = new Dropzone("#my-awesome-dropzone");
    return myDropzone.on('complete', function() {
      return location.reload();
    });
  });

}).call(this);

//# sourceMappingURL=uploadAttachment.js.map
