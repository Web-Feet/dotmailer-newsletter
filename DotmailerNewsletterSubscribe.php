<?php
require_once( 'vendor/autoload.php' );
require_once( '../../../wp-load.php' );

class DotmailerNewsletterSubscribe {
	// Connect to the dotmailer api
	private $username;
	private $password;

	public function __construct( $username, $password, $address_book_id )
  {
    $this->username = $username;
		$this->password = $password;
		$this->address_book_id = $address_book_id;

		$credentials = array(
			\DotMailer\Api\Container::USERNAME => $username,
			\DotMailer\Api\Container::PASSWORD => $password
		);
		
    $resources = \DotMailer\Api\Container::newResources($credentials);

		$account_data = $resources->GetAccountInfo();

    $email = sanitize_text_field( $_POST['dotmailer-email'] );
		$data['email'] = $email;
    $data['addressBookId'] = intval($address_book_id);
    $data['userId'] = $account_data['Id'];
    $data['emailType'] = 'Html';
    $data['optInType'] = 'Single';

    try {
      $client = new \GuzzleHttp\Client(['base_uri' => 'https://api.dotmailer.com']);

      $r = $client->request('POST', 'v2/address-books/'.$data['addressBookId'].'/contacts', ['auth' => [$username, $password], 'json' => $data]);
      $status = $r->getStatusCode();

      if ($status = 200) {
        echo "You have signed up to our newsletter.";
      }

      } catch ( Exception $e ) {
        echo "Please enter a valid email address.";
        return $e->getMessage();
      }
  }
}

$options = get_option( 'dotmailer_option_name' );

$new_subscription = new DotmailerNewsletterSubscribe( $options['dotmailer_username'], $options['dotmailer_password'], $options['dotmailer_address_book_id'] );