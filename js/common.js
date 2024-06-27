$(function () {
    var includes = $('[data-include]')
    $.each(includes, function () {
      var file = $(this).data('include') + '.html'
    //   var file = 'views/' + $(this).data('include') + '.html'
      $(this).load(file)
    })
  })