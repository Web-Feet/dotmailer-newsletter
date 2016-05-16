jQuery(document).ready(function() {

  // Get the messages div.
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

      jQuery(formMessages).removeClass('error');
      jQuery(formMessages).addClass('success');

      jQuery(formMessages).text(response);
      jQuery('#dotmailer-email').val('');

    }).fail(function(data) {

      jQuery(formMessages).removeClass('success');
      jQuery(formMessages).addClass('error');

      if (data.responseText !== '') {
        jQuery(formMessages).text(data.responseText);
      } else {
        jQuery(formMessages).text('Oops! An error occured and your message could not be sent.');
      }
    });
  });
});