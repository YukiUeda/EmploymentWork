$(function() {
  $('.button-collapse').sideNav();


  // 初期設定
  var options = {
    aspectRatio: 1 / 1,
    viewMode: 1,
    crop: function(e) {
      cropData = $('#img').cropper("getData");
      $("#upload-image-x").val(Math.floor(cropData.x));
      $("#upload-image-y").val(Math.floor(cropData.y));
      $("#upload-image-w").val(Math.floor(cropData.width));
      $("#upload-image-h").val(Math.floor(cropData.height));
    },
    zoomable: false,
    minCropBoxWidth: 162,
    minCropBoxHeight: 162
  }
  $('#img').cropper(options);
  $('.modal').modal();
  $("#profile-image").change(function() {
    // ファイル選択変更時に、選択した画像をCropperに設定する
    $('#img').cropper('replace', URL.createObjectURL(this.files[0]));
    $('#modal1').modal('open');
  });
  $(document).ready(function() {
    $('select').material_select();
  });
});
