$(function() {
  $('.button-collapse').sideNav();

  $(document).ready(function() {
    $('select').material_select();
  });

  $('#add').on('click', function() {
    var form = $('.clone .input-field').clone();
    console.log(form);
    form.children('input').val('').attr('name', 'class[]');
    form.children('.select-wrapper').children('select').attr('name', 'teacher[]').val('');
    form.appendTo('.form');
    $('select').material_select();
  });

  $('#del').on('click', function() {
    var child = $('.form').children();
    var len = child.length;
    if (len >= 2) {
      child[len - 2].remove();
      child[len - 1].remove();
    }
  });

  $('[id^="objective"]').on('click', function() {
    var input = $('#autocomplete-input').val();
    if (input.length == 0) {
      alert('入力してください。')
    } else {
      var semester = $(this).data('semester');
      var tag = $('#input_objective' + semester).children('div').children('input').map(function(index, el) {
        return $(this).val();
      });
      var flg = true;
      for (var i = 0; i < tag.length; i++) {
        if (tag[i] === input) {
          alert('タグは同じものを登録する事はできません');
          flg = false;
          break;
        }
      }
      if (flg) {
        $('#input_objective' + semester).append('<div class="chip">' + input + '<i class="close material-icons">close</i><input value="' + input + '" name="objective[' + semester + '][]" type="hidden"></div>');
      }
    }
  });

  /**
   * 目標のautocompleteを取得するメソッド
   **/
  $(function() {
    $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
        },
        url: '/school/objective/ajax',
        type: 'POST',
      })
      .done(function(data) {
        $('input.autocomplete').autocomplete({
          data: data,
          limit: 20, // The max amount of results that can be shown at once. Default: Infinity.
          onAutocomplete: function(val) {
            // Callback function when value is autcompleted.
          },
          minLength: 1, // The minimum length of the input for the autocomplete to start. Default: 1.
        });
      })
      .fail(function(data) {
        $('.result').html(data);
      });
    });

    $('.timepicker').pickatime({
      default: 'now', // Set default time: 'now', '1:30AM', '16:30'
      fromnow: 0,       // set default time to * milliseconds from now (using with default = 'now')
      twelvehour: false, // Use AM/PM or 24-hour format
      donetext: 'OK', // text for done-button
      cleartext: 'Clear', // text for clear-button
      canceltext: 'Cancel', // Text for cancel-button
      autoclose: false, // automatic close timepicker
      ampmclickable: true, // make AM PM clickable
      aftershow: function(){} //Function for after opening timepicker
    });
});
