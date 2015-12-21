$ ->
  # 搜索功能键的设置
  $("#search-form").submit ->
    keywords = $("#search").val().trim()
    keywords = keywords.replace(/\//,' ') #去除搜索中的"/"，避免出现路由错误
    location.href = "http://"+location.host+"/search/#{keywords}"
    false
  # 前后导航键的设置，方便浏览
  if $('.next a').length
    key 'right',->
      location.href = $('.next a').attr('href')
  if $('.previous a').length
    key 'left',->
      location.href = $('.previous a').attr('href')


# 收藏功能的设置
#  $('#favorite-button').click ->
#    if $('#favorite').attr('class').trim() is 'glyphicon glyphicon-heart'
#      url = window.location.href + '/deleteFavorite'
#      $.getJSON url,(data)->
#        $('#favorite').attr('class','glyphicon glyphicon-heart-empty') if data.status is 'success'
#    else
#      url = window.location.href + '/addFavorite'
#      $.getJSON url,(data)->
#        $('#favorite').attr('class','glyphicon glyphicon-heart') if data.status is 'success'