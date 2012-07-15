<?php

// Organized the same as Peter Myer Nore did in section
define('PROJECT0', '/home/jharvard/vhosts/project0/');
define('APP', PROJECT0 . 'application/');
define('M',   APP      . 'model/');
define('V',   APP      . 'view/');
define('C',   APP      . 'controller/');

// start controller
require(C . "controller.php");
?>