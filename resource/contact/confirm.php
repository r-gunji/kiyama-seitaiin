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
  if(!hasValueIn('comment')){
    $isError['is_comment_empty'] = true;
  }

  $_SESSION['post_data'] = $_POST;
  if(!empty($isError)){
      $_SESSION['errors'] = $isError;
      header("Status: 301 Moved Permanently");
      header("Location: /contact/contact.php");
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
    <title>お問い合わせ内容の確認 | 株式会社タイム</title>
    <meta charset="utf-8">
    <meta name="description" content="株式会社タイムのお問い合わせ内容の確認ページです。">
    <meta name="keywords" content="株式会社タイム, お問い合わせ, お問い合わせ内容の確認, お問い合わせ内容の確認ページ">
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
      <section class="confirm-main" id="confirm">
        <div class="contact-main__inner l-inner">
          <h1 class="confirm-title">以下の内容で<span class="u-nowrap">よろしいですか？</span></h1>
          <table class="form-table">
            <tr>
              <th>
                <p>お問い合わせ項目</p>
              </th>
              <td>
                <div>
                  <?php echo htmlspecialchars($_POST['inquiry'], ENT_QUOTES, 'UTF-8'); ?>
                </div>
              </td>
            </tr>
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
              <th>
                <p>会社名</p>
              </th>
              <td>
                <div class="row-content">
                  <?php echo htmlspecialchars($_POST['organization'], ENT_QUOTES, 'UTF-8'); ?>
                </div>
              </td>
            </tr>
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
                <p>メールアドレス（確認用）</p>
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
            <tr class="last-tr">
              <th>
                <p>お問い合わせ内容</p>
              </th>
              <td>
                <div class="last-form-content"><?php echo htmlspecialchars($_POST['comment'], ENT_QUOTES, 'UTF-8'); ?></div>
              </td>
            </tr>
          </table>
          <form action="/contact/complete.php" class="confirm-form" method="post">
            <button class="button back-button" formaction="/contact/contact.php" formmethod="post" type="submit">
              <span class="submit-text">戻る</span>
            </button>
            <button class="button top-button" formmethod="post" type="submit">
              <span class="submit-text">送信する</span>
            </button>
              <?php foreach ($_POST as $key => $value): ?>
                <input name="<?php echo $key; ?>" type="hidden" value="<?php echo $value; ?>">
              <?php endforeach; ?>
              <input name="token" type="hidden" value="<?php echo $token; ?>">
          </form>
        </div>
      </section>
    </main>
    <?php include __DIR__ . '/../includes/footer.php'; ?>
    <script src="/assets/js/common.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  </body>
</html>