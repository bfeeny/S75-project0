<?php
	
// Code snippet from the PHP manual http://www.php.net/manual/en/function.simplexml-load-file.php
// Look for the existence of our xml data and suck it into $menu, if it's not there fail
if (file_exists(PROJECT0 . 'xml/menu.xml')) {
    $menu = simplexml_load_file(PROJECT0 . 'xml/menu.xml');
} else {
    exit('Failed to open menu.xml.');
}

// Create an array of categories
$categoryArray = generateCategoryIndexes();

// Current number of categories so we know when we are at the end of the menu
function maxCategoryIndex( $params = '' ) {
	global $categoryArray; 
	return count($categoryArray)-1;
}

// Determine what part of the menu we should be displaying
function getCategoryToDisplay ( $params = '') {
		$categoryToDisplay = ( isset($_GET['categoryNumber']) && 
					           (int) $_GET['categoryNumber'] < maxCategoryIndex() && (int) $_GET['categoryNumber'] >= 0 ) 
					         ? (int) $_GET['categoryNumber'] 
					         : 0;
		return $categoryToDisplay;
}

// Find the categoryIndex and categoryName we are looking for
function getCategory( $query) {
	global $categoryArray;
	$previousCategoryId = $categoryArray[$query];
	$previousCategoryName = ucwords(str_replace("_", " ", $previousCategoryId));
	return array($previousCategoryId, $previousCategoryName);
}

// Calculate the number of size options for an item
function getNumberSizes( $query) {
	
}

// Ability to give each category/section of the menu an index to make coding of navigation easier
function generateCategoryIndexes( $params = '' ) {
	global $menu; 
	$categoryArray = array();
	array_push($categoryArray,'menu');
    foreach($menu->children() as $category) {   
    	array_push($categoryArray,$category->getName());
	}   
	return $categoryArray;     
}


?>
