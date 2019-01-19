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
});