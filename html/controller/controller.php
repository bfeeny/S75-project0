<?php
    
// setup similar to Peter's section notes
include(M . "model.php");
include(V . "view.php");

// Figure out where what part of the menu we should be displaying
// based on Peter Myer Nore's section notes 
$categoryToDisplay = 
(isset($_GET['categoryNumber'])) 
? (int)$_GET['categoryNumber'] 
: 1;
    
echo "<br />";

if($categoryToDisplay > 0) {
	echo 'Previous Category:' . getCategoryPrevious($categoryToDisplay) . '<br />';
}

echo 'Current Category:' . getCategoryCurrent($categoryToDisplay) . '<br />';

if($categoryToDisplay < maxCategoryIndex()) {
	echo 'Next Category:' . getCategoryNext($categoryToDisplay) . '<br />';
}



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
  	echo '<pre>';
  	print_r($menu);
  	echo '</pre>';
  	
//  	$current = 'pizzas';

//  	foreach($menu->$current->item as $item) {
//  		echo $item->name . '    ' . $item->price->count() . '     ' . count($item->price->children()) . '<br />';
 // 	}
?>

</body>

</html>