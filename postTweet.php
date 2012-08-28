<?php

	session_start();
	require_once('connect.inc');
	require_once('tweetfunctions.inc');
	if(isset($_SESSION['history']))
		$searchHistory = $_SESSION['history'];
	$wineDetails = array();
	
	/* Create New PDO OBJECT */
	$pdo = createPDO();
	
	if(isset($searchHistory))
	{
		foreach($searchHistory as $row)
		{
			
			$query = "SELECT wine.wine_name FROM wine WHERE wine.wine_id LIKE '{$row}'";		
					
			$result = $pdo->query($query);
			$result = $result->fetch(PDO::FETCH_OBJ);
			array_push($wineDetails, $result->wine_name);
			
		}
	}
	destroyPDO($pdo);
	
	$tweet;
	foreach($wineDetails as $row)
	{
		$tweet .= $row;
		$tweet .= ', ';
	}
	
	$tweet = substr($tweet, 0, 137);
	$tweet .= '...';
	$result = post_tweet($tweet);
	print_r($tweet);
	print_r($result);
	echo '<a href="search.php">Back to Search Page</a>'
	
	//
	//	$numOfResults = count($wineDetails);
	//	define("USER_HOME_DIR", "/home/stud/s3241690");
	//	require(USER_HOME_DIR . "/php/Smarty-3.1.11/libs/Smarty.class.php");
	//	$smartyEngine = new Smarty();
	//	$smartyEngine->template_dir = USER_HOME_DIR . "/php/Smarty-Work-Dir/templates";
	//	$smartyEngine->compile_dir = USER_HOME_DIR . "/php/Smarty-Work-Dir/templates_c";
	//	$smartyEngine->cache_dir = USER_HOME_DIR . "/php/Smarty-Work-Dir/cache";
	//	$smartyEngine->config_dir = USER_HOME_DIR . "/php/Smarty-Work-Dir/configs";
	//	$smartyEngine->display('header.tpl');
	//	
	//	$smartyEngine->assign('views', $_SESSION['views']);
	//	$smartyEngine->assign('title', 'WDA: Search Results');
	//	$smartyEngine->assign('returnString', $returnString);
	//
	//if($numOfResults > 0){
	//	$smartyEngine->assign('wines', $wineDetails);
	//	$smartyEngine->display('searchResultsPartE.tpl');
	//}
	//else{
	//	$smartyEngine->display('noResults.tpl');
	//}
	//
	//$smartyEngine->display('footer.tpl');
	
?>








