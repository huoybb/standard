// Generated by CoffeeScript 1.9.1
(function() {
  $(function() {
    $("#search-form").submit(function() {
      var keywords;
      keywords = $("#search").val().trim();
      keywords = keywords.replace(/\//, ' ');
      location.href = "http://" + location.host + ("/search/" + keywords);
      return false;
    });
    if ($('.next a').length) {
      key('right', function() {
        return location.href = $('.next a').attr('href');
      });
    }
    if ($('.previous a').length) {
      return key('left', function() {
        return location.href = $('.previous a').attr('href');
      });
    }
  });

}).call(this);

//# sourceMappingURL=my.js.map
