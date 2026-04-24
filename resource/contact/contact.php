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
        <section id="contact-title">
          <hgroup>
            <p>contact</p>
            <h2>お問い合わせ</h2>
          </hgroup>
        </section>
        <section id="contact-form">
          <!--<div class="form-error">
            <p>未入力の項目があります。</p>
          </div>-->
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

                  // YYYY-MM-DDTHH:MM 形式に整形
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
                    <span><a href="../privacypolicy.html">プライバシーポリシー</a>に同意する</span>
                  </label>
                  <!--<div class="error-message-agree">
                    ※プライバシーポリシーに同意してください
                  </div>-->
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
    <script src="../assets/js/contact.js"></script>
  </body>
</html>