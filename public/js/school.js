$(function(){
  $('.button-collapse').sideNav();

  $(document).ready(function() {
    $('select').material_select();
  });

  $('#add').on('click',function(){
      var form = $('.clone .input-field').clone();
      console.log(form);
      form.children('input').val('').attr('name','class[]');
      form.children('.select-wrapper').children('select').attr('name','teacher[]').val('');
      form.appendTo('.form');
      $('select').material_select();
  });

  $('#del').on('click',function(){
      var child = $('.form').children();
      var len   = child.length;
      if(len>=2){
        child[len-2].remove();
        child[len-1].remove();
      }
  });
});
(function($) {
    $('.textpicker').pickatime({
        default: 'now', // Set default text: 'now', '1:30AM', '16:30'
        fromnow: 0,       // set default text to * milliseconds from now (using with default = 'now')
        twelvehour: false, // Use AM/PM or 24-hour format
        donetext: 'OK', // text for done-button
        cleartext: 'Clear', // text for clear-button
        canceltext: 'Cancel', // Text for cancel-button
        autoclose: false, // automatic close textpicker
        ampmclickable: true, // make AM PM clickable
        aftershow: function(){} //Function for after opening textpicker
    });
}(jQuery));
