$(function() {
	if (!$('.contact-main__form').length) return;

  const $page = $('html, body');
  const $header = $('header');

  // 共通スクロール関数（対象を画面中央寄せ）
  function scrollToCenter($target, speed = 300, extraAdjust = 0) {
    if (!$target.length) return;

    const headerHeight = $header.outerHeight() || 0;
    const targetTop = $target.offset().top;
    const targetHeight = $target.outerHeight() || 0;
    const windowHeight = $(window).height();

    const scrollTop =
      targetTop
      - headerHeight
      - (windowHeight / 2)
      + (targetHeight / 2)
      + extraAdjust;

    $page.stop().animate({ scrollTop: Math.max(scrollTop, 0) }, speed);
  }

  // =========================
  // 1) PHPバリデーションエラー再表示時
  // =========================
  // エラーが付与されている最初の行を探す
  const $firstErrorRow = $('.form-field .form-row.open').first();

  if ($firstErrorRow.length) {
    // 入力エラー箇所へ移動（フォーム先頭にしたい場合は .form-field に変える）
    scrollToCenter($firstErrorRow, 300);

    // 任意：該当input/textarea/selectにフォーカス
    const $focusTarget = $firstErrorRow.find('input, textarea, select').first();
    if ($focusTarget.length) {
      $focusTarget.trigger('focus');
    }
  }

  $(function() {
    if (!$('#contact-form').length) return;
    // ページ読み込み時に PHP のエラーがあれば form-error を表示
    if ($('.form-field .open-empty').length > 0) {
      $('.form-error').css('visibility', 'visible');
      $('html, body').scrollTop(0);
    }

    $('form').on('submit', function(e) {
      var isAgreeChecked = $('#agree').prop('checked');
      if (!isAgreeChecked) {
        e.preventDefault();
        $('.error-message-agree').addClass('open');
        // 同意欄を画面中央にスクロール
        $('html, body').animate({
          scrollTop: $('.form-consent').offset().top - ($(window).height()/2) + ($('.form-consent').height()/2)
        }, 'fast');
      }
    });
  });
});