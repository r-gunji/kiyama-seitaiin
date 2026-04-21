<?php

/**
 * テンプレート関連のユーティリティ
 * テンプレートファイルはtemplatesディレクトリに配置する
 * メールテンプレートファイルはtemplates/mailディレクトリに配置する
 * テンプレートファイルはHTML形式とテキスト形式がある   
 * メールテンプレートファイルはHTML形式とテキスト形式がある
 * 
 * - getMailTemplate: メールテンプレートを取得する
 */

// 直接アクセスされた場合は処理を停止
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    exit('No direct script access allowed');
}

/**
 * getMailTemplate
 *
 * メールテンプレートを取得する
 * 
 * @param string $template_file_name テンプレート名
 * @param array $replacements 置換する文字列
 * @param bool $isHtml テンプレートがHTMLかどうか(Htmlの場合はnl2brを適用する)
 * @return string テンプレート内容
 */
function getMailTemplate(string $template_file_name, array $replacements = [], bool $isHtml = true): string {
    $template_path = __DIR__ . "/templates/mail/{$template_file_name}";
    if (!file_exists($template_path)) {
        throw new Exception("Template file not found: {$template_file_name}");
    }
    $template = file_get_contents($template_path);
    $result = strtr($template, $replacements);
    if($isHtml){
        $result = nl2br($result);
    }
    return $result;
}
?>