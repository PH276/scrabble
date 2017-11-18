<?php
// mise à zéro du tirage
$req = $pdo -> query("UPDATE infos SET info='' WHERE info_type='tirage'");
$req -> execute();
