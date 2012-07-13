<!DOCTYPE html>
<html lang="en">

<head>
	<?php include('header-content.php'); ?>
</head>

<body>
<?php include('top-bar.php');
      include('content.php'); ?>
    <h1>Menu</h1>
    <br />
    <br />

    <?php
    
// Bounds checking is done in our controller
if($categoryToDisplay > 1) {
	list($previousCategoryId, $previousCategoryName) = getCategory($categoryToDisplay - 1);
	echo "Previous Category ID: $previousCategoryId<br />";
	echo "Previous Category Name: $previousCategoryName<br />";
}

list($currentCategoryId, $currentCategoryName) = getCategory($categoryToDisplay);
echo "Current Category ID: $currentCategoryId<br />";
echo "Current Category Name: $currentCategoryName<br />";

if($categoryToDisplay < maxCategoryIndex()) {
	list($nextCategoryId, $nextCategoryName) = getCategory($categoryToDisplay+1);
	echo "Next Category ID: $nextCategoryId<br />";
	echo "Next Category Name: $nextCategoryName<br />";
}
?>
	</body>
</html>

