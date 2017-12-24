<?php
session_start();
// echo '<pre>';
// print_r ($_SESSION);
// echo '</pre>';
session_destroy();
// echo '<pre>';
// print_r ($_SESSION);
// echo '</pre>';


header('location: newPartie.php');
