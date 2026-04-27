<?php
  require_once '../php/utils.php';
  noCacheOnDebug();
  session_start();

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST)) {
    $post_data = $_POST;
    unset($post_data['token']);
    $errors = [];
  } else {
    $post_data = $_SESSION['post_data'] ?? [];
    $errors = $_SESSION['errors'] ?? [];
  }

  unset($_SESSION['post_data']);
  unset($_SESSION['errors']);
  writeRequestLog();
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <title>お問い合わせ｜きやま整体院</title>
    <meta charset="utf-8">
    <meta name="description" content="きやま整体院のお問い合わせページです。">
    <meta name="keywords" content="きやま整体院, お問い合わせ, お問い合わせページ">
    <meta name="robots" content="index, follow">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta content="telephone=no" name="format-detection">
    <link rel="canonical" href="https://kiyama-katakosi.com/">
    <link rel="icon" href="assets/img/favicon.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Zen+Kaku+Gothic+New:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/ress@4.0.0/dist/ress.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://tsurumiworks.com/assets/css/style.css">
    <link rel="stylesheet" href="https://tsurumiworks.com/assets/css/header.css">
    <link rel="stylesheet" href="https://tsurumiworks.com/assets/css/footer.css">
    <link rel="stylesheet" href="https://tsurumiworks.com/assets/css/contact.css">
  </head>
  <body class="page-contact">
	<header class="site-header">
		<div class="site-header__inner wrapper">
			<a class="site-header__brand" href="https://tsurumiworks.com/index.html"><img alt="木山整体院 ロゴ" class="site-header__logo" src="https://tsurumiworks.com/assets/img/1776753879505.webp"> <span class="site-header__brand-text"><span class="site-header__name">きやま整体</span> <span class="site-header__subname">肩腰はりきゅう院</span></span></a> <button aria-controls="site-menu-panel" aria-expanded="false" aria-label="メニューを開く" class="site-header__menu-button js-menu-button" type="button"><span class="site-header__menu-line"></span> <span class="site-header__menu-line"></span> <span class="site-header__menu-line"></span></button>
		</div>
	</header>
	<div aria-hidden="true" class="site-menu-overlay js-menu-overlay"></div>
	<nav aria-hidden="true" aria-label="グローバルメニュー" class="site-menu js-menu-panel" id="site-menu-panel">
		<div class="site-menu__inner wrapper">
			<ul class="site-menu__list">
				<li class="site-menu__item">
					<a aria-disabled="true" class="site-menu__link" disabled>三つの特徴</a>
				</li>
				<li class="site-menu__item">
					<a aria-disabled="true" class="site-menu__link" disabled>院長あいさつ</a>
				</li>
				<li class="site-menu__item">
					<a aria-disabled="true" class="site-menu__link" disabled>お客様の声</a>
				</li>
				<li class="site-menu__item">
					<a aria-disabled="true" class="site-menu__link" disabled>施術の流れ</a>
				</li>
				<li class="site-menu__item">
					<a aria-disabled="true" class="site-menu__link" disabled>料金</a>
				</li>
				<li class="site-menu__item">
					<a aria-disabled="true" class="site-menu__link" disabled>アクセス</a>
				</li>
				<li class="site-menu__item">
					<a aria-disabled="true" class="site-menu__link" disabled>お問い合わせ</a>
				</li>
			</ul>
		</div>
		<section class="site-menu-hours wrapper">
			<hgroup>
				<h2>営業時間</h2>
			</hgroup>
			<div class="site-menu-hours__table-wrap">
				<table class="site-menu-hours__table">
					<thead>
						<tr>
							<th></th>
							<th>月</th>
							<th>火</th>
							<th>水</th>
							<th>木</th>
							<th>金</th>
							<th>土</th>
							<th>日</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th>10:00〜22:00</th>
							<td>◯</td>
							<td>◯</td>
							<td>◯</td>
							<td>◯</td>
							<td>◯</td>
							<td>◯</td>
							<td>◯</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="site-menu-hours__note">
				<p>※当院は完全予約制でおこなっております。</p>
				<p>※祝日も22:00まで営業しています</p>
			</div>
		</section>
		<section class="site-menu-contact">
			<div aria-hidden="true" class="site-menu-contact__bg"></div>
			<div class="site-menu-contact__card wrapper">
				<hgroup>
					<p>Contact</p>
					<h2>お問い合わせ</h2>
				</hgroup>
				<p class="site-menu-contact__text">ご予約フォーム・お電話・インスタDM・LINE等から、<br>
				ご希望日時・メッセージをお送り下さい。</p>
				<div class="site-menu-contact__buttons">
					<a class="c-button c-button--line site-menu-contact__button--tel" href="tel:07035256934"><img alt="" class="c-button__icon" src="https://tsurumiworks.com/assets/img/tel-icon.svg"> 070-3525-6934</a> <a class="c-button c-button--line site-menu-contact__button--external" href="https://lin.ee/9mo0d6V" rel="noopener noreferrer" target="_blank">LINE <img alt="" class="c-button__icon" src="https://tsurumiworks.com/assets/img/external-link-icon.svg"></a>
				</div><a class="c-button c-button--primary site-menu-contact__reserve-button" href="https://tsurumiworks.com/contact/contact.php">予約する</a>
			</div>
		</section>
	</nav>

    <main>
      <div class="c-wrapper">
        <section id="contact-title">
          <hgroup>
            <p>contact</p>
            <h2>お問い合わせ</h2>
          </hgroup>
        </section>
        <section id="contact-form">
          <form class="contact-main__form" action="confirm.php" method="post">
            <div class="form-field">

              <div class="form-row <?php if (isset($errors['is_name_empty'])) echo 'open-empty'; ?>">
                <span class="list-title">
                  <label for="name">お名前</label>
                  <h5 class="required">＊</h5>
                </span>
                <input autocomplete="name" id="name" name="name" placeholder="入力例：田中太郎" type="text" value="<?php echo htmlspecialchars($post_data['name'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
                <?php if (isset($errors['is_name_empty'])): ?>
                  <span class="error-message <?php if (isset($errors['is_name_empty'])) echo 'open'; ?>">※お名前を入力してください</span>
                <?php endif; ?>
              </div>

              <div class="form-row <?php if (isset($errors['is_furigana_empty'])) echo 'open-empty'; ?> <?php if (isset($errors['is_furigana_illegal'])) echo 'open'; ?>">
                <span class="list-title">
                  <label for="furigana">フリガナ</label>
                  <h5 class="required">＊</h5>
                </span>
                <input autocomplete="additional-name" id="furigana" name="furigana" placeholder="入力例：タナカタロウ" type="text" value="<?php echo htmlspecialchars($post_data['furigana'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
                <?php if (isset($errors['is_furigana_empty']) || isset($errors['is_furigana_illegal'])): ?>
                  <span class="error-message <?php if (isset($errors['is_furigana_empty']) || isset($errors['is_furigana_illegal'])) echo 'open'; ?>">※フリガナを正しく入力してください</span>
                <?php endif; ?>
              </div>

              <div class="form-row <?php if (isset($errors['is_email_empty'])) echo 'open-empty'; ?> <?php if (isset($errors['is_email_illegal'])) echo 'open'; ?>">
                <span class="list-title">
                  <label for="email">メールアドレス</label>
                  <h5 class="required">＊</h5>
                </span>
                <input autocomplete="email" id="email" name="email" placeholder="入力例：info@example.jp" type="email" value="<?php echo htmlspecialchars($post_data['email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
                <?php if (isset($errors['is_email_empty']) || isset($errors['is_email_illegal'])): ?>
                  <span class="error-message <?php if (isset($errors['is_email_empty']) || isset($errors['is_email_illegal'])) echo 'open'; ?>">※メールアドレスを正しく入力してください</span>
                <?php endif; ?>
              </div>

              <div class="form-row <?php if (isset($errors['is_confirm_email_empty'])) echo 'open-empty'; ?> <?php if (isset($errors['is_confirm_email_illegal']) || isset($errors['is_confirm_email_not_match'])) echo 'open'; ?>">
                <span class="list-title">
                  <label for="confirm-email">メールアドレス[確認用]</label>
                  <h5 class="required">＊</h5>
                </span>
                <input autocomplete="email" id="confirm-email" name="confirm-email" placeholder="入力例：info@example.jp" type="email" value="<?php echo htmlspecialchars($post_data['confirm-email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
                <?php if (isset($errors['is_confirm_email_empty']) || isset($errors['is_confirm_email_illegal']) || isset($errors['is_confirm_email_not_match'])): ?>
                  <span class="error-message <?php if (isset($errors['is_confirm_email_empty']) || isset($errors['is_confirm_email_illegal']) || isset($errors['is_confirm_email_not_match'])) echo 'open'; ?>">※確認用メールアドレスを正しく入力してください</span>
                <?php endif; ?>
              </div>

              <div class="form-row">
                <span class="list-title">
                  <label for="tel">電話番号</label>
                  <h5 class="required">＊</h5>
                </span>
                <input autocomplete="tel-national" id="tel" name="tel" placeholder="入力例：00011112222" type="tel" value="<?php echo htmlspecialchars($post_data['tel'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
                <?php if (isset($errors['is_tel_empty'])): ?>
                  <span class="error-message <?php if (isset($errors['is_tel_empty'])) echo 'open'; ?>">※電話番号を入力してください</span>
                <?php endif; ?>
              </div>

              <div class="form-row">
                <span class="list-title">
                  <label class="contact-main__label" for="inquiry">再診・初診</label>
                  <h5 class="required">＊</h5>
                </span>
                <div class="contact-main__control">
                  <div class="contact-main__select">
                    <select id="inquiry" name="inquiry" required>
                      <option value="">選択してください</option>
                      <option value="再診" <?php echo (($post_data['inquiry'] ?? '') === '再診') ? 'selected' : ''; ?>>再診</option>
                      <option value="初診" <?php echo (($post_data['inquiry'] ?? '') === '初診') ? 'selected' : ''; ?>>初診</option>
                    </select>
                  </div>
                </div>
              </div>

              <div class="form-row">
                <span class="list-title">
                  <label for="preferreddate">希望日時</label>
                  <h5 class="required">＊</h5>
                </span>
                <input autocomplete="off" id="preferreddate" name="preferreddate" placeholder="/年/月/日 --:--" type="datetime-local" value="<?php echo htmlspecialchars($post_data['preferreddate'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
                <script>
                  const now = new Date();

                  const formatted = now.toISOString().slice(0,16);

                  document.getElementById("preferreddate").min = formatted;
                  
              </script>
                <?php if (isset($errors['is_preferreddate_empty'])): ?>
                  <span class="error-message <?php if (isset($errors['is_preferreddate_empty'])) echo 'open'; ?>">※希望日時を入力してください</span>
                <?php endif; ?>
              </div>

              <div class="form-row">
                <span class="list-title">
                  <label class="contact-main__label" for="menu">メニュー</label>
                  <h5 class="required">＊</h5>
                </span>
                <div class="contact-main__control">
                  <div class="contact-main__select">
                    <select id="menu" name="menu" required>
                      <option value="">選択してください</option>
                      <option value="整体" <?php echo (($post_data['menu'] ?? '') === '整体') ? 'selected' : ''; ?>>整体</option>
                      <option value="鍼灸" <?php echo (($post_data['menu'] ?? '') === '鍼灸') ? 'selected' : ''; ?>>鍼灸</option>
                    </select>
                  </div>
                </div>
              </div>

              <div class="form-row">
                <span class="list-title">
                  <label for="comment">症状の詳細</label>
                  <h5 class="required">＊</h5>
                </span>
                <textarea autocomplete="off" id="comment" name="comment" placeholder="できるだけ詳しくお書きください" required><?php echo htmlspecialchars($post_data['comment'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
                <?php if (isset($errors['is_comment_empty'])): ?>
                  <span class="error-message <?php if (isset($errors['is_comment_empty'])) echo 'open'; ?>">※お問い合わせ内容を入力してください</span>
                <?php endif; ?>
              </div>

              <div class="form-row last-form-row">
                <span class="list-title">
                  <label for="other">その他</label>
                  <h5 class="optional"></h5>
                </span>
                <textarea autocomplete="off" id="other" name="other" placeholder="ご質問・ご要望等ございましたらご記入ください" ><?php echo htmlspecialchars($post_data['other'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
              </div>

            </div>
            <div class="contact-main__consent">
              <div class="form-consent">
                <div class="agree">
                  <label for="agree">
                    <input id="agree" name="agree" type="checkbox" required>
                    <span class="checkmark"></span>
                    <span><a href="https://tsurumiworks.com/privacypolicy.html">プライバシーポリシー</a>に同意する</span>
                  </label>
                </div>

                <button class="button top-button" id="submitBtn" type="submit"><span class="submit-text">確認する
                  <svg width="20" height="20" viewBox="0 0 24 24">
                    <path d="M5 12h14M13 5l7 7-7 7"
                    stroke="white"
                    stroke-width="2"
                    fill="none"
                    stroke-linecap="round"
                    stroke-linejoin="round" />
                  </svg>
                </span></button>
              </div>
            </div>
          </form>
        </section>
      </div>
    </main>
	<footer class="site-footer">
		<div class="site-footer__main wrapper">
			<div class="site-footer__info">
				<a class="site-footer__brand" href="https://tsurumiworks.com/index.html"><img alt="木山整体院 ロゴ" class="site-footer__logo" src="https://tsurumiworks.com/assets/img/1776753879505.webp"> <span class="site-footer__brand-text"><span class="site-footer__name">きやま整体</span> <span class="site-footer__subname">肩腰はりきゅう院</span></span></a>
				<div class="site-footer__address-row">
					<address class="site-footer__address">
						<span>〒769-1601</span> <span>香川県観音寺市豊浜町姫浜 701-1</span>
					</address><a class="site-footer__detail-link" href="https://maps.app.goo.gl/cKzpzbnaSFheEMDWA" rel="noopener noreferrer" target="_blank">詳しくはこちら <img alt="" class="c-button__icon" src="https://tsurumiworks.com/assets/img/map-pin.svg"></a>
				</div>
				<div class="site-footer__cta">
					<a class="c-button c-button--line site-footer__cta-button site-footer__cta-button--tel" href="tel:07035256934" rel="noopener noreferrer" target="_blank"><img alt="" class="c-button__icon" src="https://tsurumiworks.com/assets/img/tel-icon.svg"> <span>070-3525-6934</span></a> <a class="c-button c-button--line site-footer__cta-button" href="https://lin.ee/9mo0d6V" rel="noopener noreferrer" target="_blank"><span>LINE</span> <img alt="" class="c-button__icon" src="https://tsurumiworks.com/assets/img/external-link-icon.svg"></a> <a class="c-button c-button--line site-footer__cta-button" href="https://www.instagram.com/kiyama.katakosi.harikyuuinn?igsh=emtpMG4xdDg5YTV5&utm_source=qr" rel="noopener noreferrer" target="_blank"><span>Instagram</span> <img alt="" class="c-button__icon" src="https://tsurumiworks.com/assets/img/external-link-icon.svg"></a>
				</div>
			</div>
			<div class="site-footer__schedule">
				<table class="site-footer__table">
					<thead>
						<tr>
							<th>営業時間</th>
							<th>月</th>
							<th>火</th>
							<th>水</th>
							<th>木</th>
							<th>金</th>
							<th>土</th>
							<th>日</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th>10:00~22:00</th>
							<td>◯</td>
							<td>◯</td>
							<td>◯</td>
							<td>◯</td>
							<td>◯</td>
							<td>◯</td>
							<td>◯</td>
						</tr>
					</tbody>
				</table>
				<p class="site-footer__schedule-note site-footer__schedule-note--accent">土日祝も営業・年中無休（※随時休業あり）</p>
				<p class="site-footer__schedule-note">※当院は完全予約制でおこなっております。<br>
				※祝日も22:00まで営業しています</p>
			</div>
		</div>
		<nav aria-label="フッターナビ" class="site-footer__nav">
			<ul class="site-footer__nav-list wrapper">
				<li>
					<a href="#" disabled>三つの特徴</a>
				</li>
				<li>
					<a href="#" disabled>今までの成り立ち</a>
				</li>
				<li>
					<a href="#" disabled>施術の流れ</a>
				</li>
				<li>
					<a href="#" disabled>営業時間</a>
				</li>
				<li>
					<a href="#" disabled>料金</a>
				</li>
				<li>
					<a href="#" disabled>アクセス</a>
				</li>
				<li>
					<a href="https://tsurumiworks.com/contact/contact.php">お問い合わせ</a>
				</li>
				<li>
					<a href="https://tsurumiworks.com/privacy.html">プライバシーポリシー</a>
				</li>
			</ul>
		</nav>
	</footer>

    <script src="https://tsurumiworks.com/assets/js/style.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://tsurumiworks.com/assets/js/contact.js"></script>
  </body>
</html>