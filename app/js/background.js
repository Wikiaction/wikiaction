
$(window).scroll(function() {
  $('#menu').css('left', -$(this).scrollLeft() + "px");
  $('.footer-wrap').css('left', -$(this).scrollLeft() + "px");
});
