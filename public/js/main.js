$(function () {
  // フォーム同意にチェックが入ったら送信ボタン有効化
  var formTerm = $('#formTerm'),
      formSubmit = $('#formSubmit');
  
  if (formTerm. prop("checked")) {
    formSubmit. prop('disabled', false);
  }
  
  formTerm. on('change', function () {
    if ($(this). prop("checked")) {
      formSubmit. prop('disabled', false);
    } else {
      formSubmit. prop('disabled', true);
    }
  });


  // ダッシュボード大会一覧ドロップダウン
  $('.dashboard_tournaments-title'). on('click', function () {
    if ($(this).hasClass('active')) {
      $(this). removeClass('active');
      $(this). siblings('.dashboard_tournaments-lists'). slideUp();
    } else {
      $(this). addClass('active');
      $(this). siblings('.dashboard_tournaments-lists'). slideDown();
    }
  });
});