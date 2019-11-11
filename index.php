<?php

require 'autoload.php';

use Abraham\TwitterOAuth\TwitterOAuth; // API class, located in autoload.php


session_start();

//Defining variables
define('CONSUMER_KEY', '4dvhIGlVuHOAmpcPcB3fEVAOb');
define('CONSUMER_SECRET', 'uUPC5f9ExMCRHIRVXNxkgXU9NB36RoRVeJIZfFQQUAmVWmZusJ');
define('OAUTH_CALLBACK', 'https://twitterfeedapi.herokuapp.com/callback.php');

if (!isset($_SESSION['access_token'])) {
    $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
    $request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => OAUTH_CALLBACK)); // Temporary Token
    $_SESSION['oauth_token'] = $request_token['oauth_token']; //Saving tokens to session
    $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
    $url = $connection->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token'])); //Send to Twitter's Authorization page
    header('Location: ' . $url);
} else {
    //echo('hello');
    $access_token = $_SESSION['access_token'];
    $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
    $content = $connection->get("account/verify_credentials");
    $statuses = $connection->get("statuses/home_timeline", ["screen_name"=>$content->screen_name, "count"=>9]);
    //$contentArr = json_decode($content,true);

foreach($statuses as $key => $status){
    $arrStatus=[];
    $arrStatus['created_at'] = $status->created_at;
    $arrStatus['created_by'] = $status->name;
    $arrStatus['message'] = $status->text;
    $arrStatus['pp'] = $status->user->profile_image_url;
    $arrStatus['uname'] = $status->user->name;
    $arrStatuses[] = $arrStatus;
}

    $pimage = $content->profile_image_url;
    $pname = $content->name;


}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>twitterapi</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styles.min.css">
</head>

<body>
    <div class="testimonials-clean">
        <div class="container">
            <div class="intro">
                <h2 class="text-center">TwitterOAuth - PHP API<br>Live Example</h2>
                <p class="text-center">Here are the most recent tweets on your feed.</p>
            </div>
            <div class="row">
                <div class="col col-6 mx-auto mt-3">
                    <div class="input-group">
                        <div class="input-group-prepend"></div><input class="form-control" type="text" placeholder="Need to say something?">
                        <div class="input-group-append"><button class="btn btn-primary" type="button">Tweet</button></div>
                    </div>
                </div>
            </div>
            <div class="row people">

                <?php 
                    foreach ($arrStatuses as $key => $arrStatus){
                        echo("
                        <div class='col-md-6 col-lg-4 item'>
                        <div class='box'>
                            <p class='description'>" . $arrStatus['message'] . "</p>
                        </div>
                        <div class='author'><img class='rounded-circle' src='". $arrStatus['pp'] . "'>
                            <h5 class='name'>". $arrStatus['uname'] . "</h5>
                            <p class='title'> " . $arrStatus['created_at'] . "</p>
                        </div>
                    </div>
                        
                        
                        ");
                    }
                
                ?>
                <!-- <div class="col-md-6 col-lg-4 item">
                    <div class="box">
                        <p class="description">Aenean tortor est, vulputate quis leo in, vehicula rhoncus lacus. Praesent aliquam in tellus eu gravida. Aliquam varius finibus est.</p>
                    </div>
                    <div class="author"><img class="rounded-circle" src="<?php echo($pimage); ?>">
                        <h5 class="name"><?php echo($pname); ?></h5>
                        <p class="title">CEO of Company Inc.</p>
                    </div>
                </div> -->


            </div>
        </div>
    </div>
    <div class="footer-dark">
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-md-3 item">
                    <h3>References</h3>
                    <ul>
                        <li><a href="https://developer.twitter.com/en/docs/tweets/timelines/api-reference/get-statuses-home_timeline">Twitter API Docs</a></li>
                        <li><a href="#"></a></li>
                        <li><a href="https://twitteroauth.com">TwitterOAuth</a></li>
                        <li><a href="https://www.youtube.com/watch?v=t5hD96EYAtU&amp;list=PLmpuiTmSb3xBT_j9DO2T2l4iq6J9TVVSf&amp;index=1">Youtube Tutorial</a></li>
                    </ul>
                </div>
                <div class="col-sm-6 col-md-3 item">
                    <h3>Group Members</h3>
                    <ul>
                        <li><a href="#">Denzil Williams</a></li>
                        <li><a href="#">Kelleshia Kinlocke</a></li>
                        <li><a href="#"></a></li>
                    </ul>
                </div>
                <div class="col-md-6 item text">
                    <h3>Web Systems Implementation &amp; Design</h3>
                    <p>Presentation Date: Nov 11, 2019.</p>
                </div>
                <div class="col item social"><a href="#"><i class="icon ion-social-facebook"></i></a><a href="#"><i class="icon ion-social-twitter"></i></a><a href="#"><i class="icon ion-social-snapchat"></i></a><a href="#"><i class="icon ion-social-instagram"></i></a></div>
            </div>
            <p class="copyright">Company Name © 2017</p>
        </div>
    </footer>
</div>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>