<?php
/**
 * @file send_mail_utils.php
 * @brief メール送信関連のユーティリティ関数をまとめたファイル
 *
 * このファイルでは、PHPMailerライブラリを使用してメールを送信するための関数を提供します。
 * mail.iniファイルから設定を読み込み、SMTPサーバー経由でメールを送信します。
 * また、デバッグ用のログ出力機能も備えています。
 *
 * 含まれる関数：
 * - sendMail: PHPMailerを使用してメールを送信します。
 * - sendTemplateMail: テンプレートを使用してメールを送信します。
 * - getMailConf: mail.iniファイルから設定を読み込みます。
 */

#Composerが使えないので手動ロード
require_once __DIR__ . '/vendor/PHPMailer/PHPMailer.php';
require_once __DIR__ . '/vendor/PHPMailer/SMTP.php';
require_once __DIR__ . '/vendor/PHPMailer/Exception.php';
require_once __DIR__ . '/utils.php';
require_once __DIR__ . '/template_utils.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// 直接アクセスされた場合は処理を停止
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    exit('No direct script access allowed');
}

// PHPMailerのオートロードと日本語設定ファイルを読み込む
require_once __DIR__ . '/vendor/PHPMailer/language/phpmailer.lang-ja.php';

// 日本語の設定
mb_language("japanese");
mb_internal_encoding("UTF-8");

/**
 * メールを送信する
 *
 * @param string|array|null $recvAddress 送信先アドレス（文字列または配列）
 * @param string $subject 件名
 * @param string $body 本文（HTML形式）
 * @param string|null $textBody 本文（テキスト形式、オプション）
 * @param array $attachments 添付ファイル（配列）
 * @return bool 送信に成功した場合はtrue、失敗した場合はfalse
 */
function sendMail(array $conf, string|array|null $recvAddress, string $subject, string $body, ?string $textBody, array $attachments = []): bool
{
    $mail = new PHPMailer(true);

    try {
        // 設定値の取得
        $host = $conf["HOST"] ?? '';
        $username = $conf["USERNAME"] ?? '';
        $password = $conf["PASSWORD"] ?? '';
        $port = (int) ($conf["PORT"] ?? 587); // デフォルトのポート番号を設定
        $sendAddress = $conf["SEND_ADDRESS"] ?? '';
        $addrs = $recvAddress ? (is_string($recvAddress) ? [$recvAddress] : $recvAddress) : explode(',', $conf["RECV_ADDRESS"] ?? '');
        $isDebug = isDebug();

        // デバッグモードの場合、ログを出力
        if ($isDebug && isWriteDebugLogOnPage()) {
            writeLogVar("subject", $subject);
            writeLogVar("body", $body);
            writeLogVar("textBody", $textBody);
            writeLogVar("host", $host);
            writeLogVar("username", $username);
            writeLogVar("password", $password);
            writeLogVar("port", $port);
            writeLogVar("sendAddress", $sendAddress);
            writeLogVar("addrs", $addrs);
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        }

        if($host === ''){
            throw new Exception("host is empty");
        }
        if($username === ''){
            throw new Exception("username is empty");
        }
        if($password === ''){
            throw new Exception("password is empty");
        }
        if($port === ''){
            throw new Exception("port is empty");
        }
        if($sendAddress === ''){
            throw new Exception("sendAddress is empty");
        }
        if(count($addrs) === 0){
            throw new Exception("addrs is empty");
        }

        // SMTPの設定
        $mail->isSMTP();
        $mail->CharSet = "utf-8";
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

        // サーバーの設定
        $mail->Host = $host;
        $mail->Username = $username;
        $mail->Password = $password;
        $mail->Port = $port;
        $mail->isHTML(true);

        // 送信元アドレスの設定
        $mail->setFrom($sendAddress);

        // 送信先アドレスの設定
        if (is_array($addrs) && count($addrs) > 0) {
            foreach ($addrs as $addr) {
                $mail->addAddress($addr);
            }
        } elseif (is_string($addrs)) {
            $mail->addAddress($addrs);
        }

        // 件名と本文の設定
        $mail->Subject = $subject;

        // テキスト形式の本文が指定されている場合は設定
        if ($textBody !== null) {
            $mail->AltBody = $textBody;
        }

        $mail->Body = $body;

        // 添付ファイルの設定
        foreach ($attachments as $attachment) {
            $mail->addStringAttachment($attachment['content'], $attachment['name']);
        }

        $mail->send();

        return true;

    } catch (Exception $e) {
        // エラーが発生した場合
        if ($isDebug == "TRUE") {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
        return false;
    }
}

/**
 * テンプレートを使用してメールを送信する
 *
 * @param array $conf 設定
 * @param string|array|null $recvAddress 送信先アドレス
 * @param string $subject 件名
 * @param string $htmlTemplate HTMLテンプレート
 * @param string $textTemplate テキストテンプレート
 * @param array $replacements 置換文字列
 * @param array $attachments 添付ファイル
 * @return bool 送信に成功した場合はtrue、失敗した場合はfalse
 */
function sendTemplateMail(array $conf, string|array|null $recvAddress, string $subject, string $htmlTemplate, string $textTemplate, array $replacements = [], array $attachments = []): bool
{
    $htmlBody = getMailTemplate($htmlTemplate, $replacements);
    $textBody = getMailTemplate($textTemplate, $replacements, false);
    return sendMail($conf, $recvAddress, $subject, $htmlBody, $textBody, $attachments);
}

/**
 * mail.iniファイルから設定を読み込む
 *
 * @return array 設定内容
 */ 
function getMailConf(): array
{
    return parse_ini_file(__DIR__ . "/config/mail.ini", true);
}
?>
