// Generated by CoffeeScript 1.9.1
(function() {
  var relationMap;

  relationMap = (function() {
    function relationMap() {}

    relationMap.prototype.format = {
      sameRef: {
        map: 'refciteMap ref-g',
        line: 'mark-sameRef',
        papers: 'papers ref-papers'
      },
      ref1: {
        map: 'refciteMap ref-g',
        line: 'mark-ref1',
        papers: 'papers ref-papers'
      },
      ref2: {
        map: 'refciteMap ref-g',
        line: 'mark-ref2',
        papers: 'papers ref-papers'
      },
      sameCite: {
        map: 'refciteMap cite-g',
        line: 'mark-sameCite',
        papers: 'papers cite-papers'
      },
      cite1: {
        map: 'refciteMap cite-g',
        line: 'mark-cite1',
        papers: 'papers cite-papers'
      },
      cite2: {
        map: 'refciteMap cite-g',
        line: 'mark-cite2',
        papers: 'papers cite-papers'
      }
    };

    relationMap.prototype.show = function(key) {
      var file_id, item, url;
      item = this.format[key];
      file_id = $('.citeRelation').data('id');
      url = 'http://' + location.host + '/standards/' + file_id + '/getRelation/' + key;
      if (/http:\/\/standard.zhaobing\/tags\/[0-9]+$/m.test(location.href)) {
        url = location.href + '/getRelation/' + key;
      }
      return $.get(url, (function(_this) {
        return function(data) {
          $('.refciteMap').attr('class', item.map);
          $('#markLine').attr('class', item.line);
          return $('.papers').attr('class', item.papers).html(data);
        };
      })(this));
    };

    return relationMap;

  })();

  $(function() {
    var item, key, map, ref, results;
    map = new relationMap();
    ref = map.format;
    results = [];
    for (key in ref) {
      item = ref[key];
      results.push((function(key) {
        return $('.' + key).click((function(_this) {
          return function() {
            return map.show(key);
          };
        })(this));
      })(key));
    }
    return results;
  });

}).call(this);

//# sourceMappingURL=manipulateRelationMap.js.map
