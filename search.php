<?php 
	require_once('connect.inc');
	
	$pdo = createPDO();
	
	// Create Smarty Object
	define("USER_HOME_DIR", "/home/stud/s3241690");
	require(USER_HOME_DIR . "/php/Smarty-3.1.11/libs/Smarty.class.php");
	$smartyEngine = new Smarty();
	$smartyEngine->template_dir = USER_HOME_DIR . "/php/Smarty-Work-Dir/templates";
	$smartyEngine->compile_dir = USER_HOME_DIR . "/php/Smarty-Work-Dir/templates_c";
	$smartyEngine->cache_dir = USER_HOME_DIR . "/php/Smarty-Work-Dir/cache";
	$smartyEngine->config_dir = USER_HOME_DIR . "/php/Smarty-Work-Dir/configs";
	$smartyEngine->display('header.tpl');
	
	// Get Regions
	$query = 'select region_name from region';
    $result = $pdo->query($query);
	$i = 0;
	while($row = $result->fetch(PDO::FETCH_OBJ))  {
		$regionList[$i] = $row->region_name;
		$i++;
	}
	// Get Grape Varieties
	$query = 'select variety from grape_variety;';
    $result = $pdo->query($query);
	$i = 0;
	while($row = $result->fetch(PDO::FETCH_OBJ))
	{
		$grapeVarietyList[$i] = $row->variety;
		$i++;
	}
	
	// Get Lower Bound of the Wine Production Years
	$query = 'select min(year) as min from wine';
    $result = $pdo->query($query);
	$result = $result->fetch(PDO::FETCH_OBJ);
	$yearMinimum = $result->min;
	
	
	
	// Get Upper Bound of the Wine Production Years
	$query = 'select max(year) as max from wine;';
    $result = $pdo->query($query);
	$result = $result->fetch(PDO::FETCH_OBJ);
	$yearMaximum = $result->max;
	
	// Calculate Production Year Difference 
	$yearDifference = $yearMaximum - $yearMinimum;
	
	
		
	// Collect GET variables	
		/* Collect GET Search Criteria */
if($_GET['wine'] != null)
	$wine = $_GET['wine'];

if($_GET['winery'] != null)
	$winery = $_GET['winery'];

if($_GET['region'] != null)
	$region = $_GET['region'];

if($_GET['grapeVariety'] != null)
	$grapeVariety = $_GET['grapeVariety'];
	
if($_GET['yearLowerBound'] != null)
	$yearLowerBound = $_GET['yearLowerBound'];
	
if($_GET['yearUpperBound'] != null)
	$yearUpperBound = $_GET['yearUpperBound'];
	
if($_GET['minWinesInStock'] != null)
	$minWinesInStock = $_GET['minWinesInStock'];
	
if($_GET['minWinesOrdered'] != null)
	$minWinesOrdered = $_GET['minWinesOrdered'];
	
if($_GET['costLowerBound'] != null)
	$costLowerBound = $_GET['costLowerBound'];
	
if($_GET['costUpperBound'] != null)
	$costUpperBound = $_GET['costUpperBound'];
	
if($_GET['errors'] != null)
	$errors = $_GET['errors'];
?>

<?php
	/* Check if there are any error messages to display */
	switch($errors)
	{
	case -1:
		$smartyEngine->assign('error', 'You have attempted to search the database in an unauthorise way, please re-submit:');
		$smartyEngine->display('error.tpl');
		break;
	case 1:
		$smartyEngine->assign('error', 'You have entered invalid year requirements, please check them and re-submit:');
		$smartyEngine->display('error.tpl');
		break;
	case 2:
		$smartyEngine->assign('error', 'You have entered invalid cost requirements, please check them and re-submit:');
		$smartyEngine->display('error.tpl');
		break;
	case 3:
		$smartyEngine->assign('error', 'You have attempted to search the database in an unauthorise way, please re-submit:');
		$smartyEngine->display('error.tpl');
		break;	
	default:
		echo '<p>Please enter your search requirments below:</p>';
	}
	

		$smartyEngine->assign('wine', $wine);
		$smartyEngine->assign('winery', $winery);
		$smartyEngine->assign('region', $region);
		$smartyEngine->assign('grapeVariety', $grapeVariety);
		$smartyEngine->assign('yearLowerBound', $yearLowerBound);
		$smartyEngine->assign('yearUpperBound', $yearUpperBound);
		$smartyEngine->assign('minWinesInStock', $minWinesInStock);
		$smartyEngine->assign('minWinesOrdered', $minWinesOrdered);
		$smartyEngine->assign('costLowerBound', $costLowerBound);
		$smartyEngine->assign('costUpperBound', $costUpperBound);
		$smartyEngine->assign('yearMinimum', $yearMinimum);
		$smartyEngine->assign('yearMaximum', $yearMaximum);
		$smartyEngine->assign('regionList', $regionList);
		$smartyEngine->assign('grapeVarietyList', $grapeVarietyList);
		$smartyEngine->display('search.tpl');
		$smartyEngine->display('footer.tpl');

	// Destroy the PDO
	destroyPDO($pdo);
?>