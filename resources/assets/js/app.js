
$(document).ready(function () {
  $('a[href*="#"]')
  // Remove links that don't actually link to anything
  .not('[href="#"]')
  .not('[href="#0"]')
  .click(function(event) {
    // On-page links
    if (
      location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') 
      && 
      location.hostname == this.hostname
      ) {
      // Figure out element to scroll to
    var target = $(this.hash);
    target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
      // Does a scroll target exist?
      if (target.length) {
        // Only prevent default if animation is actually gonna happen
        event.preventDefault();
        $('html, body').animate({
          scrollTop: target.offset().top
        }, 1000, function() {
          // Callback after animation
          // Must change focus!
          var $target = $(target);
          $target.focus();
          if ($target.is(":focus")) { // Checking if the target was focused
            return false;
          } else {
            $target.attr('tabindex','-1'); // Adding tabindex for elements not focusable
            $target.focus(); // Set focus again
          };
        });
      }
    }
  });



  $('#btn-apoia-se').on('click', function(e){
    fbq('trackCustom', 'Clique Apoiese Topo');
    gtag('event', 'Clique Apoiese Topo');
  });



  $('.js-btn-modal').on('click', function(e){
    var target = $(this).data('target');
    $(target).fadeIn();
  });



  $('.js-modal-close').on('click', function() {
    $(this).closest('.c-modal').fadeOut();
  });



  var $body = $('body');
  $('.js-menu-trigger').on('click', function() {
    $body.toggleClass('menu-opened');
  });



  var $htmlBody = $('html, body');
  $('.js-anchor').on('click', function() {

    var target = $(this).data('anchor');

    $body.removeClass('menu-opened');

    $htmlBody.animate({
      scrollTop: $(target).offset().top - 100
    }, 300);
  });



  var $document   = $(document);
  $document.on('scroll', function(){
    if ( $(this).scrollTop() >= 80 ){
      $body.addClass('is-scroll');
    }
    else{
      $body.removeClass('is-scroll');
    }
  });


});