<?php
    require "../php/mail_send.php";

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
        header("Location:/tps/snapshot-2024-05-14-22-18-09/contact.php?". $redirectQuery);
        exit;
    }
    $title = "お客様からのお問い合わせ";

    $body = "新たなお客様からのお問い合わせが来ました。<br><br>";
    $body = $body . "送信日付: " . date("Y-m-d H:i:s") . "<br><br>";
    $body = $body . "会社名: " . htmlspecialchars($_POST['companyname']) . "<br>";
    $body = $body . "部署名: " . htmlspecialchars($_POST['departmentname']) . "<br>";
    $body = $body . "お名前: " . htmlspecialchars($_POST['name']) . "<br>";
    $body = $body . "〒:" . htmlspecialchars($_POST['postcode1']) . "-" . htmlspecialchars($_POST['postcode2']) . "<br>";
    $body = $body . "会社の所在地: " . htmlspecialchars($_POST['address']) . "<br>";
    $body = $body . "メールアドレス: <a href='mailto:" . htmlspecialchars($_POST['mail']) . "'>" . htmlspecialchars($_POST['mail']) . "</a><br>";
    $body = $body . "電話番号: <a href='tel:" . htmlspecialchars($_POST['tel']) . "'>" . htmlspecialchars($_POST['tel']) . "</a><br>";
    $body = $body . "コメント:<br>" . htmlspecialchars($_POST['contactcontent']);

    $textBody = "新たなお客様からのお問い合わせが来ました。\n\n";
    $textBody = $textBody . "送信日付: " . date("Y-m-d H:i:s") . "\n\n";
    $textBody = $textBody . "会社名: " . htmlspecialchars($_POST['companyname']) . "\n";
    $textBody = $textBody . "部署名: " . htmlspecialchars($_POST['departmentname']) . "\n";
    $textBody = $textBody . "お名前: " . htmlspecialchars($_POST['name']) . "\n";
    $textBody = $textBody . "〒: " . htmlspecialchars($_POST['postcode1']) . "-" . htmlspecialchars($_POST['postcode2']) . "\n";
    $textBody = $textBody . "会社の所在地: " . htmlspecialchars($_POST['address']) . "\n";
    $textBody = $textBody . "メールアドレス: " . htmlspecialchars($_POST['mail']) . "\n";
    $textBody = $textBody . "電話番号: " . htmlspecialchars($_POST['tel']) . "\n";
    $textBody = $textBody . "コメント:\n" . htmlspecialchars($_POST['contactcontent']);

    sendMailToMe($title, $body, $textBody);
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
    <main>
        <div class="wrapper">
            <section>
                <p>この度はご予約いただき、誠にありがとうございます。<br>
                ご入力いただいた内容を確認のうえ、折り返しご連絡いたします。</p>

                <p>なお、数日経っても連絡がない場合は、
                お手数ですがお電話にてお問い合わせください。</p>
                <a her>
                    <svg width="10" height="10" viewBox="0 0 10 10">
                        <path d="M6 1 L2 5 L6 9" stroke="black" fill="none"/>
                    </svg>
                    戻る
                </a>
            </section>
        </div>
    </main>
</body>
</html>