"use strict";

Dropzone.autoDiscover = false;
$(".dropzone").dropzone({
  url: 'upload.php',
  addRemoveLinks: true,
  removedfile: function(file) {
  var name = file.name; 
   
  $.ajax({
   type: 'POST',
   url: 'upload.php',
   data: {name: name,request: 2},
   sucess: function(data){
    console.log('success: ' + data);
   }
  });
  var _ref;
  return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
 }
});
