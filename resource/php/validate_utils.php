<?php
/**
 * @file validate_utils.php
 * @brief バリデーション関連のユーティリティ関数をまとめたファイル
 *
 * このファイルでは、日付の形式が正しいかどうかを検証する関数、
 * 電話番号の形式が正しいかどうかを検証する関数、
 * メールアドレスの形式が正しいかどうかを検証する関数、
 * アップロードされたファイルが許可された形式かどうかを検証する関数を提供します。
 *
 * 関数概要:
 * - isAllowedDate: 指定されたフォーマットで日付が正しいかどうかを検証する
 * - isPhoneText: 電話番号の形式が正しいかどうかを検証する
 * - isMailText: メールアドレスの形式が正しいかどうかを検証する
 * - isKatakanaText: カタカナの形式が正しいかどうかを検証する
 * - hasValueIn: 指定されたキーが存在し、かつその値が空でないかどうかを検証する
 */
require_once __DIR__ . '/utils.php';


// 直接アクセスされた場合は処理を停止
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    exit('No direct script access allowed');
}

/**
 * validateDate
 *
 * 指定されたフォーマットで日付が正しいかどうかを検証する
 * @param string $date 検証する日付文字列
 * @param string $format 日付フォーマット (デフォルト: "Y年m月d日")
 * @param DateTime|null $from 開始日
 * @param DateTime|null $to 終了日
 * @return bool 日付が正しい場合はtrue、そうでない場合はfalse
 */
function isAllowedDate(string $date, string $format = "Y年m月d日", ?DateTime $from = null, ?DateTime $to = null): bool {
    $dateTime = DateTime::createFromFormat($format, $date);
    if (!$dateTime) {
        $errors = DateTime::getLastErrors();
        return false;
    }
    $year = $dateTime->format('Y');
    $month = $dateTime->format('m');
    $day = $dateTime->format('d');
    if (!checkdate((int)$month, (int)$day, (int)$year)) {
        return false;
    }
    if ($from !== null && $dateTime < $from) {
        return false;
    }
    if ($to !== null && $dateTime > $to) {
        return false;
    }
    return true;
}

/**
 * isPhoneText
 *
 * 電話番号の形式が正しいかどうかを検証する
 * @param string $phone 電話番号文字列
 * @return bool 電話番号の形式が正しい場合はtrue、そうでない場合はfalse(空文字列の場合はfalse)
 */
function isPhoneText($phone): bool {
    if(empty($phone)){
        return false;
    }
    // 変更点：より広範な電話番号形式を許可する正規表現に変更
    // 日本の電話番号の一般的な形式を考慮し、ハイフンあり/なし、市外局番の長さを許容
    if (preg_match('/^(?:\+81|0)\d{1,4}[-]?\d{1,4}[-]?\d{4}$/', $phone)) {
        return true;
    }
    return false;
}

/**
 * isMailText
 *
 * メールアドレスの形式が正しいかどうかを検証する
 * @param string $mail メールアドレス文字列
 * @return bool メールアドレスの形式が正しい場合はtrue、そうでない場合はfalse(空文字列の場合はfalse)
 */
function isMailText($mail): bool {
    if(empty($mail)){
        return false;
    }
    if(filter_var($mail, FILTER_VALIDATE_EMAIL) &&
        preg_match('/^[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/', $mail)){ //変更点：RFCに準拠した正規表現を追加
        return true;
    }
    return false;
}

/**
 * isKatakanaText
 *
 * カタカナの形式が正しいかどうかを検証する
 * @param string $text カタカナ文字列
 * @return bool カタカナの形式が正しい場合はtrue、そうでない場合はfalse(空文字列の場合はtrue)
 */
function isKatakanaText($text): bool {
    if(empty($text)){
        return true;
    }
    return preg_match('/^[ァ-ヶー\s]+$/u', $text);
}

/**
 * hasValueOn
 *
 * 指定されたキーが存在し、かつその値が空でないかどうかを検証する
 * @param string $key 検証するキー
 * @param string $type 検証するグローバル変数の型 (POST, GET, REQUEST)
 * @param bool $checkEmpty 空文字列の場合はfalseを返すかどうか
 * @return bool 指定されたキーが存在し、かつその値が空でない場合はtrue、そうでない場合はfalse
 */
function hasValueIn(string $key, string $type = 'POST', bool $checkEmpty = true): bool {
    if($type === 'POST'){
        return array_key_exists($key, $_POST) && (!$checkEmpty || trim($_POST[$key]) !== '');
    }else if($type === 'GET'){
        return array_key_exists($key, $_GET) && (!$checkEmpty || trim($_GET[$key]) !== '');
    }else if($type === 'REQUEST'){
        return array_key_exists($key, $_REQUEST) && (!$checkEmpty || trim($_REQUEST[$key]) !== '');
    }
    return false;
}
?>