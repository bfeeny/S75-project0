<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Three Aces Pizza</title>
</head>

<body>
    <?php
    // Code snippet from the PHP manual http://www.php.net/manual/en/function.simplexml-load-file.php

    if (file_exists(PROJECT0 . 'xml/menu.xml')) {
    	$menu = simplexml_load_file(PROJECT0 . 'xml/menu.xml');
    } else {
    	exit('Failed to open menu.xml.');
    }

    echo "<br />";

    foreach($menu->children() as $category)
    {
  		echo $category->getName() . '<br />';
  	}

  	$current = 'pizzas';

  	foreach($menu->$current->item as $item) {
  		echo $item->name . '     ' . $item->price->count() . '<br />';
  	}
?>

</body>

</html>