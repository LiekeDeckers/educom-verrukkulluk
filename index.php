<?php
//// Allereerst zorgen dat de "Autoloader" uit vendor opgenomen wordt:
require_once("./vendor/autoload.php");

/// Twig koppelen:
$loader = new \Twig\Loader\FilesystemLoader("./templates");
/// VOOR PRODUCTIE:
/// $twig = new \Twig\Environment($loader), ["cache" => "./cache/cc"]);

/// VOOR DEVELOPMENT:
$twig = new \Twig\Environment($loader, ["debug" => true ]);
$twig->addExtension(new \Twig\Extension\DebugExtension());


require_once("lib/database.php");
require_once("lib/artikel.php");
require_once("lib/user.php");
require_once("lib/type_keuken.php");
require_once("lib/ingredient.php");
require_once("lib/gerecht_info.php");
require_once("lib/gerecht.php");
require_once("lib/boodschappen.php");

/// INIT
$db = new database();
$art = new artikel($db->getConnection());
$usr = new user($db->getConnection());
$tk = new type_keuken($db->getConnection());
$ing = new ingredient($db->getConnection());
$gerinfo = new gerecht_info($db->getConnection());
$ger = new gerecht($db->getConnection());
$boo = new boodschappen($db->getConnection());

/// VERWERK 
$data_art = $art->selecteerArtikel(1);
$data_usr = $usr->selecteerUser(2);
$data_tk = $tk-> selecteerTypeKeuken(1);
$data_ing = $ing->selecteerIngredient(2);
$data_gerinfo = $gerinfo->selecteerGerechtInfo(2, 'W');
$data_ger = $ger->selecteerGerecht(2);
$data_boo = $boo->selecteerBoodschappen(1);

/// RETURN
echo '<pre>';
//var_dump($data_art);
//var_dump($data_usr);
//var_dump($data_tk);
//var_dump($data_ing);
//var_dump($data_gerinfo);
//var_dump($data_ger);
//var_dump($data_boo);

/******************************/

/// Next step, iets met je data doen. Ophalen of zo
require_once("lib/gerecht.php");
$gerecht = new gerecht();
$data_ger = $gerecht->selecteerGerecht();


/*
URL:
http://localhost/index.php?gerecht_id=4&action=detail
*/

$gerecht_id = isset($_GET["gerecht_id"]) ? $_GET["gerecht_id"] : "";
$action = isset($_GET["action"]) ? $_GET["action"] : "homepage";


switch($action) {

        case "homepage": {
            $data = $gerecht->selecteerGerecht();
            $template = 'homepage.html.twig';
            $title = "homepage";
            break;
        }

        case "detail": {
            $data = $gerecht->selecteerGerecht($gerecht_id);
            $template = 'detail.html.twig';
            $title = "detail pagina";
            break;
        }

        /// etc

}


/// Onderstaande code schrijf je idealiter in een layout klasse of iets dergelijks
/// Juiste template laden, in dit geval "homepage"
$template = $twig->load($template);


/// En tonen die handel!
echo $template->render(["title" => $title, "data" => $data]);
