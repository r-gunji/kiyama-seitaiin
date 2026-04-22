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
    <title>お問い合わせ｜きやま整体</title>
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
    <link rel="stylesheet" href="../assets/css/common.css">
    <link rel="stylesheet" href="../assets/css/header.css">
    <link rel="stylesheet" href="../assets/css/footer.css">
    <link rel="stylesheet" href="../assets/css/contact.css">
  </head>
  <body class="page-contact">
    <?php include __DIR__ . '../includes/header.php'; ?>
    <main>
      <div class="wrapper">
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
                <span>
                  <label for="name">お名前</label>
                  <h5 class="required">＊</h5>
                </span>
                <input autocomplete="name" id="name" name="name" placeholder="入力例：田中太郎" type="text" value="<?php echo htmlspecialchars($post_data['name'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                <?php if (isset($errors['is_name_empty'])): ?>
                  <span class="error-message <?php if (isset($errors['is_name_empty'])) echo 'open'; ?>">※お名前を入力してください</span>
                <?php endif; ?>
              </div>

              <div class="form-row <?php if (isset($errors['is_furigana_empty'])) echo 'open-empty'; ?> <?php if (isset($errors['is_furigana_illegal'])) echo 'open'; ?>">
                <span>
                  <label for="furigana">フリガナ</label>
                  <h5 class="required">＊</h5>
                </span>
                <input autocomplete="additional-name" id="furigana" name="furigana" placeholder="入力例：タナカタロウ" type="text" value="<?php echo htmlspecialchars($post_data['furigana'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                <?php if (isset($errors['is_furigana_empty']) || isset($errors['is_furigana_illegal'])): ?>
                  <span class="error-message <?php if (isset($errors['is_furigana_empty']) || isset($errors['is_furigana_illegal'])) echo 'open'; ?>">※フリガナを正しく入力してください</span>
                <?php endif; ?>
              </div>

              <div class="form-row <?php if (isset($errors['is_email_empty'])) echo 'open-empty'; ?> <?php if (isset($errors['is_email_illegal'])) echo 'open'; ?>">
                <span>
                  <label for="email">メールアドレス</label>
                  <h5 class="required">＊</h5>
                </span>
                <input autocomplete="email" id="email" name="email" placeholder="入力例：info@example.jp" type="email" value="<?php echo htmlspecialchars($post_data['email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
                <?php if (isset($errors['is_email_empty']) || isset($errors['is_email_illegal'])): ?>
                  <span class="error-message <?php if (isset($errors['is_email_empty']) || isset($errors['is_email_illegal'])) echo 'open'; ?>">※メールアドレスを正しく入力してください</span>
                <?php endif; ?>
              </div>

              <div class="form-row <?php if (isset($errors['is_confirm_email_empty'])) echo 'open-empty'; ?> <?php if (isset($errors['is_confirm_email_illegal']) || isset($errors['is_confirm_email_not_match'])) echo 'open'; ?>">
                <span>
                  <label for="confirm-email">メールアドレス[確認用]</label>
                  <h5 class="required">＊</h5>
                </span>
                <input autocomplete="email" id="confirm-email" name="confirm-email" placeholder="入力例：info@example.jp" type="email" value="<?php echo htmlspecialchars($post_data['confirm-email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
                <?php if (isset($errors['is_confirm_email_empty']) || isset($errors['is_confirm_email_illegal']) || isset($errors['is_confirm_email_not_match'])): ?>
                  <span class="error-message <?php if (isset($errors['is_confirm_email_empty']) || isset($errors['is_confirm_email_illegal']) || isset($errors['is_confirm_email_not_match'])) echo 'open'; ?>">※確認用メールアドレスを正しく入力してください</span>
                <?php endif; ?>
              </div>

              <div class="form-row">
                <span>
                  <label for="tel">電話番号</label>
                  <h5 class="required">＊</h5>
                </span>
                <input autocomplete="tel-national" id="tel" name="tel" placeholder="入力例：00011112222" type="tel" value="<?php echo htmlspecialchars($post_data['tel'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
              </div>

              <div class="form-row">
                <span>
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
                <span>
                  <label for="preferreddate">希望日時</label>
                  <h5 class="required">＊</h5>
                </span>
                <input autocomplete="off" id="preferreddate" name="preferreddate" placeholder="/年/月/日 --:--" type="datetime-local" value="<?php echo htmlspecialchars($post_data['preferreddate'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                <script>
                  const now = new Date();

                  // YYYY-MM-DDTHH:MM 形式に整形
                  const formatted = now.toISOString().slice(0,16);

                  document.getElementById("preferreddate").min = formatted;
              </script>
              </div>

              <div class="form-row">
                <span>
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
                <span>
                  <label for="comment">症状の詳細</label>
                  <h5 class="required">＊</h5>
                </span>
                <textarea autocomplete="off" id="comment" name="comment" placeholder="できるだけ詳しくお書きください" required><?php echo htmlspecialchars($post_data['comment'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
                <?php if (isset($errors['is_comment_empty'])): ?>
                  <span class="error-message <?php if (isset($errors['is_comment_empty'])) echo 'open'; ?>">※お問い合わせ内容を入力してください</span>
                <?php endif; ?>
              </div>

              <div class="form-row last-form-row">
                <span>
                  <label for="other">その他</label>
                  <h5 class="optional"></h5>
                </span>
                <textarea autocomplete="off" id="other" name="other" placeholder="ご質問・ご要望等ございましたらご記入ください" required><?php echo htmlspecialchars($post_data['other'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
              </div>

            </div>
            <div class="contact-main__consent">
              <div class="form-consent">
                <div class="agree">
                  <!--<p>株式会社タイムの「個人情報の取扱い」について<span class="u-nowrap">ご確認いただき、</span><br class="u-hidden-sp">ご同意いただいた上で<span class="u-nowrap">「確認する」</span><span class="u-nowrap">ボタン</span>をクリックしてください。</p>-->
                  <label for="agree">
                    <input id="agree" name="agree" type="checkbox" required>
                    <span class="checkmark"></span>
                    <span><a href="#">プライバシーポリシー</a>に同意する</span>
                  </label>
                  <!--<div class="error-message-agree">
                    ※プライバシーポリシーに同意してください
                  </div>-->
                </div>

                <button class="button top-button" id="submitBtn" type="submit"><span class="submit-text">確認する&emsp;→</span></button>
              </div>
            </div>
          </form>
        </section>
      </div>
    </main>
    <?php include __DIR__ . '../includes/footer.php'; ?>
    <script src="/assets/js/common.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  </body>
</html>