"use strict";

$(function () {
  if (!$('.contact-main__form').length) return;
  var $page = $('html, body');
  var $header = $('header'); // 共通スクロール関数（対象を画面中央寄せ）

  function scrollToCenter($target) {
    var speed = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 300;
    var extraAdjust = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 0;
    if (!$target.length) return;
    var headerHeight = $header.outerHeight() || 0;
    var targetTop = $target.offset().top;
    var targetHeight = $target.outerHeight() || 0;
    var windowHeight = $(window).height();
    var scrollTop = targetTop - headerHeight - windowHeight / 2 + targetHeight / 2 + extraAdjust;
    $page.stop().animate({
      scrollTop: Math.max(scrollTop, 0)
    }, speed);
  } // =========================
  // 1) PHPバリデーションエラー再表示時
  // =========================
  // エラーが付与されている最初の行を探す


  var $firstErrorRow = $('.form-field .form-row.open').first();

  if ($firstErrorRow.length) {
    // 入力エラー箇所へ移動（フォーム先頭にしたい場合は .form-field に変える）
    scrollToCenter($firstErrorRow, 300); // 任意：該当input/textarea/selectにフォーカス

    var $focusTarget = $firstErrorRow.find('input, textarea, select').first();

    if ($focusTarget.length) {
      $focusTarget.trigger('focus');
    }
  }

  $(function () {
    if (!$('#contact-form').length) return; // ページ読み込み時に PHP のエラーがあれば form-error を表示

    if ($('.form-field .open-empty').length > 0) {
      $('.form-error').css('visibility', 'visible');
      $('html, body').scrollTop(0);
    }

    $('form').on('submit', function (e) {
      var isAgreeChecked = $('#agree').prop('checked');

      if (!isAgreeChecked) {
        e.preventDefault();
        $('.error-message-agree').addClass('open'); // 同意欄を画面中央にスクロール

        $('html, body').animate({
          scrollTop: $('.form-consent').offset().top - $(window).height() / 2 + $('.form-consent').height() / 2
        }, 'fast');
      }
    });
  });
});