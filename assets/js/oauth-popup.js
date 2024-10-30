/*!
 * jQuery OAuth via popup window plugin
 *
 * Adapted from oauth-popup by Nobu Funaki @zuzara
 *
 * Dual licensed under the MIT and GPL licenses:
 *   http://www.opensource.org/licenses/mit-license.php
 *   http://www.gnu.org/licenses/gpl.html
 */
(function (jQuery) {
  //  inspired by DISQUS
  jQuery.oauthpopup = function (options) {
    options.windowName = options.windowName || 'ConnectWithOAuth'; // should not include space for IE
    options.windowOptions = options.windowOptions || 'location=0,status=0,width=800,height=600,scrollbars=1';
    options.callback = options.callback || window.location.reload();

    this._oauthWindow = window.open(options.path, options.windowName, options.windowOptions);
    this._oauthInterval = window.setInterval(() => {
      if (this._oauthWindow.closed) {
        window.clearInterval(this._oauthInterval);
        options.callback();
      }
    }, 1000);
  };
})(jQuery);
