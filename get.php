<?php

/*
 * CYW example api get
 * Requires oauth to be installed - http://pecl.php.net/package/oauth
 */

class cyw {

    private $consumerKey;
    private $consumerSecret;
    private $token;
    private $tokenSecret;

    public function __construct() {

        $this->consumerKey  = "";
        $this->consumerSecret   = "";
        $this->token        = "";
        $this->tokenSecret  = "";

        $this->getJson();
    }

    private function getJson() {
         try {
            $oauth = new OAuth( $this->consumerKey , $this->consumerSecret , OAUTH_SIG_METHOD_HMACSHA1,OAUTH_AUTH_TYPE_URI );
            $oauth->setToken( $this->token , $this->tokenSecret );

            $query = "http://beta.pcw.awsripple.com/rest/v1/discover?limit=1&offset=2";
            //$query = "http://beta.pcw.awsripple.com/rest/v1/facet?type=what";
            //$query = "http://beta.pcw.awsripple.com/rest/v1/item?createdAfter=2012-01-01";
            //$query = "http://beta.pcw.awsripple.com/rest/v1/collection";
            
            $oauth->fetch($query);

            $response_info = $oauth->getLastResponseInfo();
            header("Content-Type: {$response_info["content_type"]}");
            echo $oauth->getLastResponse();
        } catch(OAuthException $E) {
            print_r($E);
            echo "Exception caught!\n";
            echo "Response: ". $E->lastResponse . "\n";
        }       
    }
}

new cyw();
