document.addEventListener("DOMContentLoaded", function() {
	const menuButton = document.querySelector(".js-menu-button");
	const menuPanel = document.querySelector(".js-menu-panel");
	const menuOverlay = document.querySelector(".js-menu-overlay");
	if (!menuButton || !menuPanel || !menuOverlay) {
		return;
	}
	const openMenu = function() {
		menuButton.classList.add("is-open");
		menuPanel.classList.add("is-open");
		menuOverlay.classList.add("is-open");
		document.body.classList.add("is-menu-open");
		menuButton.setAttribute("aria-expanded", "true");
		menuButton.setAttribute("aria-label", "メニューを閉じる");
		menuPanel.setAttribute("aria-hidden", "false");
		menuOverlay.setAttribute("aria-hidden", "false");
	};
	const closeMenu = function() {
		menuButton.classList.remove("is-open");
		menuPanel.classList.remove("is-open");
		menuOverlay.classList.remove("is-open");
		document.body.classList.remove("is-menu-open");
		menuButton.setAttribute("aria-expanded", "false");
		menuButton.setAttribute("aria-label", "メニューを開く");
		menuPanel.setAttribute("aria-hidden", "true");
		menuOverlay.setAttribute("aria-hidden", "true");
	};
	const toggleMenu = function() {
		if (menuPanel.classList.contains("is-open")) {
			closeMenu();
			return;
		}
		openMenu();
	};
	menuButton.addEventListener("click", toggleMenu);
	menuOverlay.addEventListener("click", function() {
		closeMenu();
	});
	document.addEventListener("keydown", function(event) {
		if (event.key === "Escape" && menuPanel.classList.contains("is-open")) {
			closeMenu();
		}
	});
});
////////////////////////////////////////////////////////////////////
//各ブラウザ毎のスクロールバー計算　var(--scrollbar)にて自動計算
////////////////////////////////////////////////////////////////////
function setScrollbarWidth() {
	const scrollbarWidth = window.innerWidth - document.documentElement.clientWidth;
	document.documentElement.style.setProperty('--scrollbar', `${scrollbarWidth}px`);
}
// 初回実行
window.addEventListener('load', setScrollbarWidth);
// リサイズ時にも再計算
window.addEventListener('resize', setScrollbarWidth);

document.addEventListener("DOMContentLoaded", function() {
	const fvCard = document.querySelector(".fv__card");
	const closeButton = document.querySelector(".js-fv-card-close");
	const footer = document.querySelector(".site-footer");
	if (!fvCard || !closeButton || !footer) {
		return;
	}
	const fadeOffset = 24;
	const updateFvCardFade = function() {
		if (fvCard.classList.contains("is-closed")) {
			return;
		}
		const footerTop = footer.getBoundingClientRect().top;
		const shouldFade = footerTop <= window.innerHeight - fadeOffset;
		fvCard.classList.toggle("is-fading", shouldFade);
	};
	closeButton.addEventListener("click", function() {
		fvCard.classList.add("is-closed");
	});
	window.addEventListener("scroll", updateFvCardFade, {
		passive: true
	});
	window.addEventListener("resize", updateFvCardFade);
	updateFvCardFade();
});