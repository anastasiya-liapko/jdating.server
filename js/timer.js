'use strict';

$(document).ready(function () {
  
  var seconds = $('.seconds');
  var minutes = $('.minutes');

  // начальное время таймера
  var secondsValue = 59;
  var minutesValue = '01';

  
  function startTimer() {

    // начать повторы с интервалом 1 сек
    var interval = setInterval(function() {
      seconds.text(secondsValue);
      minutes.text(minutesValue);

      secondsValue = parseInt(secondsValue);
      secondsValue -= 1;
      // minutesValue;

      if (secondsValue < 10 && secondsValue !== 0) {
        seconds.text('0' + secondsValue);
      } else if (secondsValue === 0) {
          seconds.text('0' + secondsValue);
          secondsValue = 60;
          minutesValue -= 1;
        } else {
          seconds.text(secondsValue);
        }

      if (minutesValue === 0) {
        minutesValue = '0' + 0;
      }
    }, 1000);

    // через 2 мин остановить повторы
    var timeout = setTimeout(function() {
      clearInterval(interval);
      $('#sms-code-link').attr('href', '#');
      $('#sms-code-link').removeClass('link_disabled');
    }, 119000);

    // функция сброса таймера
    function resetTimer() {
      clearInterval(interval);
      clearTimeout(timeout);
      secondsValue = 59;
      minutesValue = '01';
      seconds.text(secondsValue);
      minutes.text(minutesValue);
      $('#sms-code-link').removeAttr('href');
      $('#sms-code-link').addClass('link_disabled');
    };

    // сброс таймера при закрытии модального окна
    $('#js-enter-modal .modal__close').on('click', function (e) {
      resetTimer();
    })

    // сброс и старт таймера при клике на "запросить код повторно"
    $('#sms-code-link').on('click', function (e) {
      if ($('#sms-code-link').attr('href')) {
        resetTimer();
        startTimer(); 
      };   
    });

  };

  // старт таймера при открытии модального окна
  $('#js-enter-btn').on('click', function (e) {
    startTimer();
  });

});
