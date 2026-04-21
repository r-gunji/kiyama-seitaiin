<?php
    require_once '../php/utils.php';
    require_once '../php/validate_utils.php';
    require_once '../php/send_mail_utils.php';
    require_once '../php/template_utils.php';

    noCacheOnDebug();
    session_start();

    // トークンを検証
    if (!isset($_POST['token']) || !isset($_SESSION['token']) || $_POST['token'] !== $_SESSION['token']) {
        // 不正なリクエストとして処理
        error_log("Invalid token. Possible CSRF attack or duplicate submission.");
        header("HTTP/1.1 400 Bad Request");
        echo "フォームの有効期限が切れたか、正しい手順でアクセスされていないようです。
        お手数ですが、再度フォームからご入力ください。";
        exit;
    }

    // トークンを削除して、再送信を防ぐ
    unset($_SESSION['token']);

    $isError = [];
    if (!hasValueIn('inquiry')) {
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

    if(!empty($isError)){
      $_SESSION['post_data'] = $_POST;
      $_SESSION['errors'] = $isError;

      header("Status: 301 Moved Permanently");
      header("Location: /contact/contact.php");
      exit;
    }

    $mailConf = getMailConf();
    $mailSection = $mailConf["INQUIRY"];
    if(isDebug()){
      $mailSection = $mailConf["INQUIRY_DEBUG"];
    }
    $recvAddress = array_map('trim', explode(',', $mailSection["RECV_ADDRESS"]));

    $replacements = [
      '${date}' => date("Y年m月d日H時i分s秒"),
      '${inquiry}' => htmlspecialchars($_POST['inquiry'] ?? '', ENT_QUOTES, 'UTF-8'),
      '${service}' => htmlspecialchars($_POST['service'] ?? '', ENT_QUOTES, 'UTF-8'),
      '${name}' => htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8'),
      '${furigana}' => htmlspecialchars($_POST['furigana'], ENT_QUOTES, 'UTF-8'),
      '${email}' => htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8'),
      '${confirm-email}' => htmlspecialchars($_POST['confirm-email'], ENT_QUOTES, 'UTF-8'),
      '${tel}' => htmlspecialchars($_POST['tel'], ENT_QUOTES, 'UTF-8'),
      '${comment}' => htmlspecialchars($_POST['comment'] ?? '', ENT_QUOTES, 'UTF-8'),
    ];

    // メール送信
    $attachments = [];
    sendTemplateMail($mailSection, $recvAddress, $mailSection["MAIL_SUBJECT"], 'inquiry.tpl', 'inquiry-text.tpl', $replacements, $attachments);
    // 確認メール送信
    sendTemplateMail($mailSection, $_POST['email'], $mailSection["MAIL_CONFIRM_SUBJECT"], 'inquiry-confirm.tpl', 'inquiry-confirm-text.tpl', $replacements);
    unset($_SESSION['post_data']);
    unset($_SESSION['errors']);
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <title>お問い合わせ完了 | 株式会社タイム</title>
    <meta charset="utf-8">
    <meta name="description" content="株式会社タイムのお問い合わせ完了ページです。">
    <meta name="keywords" content="株式会社タイム, お問い合わせ, お問い合わせ完了, お問い合わせ完了ページ">
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
    <section class="complete-main" id="complete">
			<div class="complete-main__inner l-inner">
				<p class="complete-heading">
          送信が完了しました。<br>この度はお問い合わせありがとうございます。
        </p>
        <a class="button top-button" href="/">トップに戻る</a>
			</div>
		</section>
    </main>
    <?php include __DIR__ . '/../includes/footer.php'; ?>
    <script src="/assets/js/common.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  </body>
</html>