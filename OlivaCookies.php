<?php
/**
 * OlivaCookies - simple cookie notice plugin for WonderCMS.
 * Prepared by Steve Alink for Oliva Solutions
 *
 * Shows a cookie notice bar until the visitor accepts it.
 * Place this folder in: /plugins/OlivaCookies/
 */

if (!defined('VERSION')) {
    die('Direct access is not allowed.');
}

/**
 * Register listeners for WonderCMS 3.x and older variants where possible.
 */
if (isset($Wcms) && is_object($Wcms)) {
    $Wcms->addListener('css', 'olivaCookiesCss');
    $Wcms->addListener('js', 'olivaCookiesJs');
    $Wcms->addListener('footer', 'olivaCookiesFooter');
} elseif (class_exists('wCMS')) {
    wCMS::addListener('css', 'olivaCookiesCss');
    wCMS::addListener('js', 'olivaCookiesJs');
    wCMS::addListener('footer', 'olivaCookiesFooter');
}

function olivaCookiesPluginBasePath()
{
    return 'plugins/OlivaCookies/';
}

function olivaCookiesDefaultTranslations()
{
    return [
        'noticeText' => 'This website uses cookies to improve your browsing experience. By continuing, you accept the use of cookies.',
        'buttonText' => 'Accept',
        'moreText'   => 'More information',
        'moreUrl'    => '/privacy',
        'ariaLabel'  => 'Cookie notice'
    ];
}

function olivaCookiesGetLanguage()
{
    global $Wcms;

    $defaultLanguage = 'en_US';
    $language = $defaultLanguage;

    if (isset($Wcms) && is_object($Wcms)) {
        // Check and populate contactFormLanguage, as requested.
        $configuredLanguage = $Wcms->get('config', 'contactFormLanguage');
        if (empty($configuredLanguage) || is_object($configuredLanguage)) {
            $Wcms->set('config', 'contactFormLanguage', $defaultLanguage);
            $configuredLanguage = $defaultLanguage;
        }
        $language = (string) $configuredLanguage;
    }

    // Only allow safe language filenames like en_US, nl_NL, es_ES.
    if (!preg_match('/^[a-z]{2}_[A-Z]{2}$/', $language)) {
        $language = $defaultLanguage;
    }

    return $language;
}

function olivaCookiesLoadTranslations()
{
    $translations = olivaCookiesDefaultTranslations();
    $language = olivaCookiesGetLanguage();

    $languageFile = __DIR__ . '/languages/' . $language . '.ini';
    if (!file_exists($languageFile)) {
        $languageFile = __DIR__ . '/languages/en_US.ini';
    }

    if (file_exists($languageFile)) {
        $loadedTranslations = parse_ini_file($languageFile);
        if (is_array($loadedTranslations)) {
            $translations = array_merge($translations, $loadedTranslations);
        }
    }

    return $translations;
}

function olivaCookiesCss($args)
{
    $css = '<link rel="stylesheet" href="' . olivaCookiesPluginBasePath() . 'css/oliva-cookies.css" type="text/css">';

    if (isset($args[0]) && is_array($args[0])) {
        $args[0][] = $css;
    } else {
        $args[0] = ($args[0] ?? '') . $css;
    }

    return $args;
}

function olivaCookiesJs($args)
{
    $js = '<script src="' . olivaCookiesPluginBasePath() . 'js/oliva-cookies.js" defer></script>';

    if (isset($args[0]) && is_array($args[0])) {
        $args[0][] = $js;
    } else {
        $args[0] = ($args[0] ?? '') . $js;
    }

    return $args;
}

function olivaCookiesFooter($args)
{
    $t = olivaCookiesLoadTranslations();

    $html = PHP_EOL . '<div id="oliva-cookie-notice" class="oliva-cookie-notice" role="dialog" aria-live="polite" aria-label="' . htmlspecialchars($t['ariaLabel'], ENT_QUOTES, 'UTF-8') . '" hidden>' . PHP_EOL
        . '  <div class="oliva-cookie-notice__text">' . htmlspecialchars($t['noticeText'], ENT_QUOTES, 'UTF-8') . '</div>' . PHP_EOL
        . '  <div class="oliva-cookie-notice__actions">' . PHP_EOL
        . '    <a class="oliva-cookie-notice__link" href="' . htmlspecialchars($t['moreUrl'], ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($t['moreText'], ENT_QUOTES, 'UTF-8') . '</a>' . PHP_EOL
        . '    <button type="button" id="oliva-cookie-accept" class="oliva-cookie-notice__button">' . htmlspecialchars($t['buttonText'], ENT_QUOTES, 'UTF-8') . '</button>' . PHP_EOL
        . '  </div>' . PHP_EOL
        . '</div>' . PHP_EOL;

    if (isset($args[0]) && is_array($args[0])) {
        $args[0][] = $html;
    } else {
        $args[0] = ($args[0] ?? '') . $html;
    }

    return $args;
}
