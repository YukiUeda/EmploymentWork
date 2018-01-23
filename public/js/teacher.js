jQuery(function() {
  $(".button-collapse").sideNav();

  $(document).ready(function() {
    $('select').material_select();
  });

  $(document).on('change', '.form select', function() {
    var time = 0;
    for (var i = 0; i < $('.form select').length; i++) {
      var index = parseInt($($('.form select')[i]).val()) - 1;
      if (0 <= index) {
        time += parseInt($($('.form select')[i]).parent().parent().data('time')[index]);
      }
    }
    $('.total').data('total', time);

    $('.total').text('合計時間' + time + '分');

    if (time < $('[data-max]').data('max')) {
      var form = $('.clone').clone();
      form.children('.input-field').children('.date').val('');
      form.children('.input-field').children('.time').val('');
      form.removeClass('clone');
      form.appendTo('.group');
      $('select').material_select();
      $(".datepicker").pickadate({
        monthsFull: ["1月", "2月", "3月", "4月", "5月", "6月", "7月", "8月", "9月", "10月", "11月", "12月"],
        monthsShort: ["1月", "2月", "3月", "4月", "5月", "6月", "7月", "8月", "9月", "10月", "11月", "12月"],
        weekdaysFull: ["日曜日", "月曜日", "火曜日", "水曜日", "木曜日", "金曜日", "土曜日"],
        weekdaysShort: ["日", "月", "火", "水", "木", "金", "土"],
        weekdaysLetter: ["日", "月", "火", "水", "木", "金", "土"],
        labelMonthNext: "翌月",
        labelMonthPrev: "前月",
        labelMonthSelect: "月を選択",
        labelYearSelect: "年を選択",
        today: "今日",
        clear: "クリア",
        close: "閉じる",
        format: "yyyy-mm-dd",
      });
    } else {
      for (var i = 0; i < $('.form select').length; i++) {
        if ($($('.form select')[i]).val() == 0) {
          $($('.form select')[i]).attr("disabled", true);
          $('select').material_select('destroy');
          $('select').material_select();
        }
      }
    }
  });

  $(".datepicker").pickadate({
    monthsFull: ["1月", "2月", "3月", "4月", "5月", "6月", "7月", "8月", "9月", "10月", "11月", "12月"],
    monthsShort: ["1月", "2月", "3月", "4月", "5月", "6月", "7月", "8月", "9月", "10月", "11月", "12月"],
    weekdaysFull: ["日曜日", "月曜日", "火曜日", "水曜日", "木曜日", "金曜日", "土曜日"],
    weekdaysShort: ["日", "月", "火", "水", "木", "金", "土"],
    weekdaysLetter: ["日", "月", "火", "水", "木", "金", "土"],
    labelMonthNext: "翌月",
    labelMonthPrev: "前月",
    labelMonthSelect: "月を選択",
    labelYearSelect: "年を選択",
    today: "今日",
    clear: "クリア",
    close: "閉じる",
    format: "yyyy-mm-dd",
  });

});
