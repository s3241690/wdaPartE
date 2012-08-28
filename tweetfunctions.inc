<?php 
 function post_tweet($tweet_text) {

  // Use Matt Harris' OAuth library to make the connection
  // This lives at: https://github.com/themattharris/tmhOAuth
  require_once('tmhOAuth/tmhOAuth.php');
      
  // Set the authorization values
  // In keeping with the OAuth tradition of maximum confusion, 
  // the names of some of these values are different from the Twitter Dev interface
  // user_token is called Access Token on the Dev site
  // user_secret is called Access Token Secret on the Dev site
  // The values here have asterisks to hide the true contents 
  // You need to use the actual values from Twitter
  $connection = new tmhOAuth(array(
    'consumer_key' => 'binGzsqsmQUFLuFQbyz8Q',
    'consumer_secret' => 'pmXugYFc0TVZqKPZJDVK5SGEw8ihQSQCYdR5qV0us',
    'user_token' => '786495570-tAaHqwQkuuTxXWGf8ACFg5PDo2Pqb2CrVqTapFno',
    'user_secret' => 'Ocwea7zZ1kDeW30sjPVXUTiKJcLs9QuDYDSrNZA6kLs',
  )); 
  
  // Make the API call
  $connection->request('POST', 
    $connection->url('1/statuses/update'), 
    array('status' => $tweet_text));
  
  return $connection->response['code'];
}

?>