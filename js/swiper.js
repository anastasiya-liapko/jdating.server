'use strict';

$(document).ready(function(){

  // init swiper
  var mySwiper = new Swiper ('.swiper-container', {
    slidesPerView: 1,
    loop: true,
    speed: 800,
    
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
  })


  var mySwiperCandidat = new Swiper ('.swiper-container-candidat', {
    slidesPerView: 3,
    loop: true,
    speed: 800,

    // Responsive breakpoints
    breakpoints: {
      992: {
        slidesPerView: 1
      }
    },

    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
  })

  // add candidats data
  mySwiperCandidat.on('slideChangeTransitionEnd', function() {
    var width = $(window).width();

    if (width <= 992) {
      var name = $('.swiper-slide-active .name').text();
      $('#name').text(name);
    } else {
      var name = $('.swiper-slide-next .name').text();
      $('#name').text(name);
    }
  })

  $(window).resize(function () {
    var width = $(window).width();

    if (width <= 992) {
      var name = $('.swiper-slide-active .name').text();
      $('#name').text(name);
    } else {
      var name = $('.swiper-slide-next .name').text();
      $('#name').text(name);
    }
  })
  $(window).trigger('resize');

})