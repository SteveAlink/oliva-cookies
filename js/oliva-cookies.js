(function () {
  'use strict';

  var cookieName = 'oliva_cookies_accepted';
  var cookieMaxAge = 60 * 60 * 24 * 180; // 180 days

  function hasAcceptedCookies() {
    return document.cookie.split(';').some(function (item) {
      return item.trim().indexOf(cookieName + '=yes') === 0;
    });
  }

  function acceptCookies() {
    document.cookie = cookieName + '=yes; max-age=' + cookieMaxAge + '; path=/; SameSite=Lax';
    var notice = document.getElementById('oliva-cookie-notice');
    if (notice) {
      notice.setAttribute('hidden', 'hidden');
    }
  }

  document.addEventListener('DOMContentLoaded', function () {
    var notice = document.getElementById('oliva-cookie-notice');
    var acceptButton = document.getElementById('oliva-cookie-accept');

    if (!notice) {
      return;
    }

    if (!hasAcceptedCookies()) {
      notice.removeAttribute('hidden');
    }

    if (acceptButton) {
      acceptButton.addEventListener('click', acceptCookies);
    }
  });
}());
