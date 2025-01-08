<?php
// Determine the base URL based on the current domain
if ($_SERVER['HTTP_HOST'] === 'nayanfood.in') {
    $base = 'http://nayanfood.in/bakery/main';
} else {
    $base = 'http://localhost/bakery/main';
}

// You can now use the $base variable in your application
?>
