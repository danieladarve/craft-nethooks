/**
 * Nethooks plugin for Craft CMS
 *
 * Nethooks Utility JS
 *
 * @author    Jungle Minds
 * @copyright Copyright (c) 2018 Jungle Minds
 * @link      https://jungleminds.com
 * @package   Nethooks
 * @since     1.1.2
 */
!function ($) {
  var deployButtons = $('#content .nethooks .hooks .hook button');
  if (deployButtons) {

    deployButtons.on('click', function () {
      var _this = this
      $(_this).addClass('add loading');
      var badge = $(this).parents('.hook').find('img') ?? false
      var badgeSrc = badge.attr('src');
      var intervalId = null;

      $(_this).removeClass('submit');
      $(_this).prop('disabled', true);
      $.ajax({
        type: "POST",
        url: $(_this).attr('data-build-hook'),
        error: function() {
          console.log(error)
          $(_this).removeClass('add loading');
          $(_this).addClass('submit');
          $(_this).prop('disabled', false);
          if(badge){
            clearInterval(intervalId); // Stop the reloading interval
          }
        },
        success:  function() {
          $(_this).removeClass('add loading');
          if(badge){
            console.log(badge)
            intervalId = setInterval(function() {
              var d = new Date();
              badge.attr('src', badgeSrc+"?"+d.getTime());
            }, 350);
          }
        },
      });

      if(badge){
        setTimeout(function() {
          clearInterval(intervalId); // Stop the reloading interval
        }, 180000);
      }
    });
  }
}(jQuery);
