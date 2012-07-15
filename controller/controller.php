<?php
// Start session tracking
session_start();

// Prepare data and make functions available
include(M . "model.php");

// import menu into simpleXML object
$menu = initMenu();

// Create an array of categories
$categoryArray = generateCategoryIndexes();

// renderNav variable which will hold the HTML to be used for the navigation pane
$renderNav='';
// renderMenu variable which will hold the HTML to be used for the menu page
$renderMenu = '';

// Some code snippets/concepts below from Simple PHP Shopping Cart Tutorial
// http://jameshamilton.eu/content/simple-php-shopping-cart-tutorial

// Check if we have any actions to take care of
if(isset($_GET['action'])) {

	// Copy $_GET['itemId'] into variable
	if(isset($_GET['itemId'])) { 
		$itemId = $_GET['itemId']; //the product id from the URL
	} 
	
	// Find out what needs to be done, add items, clear cart (logout), view cart 
	$action = $_GET['action']; //the action from the URL 
    switch($action) { 
    
    	// check to make sure its a valid itemId, then increment if it exists, or add it as qty 1
        case "add":
        	if(checkItemId($itemId)) {
        		if(isset($_SESSION['cart'][$itemId])) {
            		$_SESSION['cart'][$itemId]++;
            			} else {
	            	$_SESSION['cart'][$itemId] = 1;
	            }
	        }
        break;
       
       // check that all updates are valid itemId's, first they should already be set, second valid itemId's
       // and last check the qty so that we can only enter positive values
        case "update":
            foreach ( $_GET as $itemId => $value ) {
            	if(isset($_SESSION['cart'][$itemId]) && ($value >= 0)) {
            		if(checkItemId($itemId)) {
	            		$_SESSION['cart'][$itemId]=$value;
	            	} 
	            } 
	        }
        break;
        
        // remove the item, could check for valid itemId but not necessary
        case "remove":
        	unset($_SESSION['cart'][$itemId]);
        	
        	// If we removed the last item in the cart, clear cart so count show correctly
        	if(count($_SESSION['cart']) == 0) {
        	    unset($_SESSION['cart']);
        	    header( 'Location: index.php' );
        	}
        break;
    
        // destroy session as shown in section, load up the main page when done
        case "logout":
   			session_destroy();
   			header( 'Location: index.php' );
        break;    
    }
    
    // if we have $_GET['action'] then we are messing with the Shopping Cart
	$pageTitle = "Shopping Cart";
	$renderMenu = displayItemsInCart();

} else {
	// Figure out where what part of the menu we should be displaying
	$categoryToDisplay = getCategoryToDisplay();

	// Setup the navigation array based on where we are at
	setNavigation($categoryToDisplay);

    // If we are on the Main page nav controls are not present, display main cateogories to choose from
    // dynamically build those from the element names, but prettify them since XML has strict rules about
    // element names
    if($categoryToDisplay == 0) {
        buildMainPage();
    // Display Menu Page, with items, descriptions, prices
    } else {
    	buildNavigation();
    	buildMenuPage();
    }
    // Add a shopping cart button, also displaying number of items in our Cart
    $renderMenu .= renderCartButton();
}

// render view
include(V . "view.php");

?>
