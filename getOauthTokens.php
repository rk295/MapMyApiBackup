<?php
include_once "includes/MMF/MMF.php";

$callbackUrl = "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'];

$oauth = new MMF_OAuth;

if (! count($_GET)){

    print "Click <a href='" . $_SERVER['PHP_SELF'] . "?redirect'>here</a> to be sent to MapMyApi to generate a set of tokens";

}elseif(isset($_GET['redirect'])){

    $location = $oauth->getAuthorizeURL($callbackUrl);
    header("Location: $location");

}elseif(isset($_GET['oauth_token'])){

  $oauthToken    = $_GET['oauth_token'];
  $oauthVerifier = $_GET['oauth_verifier'];

  $tokens = $oauth->getAccessToken($oauthToken, $oauthVerifier);

?>
<p>Likely config for your app follows:</p>
<pre>
$accessToken       = "<?php echo $tokens["access_token"];?>";
$accessTokenSecret = "<?php echo $tokens["access_token_secret"];?>";
</pre>
<p>Or...</p>
<pre>
define("MMF_OAUTH_ACCESS_TOKEN", "<?php echo $tokens["access_token"];?>");
define("MMF_OAUTH_ACCESS_TOKEN_SECRET", "<?php echo $tokens["access_token_secret"];?>");

</pre>

<p>Click <a href='<?php echo $_SERVER['PHP_SELF'];?>?redirect'>here</a> to try again<br></p>

<?php
}
?>
