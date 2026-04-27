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
    <link rel="canonical" href="https://kiyama-katakosi.com/">
    <link rel="icon" href="assets/img/favicon.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Zen+Kaku+Gothic+New:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/ress@4.0.0/dist/ress.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/header.css">
    <link rel="stylesheet" href="../assets/css/footer.css">
    <link rel="stylesheet" href="../assets/css/contact.css">
  </head>
  <body class="page-contact">
    <header class="site-header">
      <div class="site-header__inner l-container">
        <a class="site-header__brand" href="index.html">
          <img class="site-header__logo" src="../assets/img/1776753879505.png" alt="木山整体院 ロゴ">
          <span class="site-header__brand-text">
            <span class="site-header__name">きやま整体</span>
            <span class="site-header__subname">肩腰はりきゅう院</span>
          </span>
        </a>

        <button class="site-header__menu-button js-menu-button" type="button" aria-expanded="false" aria-controls="site-menu-panel" aria-label="メニューを開く">
          <span class="site-header__menu-line"></span>
          <span class="site-header__menu-line"></span>
          <span class="site-header__menu-line"></span>
        </button>
      </div>
    </header>

    <div class="site-menu-overlay js-menu-overlay" aria-hidden="true"></div>
    <nav id="site-menu-panel" class="site-menu js-menu-panel" aria-hidden="true" aria-label="グローバルメニュー">
      <div class="site-menu__inner l-container">
        <ul class="site-menu__list">
          <li class="site-menu__item">
            <a class="site-menu__link" href="javascript:void(0)" aria-disabled="true">三つの特徴</a>
          </li>
          <li class="site-menu__item">
            <a class="site-menu__link" href="javascript:void(0)" aria-disabled="true">院長あいさつ</a>
          </li>
          <li class="site-menu__item">
            <a class="site-menu__link" href="javascript:void(0)" aria-disabled="true">お客様の声</a>
          </li>
          <li class="site-menu__item">
            <a class="site-menu__link" href="javascript:void(0)" aria-disabled="true">施術の流れ</a>
          </li>
          <li class="site-menu__item">
            <a class="site-menu__link" href="javascript:void(0)" aria-disabled="true">料金</a>
          </li>
          <li class="site-menu__item">
            <a class="site-menu__link" href="javascript:void(0)" aria-disabled="true">アクセス</a>
          </li>
          <li class="site-menu__item">
            <a class="site-menu__link" href="javascript:void(0)" aria-disabled="true">お問い合わせ</a>
          </li>
        </ul>
      </div>

      <section class="site-menu-hours l-container">
        <h2 class="site-menu-hours__title">営業時間</h2>
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
        <p class="site-menu-hours__note">※当院は完全予約制でおこなっております。</p>
        <p class="site-menu-hours__note">※祝日も22:00まで営業しています</p>
      </section>

      <section class="site-menu-contact">
        <div class="site-menu-contact__bg" aria-hidden="true"></div>
        <div class="site-menu-contact__card l-container">
          <p class="site-menu-contact__label">Contact</p>
          <h2 class="site-menu-contact__title">お問い合わせ</h2>
          <p class="site-menu-contact__text">
            ご予約フォーム・お電話・公式LINE・Instagramから、
            <br>
            ご希望日時・メッセージをお送り下さい。
          </p>
          <div class="site-menu-contact__buttons">
            <a class="c-button c-button--line" href="tel:07035256934">070-3525-6934</a>
            <a class="c-button c-button--line" href="https://lin.ee/9mo0d6V" target="_blank" rel="noopener noreferrer">LINE</a>
            <a class="c-button c-button--line" href="https://www.instagram.com/kiyama.katakosi.harikyuuinn?igsh=emtpMG4xdDg5YTV5&utm_source=qr" target="_blank" rel="noopener noreferrer">Instagram</a>
          </div>
          <a class="c-button c-button--primary" href="javascript:void(0)">予約する</a>
        </div>
      </section>
    </nav>
    <main>
      <div class="wrapper">
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
      <div class="site-footer__main l-container">
        <div class="site-footer__info">
          <a class="site-footer__brand" href="index.html">
            <img
              class="site-footer__logo"
              src="../assets/img/1776753879505.png"
              alt="木山整体院 ロゴ"
              width="64"
              height="64"
            >
            <span class="site-footer__brand-text">
              <span class="site-footer__name">きやま整体</span>
              <span class="site-footer__subname">肩腰はりきゅう院</span>
            </span>
          </a>
          <address class="site-footer__address">
            〒000-0000 神奈川県横浜市鶴見区（住所仮）
          </address>
          <div class="site-footer__cta">
            <a class="c-button c-button--line" href="tel:07035256934">TEL</a>
            <a class="c-button c-button--line" href="https://lin.ee/9mo0d6V" target="_blank" rel="noopener noreferrer">LINE</a>
            <a class="c-button c-button--line" href="https://www.instagram.com/kiyama.katakosi.harikyuuinn?igsh=emtpMG4xdDg5YTV5&utm_source=qr" target="_blank" rel="noopener noreferrer">Instagram</a>
          </div>
        </div>

        <div class="site-footer__schedule">
          <h2 class="site-footer__schedule-title">営業時間</h2>
          <table class="site-footer__table">
            <thead>
              <tr>
                <th>時間</th>
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
                <td>10:00-22:00</td>
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
          <p class="site-footer__schedule-note">※当院は完全予約制です。※祝日も22:00まで営業しています。</p>
        </div>
      </div>

      <nav class="site-footer__nav" aria-label="フッターナビ">
        <ul class="site-footer__nav-list l-container">
          <li><a href="javascript:void(0)">トップ</a></li>
          <li><a href="javascript:void(0)">施術の流れ</a></li>
          <li><a href="javascript:void(0)">料金</a></li>
          <li><a href="javascript:void(0)">アクセス</a></li>
          <li><a href="javascript:void(0)">お問い合わせ</a></li>
        </ul>
      </nav>
    </footer>
    <script src="../assets/js/style.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  </body>
</html>