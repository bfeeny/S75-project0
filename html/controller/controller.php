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


// render view
include(V . "view.php");

// foreach ($menu->children() as $category) {
//     echo $category->getName() . '<br />';
//     }

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
