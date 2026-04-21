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
    <title>お問い合わせ | 株式会社タイム</title>
    <meta charset="utf-8">
    <meta name="description" content="株式会社タイムのお問い合わせページです。">
    <meta name="keywords" content="株式会社タイム, お問い合わせ, お問い合わせページ">
    <meta name="robots" content="index, follow">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta content="telephone=no" name="format-detection">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Zen+Kaku+Gothic+New:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/ress@4.0.0/dist/ress.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/common.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
    <link rel="stylesheet" href="/assets/css/contact.css">
  </head>
  <body class="page-contact">
    <?php include __DIR__ . '/../includes/header.php'; ?>
    <main>
      <section class="page-mv page-mv--simple">
        <div class="page-mv__inner l-inner">
          <h1 class="page-mv__title">
            <span class="page-mv__title-en">Contact</span>
            <span class="page-mv__title-jp"><span class="u-hidden-sp">/</span>お問い合わせ</span>
          </h1>
        </div>
        <div class="page-mv__wave" aria-hidden="true">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            xmlns:xlink="http://www.w3.org/1999/xlink"
            viewBox="0 0 1380 145"
            width="1380"
            height="145"
            preserveAspectRatio="xMidYMid slice"
          >
            <defs>
              <linearGradient id="page-mv-wave-gradient" x1="0" y1="0" x2="1" y2="0">
                <stop offset="0%" stop-color="#0f5cb8"/>
                <stop offset="100%" stop-color="#0b4a97"/>
              </linearGradient>
            </defs>
            <path fill-rule="evenodd" fill="url(#page-mv-wave-gradient)"
              d="M-0.000,0.040 L1379.1000,0.040 L1379.1000,117.511 C1379.1000,117.511 1322.204,145.993 1222.836,144.980 C1123.468,143.967 995.312,105.1000 899.1000,105.1000 C804.688,105.1000 692.731,147.814 544.497,138.714 C483.1000,134.1000 454.379,140.920 349.1000,86.1000 C265.812,43.510 253.490,49.535 215.974,38.395 C178.457,27.256 19.265,-0.972 -0.000,0.040 Z"/>
          </svg>
        </div>
      </section>

      <section class="contact-main">
        <div class="contact-main__inner l-inner">
          <div class="contact-main__intro">
            <h2 class="contact-main__title">床から始まる快適空間<br>心地良さを体験して<span class="u-nowrap">みませんか？</span></h2>
            <div class="contact-main__intro-text">
              <p>お問い合わせなどはこちらのメールフォームより承ります。<br>必要事項をご入力の上、「確認する」ボタンをクリックしてください。</p>
              <p class="contact-main__intro-note">※メールの場合、ご返信が少し遅くなることがあります。<br>お急ぎの方は、直接お電話をくださいますようお願いします。</p>
            </div>
          </div>
          <div class="contact-main__divider" aria-hidden="true"></div>
          <div class="contact-main__tel">
            <h3 class="contact-main__tel-title">お電話でのお問い合わせ <br class="u-hidden-pc"><span class="contact-main__tel-number">055-288-8844</span></h3>
            <p class="contact-main__tel-note">受付時間 平日 9:00 - 18:00（定休日：年末年始除く）</p>
          </div>
          <div class="contact-main__divider" aria-hidden="true"></div>
          <ol class="contact-main__steps" aria-label="お問い合わせの流れ">
            <li class="contact-main__step contact-main__step--active">
              <div class="contact-main__step-num">
                <span>01</span>
              </div>
              <span class="contact-main__step-label">内容入力</span>
            </li>
            <li class="contact-main__step">
              <div class="contact-main__step-num">
                <span>02</span>
              </div>
              <span class="contact-main__step-label">内容確認</span>
            </li>
            <li class="contact-main__step">
              <div class="contact-main__step-num">
                <span>03</span>
              </div>
              <span class="contact-main__step-label">送信完了</span>
            </li>
          </ol>
          <form class="contact-main__form" action="confirm.php" method="post">
            <div class="form-field">
              <div class="form-row">
                <label class="contact-main__label" for="inquiry">お問い合わせ項目</label>
                <span class="required">必須</span>
                <div class="contact-main__control">
                  <div class="contact-main__select">
                    <select id="inquiry" name="inquiry" required>
                      <option value="">選択してください</option>
                      <option value="ハウスクリーニング" <?php echo (($post_data['inquiry'] ?? '') === 'ハウスクリーニング') ? 'selected' : ''; ?>>ハウスクリーニング</option>
                      <option value="リフォーム" <?php echo (($post_data['inquiry'] ?? '') === 'リフォーム') ? 'selected' : ''; ?>>リフォーム</option>
                      <option value="外装工事" <?php echo (($post_data['inquiry'] ?? '') === '外装工事') ? 'selected' : ''; ?>>外装工事</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="form-row <?php if (isset($errors['is_name_empty'])) echo 'open-empty'; ?>">
                <label for="name">お名前</label>
                <span class="required">必須</span>
                <input autocomplete="name" id="name" name="name" placeholder="（例）名前　太郎　※姓名の間にスペースを入力してください" type="text" value="<?php echo htmlspecialchars($post_data['name'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                <?php if (isset($errors['is_name_empty'])): ?>
                  <span class="error-message <?php if (isset($errors['is_name_empty'])) echo 'open'; ?>">※お名前を入力してください</span>
                <?php endif; ?>
              </div>
              <div class="form-row <?php if (isset($errors['is_furigana_empty'])) echo 'open-empty'; ?> <?php if (isset($errors['is_furigana_illegal'])) echo 'open'; ?>">
                <label for="furigana">フリガナ</label>
                <span class="required">必須</span>
                <input autocomplete="family-name" id="furigana" name="furigana" placeholder="（例）ナマエ　タロウ　※全角カタカナで入力してください" type="text" value="<?php echo htmlspecialchars($post_data['furigana'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                <?php if (isset($errors['is_furigana_empty']) || isset($errors['is_furigana_illegal'])): ?>
                  <span class="error-message <?php if (isset($errors['is_furigana_empty']) || isset($errors['is_furigana_illegal'])) echo 'open'; ?>">※フリガナを正しく入力してください</span>
                <?php endif; ?>
              </div>
              <div class="form-row">
                <label for="organization">会社名</label>
                <span class="optional">任意</span>
                <input autocomplete="organization" id="organization" name="organization" placeholder="（例）株式会社タイム" type="text" value="<?php echo htmlspecialchars($post_data['organization'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
              </div>
              <div class="form-row <?php if (isset($errors['is_email_empty'])) echo 'open-empty'; ?> <?php if (isset($errors['is_email_illegal'])) echo 'open'; ?>">
                <label for="email">メールアドレス</label>
                <span class="required">必須</span>
                <input autocomplete="email" id="email" name="email" placeholder="（例）mail@example.com" type="email" value="<?php echo htmlspecialchars($post_data['email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
                <?php if (isset($errors['is_email_empty']) || isset($errors['is_email_illegal'])): ?>
                  <span class="error-message <?php if (isset($errors['is_email_empty']) || isset($errors['is_email_illegal'])) echo 'open'; ?>">※メールアドレスを正しく入力してください</span>
                <?php endif; ?>
              </div>
              <div class="form-row <?php if (isset($errors['is_confirm_email_empty'])) echo 'open-empty'; ?> <?php if (isset($errors['is_confirm_email_illegal']) || isset($errors['is_confirm_email_not_match'])) echo 'open'; ?>">
                <label for="confirm-email">メールアドレス（確認用）</label>
                <span class="required">必須</span>
                <input autocomplete="email" id="confirm-email" name="confirm-email" placeholder="確認のため再度入力してください" type="email" value="<?php echo htmlspecialchars($post_data['confirm-email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
                <?php if (isset($errors['is_confirm_email_empty']) || isset($errors['is_confirm_email_illegal']) || isset($errors['is_confirm_email_not_match'])): ?>
                  <span class="error-message <?php if (isset($errors['is_confirm_email_empty']) || isset($errors['is_confirm_email_illegal']) || isset($errors['is_confirm_email_not_match'])) echo 'open'; ?>">※確認用メールアドレスを正しく入力してください</span>
                <?php endif; ?>
              </div>
              <div class="form-row">
                <label for="tel">電話番号</label>
                <span class="optional">任意</span>
                <input autocomplete="tel" id="tel" name="tel" placeholder="（例）0011122222　※ハイフンなしで入力してください" type="tel" value="<?php echo htmlspecialchars($post_data['tel'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
              </div>
              <div class="form-row last-form-row">
                <label for="comment">お問い合わせ内容</label>
                <span class="required">必須</span>
                <textarea autocomplete="off" id="comment" name="comment" placeholder="具体的にご記入ください" required><?php echo htmlspecialchars($post_data['comment'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
                <?php if (isset($errors['is_comment_empty'])): ?>
                  <span class="error-message <?php if (isset($errors['is_comment_empty'])) echo 'open'; ?>">※お問い合わせ内容を入力してください</span>
                <?php endif; ?>
              </div>
            </div>
            <div class="contact-main__consent">
              <div class="form-consent">
                <div class="agree">
                  <p>株式会社タイムの「個人情報の取扱い」について<span class="u-nowrap">ご確認いただき、</span><br class="u-hidden-sp">ご同意いただいた上で<span class="u-nowrap">「確認する」</span><span class="u-nowrap">ボタン</span>をクリックしてください。</p>
                  <label for="agree">
                    <input id="agree" name="agree" type="checkbox" required>
                    <span class="checkmark"></span>
                    <span><a href="/privacy/privacy.php">プライバシーポリシー</a>に同意する</span>
                  </label>
                  <div class="error-message-agree">
                    ※プライバシーポリシーに同意してください
                  </div>
                </div>
                <button class="button top-button" id="submitBtn" type="submit"><span class="submit-text">確認する</span></button>
              </div>
            </div>
          </form>
        </div>
      </section>
    </main>
    <?php include __DIR__ . '/../includes/footer.php'; ?>
    <script src="/assets/js/common.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  </body>
</html>