$(function () {
  // var includes = $('[data-include]')
  // $.each(includes, function () {
  //   var file = $(this).data('include') + '.html'
  // //   var file = 'views/' + $(this).data('include') + '.html'
  //   $(this).load(file)
  // })
  //   $(".nav-item").removeClass("active");
  //   var path = window.location.pathname;
  //   var page = path.split("/").pop();
  //   if(page=="" || page== null){
  //     $('#index').addClass("active");
  //   }else{
  //     var pagename = page.split(".")
  //     $('#'+pagename[0]).addClass("active");
  //   }

  $(document).on("click",".nav-item",function() {
    showload();
  });
  showload();
  setTimeout('stopload()', 1000);
})
function showload(){
  $('#loader-bg').css("display", "block");
  $('#loader').css("display", "block");
  $('.load-on').css("display", "block");
}
function stopload() {
  $('#loader-bg').delay(900).fadeOut(800);
  $('#loader').delay(600).fadeOut(300);
}