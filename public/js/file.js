// Generated by CoffeeScript 1.9.1
(function() {
  $(function() {
    var myDropzone;
    myDropzone = new Dropzone("#my-awesome-dropzone");
    myDropzone.on('complete', function() {
      return location.reload();
    });
    $("#comment-form").submit(function() {
      var url;
      url = $(this).attr('action');
      if ($('#content').val() === '') {
        console.log('内容不能为空');
        return false;
      }
      $.post(url, $(this).serialize(), function(data) {
        if (data === 'success') {
          return location.reload();
        }
      });
      return false;
    });
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
    $("#tag-form").submit(function() {
      var url;
      url = $(this).attr('action');
      if ($('#tagName').val() === '') {
        console.log('标签内容不能为空');
        return false;
      }
      $.post(url, $(this).serialize(), function(data) {
        if (data === 'success') {
          return location.reload();
        }
      });
      return false;
    });
    $('#addRev-form').submit(function() {
      var file2, file2url, url;
      file2url = $('#addRev').val();
      if (!/http:\/\/standard.zhaobing\/standards\/([0-9]+)/.test(file2url)) {
        console.log(file2url);
        return false;
      }
      file2 = file2url.replace(/http:\/\/standard.zhaobing\/standards\/([0-9]+)/mg, "$1");
      url = $(this).attr('action') + file2;
      $.post(url, $(this).serialize(), function(data) {
        if (data === 'success') {
          return location.reload();
        }
      });
      return false;
    });
    return $('#addLink-form').submit(function() {
      var url;
      url = $(this).attr('action');
      if ($('#link').val() === '') {
        console.log('链接不能够为空');
      }
      $.post(url, $(this).serialize(), function(data) {
        if (data === 'success') {
          console.log('添加成功');
          return location.reload();
        }
      });
      return false;
    });
  });

}).call(this);

//# sourceMappingURL=file.js.map