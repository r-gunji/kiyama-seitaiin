"use strict";

document.addEventListener("DOMContentLoaded", function () {
  var menuButton = document.querySelector(".js-menu-button");
  var menuPanel = document.querySelector(".js-menu-panel");
  var menuOverlay = document.querySelector(".js-menu-overlay");

  if (!menuButton || !menuPanel || !menuOverlay) {
    return;
  }

  var openMenu = function openMenu() {
    menuButton.classList.add("is-open");
    menuPanel.classList.add("is-open");
    menuOverlay.classList.add("is-open");
    document.body.classList.add("is-menu-open");
    menuButton.setAttribute("aria-expanded", "true");
    menuButton.setAttribute("aria-label", "メニューを閉じる");
    menuPanel.setAttribute("aria-hidden", "false");
    menuOverlay.setAttribute("aria-hidden", "false");
  };

  var closeMenu = function closeMenu() {
    menuButton.classList.remove("is-open");
    menuPanel.classList.remove("is-open");
    menuOverlay.classList.remove("is-open");
    document.body.classList.remove("is-menu-open");
    menuButton.setAttribute("aria-expanded", "false");
    menuButton.setAttribute("aria-label", "メニューを開く");
    menuPanel.setAttribute("aria-hidden", "true");
    menuOverlay.setAttribute("aria-hidden", "true");
  };

  var toggleMenu = function toggleMenu() {
    if (menuPanel.classList.contains("is-open")) {
      closeMenu();
      return;
    }

    openMenu();
  };

  menuButton.addEventListener("click", toggleMenu);
  menuOverlay.addEventListener("click", function () {
    closeMenu();
  });
  document.addEventListener("keydown", function (event) {
    if (event.key === "Escape" && menuPanel.classList.contains("is-open")) {
      closeMenu();
    }
  });
}); ////////////////////////////////////////////////////////////////////
//各ブラウザ毎のスクロールバー計算　var(--scrollbar)にて自動計算
////////////////////////////////////////////////////////////////////

function setScrollbarWidth() {
  var scrollbarWidth = window.innerWidth - document.documentElement.clientWidth;
  document.documentElement.style.setProperty('--scrollbar', "".concat(scrollbarWidth, "px"));
} // 初回実行


window.addEventListener('load', setScrollbarWidth); // リサイズ時にも再計算

window.addEventListener('resize', setScrollbarWidth);