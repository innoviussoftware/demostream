<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

use \youtube as dbx;

class Youtube {

    public function __construct() {
        if (file_exists(APPPATH . "third_party/youtube/autoload.php")) {
            require_once APPPATH . "third_party/youtube/autoload.php";
            require_once APPPATH . "third_party/youtube/Client.php";
            require_once APPPATH . "third_party/youtube/Service/YouTube.php";
        }
    }

    public function youtube_video($filename, $filepath, $title, $description, $tag) {

        $client = new Google_Client();
        $client->setClientId(OAUTH_CLIENT_ID);
        $client->setClientSecret(OAUTH_CLIENT_SECRET);
        $client->setScopes('https://www.googleapis.com/auth/youtube');
        $client->setRedirectUri(REDIRECT_URL);
        $youtube = new Google_Service_YouTube($client);
        $filePath = $filepath . "/" . $filename;
        $allowedTypeArr = array("video/mp4", "video/avi", "video/mpeg", "video/mpg", "video/mov", "video/wmv", "video/rm");
        $videoData = $filename;
        $tokenSessionKey = 'token-' . $client->prepareScopes();
//        if (isset($_GET['code'])) {
//            if (strval($_SESSION['state']) !== strval($_GET['state'])) {
//                die('The session state did not match.');
//            }
//            $client->authenticate($_GET['code']);
//            $_SESSION[$tokenSessionKey] = $client->getAccessToken();
//            header('Location: ' . REDIRECT_URL);
//        }
//        if (isset($_SESSION[$tokenSessionKey])) {
//            $client->setAccessToken($_SESSION[$tokenSessionKey]);
//        }
//        $videoPath = $filePath;
//        $tokenSessionKey = 'token-' . $client->prepareScopes();
//        if (isset($_GET['code'])) {
//            if (strval($_SESSION['state']) !== strval($_GET['state'])) {
//                die('The session state did not match.');
//            }
//            $client->authenticate($_GET['code']);
//            $_SESSION[$tokenSessionKey] = $client->getAccessToken();
//            header('Location: ' . REDIRECT_URL);
//        }
//        if (isset($_SESSION[$tokenSessionKey])) {
//            $client->setAccessToken($_SESSION[$tokenSessionKey]);
//        }
//        if ($client->getAccessToken()) {
//            $htmlBody = '';
//            try {
//                $videoPath = $filePath;
//                if (!empty($videoData['youtube_video_id'])) {
//                    @$videoTitle = $title;
//                    @$videoDesc = $description;
//                    @$videoTags = $tag;
//                } else {
//                    echo "<pre>";
//                    $snippet = new Google_Service_YouTube_VideoSnippet();
//                    @$snippet->setTitle($title);
//                    @$snippet->setDescription($description);
//                    @$snippet->setTags(explode(",", $tags));
//
//                    $snippet->setCategoryId("22");
//
//                    $status = new Google_Service_YouTube_VideoStatus();
//                    $status->privacyStatus = "public";
//                    $video = new Google_Service_YouTube_Video();
//                    $video->setSnippet($snippet);
//                    $video->setStatus($status);
//                    $chunkSizeBytes = 1 * 1024 * 1024;
//                    $client->setDefer(true);
//                    $insertRequest = $youtube->videos->insert("status,snippet", $video);
//
//                    $media = new Google_Http_MediaFileUpload(
//                            $client, $insertRequest, 'video/*', null, true, $chunkSizeBytes
//                    );
//
//                    $media->setFileSize(filesize($videoPath));
//                    $videoPath;
//                    $status = false;
//                    $handle = fopen($videoPath, "rb");
//                    while (!$status && !feof($handle)) {
//                        $chunk = fread($handle, $chunkSizeBytes);
//                        $status = $media->nextChunk($chunk);
//                    }
//
//                    fclose($handle);
//
//                    $client->setDefer(false);
//                    //exit;
//
//                    $video_id = $status['id'];
//                    //echo  $status['snippet']['title'];
//                    $WrapperPath = $status['snippet']['thumbnails']['default']['url'];
//                }
//                $htmlBody = array('url' => "https://youtu.be/" . $video_id, 'WrapperPath' => $WrapperPath);
//                return $htmlBody;
//            } catch (Google_Service_Exception $e) {
//                $htmlBody = array('url' => "https://youtu.be/" . $video_id, 'WrapperPath' => $WrapperPath);
//                return $htmlBody;
//            } catch (Google_Exception $e) {
//                echo $htmlBody .= sprintf('<p>An client error occurred: <code>%s</code></p>', htmlspecialchars($e->getMessage()));
//                echo $htmlBody .= 'Please reset session <a href="' . base_url('admin/Video_Sync/logout_youtube') . '">Logout</a>';
//                return $htmlBody;
//            }
//            $_SESSION[$tokenSessionKey] = $client->getAccessToken();
//        } else

        if (@$OAUTH2_CLIENT_ID == OAUTH_CLIENT_ID) {
            echo $htmlBody = "<h3>Client Credentials Required</h3>
        <p>
        You need to set <code>\$OAUTH2_CLIENT_ID</code> and
        <code>\$OAUTH2_CLIENT_ID</code> before proceeding.
        <p>";
            exit;
        } else {
            $state = mt_rand();
            $client->setState($state);
            $_SESSION['state'] = $state;

            $authUrl = $client->createAuthUrl();
            echo "<script>location.replace('" . $authUrl . "');</script>";
            exit;
            echo $htmlBody = "
      <center><div style='margin-top:5%;border:1px solid #999;width:30%;padding:1%;'><h3>Authorization Required</h3>
      <p>You need to <a href=" . $authUrl . ">authorize access</a> before proceeding.<p></div></center>";
            //return $htmlBody;
            exit;
        }
    }

    public function upload_video($filename, $filepath, $title, $description, $tag, $state, $code) {

        $client = new Google_Client();
        $client->setClientId(OAUTH_CLIENT_ID);
        $client->setClientSecret(OAUTH_CLIENT_SECRET);
        $client->setScopes('https://www.googleapis.com/auth/youtube');
        $client->setRedirectUri(REDIRECT_URL);
        $youtube = new Google_Service_YouTube($client);
        $filePath = $filepath . "/" . $filename;
        $allowedTypeArr = array("video/mp4", "video/avi", "video/mpeg", "video/mpg", "video/mov", "video/wmv", "video/rm");

        $videoData = $filename;

        $tokenSessionKey = 'token-' . $client->prepareScopes();

        if (isset($code)) {
            if (strval($_SESSION['state']) !== strval($state)) {
                die('The session state did not match.');
            }

            $client->authenticate($code);
            $_SESSION[$tokenSessionKey] = $client->getAccessToken();
            header('Location: ' . REDIRECT_URL);
        }

        if (isset($_SESSION[$tokenSessionKey])) {
            $client->setAccessToken($_SESSION[$tokenSessionKey]);
        }

        $videoPath = $filePath;

        $tokenSessionKey = 'token-' . $client->prepareScopes();



        if (isset($_SESSION[$tokenSessionKey])) {
            $client->setAccessToken($_SESSION[$tokenSessionKey]);
        }


        if ($client->getAccessToken()) {
            $htmlBody = '';
            try {

                $videoPath = $filePath;
                //exit;
                if (!empty($videoData['youtube_video_id'])) {
                    $videoTitle = $title;
                    $videoDesc = $description;
                    $videoTags = $tag;
                } else {

                    //  echo "bb";
                    $snippet = new Google_Service_YouTube_VideoSnippet();
                    $snippet->setTitle(@$title);
                    $snippet->setDescription(@$description);
                    $snippet->setTags(explode(",", @$tags));
                    $snippet->setCategoryId("22");
                    $status = new Google_Service_YouTube_VideoStatus();
                    $status->privacyStatus = "public";
                    $video = new Google_Service_YouTube_Video();
                    $video->setSnippet($snippet);
                    $video->setStatus($status);
                    $chunkSizeBytes = 3 * 1024 * 1024;
                    $client->setDefer(true);

                    $insertRequest = $youtube->videos->insert("status,snippet", $video);

                    $media = new Google_Http_MediaFileUpload(
                            $client, $insertRequest, 'application/octet-stream', null, true, $chunkSizeBytes
                    );
                    $media->setFileSize(filesize($videoPath));

                    $status = false;
                    $handle = fopen($videoPath, "rb");
                    while (!$status && !feof($handle)) {
                        $chunk = fread($handle, $chunkSizeBytes);
                        $status = $media->nextChunk($chunk);
                    }

                    fclose($handle);

                    $client->setDefer(false);


                    $video_id = $status['id'];
                    $WrapperPath = $status['snippet']['thumbnails']['default']['url'];
                }

                //$htmlBody = "video_id=".$video_id;
                //$htmlBody = "WrapperPath=".$WrapperPath;
                $htmlBody = array('url' => "https://youtu.be/" . $video_id, 'WrapperPath' => $WrapperPath);
                return $htmlBody;
            } catch (Google_Service_Exception $e) {
                $htmlBody = array('url' => "https://youtu.be/" . $video_id, 'WrapperPath' => $WrapperPath);
                return $htmlBody;
            } catch (Google_Exception $e) {
                $htmlBody .= sprintf('<p>An client error occurred: <code>%s</code></p>', htmlspecialchars($e->getMessage()));
                $htmlBody .= 'Please reset session <a href="' . base_url('admin/Video_Sync/logout_youtube') . '">Logout</a>';
            }

            $_SESSION[$tokenSessionKey] = $client->getAccessToken();
        } elseif (@$OAUTH2_CLIENT_ID == OAUTH_CLIENT_ID) {
            echo $htmlBody = "<h3>Client Credentials Required</h3>
      <p>
        You need to set <code>\$OAUTH2_CLIENT_ID</code> and
        <code>\$OAUTH2_CLIENT_ID</code> before proceeding.
      <p>";

            exit;
        } else {
            $state = mt_rand();
            $client->setState($state);
            $_SESSION['state'] = $state;

            $authUrl = $client->createAuthUrl();
           
            echo $htmlBody = "
      <center><div style='margin-top:5%;border:1px solid #999;width:30%;padding:1%;'><h3>Authorization Required</h3>
      <p>You need to <a href=" . $authUrl . ">authorize access</a> before proceeding.<p></div></center>";
            //return $htmlBody;
            exit;
        }
    }

}

?>