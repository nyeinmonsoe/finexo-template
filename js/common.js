$(function () {
    var includes = $('[data-include]')
    $.each(includes, function () {
      var file = $(this).data('include') + '.html'
    //   var file = 'views/' + $(this).data('include') + '.html'
      $(this).load(file)
    })
      $(".nav-item").removeClass("active");
      var path = window.location.pathname;
      var page = path.split("/").pop();
      if(page=="" || page== null){
        $('#index').addClass("active");
      }else{
        var pagename = page.split(".")
        $('#'+pagename[0]).addClass("active");
      }
      
  })