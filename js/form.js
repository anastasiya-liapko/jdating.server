'use strict';

$(document).ready(function() {
  // hide/show conversion radio
  $(function () {
    $('label[for=j-yes]').click(function() {
      $('#radio-conversion').hide('fast');
    });
    $('label[for=j-no]').click(function() {
      $('#radio-conversion').show('fast');
    });
  });

  // send enter form
  $(document).ready(function() {
    $('#js-enter-form').submit(function(event) {
      var data = {};

      $(this).find('input').each(function() {
        data[$(this)[0].name] = $(this).val();
      })
      $.ajax({
        method: "POST",
        url: "send.php",
        data: data
      })
        .done(function( msg ) {
          console.log(msg);
          var obj = jQuery.parseJSON(msg);
          console.log(obj);
        });
      
      event.preventDefault();
      
    });
  });

  // send profile form main
  $(document).ready(function() {
    $('#profile-form-main').submit(function(event) {
      var data = {};

      $(this).find('input').each(function() {
        data[$(this)[0].name] = $(this).val();
      })
      $.ajax({
        method: "POST",
        url: "send.php",
        data: data
      })
        .done(function( msg ) {
          console.log(msg);
          var obj = jQuery.parseJSON(msg);
          console.log(obj);
        });
      
      event.preventDefault();
      
    });
  });

  // send profile form info
  $(document).ready(function() {
      $('#profile-form-info').submit(function(event) {
        var data = {};
        data['dz-filename'] = [];

        $(this).find('input').each(function() {
          data[$(this)[0].name] = $(this).val();
        })
        $(this).find('textarea').each(function() {
          data[$(this)[0].name] = $(this).val();
        })
        $(this).find('select').each(function() {
          data[$(this)[0].name] = $(this).val();
        })
        $(this).find('.dz-image-preview .dz-filename span').each(function(index) {
          data['dz-filename'][index] = $(this).text();
        })
        $.ajax({
          method: "POST",
          url: "send.php",
          data: data
        })
          .done(function( msg ) {
            console.log(msg);
            var obj = jQuery.parseJSON(msg);
            console.log(obj);
          });
        
        event.preventDefault();
        
      });
    });
});