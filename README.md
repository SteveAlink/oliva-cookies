# OlivaCookies for WonderCMS
By Steve Alink for Oliva Solutions

Simple WonderCMS plugin that shows a cookie notice until the visitor clicks **Accept**.

## Installation
1. Copy the folder `OlivaCookies` to your WonderCMS `plugins` folder.
2. Make sure the path is: `plugins/OlivaCookies/OlivaCookies.php`.
3. Refresh your website.
4. Prepare a page with name privacy as this is used in the link if visitor wants more information

## Language files
Translations are stored in:  
plugins/OlivaCookies/languages/  
Included files:  
en_US.ini  
nl_NL.ini

Each language file can contain:  
noticeText = "Cookie notice text"  
buttonText = "Accept"  
moreText = "More information"  
moreUrl = "/privacy"  
ariaLabel = "Cookie notice"

The plugin reads the configured language from (as the standard HTML language value for visitors is not ISO coded: en_US is different from en_EN):  
$Wcms->get('config', 'contactFormLanguage');  
If this value is empty, invalid, or missing, it falls back to `en_US` and populates the config value.

## Important
This is a cookie notice plugin, not a full consent-management platform. It does not block third-party scripts before consent.  
If you use analytics, tracking pixels, embedded videos, or marketing tools, you may need stricter consent handling.

## Versions
1.0.1 29-Apr-2026 Initial version
