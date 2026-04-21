<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Cache-Control" content="no-cache">
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
    
    <script charset="utf-8" type="text/javascript" src="../asset/js/jquery-3.6.4.min.js"></script>
    <script charset="utf-8" type="text/javascript" src="../asset/js/contact.js"></script>
</head>
<body>
    <main>
        <div class="wrapper">
            <section id="contitle">
                <hgroup>
                    <p>Contact</p>
                    <h2>お問い合わせ</h2>
                </hgroup>
            </section>
            <section id="conform">
                <form method="post" action="./contact-confirm.php">
                    <div class="name">
                        <span>
                            <p class="title-name">お名前</p>
                            <h5>＊</h5>
                        </span>
                        <input type="text" id="nameform" name="name"  placeholder="入力例：田中太郎" value="<?= array_key_exists('name', $_GET)  ? $_GET['name'] : '' ?>"/>
                    </div>
                    <?php if(array_key_exists('is_name_empty', $_GET)) { echo '<p class="error">お名前をご記入ください</p>'; } ?>
                    <div class="name-kana">
                        <span>
                            <p class="title-name">お名前フリガナ</p>
                            <h5>＊</h5>
                        </span>
                        <input type="text" id="rec-namekanaform" name="name-kana" placeholder="入力例：タナカタロウ"  value="<?= array_key_exists('name-kana', $_GET)  ? $_GET['name-kana'] : '' ?>"/>
                    </div>
                    <div class="mail">
                        <span>
                            <p class="title-name">メールアドレス</p>
                            <h5>＊</h5>
                        </span>
                        <input type="text" id="mail" name="mail"  placeholder="入力例：info@example.jp" value="<?= array_key_exists('mail', $_GET)  ? $_GET['mail'] : '' ?>"/>
                    </div>
                    <?php if(array_key_exists('is_mail_empty', $_GET)) { echo '<p class="error">メールアドレスをご記入ください</p>'; } ?>
                    <?php if(array_key_exists('is_mail_illegal', $_GET)) { echo '<p class="error">メールアドレスをご記入ください</p>'; } ?>
                    <div class="tel-number">
                        <span>
                            <p class="title-name">電話番号</p>
                            <h5>＊</h5>
                        </span>
                        <input type="tel" id="tel" name="tel" placeholder="入力例：00011112222" value="<?= array_key_exists('tel', $_GET)  ? $_GET['tel'] : '' ?>"/>
                    </div>
                    <?php if(array_key_exists('is_tel_empty', $_GET)) { echo '<p class="error">電話番号をご記入ください</p>'; } ?>
                    <?php if(array_key_exists('is_tel_illegal', $_GET)) { echo '<p class="error">電話番号をご記入ください</p>'; } ?>
                    <div class="prefectures">
                        <span>
                            <p class="title-name">再診・初診</p>
                            <h5>＊</h5>
                        </span>
                        <select id="rec-prefectures" name="prefectures">
                            <option>選択してください</option>
                            <option <?php if(array_key_exists('prefectures', $_GET) && $_GET['prefectures'] === '初診' ) { echo ' selected'; } ?>>初診</option>
                            <option <?php if(array_key_exists('prefectures', $_GET) && $_GET['prefectures'] === '再診' ) { echo ' selected'; } ?>>再診</option>
                        </select>
                    </div>
                    <div class="birth-day">
                        <span>
                            <p class="title-name">希望日</p>
                            <h5>＊</h5>
                        </span>
                        <input type="date" id="rec-birthday" name="birthday" placeholder="年/月/日"  value="<?= array_key_exists('birthday', $_GET)  ? $_GET['birthday'] : '' ?>"/>
                    </div>
                    <?php if(array_key_exists('is_birthday_empty', $_GET)) { echo '<p class="error">希望日を選択してください</p>'; } ?>
                    <div class="name">
                        <span>
                            <p class="title-name">希望時間</p>
                            <h5>＊</h5>
                        </span>
                        <input type="text" id="nameform" name="name"  placeholder="入力例：10:00" value="<?= array_key_exists('name', $_GET)  ? $_GET['name'] : '' ?>"/>
                    </div>
                    <?php if(array_key_exists('is_name_empty', $_GET)) { echo '<p class="error">お名前をご記入ください</p>'; } ?>
                    <div class="prefectures">
                        <span>
                            <p class="title-name">メニュー</p>
                            <h5>＊</h5>
                        </span>
                        <select id="rec-prefectures" name="prefectures">
                            <option>選択してください</option>
                            <option <?php if(array_key_exists('prefectures', $_GET) && $_GET['prefectures'] === '整体' ) { echo ' selected'; } ?>>整体</option>
                            <option <?php if(array_key_exists('prefectures', $_GET) && $_GET['prefectures'] === '鍼灸' ) { echo ' selected'; } ?>>鍼灸</option>
                        </select>
                    </div>
                    <div class="cont-content">
                        <span>
                            <p class="title-name">症状の詳細</p>
                            <h5>＊</h5>
                        </span>
                        <textarea id="contactcontent" name="contactcontent" placeholder="できるだけ詳しくお書きください"><?= array_key_exists('contactcontent', $_GET)  ? $_GET['contactcontent'] : '' ?></textarea>
                    </div>
                    <?php if(array_key_exists('is_contactcontent_empty', $_GET)) { echo '<p class="error">症状の詳細をご記入ください</p>'; } ?>
                    <div class="cont-content">
                        <span>
                            <p class="title-name">その他</p>
                            <h5></h5>
                        </span>
                        <textarea id="contactcontent" name="contactcontent" placeholder="ご質問・ご要望等ございましたらご記入ください"><?= array_key_exists('contactcontent', $_GET)  ? $_GET['contactcontent'] : '' ?></textarea>
                    </div>
                    
                    <div class="agree-check">
                        <input type="checkbox" id="agree" name="recruitcontent" <?php if(array_key_exists('has_error', $_GET)) { echo 'checked'; } ?>/>
                        <p><strong>プライバシーポリシー</strong>に同意する</p>
                    </div>
                    <div class="confirmation">
                        <button type="submit" <?php if(!array_key_exists('has_error', $_GET)) { echo 'disabled'; } ?> class='required'>確認する　→</button>
                    </div>
                    <div class="confirmation-on">
                        <button type="submit" <?php if(!array_key_exists('has_error', $_GET)) { echo 'disabled'; } ?> class='required'>確認する　→</button>
                    </div>
                </form>
            </section>
        </div>
    </main>
</body>
</html>