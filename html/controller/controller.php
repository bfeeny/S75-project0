<?php

// Prepare data and make functions available
include(M . "model.php");

// Figure out where what part of the menu we should be displaying
// based on Peter Myer Nore's section notes 
$categoryToDisplay = getCategoryToDisplay();

// Prepare the current and if applicable previous and next navigation elements
list($currentCategoryId, $currentCategoryName) = getCategory($categoryToDisplay);

if($categoryToDisplay > 1) {
	list($previousCategoryId, $previousCategoryName) = getCategory($categoryToDisplay - 1);
}

if($categoryToDisplay < maxCategoryIndex()) {
	list($nextCategoryId, $nextCategoryName) = getCategory($categoryToDisplay+1);
}

// renderNav variable which will hold the HTML to be used for the navigation pane
$renderNav='';
// renderMenu variable which will hold the HTML to be used for the menu page
$renderMenu = '';

// If we are on the Main page nav controls are not present
if($categoryToDisplay == 0) {
	for ($i = 1; $i <= maxCategoryIndex(); $i++) {
    	$renderMenu .= "<ul class=\"unstyled\"><a href=\"index.php?categoryNumber=$i\"><h3>" . 
    	ucwords(str_replace("_", " ", $categoryArray[$i]))  . '</h3></a></ul>';	
	}
} else {
	$result = $menu->xpath("/menu/$currentCategoryId/*");

	while(list( , $node) = each($result)) {
    	$renderMenu .= "<span style=\"color: #FF0000\";><strong>" . $node->name . "</span></strong>";
    	$renderMenu .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em>" . $node->description . "</em>";
    	$renderMenu .= "<span class=\"pull-right\";>
    					<a class=\"btn btn-mini\" href=\"\"><i class=\"icon-plus\"></i> <strong>Add</strong></a>
    					small&nbsp;&nbsp;" . $node->price->small . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    	$renderMenu .= "<a class=\"btn btn-mini\" href=\"\"><i class=\"icon-plus\"></i> <strong>Add</strong></a>
    					large&nbsp;&nbsp;" . $node->price->large . "</span><br />";
    	$renderMenu .= "<br />";
    }
    
    $renderMenu .= renderCart();


	// Show a previous button if we are not on the first page of the menu
	if($categoryToDisplay > 1) {
		$renderNav = "<li class=\"previous\"><a href=\"index.php?categoryNumber=" . 
		($categoryToDisplay - 1) . "\">&larr; $previousCategoryName</a></li>";
	}
	
	// Always show a nav button to access the Main Menu, unless we are on the Main Menu already
	if($categoryToDisplay != 0) {
		$renderNav .= "<li><a href=\"index.php\">Main Menu</a></li>";
	
	}
	
	// Show a next button if we are not on the last page of the menu
	if($categoryToDisplay < maxCategoryIndex() &&
		$categoryToDisplay > 0) {
		$renderNav .= "<li class=\"next\"><a href=\"index.php?categoryNumber=" . 
		($categoryToDisplay + 1) . "\">$nextCategoryName &rarr;</a></li>";
	}
}


// render view
include(V . "view.php");


// foreach ($menu as $category) {
//     printf("%s has got %d children.<br />", $category->getName(), $category->count());
// }

// foreach($menu->children() as $category)
// {
// 		echo ucfirst($category->getName()) . '<br /><ul>';
// 		foreach($category->children() as $item) {
//   		echo '<li>' . $item->name	.'</li>';
//   		foreach($item->price->children() as $price) {
// 	  		 echo $price->getName() . '&nbsp;&nbsp;&nbsp;&nbsp;' . $price . '<br />';
//   		}
//   	}
//   	echo ('</ul>');
// 	}
// 	
// 	$result = $menu->xpath('/menu/pizzas/item/name');
// 
// while(list( , $node) = each($result)) {
//     echo $node,"<br />";
//      $result2 = $menu->xpath('/menu/pizzas/item/name');
// 
//     while(list( , $node2) = each($result2)) {
//     	echo $node2,"<br />";
//     }
// 
// }
//  	echo '<pre>';
//  	print_r($menu);
//  	echo '</pre>';
  	
//  	$current = 'pizzas';

//  	foreach($menu->$current->item as $item) {
//  		echo $item->name . '    ' . $item->price->count() . '     ' . count($item->price->children()) . '<br />';
 // 	}
?>
