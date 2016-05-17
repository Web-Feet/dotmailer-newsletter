jQuery(document).ready(function() {

  var formMessages = jQuery('#form-messages');

  jQuery('#dotmailer-subscribe').submit(function(event) {
    event.preventDefault();

    var formData = jQuery('#dotmailer-subscribe').serialize();

    jQuery.ajax({

      type: 'POST',
      url: jQuery('#dotmailer-subscribe').attr('action'),
      data: formData,
      dataType: 'text'

    }).done(function(response) {

      jQuery(formMessages).removeClass('error').delay(300).fadeIn(300).delay(2000);
      jQuery(formMessages).addClass('success').fadeOut(300);

      jQuery(formMessages).text(response)
      jQuery('#dotmailer-email').val('');

    }).fail(function(data) {

      jQuery(formMessages).removeClass('success').delay(300).fadeIn(300).delay(2000);
      jQuery(formMessages).addClass('error').fadeOut(300);

      jQuery(formMessages).text('Oops! An error occured and your message could not be sent.');

    });
  });
});