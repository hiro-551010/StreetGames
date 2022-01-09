$(function () {
    // チャットページスクロール
    var oldBtn = $('.chat_content-top'),
    latestBtn = $('.chat_content-bottom'),
    box = $('.chat_content-message'), // スクロール要素
    boxHeight = box. get(0). scrollHeight, // 要素の高さ
    boxArea = box. get(0). offsetHeight; // 表示領域

// 読み込み時に最下部までスクロールしておく
box. scrollTop(boxHeight - boxArea);
// 最初のメッセージと最後のメッセージにID属性付与
$('.chat_list > li:first'). attr('id', 'oldMessage');
$('.chat_list > li:last'). attr('id', 'latestMessage');

box.on('scroll', function () {
  // 古いボタン表示・非表示
  if ($(this). scrollTop() > 150) {
    oldBtn. css('display', 'block');
  } else {
    oldBtn. css('display', 'none');
  }
  // 新しいボタン表示・非表示
  if (boxHeight - $(this). scrollTop() < boxArea + 150) {
    latestBtn. css('display', 'none');
  } else {
    latestBtn. css('display', 'flex');
  }
});

// ボタンでスクロール
var btn = $('.chat_content-btn > a'),
    target,
    targetPosition;

btn. on('click', function (e) {
  e.preventDefault(); // リンククリック無効化
  target = $(this). attr('href'); // リンクの遷移先を取得
  targetPosition = $(target). position(). top; // 親からの相対位置を取得

  // スクロールさせる
  box. animate({
    scrollTop: targetPosition
  }, 400);
});
});