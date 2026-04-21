<?php
    function isPhoneText($phone){
        if($phone == ""){
            return false;
        }
        if(preg_match( '/^(\+81)*0[0-9]{1,4}-[0-9]{1,4}-[0-9]{3,4}\z/', $phone)){
            return true;
        }
        if(preg_match( '/^(\+81)*0[0-9]{9,10}\z/', $phone)){
            return true;
        }
        return false;
    }

    function isMailText($mail){
        if($mail == ""){
            return false;
        }
        if(filter_var($mail, FILTER_VALIDATE_EMAIL)){
            return true;
        }
        return false;
    }

    $isError = [];
    if(!array_key_exists('companyname', $_POST) || trim($_POST['companyname']) === '' ){
        $isError['is_companyname_empty'] = true;
    }
    if(!array_key_exists('name', $_POST) || trim($_POST['name']) === '' ){
        $isError['is_name_empty'] = true;
    }
    if(!array_key_exists('mail', $_POST) || trim($_POST['tel']) === ''){
        $isError['is_mail_empty'] = true;
    }elseif(!isMailText($_POST['mail'])){
        $isError['is_mail_illegal'] = true;
    }
    if(!array_key_exists('tel', $_POST) || trim($_POST['tel']) === ''){
        $isError['is_tel_empty'] = true;
    }elseif(!isPhoneText($_POST['tel'])){
        $isError['is_tel_illegal'] = true;
    }
    if(!array_key_exists('contactcontent', $_POST) || trim($_POST['contactcontent']) === '' ){
        $isError['is_contactcontent_empty'] = true;
    }

    if(!empty($isError)){
        $redirectQuery = [];
        $redirectQuery['has_error'] = true;
        foreach ($_POST as $key => $value) {
            $redirectQuery[$key] = $value;
        }
        $redirectQuery = array_merge($redirectQuery, $isError);
        $redirectQuery = http_build_query($redirectQuery);
        header("Status: 301 Moved Permanently");
        header("Location:./contact.php?". $redirectQuery);
        exit;
    }
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>お問い合わせ｜きやま整体</title>
    <link rel="stylesheet" type="text/css" media="screen" href="../assets/css/reset.css">
    <link rel="stylesheet" type="text/css" media="screen" href="../assets/css/contact.css">

    <link rel="icon" href="">
    <link rel="apple-touch-icon" sizes="180x180" href="">

    <script async src="https://www.googletagmanager.com/gtag/js?id=G-4MGFRJXW37"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-4MGFRJXW37');
    </script>

</head>
<body>
    <section id="company-form-confirmation">
        <div class="wrapper">
            <p>以下の内容でよろしいですか？</p>
            <table>
                <tr><th>お名前</th><td><?= $_POST['name'] ?></td></tr>
                <tr><th>お名前フリガナ</th><td><?= $_POST['name-kana'] ?></td></tr>
                <tr><th>メールアドレス</th><td><?= $_POST['mail'] ?></td></tr>
                <tr><th>電話番号</th><td><?= $_POST['tel'] ?></td></tr>
                
                <tr><th>再診・初診</th><td><?= $_POST['prefectures'] ?></td></tr>
                <tr><th>希望日</th><td><?= $_POST['birthday'] ?></td></tr>
                <tr><th>希望時間</th><td><?= $_POST['name'] ?></td></tr>
                <tr><th>メニュー</th><td><?= $_POST['prefectures'] ?></td></tr>
                <tr><th>症状の詳細</th><td><?= $_POST['contactcontent'] ?></td></tr>
                <tr><th>その他</th><td><?= $_POST['tcontactcontentel'] ?></td></tr>

                <tr><th>お問い合わせ内容</th><td><textarea><?= $_POST['contactcontent'] ?></textarea></td></tr>
            </table>
            <form method="?" action="?">
                <?php
                    foreach ($_POST as $key => $value) {
                        echo '<input type="hidden" name="' . $key . '" value="' . $value . '" />';
                    }
                ?>
                <div class="confirmation">
                    <button type="submit" formmethod="get" formaction="./contact.php">戻る</button>
                    <button type="submit" formmethod="post" formaction="./contact-completion.php">送信する</button>
                </div>
            </form>
        </div>
    </section>
</body>
</html>