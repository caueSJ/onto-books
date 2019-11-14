(function($) {
  "use strict"; // Start of use strict

  // Smooth scrolling using jQuery easing
  
  $('#resultados_link').on('.active', function() {
    if($(this).hasClass('active')){
     
    }else{
      $('.extra_buscar_button').addClass('hidden_content');
    }
  });

  $('.search_field').on('keyup', function() {
    $('.search-input').val($(this).val());
  });

  
  $('a.js-scroll-trigger[href*="#"]:not([href="#"])').click(function() {
    if($(this).hasClass('edicao_gerencia')){
      var controller = $(this).attr('data-controller');
      $('.edicao_gerencia_container').html('');
      buscarEdicaoGerencia(controller);
    }
    if($(this).hasClass('buscar_button')){
      var busca = $(".search_field").val();
      if(busca){
        var tipo = $('.ui.dropdown.tipo_busca').find('.item.active.selected').attr('data-value');                
        buscaLivros(busca,tipo);
        
        $(".resultados_container").addClass('hidden_content');
        $('#resultados').removeClass('hidden_content');
        $('.resultados_menu').removeClass('hidden_content');
        $('.sad_book').addClass('hidden_content');
        $('.resultados_menu_link').addClass('active');
        $('.resultados_container').html('');
        $('.search-input').blur();
        $('.search_field').blur();
        
        $('.bookshelf_wrapper').removeClass('hidden_content');
      }else{
        semanticAlert('Digite sua busca!', '',3, 'warning');         
      }
    }
    if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
      if (target.length) {
        $('html, body').animate({
          scrollTop: (target.offset().top - 48)
        }, 1000, "easeInOutExpo");
        return false;
      }
    }
  });
  // Closes responsive menu when a scroll trigger link is clicked
  $('.js-scroll-trigger').click(function() {
    $('.navbar-collapse').collapse('hide');
  });

  // Activate scrollspy to add active class to navbar items on scroll
  $('body').scrollspy({
    target: '#mainNav',
    offset: 48
  });
  $(window).on('activate.bs.scrollspy', function () {
    if($('.resultados_menu_link').hasClass('active')){
      $('.extra_buscar_button').removeClass('hidden_content');
    }else{
      $('.extra_buscar_button').addClass('hidden_content');
    } 
  });
   

  // Collapse Navbar
  var navbarCollapse = function() {
    if ($("#mainNav").offset().top > 100) {
      $("#mainNav").addClass("navbar-shrink");
    } else {
      $("#mainNav").removeClass("navbar-shrink");
    }
  };
  // Collapse now if page is not at top
  navbarCollapse();
  // Collapse the navbar when page is scrolled
  $(window).scroll(navbarCollapse);

  // Scroll reveal calls
  window.sr = ScrollReveal();
  sr.reveal('.sr-icons', {
    duration: 600,
    scale: 0.3,
    distance: '0px'
  }, 200);
  sr.reveal('.sr-button', {
    duration: 1000,
    delay: 200
  });
  sr.reveal('.sr-contact', {
    duration: 600,
    scale: 0.3,
    distance: '0px'
  }, 300);

  // Magnific popup calls
  $('.popup-gallery').magnificPopup({
    delegate: 'a',
    type: 'image',
    tLoading: 'Loading image #%curr%...',
    mainClass: 'mfp-img-mobile',
    gallery: {
      enabled: true,
      navigateByImgClick: true,
      preload: [0, 1]
    },
    image: {
      tError: '<a href="%url%">The image #%curr%</a> could not be loaded.'
    }
  });

  $(document).ready(function(){

  
  var targetDataSelector = "data-ic-class",
      $searchTrigger = $('['+targetDataSelector+'="search-trigger"]'),
      $searchInput = $('['+targetDataSelector+'="search-input"]'),
      $searchClear = $('['+targetDataSelector+'="search-clear"]'),
      $searchIcon = $('['+targetDataSelector+'="search-icon"]'),
      $searchForm = $searchTrigger.find('form');
  
      $searchTrigger.click(function(){
        $(this).addClass('active');
        $searchInput.focus();
      });
  
      // blur
      $searchInput.blur(function(){
        if($searchInput.val().length > 0){
          return false;
         }else{
          $searchTrigger.removeClass('active hot');
         }
      });
  
      // clear
      $searchClear.click(function(){
        $searchInput.val('');
      });
  
      // show clear
      $searchInput.keydown(function(){
        $searchTrigger.addClass('hot');
      });
  
});

})(jQuery); // End of use strict