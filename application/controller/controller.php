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
if (isset($_GET['action'])) 
{

    // if we have $_GET['action'] then we are messing with the Shopping Cart
	$pageTitle = "Shopping Cart";
	
	// Copy $_GET['itemId'] into variable
	if (isset($_GET['itemId'])) 
	{ 
		$itemId = $_GET['itemId'];
	} 
	
	// Find out what needs to be done, add items, clear cart (logout), view cart, checkout
	$action = $_GET['action']; 
    switch ($action) 
    { 
    
    	// check to make sure its a valid itemId, then increment if it exists, or add it as qty 1
        case "add":
        	if (checkItemId($itemId)) 
        	{
        		if (isset($_SESSION['cart'][$itemId])) 
        		{
            		$_SESSION['cart'][$itemId]++;
            	} 
            	else 
            	{
	            	$_SESSION['cart'][$itemId] = 1;
	            }
	        }
	        $renderMenu = displayItemsInCart();
        break;
       
       // check that all updates are valid itemId's, first they should already be set, second valid itemId's
       // and last check the qty so that we can only enter positive values, could easily check for a max quantity
       // such as 99 but not implemented
        case "update":
            foreach ( $_GET as $itemId => $value ) 
            {
            	if (isset($_SESSION['cart'][$itemId]) && ($value >= 0)) 
            	{
            		if (checkItemId($itemId)) 
            		{
	            		$_SESSION['cart'][$itemId]=$value;
	            	} 
	            } 
	        }
	        $renderMenu = displayItemsInCart();
        break;
        
        // remove the item, could check for valid itemId but not necessary, then send them back to the main page
        case "remove":
        	unset($_SESSION['cart'][$itemId]);
        	
        	// If we removed the last item in the cart, clear cart so cartCount shows correctly
        	if (count($_SESSION['cart']) == 0) 
        	{
        	    unset($_SESSION['cart']);
        	    header( 'Location: ' . $_SERVER['PHP_SELF']);
        	}
        	$renderMenu = displayItemsInCart();
        break;
        
        case "viewCart":
        	$renderMenu = displayItemsInCart();
        break;
        
        // checkout displays a page to the user which thanks them and shows them the total they have been charged
        // and calls session_destroy(), make sure we have a $_SESSION['total'] otherwise redirect
        case "checkout":
        	if (isset($_SESSION['total'])) 
        	{
	            displayThankYou();
	            session_destroy();
        	}   
        	else 
        	{
	        	header( 'Location: ' . $_SERVER['PHP_SELF']);
        	}

        break;
    
        // destroy session as shown in section, load up the main page when done
        case "logout":
   			session_destroy();
   			header( 'Location: ' . $_SERVER['PHP_SELF']);
        break;    
    }
} 
else 
{
	// Check the category requested in $_GET['categoryNumber'], if its a valid value, use it, if not, or it doesn't exist
	// then lets start at the main page
	$categoryToDisplay = getCategoryToDisplay();

	// Setup the navigation array based on where we are at
	setNavigation($categoryToDisplay);

    // If we are on the Main page nav controls are not present, display main cateogories to choose from
    // dynamically build those from the element names, but prettify them since XML has strict rules about
    // element names
    if ($categoryToDisplay == 0) 
    {
        buildMainPage();
    // Display Menu Page, with items, descriptions, prices
    } 
    else 
    {
    	buildNavigation();
    	buildMenuPage();
    }
    
    // Add a shopping cart button, also displaying number of items in our Cart
    $renderMenu .= renderCartButton();
}

// render view
include(V . "view.php");

?>
