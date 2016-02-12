
$ ->
  $('#search').keyup ->
    key = $.trim($(this).val()).toUpperCase().replace /\s+/g,"|"
    $('#allTags span')
    .hide()
    .filter ->
      keywords = $(this).text().toUpperCase()+' '+$('a',this).data('keywords').toUpperCase()
      keywords.match(key)
    .show()

  $('#tagName').keyup ->
    key = $.trim($(this).val()).toUpperCase().replace /\s+/g,"|"
    $('#allTags span')
    .hide()
    .filter ->
      keywords = $(this).text().toUpperCase()
      keywords.match(key)
    .show()
  $('#search').trigger 'keyup' if $('#search').val() isnt ''