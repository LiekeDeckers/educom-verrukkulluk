<?php

require_once("lib/database.php");
require_once("lib/artikel.php");
require_once("lib/user.php");
require_once("lib/type_keuken.php");
require_once("lib/ingredient.php");
require_once("lib/gerecht_info.php");
require_once("lib/gerecht.php");

/// INIT
$db = new database();
$art = new artikel($db->getConnection());
$usr = new user($db->getConnection());
$tk = new type_keuken($db->getConnection());
$ing = new ingredient($db->getConnection());
$gerinfo = new gerecht_info($db->getConnection());
$ger = new gerecht($db->getConnection());

/// VERWERK 
$data_art = $art->selecteerArtikel(1);
$data_usr = $usr->selecteerUser(2);
$data_tk = $tk-> selecteerTypeKeuken(1);
$data_ing = $ing->selecteerIngredient(2);
$data_gerinfo = $gerinfo->selecteerGerechtInfo(2, 'F');
$data_ger = $ger->selecteerGerecht(2);


/// RETURN
echo '<pre>';
//var_dump($data_art);
//var_dump($data_usr);
//var_dump($data_tk);
//var_dump($data_ing);
var_dump($data_gerinfo);
//var_dump($data_ger);
