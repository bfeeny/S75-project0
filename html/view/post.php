<?php
echo "
<div class='well'>

Current Category: $currentCategoryName
<ul class=\"pager\">";

			 
if($categoryToDisplay > 1) {
	echo "
	<li class=\"previous\">
	<a href=\"index.php?categoryNumber=" . ($categoryToDisplay - 1) . "\">&larr; $previousCategoryName</a>
	</li>";
}


if($categoryToDisplay != 0) {
	echo "
	<li>
	<a href=\"index.php\">Main Menu</a>
	</li>";
}

if($categoryToDisplay < maxCategoryIndex() &&
   $categoryToDisplay > 0) {
	echo "
	<li class=\"next\">
	<a href=\"index.php?categoryNumber=" . ($categoryToDisplay + 1) . "\">$nextCategoryName &rarr;</a>
	</li>";
}
?> 
</ul>

				
</div><!--well-->