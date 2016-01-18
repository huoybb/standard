// Generated by CoffeeScript 1.9.1
(function() {
  $(function() {
    var myDropzone, reStr, regex;
    myDropzone = new Dropzone("#my-awesome-dropzone");
    myDropzone.on('complete', function() {
      return location.reload();
    });
    reStr = 'http:\/\/' + location.host + '\/tags\/([0-9]+)';
    regex = new RegExp(reStr, "mg");
    $('a.delete').click(function() {
      var url;
      url = $(this).attr('href');
      $.post(url, function(data) {
        if (data === 'success') {
          return location.reload();
        }
      });
      return false;
    });
    return $('#addReference-form').submit(function() {
      var file2, file2url, url;
      file2url = $('#addReference').val();
      if (!regex.test(file2url)) {
        console.log(file2url);
        return false;
      }
      file2 = file2url.replace(regex, "$1");
      url = $(this).attr('action') + file2;
      $.post(url, $(this).serialize(), function(data) {
        if (data === 'success') {
          return location.reload();
        } else {
          return alert(data);
        }
      });
      return false;
    });
  });

}).call(this);

//# sourceMappingURL=tag.js.map
