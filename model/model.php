<?php

function initMenu() {		
    // Code snippet from the PHP manual http://www.php.net/manual/en/function.simplexml-load-file.php
    // Look for the existence of our xml data and suck it into $menu, if it's not there fail
    if (file_exists(PROJECT0 . 'xml/menu.xml')) {
        $menu = simplexml_load_file(PROJECT0 . 'xml/menu.xml');
        return $menu;
    } else {
        exit('Failed to open menu.xml.');
    }
}

// Current number of categories so we know when we are at the end of the menu
function maxCategoryIndex() {
	global $categoryArray; 
	return count($categoryArray)-1;
}

// Determine what part of the menu we should be displaying, input check request
function getCategoryToDisplay () {
		$categoryToDisplay = ( isset($_GET['categoryNumber']) && 
					           (int) $_GET['categoryNumber'] <= maxCategoryIndex() && (int) $_GET['categoryNumber'] >= 0 ) 
					         ? (int) $_GET['categoryNumber'] 
					         : 0;
		return $categoryToDisplay;
}

// Find the categoryId and categoryName we are looking for
function getCategory( $query) {
	global $categoryArray;
	$CategoryId = $categoryArray[$query];
	$CategoryName = ucwords(str_replace("_", " ", $CategoryId));
	return array($CategoryId, $CategoryName);
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

// Parts of shopping cart concepts taken from "Simple PHP Shopping Cart Tutorial" 
// http://jameshamilton.eu/content/simple-php-shopping-cart-tutorial

// Check if we have a cart, if so, total the number of items, if there is no cart return 0
function getCartCount() {
	$cartCount = 0;
	
	if(isset($_SESSION['cart'])) {
		foreach($_SESSION['cart'] as $itemId => $quantity) { 
		 	$cartCount+= $quantity;
		 }
	} else {
			$cartCount = 0;
	}
	return $cartCount;
}

// Draw a cart button for use on the Main Page and Menu Pages.  Also show number of items in Cart
function renderCartButton( $params = '') {
	  $cartCount = getCartCount();
      $renderCartButton = 
      "<div class=\"row\">
	      	<div class=\"span2 offset10\">
	      		<a class=\"btn btn-primary\" href=\"index.php?action=viewCart\"><i class=\"icon-shopping-cart icon-white\"></i> View Cart</a><br />"
	      		. $cartCount . " Items in Cart
	      	</div>
	   </div>";
	      			 
	 return $renderCartButton;
}

// Show items in cart and their quantities
function displayItemsInCart() {
	$renderCart = '';
	if(isset($_SESSION['cart'])) {
		$renderCart .= "<form action=\"index.php\" method=\"GET\">";
		$renderCart .= "<input type=\"hidden\" name=\"action\" value=\"update\" />";
	 	foreach($_SESSION['cart'] as $itemId => $quantity) { 
			$renderCart .= "<span style=\"color: #FF0000\";><strong>Product: $itemId</strong></span>";
			$renderCart .= "<span class=\"pull-right\";>Quantity&nbsp;&nbsp;";
			$renderCart .= "<input type=\"text\" name=$itemId size=\"3\" maxlength=\"3\" value=\"$quantity\" />";
			$renderCart .= "&nbsp;&nbsp;";
			$renderCart .= "<a class=\"btn btn-mini btn-danger\" href=\"index.php?action=remove&itemId=$itemId\"><i class=\"icon-remove\"></i> 
    						Remove</a>";
    		$renderCart .= "&nbsp;&nbsp;";
    		$renderCart .= "<button type=\"submit\" class=\"btn btn-mini btn-info\"><i class=\"icon-edit\"></i>Update</button>";
    		$renderCart .= "</span><br /><br />";
    	}
		$renderCart .= "<form class=\"well\">";
	} else {
		$renderCart = "You have no items in your cart.<br />";
	}
	$renderCart .= "<br /><br /><br /><br />";
	$renderCart .=  
      "<div class=\"row\">
	      	<div class=\"span4 offset8\">
	      		<a class=\"btn btn-primary\" href=\"index.php\"><i class=\"icon-shopping-cart icon-white\"></i> Continue Shopping</a>
	      		<a class=\"btn btn-success\" href=\"index.php?action=checkout\"><i class=\"icon-ok icon-white\"></i> Checkout</a><br /><br />
	      		<a class=\"btn btn-danger\" href=\"index.php?action=logout\"><i class=\"icon-trash icon-white\"></i> Clear Cart</a>

	      	</div>
	   </div>";
	      			 
	 return $renderCart;	
}

// Sets navigation array to be used in cycling through menu
function setNavigation( $categoryToDisplay ) {

	// Prepare the current and if applicable previous and next navigation elements
  	global $navigation;
  	  	
	$navigation = array( 
        'currentCategoryId'  => '' , 'currentCategoryName' => ''
      , 'previousCategoryId' => '' , 'previousCategoryName' => ''   
      , 'nextCategoryId' 	 => '' , 'nextCategoryName' => ''
      );
  
	// Prepare the current and if applicable previous and next navigation elements
    list($navigation['currentCategoryId'], $navigation['currentCategoryName']) = getCategory($categoryToDisplay);

    if($categoryToDisplay > 1) {
    	list($navigation['previousCategoryId'], $navigation['previousCategoryName']) = getCategory($categoryToDisplay- 1);
    }
    
    if($categoryToDisplay < maxCategoryIndex()) {
    	list($navigation['nextCategoryId'], $navigation['nextCategoryName']) = getCategory($categoryToDisplay + 1);

    }
}

// Display the first level of all menu categories
function buildMainPage() {
	global $pageTitle;
	global $renderMenu;
	global $navigation;
	global $categoryArray;
	
	// Set page title to reflect the name of the Main Page
	$pageTitle = $navigation['currentCategoryName'];
	
	// Generate list of categories
    for ($i = 1; $i <= maxCategoryIndex(); $i++) {
        $renderMenu .= "<ul class=\"unstyled\"><a href=\"index.php?categoryNumber=$i\"><h3>" . 
        ucwords(str_replace("_", " ", $categoryArray[$i]))  . '</h3></a></ul>';	
    }
}

// generate code that will display the proper navigation elements based on the page we are on
function buildNavigation() {
	global $pageTitle;
	global $renderNav;
	global $navigation;
	global $categoryToDisplay;
	
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

}

// Display a regular menu page, items, descriptions and prices
function buildMenuPage() {
	global $renderMenu;
	global $menu;
	global $navigation;
	
	// get a simpleXML object using xpath and looking for the $navigation['currentCategoryId']
    $categoryItemList = $menu->xpath("/menu/{$navigation['currentCategoryId']}/*");
    
    // list out all items in the category with their optional descriptions
    while(list( , $item) = each($categoryItemList)) {
        $renderMenu .= "<span style=\"color: #FF0000\";><strong>$item->name</strong></span>";
    	$renderMenu .= "<em>$item->description</em>";
    
    	// List all price options for an item
    	$renderMenu .= "<span class=\"pull-right\";>";
    	foreach($item->price->children() as $itemSize => $itemPrice ) {
    	    $itemId = $itemPrice['id'];
    		$renderMenu .= "<a class=\"btn btn-mini\" href=\"index.php?action=add&itemId=$itemId\"><i class=\"icon-plus\"></i> 
    						<strong>Add</strong></a>$itemSize&nbsp;&nbsp;$itemPrice";
    	}
    	$renderMenu .=	"</span><br /><br />";
    }
    $renderMenu .= "<br />";
}

// Check itemId's to make sure the are valid via xpath query, valid itemId's will be found at /menu//item/price/*[@id='$query']
// Used StyleStudio's xpath quick reference http://www.stylusstudio.com/docs/v62/d_xpath15.html
function checkItemId( $query ) {
	global $menu;
	
	if($result = $menu->xpath("/menu//item/price/*[@id='$query']")) {
		return TRUE;
	} else {
		return FALSE;
	}
}

?>
