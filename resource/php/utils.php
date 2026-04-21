<?php
/**
 * @file utils.php
 * @brief 汎用的な関数や定数を定義するファイル
 *
 * このファイルには、アプリケーション全体で使用される可能性のある、
 * 独立したユーティリティ関数や定義済みの定数が含まれています。
 * 例えば、データの検証、整形、変換などを行う関数、
 * あるいは設定値やステータスコードなどを表す定数が含まれます。
 *
 * 関数概要:
 * - getSystemConf: settings.iniファイルから設定を読み込む
 * - getSystemSection: settings.iniファイルからセクションを取得する
 * - getSystemSectionValue: settings.iniファイルからセクションの値を取得する
 * - isDebug: デバッグモードかどうかを取得する
 * - isWriteDebugLogOnPage: デバッグログをページに出力するかどうかを取得する
 * - isDisableCache: キャッシュを無効にするかどうかを取得する
 * - noCacheOnDebug: デバッグモードでキャッシュを無効にする
 * - writeLog: メッセージを出力する
 * - writeLogVar: 変数を出力する(デバッグモードでのみ出力する)
 */

// 直接アクセスされた場合は処理を停止
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    exit('No direct script access allowed');
}

/**
 * getSystemConf
 *
 * settings.iniファイルから設定を読み込む
 * @return array 設定内容
 */
function getSystemConf(): array
{
    return parse_ini_file(__DIR__ . "/config/settings.ini", true);
}

/**
 * getSystemSection
 *
 * settings.iniファイルからセクションを取得する
 * @return array セクション内容
 */
function getSystemSection(): array
{
    return getSystemConf()['System'] ?? [];
}

/**
 * getSystemSectionValue
 *
 * settings.iniファイルからセクションの値を取得する
 * @param string $key キー
 * @return mixed 値
 */
function getSystemSectionValue(string $key): mixed
{
    return getSystemSection()[$key] ?? null;
}

/**
 * isDebug
 *
 * settings.iniファイルからデバッグモードを取得する
 * @return bool デバッグモード
 */
function isDebug(): bool
{
    return (bool) (getSystemSectionValue("IS_DEBUG") ?? false);
}

/**
 * isWriteDebugLogOnPage
 *
 * settings.iniファイルからデバッグログをページに出力するかどうかを取得する
 * @return bool デバッグログをページに出力するかどうか
 */
function isWriteDebugLogOnPage(): bool
{
    return (bool) (getSystemSectionValue("IS_WRITE_DEBUG_LOG_ON_PAGE") ?? false) and isDebug();
}

/**
 * isWriteDebugLogOnFile
 *
 * settings.iniファイルからデバッグログをファイルに出力するかどうかを取得する
 * @return bool デバッグログをファイルに出力するかどうか
 */
function isWriteDebugLogOnFile(): bool
{
    return (bool) (getSystemSectionValue("IS_WRITE_DEBUG_LOG_ON_FILE") ?? false) and isDebug();
}

/**
 * isDisableCache
 *
 * settings.iniファイルからキャッシュを無効にするかどうかを取得する
 * @return bool キャッシュを無効にするかどうか
 */
function isDisableCache(): bool
{
    return (bool) (getSystemSectionValue("IS_DISABLE_CACHE") ?? false) and isDebug();
}

function toString($var): string {
    if(is_array($var) || is_object($var)){
        return print_r($var, true);
    }
    return (string) $var;
}

/**
 * log
 *
 * メッセージを出力する
 * @param string $message メッセージ
 */
function writeLog(string $message): void {
    if(isWriteDebugLogOnPage()){
        print($message . "<br>");
    }
    if(isWriteDebugLogOnFile()){
        $writeFileDir = __DIR__ . "/logs";
        if(!is_dir($writeFileDir)){
            mkdir($writeFileDir);
        }
        $today = date("Y-m-d");
        $now = date("Y-m-d H:i:s");
        file_put_contents($writeFileDir . "/" . $today . ".log", "[" . $now . "]" . $message, FILE_APPEND);
    }
}

/**
 * logVar
 *
 * 変数を出力する(デバッグモードでのみ出力する)
 * @param string $title 変数名
 * @param mixed $var 変数
 */
function writeLogVar(string $title, mixed $var): void
{
    if (is_array($var) || is_object($var)) {
        writeLog($title . "=>" . print_r($var, true) . "[" . gettype($var) . "]<br>");
    } else {
        writeLog($title . "=>" . $var . "[" . gettype($var) . "]<br>");
    }
}

/**
 * writeRequestLog
 *
 * リクエストログを出力する
 */
function writeRequestLog(): void {
    $data = "";
    foreach($_REQUEST as $key => $value){
        $data .= $key . "=>" . $value . "[" . gettype($value) . "]\n";
    }
    writeLog($data);
}

/**
 * noCacheOnDebug
 *
 * デバッグモードでキャッシュを無効にする
 */
function noCacheOnDebug(): void {
    if(isDisableCache()){
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
    }
}
?>