<?php
	session_start();
	require_once('connect.inc');
	if(isset($_SESSION['history']))
		$searchHistory = $_SESSION['history'];
	$wineDetails = array();
	
	/* Create New PDO OBJECT */
	$pdo = createPDO();
	
	if(isset($searchHistory))
	{
		foreach($searchHistory as $row)
		{
			
			$query = "SELECT wine.wine_id, wine_name, "
					."(SELECT GROUP_CONCAT( CAST( cost AS CHAR ) ) FROM inventory WHERE wine.wine_id = inventory.wine_id) as price, "
					."GROUP_CONCAT( variety ) as variety, year, winery_name, region_name, "
					."(SELECT SUM( on_hand ) FROM inventory WHERE wine.wine_id = inventory.wine_id) as available, "
					."(SELECT SUM(qty) FROM items WHERE wine.wine_id = items.wine_id) as total_sold, "
					."(SELECT SUM(price) FROM items WHERE wine.wine_id = items.wine_id) as total_revenue "
					."FROM winery, region, wine, grape_variety, wine_variety, inventory "
					."WHERE winery.region_id = region.region_id "
					."AND wine.winery_id = winery.winery_id "
					."AND wine_variety.variety_id = grape_variety.variety_id "
					."AND wine.wine_id = wine_variety.wine_id "
					."AND wine.wine_id = inventory.wine_id ";
					
			$query .= " AND wine.wine_id LIKE '{$row}'";		
					
					/* Group by Wine ID*/ 
			$query .="GROUP BY wine.wine_id ";
			$result = $pdo->query($query);
			$result = $result->fetch(PDO::FETCH_ASSOC);
			array_push($wineDetails, $result);
			
		}
	}
	destroyPDO($pdo);

	
	
		$numOfResults = count($wineDetails);
		define("USER_HOME_DIR", "/home/stud/s3241690");
		require(USER_HOME_DIR . "/php/Smarty-3.1.11/libs/Smarty.class.php");
		$smartyEngine = new Smarty();
		$smartyEngine->template_dir = USER_HOME_DIR . "/php/Smarty-Work-Dir/templates";
		$smartyEngine->compile_dir = USER_HOME_DIR . "/php/Smarty-Work-Dir/templates_c";
		$smartyEngine->cache_dir = USER_HOME_DIR . "/php/Smarty-Work-Dir/cache";
		$smartyEngine->config_dir = USER_HOME_DIR . "/php/Smarty-Work-Dir/configs";
		$smartyEngine->display('header.tpl');
		
		$smartyEngine->assign('views', $_SESSION['views']);
		$smartyEngine->assign('title', 'WDA: Search Results');
		$smartyEngine->assign('returnString', $returnString);
	
	if($numOfResults > 0){
		$smartyEngine->assign('wines', $wineDetails);
		$smartyEngine->display('searchResultsPartE.tpl');
	}
	else{
		$smartyEngine->display('noResults.tpl');
	}
	
	$smartyEngine->display('footerPartE.tpl');
	
?>