<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Kolkata');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code



// Stripe Errors
define('INVALID_STRIPE_PARAMS', 'Invalid stripe parameters received. Please try again.');
define('AUTHENTICATION_STRIPE_FAILED', 'Authentication with stripe failed. Please try again.');
define('NETWORK_STRIPE_FAILED', 'Network communication with Stripe failed.');
define('STRIPE_FAILED', 'Stripe payment failed. Please try again.');

//Webservices  
//http://54.213.221.3/Demostream_AWSTest/Service1.svc/ //test
//http://166.62.81.166/Demostream/Service1.svc //Live

define('USER_AUTHEDICATE','http://rhs.solutions/Demostream/Service1.svc/usp_authedicateuser'); //login webservice
define('SYNCTODB','http://rhs.solutions/Demostream/Service1.svc/SyncToDB'); //SyncToDB
define('FUND_MANAGER','http://rhs.solutions/Demostream/Service1.svc/usp_GetFundManagementDetails_new'); //Fund Manager
define('DROPBOX_COLLABORATE','http://rhs.solutions/Demostream/Service1.svc/usp_GetDropBoxSharedFiles_New');//Dropbox Collaborate

define('COMMENTS','http://rhs.solutions/Demostream/Service1.svc/usp_GetCommentsListTabDetails_new'); //Comments
define('DONORS','http://rhs.solutions/Demostream/Service1.svc/usp_GetDonorsListTabDetails_new');//Donors
define('VIDEO_LIST','http://rhs.solutions/Demostream/Service1.svc/usp_GetVideoListTabDetails_new'); //Video-list
define('FRONT_VIDEO','http://rhs.solutions/Demostream/Service1.svc/usp_GetFrontVideoInfo'); //Front video
define('VIDEO','http://rhs.solutions/Demostream/Service1.svc/usp_GetVideoTabDetails_new'); //Video-list
define('CAMPAIGN','http://rhs.solutions/Demostream/Service1.svc/usp_GetOneProjectTabDetails_new'); //Campaign
define('VIDEO_DETAIL','http://rhs.solutions/Demostream/Service1.svc/usp_GetOneVideoTabDetails_new');// Video detail

define('ACTIVITY_LIST','http://rhs.solutions/Demostream/Service1.svc/usp_GetActivityUpdatesListTabDetails_new');//Activity List
define('ACTIVITY','http://rhs.solutions/Demostream/Service1.svc/usp_GetVideoActivityUpdates'); // Activity for iscampaign=0
define('CONTACT_EMAIL','jack@demostream.tv'); //Get demostream
//define('CONTACT_EMAIL','testingktss@gmail.com'); //Get demostream


define('SITE_NAME', 'Demostream');
define('SITE_URL_MAIL', 'http://demostream.tv/');

define('FROM_MAIL','demostream@gator2011.hostgator.com'); //Get demostream

/*define('SHOPIFY_API_KEY','00e183f2ecb28b6efd909aae4a64cb1b');//Shopify Api key
define('SHOPIFY_PASSWORD','ff1784bfbbaa2b08f4207127355c051a');//Shopify App Password
define('SHOPIFY_STORE_NAME','demo-stream.myshopify.com');//Shopify store name
*/
define('SHOPIFY_FUND_DETAILS','http://rhs.solutions/Demostream/Service1.svc/usp_GetFundManagementDetails_new');
/*define('SHOPIFY_API_KEY','9869d53e6dbf7703df530b7e068b1cef');//Shopify Api key
define('SHOPIFY_PASSWORD','2bf9c9afcab8e97e572aef822e2ce0a2');//Shopify App Password
define('SHOPIFY_STORE_NAME','ktsdemostream.myshopify.com');//Shopify store name
*/

define('MY_DONATION','http://rhs.solutions/Demostream/Service1.svc/usp_GetMyVideoDonation');

define('Banner_Detail', 'http://rhs.solutions/Demostream/Service1.svc/usp_GetBannerDetails');

define('Userlist', 'http://rhs.solutions/Demostream/Service1.svc/usp_GetUserList');

define('Subscriptionlist', 'http://rhs.solutions/Demostream/Service1.svc/usp_GetUserSubscriptions');

define('PACKGE_LIST', 'http://rhs.solutions/Demostream/Service1.svc/usp_GetSubscriptionPackages');

define('SYNCTOCONFIGDB', 'http://rhs.solutions/Demostream/Service1.svc/SyncToConfigDB');

define('DEALER_LIST', 'http://rhs.solutions/Demostream/Service1.svc/usp_GetDealerDetails');

define('Forgot_password','http://rhs.solutions/Demostream/Service1.svc/usp_authedicateuserbyusername');

$oauthClientID = '887376612845-7suafad0jgivacmr253gb5mh798n55qq.apps.googleusercontent.com';
$oauthClientSecret = 'riBlI1JHOS9W32H9QLa4tmeD';
$baseURL = 'http://demostream.tv/';
$redirectURL = 'http://demostream.tv/admin/Video_Sync/success_video';
//$redirectURL = 'http://localhost/demostream/admin/Video_Sync/success_video';


define('OAUTH_CLIENT_ID',$oauthClientID);
define('OAUTH_CLIENT_SECRET',$oauthClientSecret);
define('REDIRECT_URL',$redirectURL);
define('BASE_URL',$baseURL);

//http://localhost/demostream/admin/Youtube/upload_video


//ning paywall

// define('NETWORK_KEY', 'testSite');
define('NETWORK_KEY','demostream_test');
define('PRODUCT_KEY799', 'hiphopperiod799');
define('PRODUCT_KEY699', 'hiphopperiod699');
define('PRODUCT_KEY499', 'pack499');
define('PRODUCT_KEY_DONATE', 'hiphop_donation');
define('API_LOGIN', 'demostream');
define('API_PASSWORD', 'Va8JqGdhRX');

// define('API_LOGIN', 'demostream-live');
// define('API_PASSWORD', '26KjkF27bVGzS6hR');

define('PAYWALL_EMAIL', 'jack@demostream.tv');

if($_SERVER["HTTP_HOST"] == 'localhost'){
  $base_url_ning = $_SERVER["HTTP_HOST"] .'/demostream';
}else{
  $base_url_ning = $_SERVER["HTTP_HOST"] ;
}
define('SUCCESS_GOBACK_URL','http://'.$base_url_ning . '/Subscribe/paywall_close');
define('SUCCESS_GOBACK_URL_DONATE','http://'. $base_url_ning . '/Donate/complete_donation');
define('DOWNLOAD_SUCCESS_GOBACK_URL','http://'. $base_url_ning . '/Download/payment_success');

define('CHECK_USER_PERMISSION', 'https://e-commerce.ning.com/api/v1/checkUserPermissionForProduct');
define('REGISTER_PAYMENT_DATA', 'https://e-commerce.ning.com/api/v1/registerPaymentData');
define('GET_PAYMENT_HISTORY', 'https://e-commerce.ning.com/api/v1/getPaymentHistory');
define('CREATE_PRODUCT_FOR_NETWORK', 'https://e-commerce.ning.com/api/v1/createProductForNetwork');
define('PAYWALL_LIST', 'https://e-commerce.ning.com/api/v1/getPayWallListForNetwork');
define('IFRAME_NING_PAYWALL', 'https://e-commerce.ning.com/api/v1/getOtpForNetwork');
define('ADD_RELATION_BETWEEN_PRODUCTKEY_AND_PAYWALL', 'https://e-commerce.ning.com/api/v1/addRelationBetweenProductKeyAndPayWall');
define('CREATE_NETWORK','http://e-commerce.ning.com/api/v1/createNetworkAndManageProfile');
