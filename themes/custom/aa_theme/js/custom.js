(function ($, Drupal, drupalSettings) {

  Drupal.behaviors.language_switcher = {
    attach: function (context, settings) {
      $('.ae-select-content').text($('.language-dropdown-menu > li.is-active').text());
      var newOptions = $('.language-dropdown-menu > li');
      newOptions.click(function() {
        $('.ae-select-content').text($(this).text());
        $('.language-dropdown-menu > li').removeClass('is-active');
        $(this).addClass('is-active');
      });

      $('.ae-dropdown', context).once('show_languages').each(function () {
        $(this).on('click', function(clickEvent) {
          $('.language-dropdown-menu').toggleClass('ae-hide');
        })
      });
    }
  };

  Drupal.behaviors.select2 = {
    attach: function (context, settings) {
      $('.form-select').select2();
    }
  };

})(jQuery, Drupal, drupalSettings);

