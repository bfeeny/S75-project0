<?php
	
// Code snippet from the PHP manual http://www.php.net/manual/en/function.simplexml-load-file.php
// Look for the existence of our xml data and suck it into $menu, if it's not there fail
if (file_exists(PROJECT0 . 'xml/menu.xml')) {
    $menu = simplexml_load_file(PROJECT0 . 'xml/menu.xml');
} else {
    exit('Failed to open menu.xml.');
}

$categoryArray = generateCategoryIndexes();

// Current number of categories so we know when we are at the end of the menu
function maxCategoryIndex( $params = '' ) {
	global $categoryArray; 
	return count($categoryArray)-1;
}

// Find previous category in the menu
function getCategoryPrevious( $query) {
	global $categoryArray;
	return $categoryArray[$query-1];
}

// Find current category in the menu
function getCategoryCurrent( $query) {
	global $categoryArray;
	return $categoryArray[$query];
}

// Find the next category in the menu
function getCategoryNext( $query) {
	global $categoryArray;
	return $categoryArray[$query+1];
}

// Calculate the number of size options for an item
function getNumberSizes( $query) {
	
}

// Ability to give each category/section of the menu an index to make coding of navigation easier
function generateCategoryIndexes( $params = '' ) {
	global $menu; 
	$categoryArray = array();
    foreach($menu->children() as $category) {   
    	array_push($categoryArray,$category->getName());
	}   
	return $categoryArray;     
}


?>
