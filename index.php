<?php

require_once("lib/database.php");
require_once("lib/artikel.php");
require_once("lib/user.php");
require_once("lib/type_keuken.php");
require_once("lib/ingredient.php");
require_once("lib/

/// INIT
$db = new database();
$art = new artikel($db->getConnection());
$usr = new user($db->getConnection());
$tk = new type_keuken($db->getConnection());

/// VERWERK 
$data = $art->selecteerArtikel(8);
$data = $usr->selecteerUser(1);
$data = $tk-> selecteerTypeKeuken();


/// RETURN
var_dump($data);