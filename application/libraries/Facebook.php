<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (file_exists(APPPATH . "third_party/facebook/autoload.php")) {
    require_once APPPATH . "third_party/facebook/autoload.php";
}

/* Facebook Class */

use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\Entities\AccessToken;
use Facebook\HttpClients\FacebookCurlHttpClient;
use Facebook\HttpClients\FacebookHttpable;

class Facebook {

    public function request($APP_ID, $SECRET_KEY) {
        // init app with app id and secret
        FacebookSession::setDefaultApplication($APP_ID, $SECRET_KEY);
        // login helper with redirect_uri
        $helper = new FacebookRedirectLoginHelper('http://demostream.tv/Hauth/facebook_success');
        $loginUrl = $helper->getLoginUrl();
        header("Location: " . $loginUrl);
    }

    public function response($APP_ID, $SECRET_KEY, $code) {
        // init app with app id and secret
        FacebookSession::setDefaultApplication($APP_ID, $SECRET_KEY);
        $params = array(
            'client_id' => FacebookSession::_getTargetAppId($APP_ID),
            'redirect_uri' => 'http://demostream.tv/Hauth/facebook_success',
            'client_secret' =>
            FacebookSession::_getTargetAppSecret($SECRET_KEY),
            'code' => $code
        );
        $response_token = (new FacebookRequest(
                FacebookSession::newAppSession($APP_ID, $SECRET_KEY), 'GET', '/oauth/access_token', $params
                ))->execute()->getResponse();

        if (isset($response_token->access_token)) {
            $token = new FacebookSession($response_token->access_token);

            // graph api request for user data
            $request = new FacebookRequest($token, 'GET', '/me?locale=en_US&fields=id,name,first_name,middle_name,last_name,email,gender,link,birthday,location');
            $response = $request->execute();
            // get response
            $graphObject = $response->getGraphObject();

            $data = $graphObject->asArray(); //this will do all job for you..
            foreach ($data as $key => $value) {
                $response_data[$key] = $value;
            }
            $fbid = $graphObject->getProperty('id');              // To Get Facebook ID
            $fbfullname = $graphObject->getProperty('name'); // To Get Facebook full name
            $femail = $graphObject->getProperty('email');    // To Get Facebook email ID

            return $response_data;
        }
    }

}

?>