<?php

// Prepare data and make functions available
include(M . "model.php");

// renderNav variable which will hold the HTML to be used for the navigation pane
$renderNav='';
// renderMenu variable which will hold the HTML to be used for the menu page
$renderMenu = '';

	// Figure out where what part of the menu we should be displaying
	$categoryToDisplay = getCategoryToDisplay();


if(isset($_GET['action'])) {
	$pageTitle = "Shopping Cart";
	$renderMenu = "<h1>CART</h1>";
} else {

	// Setup the navigation buttons based on where we are at
	setNavigation($categoryToDisplay);

    // If we are on the Main page nav controls are not present, display main cateogories to choose from
    // dynamically build those from the element names, but prettify them since XML has strict rules about
    // element names
    if($categoryToDisplay == 0) {
    	$pageTitle = $navigation['currentCategoryName'];
    	for ($i = 1; $i <= maxCategoryIndex(); $i++) {
        	$renderMenu .= "<ul class=\"unstyled\"><a href=\"index.php?categoryNumber=$i\"><h3>" . 
        	ucwords(str_replace("_", " ", $categoryArray[$i]))  . '</h3></a></ul>';	
    	}
    } else {
    	$pageTitle = $navigation['currentCategoryName'];
    	
    	// Show a previous button if we are not on the first page of the menu
    	if($categoryToDisplay > 1) {
    		$renderNav = "<li class=\"previous\"><a href=\"index.php?categoryNumber=" . 
    		($categoryToDisplay - 1) . "\">&larr; $navigation[previousCategoryName]</a></li>";
    	}
    	
    	// Always show a nav button to access the Main Menu, unless we are on the Main Menu already
    	if($categoryToDisplay != 0) {
    		$renderNav .= "<li><a href=\"index.php\">Main Menu</a></li>";
    	
    	}
    	
    	// Show a next button if we are not on the last page of the menu
    	if($categoryToDisplay < maxCategoryIndex() &&
    		$categoryToDisplay > 0) {
    		$renderNav .= "<li class=\"next\"><a href=\"index.php?categoryNumber=" . 
    		($categoryToDisplay + 1) . "\">{$navigation['nextCategoryName']} &rarr;</a></li>";
    	}
    
        // get a simpleXML object using xpath and looking for the $navigation['currentCategoryId']
    	$categoryItemList = $menu->xpath("/menu/{$navigation['currentCategoryId']}/*");
    	
    	// list out all items in the category with their optional descriptions
    	while(list( , $item) = each($categoryItemList)) {
    	    $renderMenu .= "<span style=\"color: #FF0000\";><strong>" . $item->name . "</strong></span>";
        	$renderMenu .= "<em>" . $item->description . "</em>";
    
        	// List all price options for an item
        	$renderMenu .= "<span class=\"pull-right\";>";
        	foreach($item->price->children() as $itemSize => $itemPrice ) {
        	    $itemId = $itemPrice['id'];
        		$renderMenu .= "<a class=\"btn btn-mini\" href=\"index.php?action=add&itemId=$itemId\"><i class=\"icon-plus\"></i> 
        						<strong>Add</strong></a>"
        					. $itemSize . "&nbsp;&nbsp;" . $itemPrice;
        	}
        	$renderMenu .=	"</span><br /><br />";
        }
        $renderMenu .= "<br />";
        $renderMenu .= renderCart();
    }
}

// render view
include(V . "view.php");

?>
