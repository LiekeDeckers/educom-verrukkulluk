<?php
//// Allereerst zorgen dat de "Autoloader" uit vendor opgenomen wordt:
require_once("./vendor/autoload.php");
require_once("lib/database.php");
require_once("lib/artikel.php");
require_once("lib/user.php");
require_once("lib/type_keuken.php");
require_once("lib/ingredient.php");
require_once("lib/gerecht_info.php");
require_once("lib/gerecht.php");
require_once("lib/boodschappen.php");

/// Twig koppelen:
$loader = new \Twig\Loader\FilesystemLoader("./templates");
/// VOOR PRODUCTIE:
/// $twig = new \Twig\Environment($loader), ["cache" => "./cache/cc"]);

/// VOOR DEVELOPMENT:
$twig = new \Twig\Environment($loader, ["debug" => true ]);
$twig->addExtension(new \Twig\Extension\DebugExtension());




/// RETURN
//var_dump($data_art);
//var_dump($data_usr);
//var_dump($data_tk);
//var_dump($data_ing);
//var_dump($data_gerinfo);
//var_dump($data_ger);
//var_dump($data_boo);

/******************************/

/// Next step, iets met je data doen. Ophalen of zo
$db = new database();
$gerecht = new gerecht($db->getConnection());
$boodschappen = new boodschappen($db->getConnection());




/*
URL:
http://localhost/index.php?gerecht_id=4&action=detail
*/

$gerecht_id = isset($_GET["gerecht_id"]) ? $_GET["gerecht_id"] : "";
$action = isset($_GET["action"]) ? $_GET["action"] : "homepage";
$aantal_nieuw = isset($_GET["aantal_nieuw"]) ? $_GET["aantal_nieuw"] : "";

$user_id = 1;


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

        case "toevoegenFavoriet": {
            if($dish->bepaalFavoriet($gerecht_id, $user_id) == false){
                $gerecht_info->toevoegenFavoriet($gerecht_id, $user_id);
            }
            else{
                $dish_info->verwijderenFavoriet($gerecht_id, $user_id);
            }
        break;
        }

        case "toevoegenWaardering" : {

        }

        case "boodschappenlijst": {
            $data = $boodschappen->selecteerBoodschappen($user_id);
            $template = 'boodschappenlijst.html.twig';
            $title = "boodschappenlijst";
            break;
        }

        case "toevoegenBoodschappen": {
            $data = $boodschappen->toevoegenBoodschappen($gerecht_id, $user_id);
            $template = "boodschappenlijst.html.twig";
            $title = "boodschappenlijst";
            break;
        }

        case "veranderAantal": {
            $boodschappen = veranderAantal($user_id, $artikel_id, $aantal_nieuw);
            $data = $boodschappen->selecteerBoodschappen($user_id);
            $template = "boodschappenlijst.html.twig";
            $title = "boodschappenlijst";
            break;
        }

        case "verwijderBoodschappen": {
            $boodschappen->verwijderBoodschappen($artikel_id, $user_id);
            $data = $boodschappen->selecteerBoodschappen($user_id);
            $template = "boodschappenlijst.html.twig";
            $title = "boodschappenlijst";
            break;
        }

        case "verwijderAlleBoodschappen": {
            $boodschappen->verwijderAlleBoodschappen($user_id);
            $data = $boodschappen->selecteerBoodschappen($user_id);
            $template = "boodschappenlijst.html.twig";
            $title = "boodschappenlijst";
            break;
        }

        case "zoeken": {
            $data = $zoeken->zoeken();
            $template = "homepage.html.twig";
            $title = "homepage";
            break;
        }


}


/// Onderstaande code schrijf je idealiter in een layout klasse of iets dergelijks
/// Juiste template laden, in dit geval "homepage"
$template = $twig->load($template);


/// En tonen die handel!
echo $template->render(["title" => $title, "data" => $data]);
