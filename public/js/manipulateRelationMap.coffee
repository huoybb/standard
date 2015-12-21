class relationMap
  format:{
    sameRef:{
      map:'refciteMap ref-g'
      line:'mark-sameRef'
      papers:'papers ref-papers'
    }
    ref1:{
      map:'refciteMap ref-g'
      line:'mark-ref1'
      papers:'papers ref-papers'
    }
    ref2:{
      map:'refciteMap ref-g'
      line:'mark-ref2'
      papers:'papers ref-papers'
    }

    sameCite:{
      map:'refciteMap cite-g'
      line:'mark-sameCite'
      papers:'papers cite-papers'
    }
    cite1:{
      map:'refciteMap cite-g'
      line:'mark-cite1'
      papers:'papers cite-papers'
    }
    cite2:{
      map:'refciteMap cite-g'
      line:'mark-cite2'
      papers:'papers cite-papers'
    }

  }

  show:(key)->
    item = @format[key]
    file_id = $('.citeRelation').data('id');
    url = 'http://'+location.host+'/standards/'+file_id+'/getRelation/'+key
    $.get url,(data)=>
      $('.refciteMap').attr('class',item.map)
      $('#markLine').attr('class',item.line)
      $('.papers').attr('class',item.papers).html(data)


$ ->
  map = new relationMap()
  for key,item of map.format
    do(key)-> $('.'+key).click => map.show(key)
#    console.log key
#
#  $('.sameRef').click => map.show('sameRef')
#  $('.sameCite').click => map.show('sameCite')
#  $('.ref1').click => map.show('ref1')
#  $('.ref2').click => map.show('ref2')
#  $('.cite1').click => map.show('cite1')
#  $('.cite2').click => map.show('cite2')
