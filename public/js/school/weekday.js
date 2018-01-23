jQuery(function() {
  $('#timetable').on('change', function() {
    for (var i = 0; i < $('.subject select').length; i++) {
      for (; i < $(this).val(); i++) {
        $($('.subject select')[i]).attr("disabled", false);
      }
      $($('.subject select')[i]).attr("disabled", true);
    }
    $('select').material_select('destroy');
    $('select').material_select();
  });

  $('#class').on('change', function() {
    if ($(this).val() == '') {
      $('#week').attr('disabled', true);
    } else {
      $('#week').attr('disabled', false);
      if ($('#week').val() != '') {
        $('#week').trigger('change')
      }
    }
    $('select').material_select('destroy');
    $('select').material_select();
  });
  $('#week').on('change', function() {
    if ($('#class').val() != '' && $('week').val() != '') {
      $('#timetable').attr('disabled', false);
      $.ajax({
          url: '/school/class/weekday/setting/ajax',
          type: 'POST',
          data: {
            '_token': $('[name=_token]').val(),
            'year': $('#year').val(),
            'class': $('#class').val(),
            'week': $('#week').val()
          }
        })
        .done(function(data) {
          for (var i = 0; i < $('.subject select').length; i++) {
            for (; i < data.length; i++) {
              $($('.subject select')[i]).val(data[i]);
            }
            $($('.subject select')[i]).val('');
          }
          $('select').material_select('destroy');
          $('select').material_select();
        })
        .fail(function(data) {
          console.log(data);
        });
    }else {
      $('#timetable').attr('disabled', true);
    }
  });
});
