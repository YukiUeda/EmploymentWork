$(function() {
  $(document).ready(function() {
    $('.modal').modal();
  });


  $('.button-collapse').sideNav();


  var cnt = 1;
  $('#add').on('click', function() {
    cnt++;

    var form = $('.content').clone();
    form.children('.input-field').children('textarea').attr('name', 'contents[]').val('');
    form.children('.input-field').children('.btn').children('input').attr('name', 'images[]').val('');
    form.children('.input-field').children('.btn').children('input').attr('id', 'profile-image' + cnt);
    form.children('.input-field').children('.btn').children('input').attr('data-img', cnt);
    form.children('.input-field').children('.btn').children('a').attr('href', '#modal' + cnt);
    form.children('.input-field').children('.btn').children('.cropper-example-1').children('#modal1').children('.modal-content').children('img').attr('id', 'img' + cnt);
    form.children('.input-field').children('.btn').children('.cropper-example-1').children('#modal1').children('.modal-content').children('#upload-image-x-1').attr('id', 'upload-image-x-' + cnt);
    form.children('.input-field').children('.btn').children('.cropper-example-1').children('#modal1').children('.modal-content').children('#upload-image-y-1').attr('id', 'upload-image-y-' + cnt);
    form.children('.input-field').children('.btn').children('.cropper-example-1').children('#modal1').children('.modal-content').children('#upload-image-w-1').attr('id', 'upload-image-w-' + cnt);
    form.children('.input-field').children('.btn').children('.cropper-example-1').children('#modal1').children('.modal-content').children('#upload-image-h-1').attr('id', 'upload-image-h-' + cnt);


    form.children('.input-field').children('.btn').children('.cropper-example-1').children('#modal1').attr('id', 'modal' + cnt);
    form.children('.input-field').children('.file-path-wrapper').children('input').attr('name', 'path').val('');
    form.removeClass('content')
    form.appendTo('.form');
    $('.modal').modal();
  });


  $(document).on('change', '[id^="profile-image"]', function() {
    var img = $(this).data('img');
    // 初期設定
    var options = {
      aspectRatio: 1 / 1,
      viewMode: 0,
      crop: function(e) {
        cropData = $('#img' + img).cropper("getData");
        $("#upload-image-x-" + img).val(Math.floor(cropData.x));
        $("#upload-image-y-" + img).val(Math.floor(cropData.y));
        $("#upload-image-w-" + img).val(Math.floor(cropData.width));
        $("#upload-image-h-" + img).val(Math.floor(cropData.height));
      },
      zoomable: true,
    };
    // ファイル選択変更時に、選択した画像をCropperに設定する
    $('#img' + img).cropper(options);
    $('#img' + img).cropper('replace', URL.createObjectURL(this.files[0]));
    $('#modal' + img).modal('open');
  });
  $(document).ready(function() {
    $('select').material_select();
  });

  $('#objective').on('click', function() {
    var input = $('#autocomplete-input').val();
    if (input.length == 0) {
      alert('入力してください。')
    } else {
      var tag = $('#input_objective').children('div').children('input').map(function(index, el) {
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
        $('#input_objective').append('<div class="chip">' + input + '<i class="close material-icons">close</i><input value="' + input + '" name="objective[]" type="hidden"></div>');
      }
    }
  });
});

/**
 * 目標のautocompleteを取得するメソッド
 **/
$(function() {
$.ajax({
    headers: {
      'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
    },
    url: '/programmer/autoComplete',
    type: 'POST',
  })
  .done(function(data) {
    console.log(data);
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
