<?php
  require_once '../php/utils.php';
  require_once '../php/validate_utils.php';
  noCacheOnDebug();
  session_start();

  $isError = [];
  if(!hasValueIn('inquiry')){
    $isError['is_inquiry_empty'] = true;
  }
  if(!hasValueIn('name')){
      $isError['is_name_empty'] = true;
  }
  if(!hasValueIn('furigana')){
      $isError['is_furigana_empty'] = true;
  }elseif(!isKatakanaText($_POST['furigana'])){
      $isError['is_furigana_illegal'] = true;
  }
  $hasEmail = hasValueIn('email');
  $hasConfirmEmail = hasValueIn('confirm-email');
  if(!$hasEmail){
    $isError['is_email_empty'] = true;
  }elseif(!isMailText($_POST['email'])){
    $isError['is_email_illegal'] = true;
  }
  if(!$hasConfirmEmail){
    $isError['is_confirm_email_empty'] = true;
  }elseif(!isMailText($_POST['confirm-email'])){
    $isError['is_confirm_email_illegal'] = true;
  }
  if($hasEmail && $hasConfirmEmail && $_POST['confirm-email'] !== $_POST['email']){
    $isError['is_confirm_email_not_match'] = true;
  }
  if(!hasValueIn('tel')){
      $isError['is_tel_empty'] = true;
  }
  if(!hasValueIn('preferreddate')){
      $isError['is_preferreddate_empty'] = true;
  }
  if(!hasValueIn('comment')){
    $isError['is_comment_empty'] = true;
  }

  $_SESSION['post_data'] = $_POST;
  if(!empty($isError)){
      $_SESSION['errors'] = $isError;
      header("Status: 301 Moved Permanently");
      header("Location: ./contact.php");
      exit;
  }

  // ワンタイムトークンを生成
  $token = bin2hex(random_bytes(32));
  $_SESSION['token'] = $token;
  writeRequestLog();
?>
<?php
  require_once '../php/utils.php';
  noCacheOnDebug();
  session_start();

  $post_data = $_SESSION['post_data'] ?? [];
  $errors = $_SESSION['errors'] ?? [];

  unset($_SESSION['post_data']);
  unset($_SESSION['errors']);
  writeRequestLog();
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <title>お問い合わせ内容の確認 | きやま整体院</title>
    <meta charset="utf-8">
    <meta name="description" content="きやま整体院のお問い合わせ内容の確認ページです。">
    <meta name="keywords" content="きやま整体院, お問い合わせ, お問い合わせ内容の確認, お問い合わせ内容の確認ページ">
    <meta name="robots" content="index, follow">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta content="telephone=no" name="format-detection">
    <link rel="canonical" href="https://kiyama-katakosiharikyuuin.com/">
    <link rel="icon" href="https://tsurumiworks.com/assets/img/favicon.ico">
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
					<a aria-disabled="true" class="site-menu__link is-disabled" disabled>三つの特徴</a>
				</li>
				<li class="site-menu__item">
					<a aria-disabled="true" class="site-menu__link is-disabled" disabled>院長あいさつ</a>
				</li>
				<li class="site-menu__item">
					<a aria-disabled="true" class="site-menu__link is-disabled" disabled>お客様の声</a>
				</li>
				<li class="site-menu__item">
					<a aria-disabled="true" class="site-menu__link is-disabled" disabled>施術の流れ</a>
				</li>
				<li class="site-menu__item">
					<a aria-disabled="true" class="site-menu__link is-disabled" disabled>料金</a>
				</li>
				<li class="site-menu__item">
					<a aria-disabled="true" class="site-menu__link is-disabled" disabled>アクセス</a>
				</li>
				<li class="site-menu__item">
					<a class="site-menu__link" href="https://tsurumiworks.com/contact/contact.php">お問い合わせ</a>
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
      <section class="confirm-main" id="confirm">
        <div class="contact-main__inner l-inner">
          <h2 class="confirm-title">以下の内容でよろしいですか？</h2>
          <table class="form-table">
            <tr>
              <th>
                <p>お名前</p>
              </th>
              <td>
                <div class="row-content">
                  <?php echo htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8'); ?>
                </div>
              </td>
            </tr>
            <tr>
              <th>
                <p>フリガナ</p>
              </th>
              <td>
                <div class="row-content">
                  <?php echo htmlspecialchars($_POST['furigana'], ENT_QUOTES, 'UTF-8'); ?>
                </div>
              </td>
            </tr>
            <tr>
            <tr>
              <th>
                <p>メールアドレス</p>
              </th>
              <td>
                <div class="row-content">
                  <?php echo htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8'); ?>
                </div>
              </td>
            </tr>
            <tr>
              <th>
                <p>メールアドレス[確認用]</p>
              </th>
              <td>
                <div class="row-content">
                  <?php echo htmlspecialchars($_POST['confirm-email'], ENT_QUOTES, 'UTF-8'); ?>
                </div>
              </td>
            </tr>
            <tr>
              <th>
                <p>電話番号</p>
              </th>
              <td>
                <div class="row-content">
                  <?php echo htmlspecialchars($_POST['tel'], ENT_QUOTES, 'UTF-8'); ?>
                </div>
              </td>
            </tr>
            <tr>
              <th>
                <p>再診・初診</p>
              </th>
              <td>
                <div>
                  <?php echo htmlspecialchars($_POST['inquiry'], ENT_QUOTES, 'UTF-8'); ?>
                </div>
              </td>
            </tr>
            </tr>
              <th>
                <p>希望日時</p>
              </th>
              <td>
                <div class="row-content">
                  <?php echo htmlspecialchars($_POST['preferreddate'], ENT_QUOTES, 'UTF-8'); ?>
                </div>
              </td>
            </tr>
              <th>
                <p>メニュー</p>
              </th>
              <td>
                <div>
                  <?php echo htmlspecialchars($_POST['menu'], ENT_QUOTES, 'UTF-8'); ?>
                </div>
              </td>
            </tr>
            <tr>
              <th>
                <p>症状の詳細</p>
              </th>
              <td>
                <div class="last-form-content"><?php echo htmlspecialchars($_POST['comment'], ENT_QUOTES, 'UTF-8'); ?></div>
              </td>
            </tr>
            <tr class="last-tr">
              <th>
                <p>その他</p>
              </th>
              <td>
                <div class="last-form-content"><?php echo htmlspecialchars($_POST['other'], ENT_QUOTES, 'UTF-8'); ?></div>
              </td>
            </tr>
          </table>
          <form action="./complete.php" class="confirm-form" method="post">
            <button class="button back-button" formaction="./contact.php" formmethod="post" type="submit">
              <span class="submit-text">
                  <svg class="arrow--left" width="20" height="20" viewBox="0 0 24 24">
                    <path d="M5 12h14M13 5l7 7-7 7"
                    stroke="white"
                    stroke-width="2"
                    fill="none"
                    stroke-linecap="round"
                    stroke-linejoin="round" />
                  </svg>戻る</span>
            </button>
            <button class="button top-button" formmethod="post" type="submit">
              <span class="submit-text">送信する
                  <svg width="20" height="20" viewBox="0 0 24 24">
                    <path d="M5 12h14M13 5l7 7-7 7"
                    stroke="white"
                    stroke-width="2"
                    fill="none"
                    stroke-linecap="round"
                    stroke-linejoin="round" />
                  </svg></span>
            </button>
              <?php foreach ($_POST as $key => $value): ?>
                <input name="<?php echo $key; ?>" type="hidden" value="<?php echo $value; ?>">
              <?php endforeach; ?>
              <input name="token" type="hidden" value="<?php echo $token; ?>">
          </form>
        </div>
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
					<a class="c-button c-button--line site-footer__cta-button site-footer__cta-button--tel" href="tel:07035256934" rel="noopener noreferrer"><img alt="" class="c-button__icon" src="https://tsurumiworks.com/assets/img/tel-icon.svg"> <span>070-3525-6934</span></a> <a class="c-button c-button--line site-footer__cta-button" href="https://lin.ee/9mo0d6V" rel="noopener noreferrer" target="_blank"><span>LINE</span> <img alt="" class="c-button__icon" src="https://tsurumiworks.com/assets/img/external-link-icon.svg"></a> <a class="c-button c-button--line site-footer__cta-button" href="https://www.instagram.com/kiyama.katakosi.harikyuuinn?igsh=emtpMG4xdDg5YTV5&utm_source=qr" rel="noopener noreferrer" target="_blank"><span>Instagram</span> <img alt="" class="c-button__icon" src="https://tsurumiworks.com/assets/img/external-link-icon.svg"></a>
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
					<a aria-disabled="true" class="is-disabled" href="#" disabled>三つの特徴</a>
				</li>
				<li>
					<a aria-disabled="true" class="is-disabled" href="#" disabled>今までの成り立ち</a>
				</li>
				<li>
					<a aria-disabled="true" class="is-disabled" href="#" disabled>施術の流れ</a>
				</li>
				<li>
					<a aria-disabled="true" class="is-disabled" href="#" disabled>営業時間</a>
				</li>
				<li>
					<a aria-disabled="true" class="is-disabled" href="#" disabled>料金</a>
				</li>
				<li>
					<a aria-disabled="true" class="is-disabled" href="#" disabled>アクセス</a>
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
  </body>
</html>