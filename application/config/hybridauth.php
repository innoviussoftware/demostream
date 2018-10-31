<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
  | -------------------------------------------------------------------------
  | HybridAuth settings
  | -------------------------------------------------------------------------
  | Your HybridAuth config can be specified below.
  |
  | See: https://github.com/hybridauth/hybridauth/blob/v2/hybridauth/config.php
 */
$config['hybridauth'] = array(
    "providers" => array(
        // openid providers
        "OpenID" => array(
            "enabled" => FALSE,
        ),
        "Yahoo" => array(
            "enabled" => FALSE,
            "keys" => array("id" => "", "secret" => ""),
        ),
        "AOL" => array(
            "enabled" => FALSE,
        ),
        "Google" => array(
            "enabled" => TRUE,
//            "keys" => array("id" => "454466704199-0hdc2l911rfqgsbejbr437gntmlkhbvj.apps.googleusercontent.com", "secret" => "oXT56vljdyj6HgJVdXGjIY6U"),
            "keys" => array("id" => "458063848314-ts5bm7k7ugkmj3rm4grgvvavnefq7ep8.apps.googleusercontent.com", "secret" => "ZEsb3W85eepGo8q0tmroAEfB"),
            "trustForwarded" => FALSE,
        ),
        "Facebook" => array(
            "enabled" => FALSE,
            "keys" => array("id" => "736600566548111", "secret" => "105bfe73fc8087dbf5016ed1fe7224d1"),
            "trustForwarded" => FALSE,
        ),
        "Twitter" => array(
            "enabled" => TRUE,
//            "keys" => array("key" => "yZDcWxtX44qjYLIOqkOtTEmPK", "secret" => "kkMzOoOXznFk2KbXlvCrff3IVRTo2yHWFA7zsrgEuse9TxWCtM"),
            "keys" => array("key" => "tnpHmoSJFTwacF36w2IwzVr4d", "secret" => "2ziMOgECoQiB7fgxIdiOSm0uMz0yL6RLcxgUpKVRnRmKlFNweH"),
            "includeEmail" => FALSE,
        ),
        "Dropbox" => array(
            "enabled" => FALSE,
            "keys" => array("id" => "r1qgu2e1hfv2cwg", "secret" => "6e81xwp8s9x4bs8"),
            "trustForwarded" => FALSE,
        ),
        "Stripe" => array(
            "enabled" => FALSE,
            "keys" => array("id" => "", "secret" => ""),
        ),
        "Live" => array(
            "enabled" => FALSE,
            "keys" => array("id" => "", "secret" => ""),
        ),
        "LinkedIn" => array(
            "enabled" => FALSE,
            "keys" => array("id" => "", "secret" => ""),
            "fields" => array(),
        ),
        "Foursquare" => array(
            "enabled" => FALSE,
            "keys" => array("id" => "", "secret" => ""),
        ),
    ),
    // If you want to enable logging, set 'debug_mode' to true.
    // You can also set it to
    // - "error" To log only error messages. Useful in production
    // - "info" To log info and error messages (ignore debug messages)
    //  "debug_mode" => ENVIRONMENT === 'development',
    "debug_mode" => 'error',
    // Path to file writable by the web server. Required if 'debug_mode' is not false
    "debug_file" => APPPATH . 'logs/hybridauth.log',
);
