$(document).ready(function(){
  $(window).scroll(function(){
    if ($(this).scrollTop() > 20) {
      $('#scrollToTop').fadeIn();
    } else {
      $('#scrollToTop').fadeOut();
    }
  });
});

$('.icon-menu').on('click', '.icon-box', function() {
  $(this).addClass('active').siblings().removeClass('active');
});