<?php

/*
 * CYW example api upload
 * Requires oauth to be installed - http://pecl.php.net/package/oauth
 */

class cyw {

	private $consumerKey;
	private $consumerSecret;
	private $token;
	private $tokenSecret;

	public function __construct() {

		$this->consumerKey      = "";
		$this->consumerSecret   = "";
		$this->token            = "";
		$this->tokenSecret      = "";

		$this->sendToApi();
	}

	private function sendToApi() {

		// Image filename and location
		$file = 'llgc.jpg';
		// Open the image
		$im = file_get_contents($file);
		// Generate base64 of the image
		$imdata = base64_encode($im); 
		// Generate md5 of the image
		$md5 = md5_file($file); 

		// array to be sent to the api
		$data = array(
			  'title[en]'                       => 'Hello 123'
			, 'title[cy]'                       => 'Welsh'
			, 'description[en]'                 => 'description englih'
			, 'description[cy]'                 => 'description welsh'
			, 'creator'                         => 'mij'  
			, 'file[0][data]'                   => $imdata
			, 'file[0][name]'                   => $file
			, 'file[0][checksum]'               => $md5
			, 'what[0]'                         => 6292
			, 'what[1]'                         => 6295
			//, 'type[]' => 6267
			, 'tags[]'                          => array('one','two','three','four')
			, 'locations[0][lat]'               => '52.414211'
			, 'locations[0][lon]'               => '-4.068224'
			, 'locations[0][description][en]'   => 'English location'
			, 'locations[0][description][cy]'   => 'Welsh location'
		);

		try {
			$oauth = new OAuth( $this->consumerKey , $this->consumerSecret , OAUTH_SIG_METHOD_HMACSHA1,OAUTH_AUTH_TYPE_URI );
			$oauth->setToken( $this->token , $this->tokenSecret );

			// oauthdr
			$change->fetch("http://beta.pcw.awsripple.com/rest/v1/item"
			 		, $data 
			 		, OAUTH_HTTP_METHOD_POST 
			 	 );

			echo $oauth->getLastResponse();

			} catch(OAuthException $E) {
				print_r($E);
				echo "Exception caught!\n";
				echo "Response: ". $E->lastResponse . "\n";
		}		
	}
}

new cyw();
