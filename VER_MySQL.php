<!DOCTYPE>
<html>
    <head>
    </head>

    <body>
        <?php
$servername = "localhost";
$username = "root";
$dbname = "verrukkulluk";

// Create connection
$conn = new mysqli($servername, $username, $dbname);

// Check connection
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

// create tables
// table: gerecht_info
$sql = "CREATE TABLE gerecht_info (
    gerecht_info_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    record_type VARCHAR(30) NOT NULL,
    gerecht_id VARCHAR(30) NOT NULL,
    user_id VARCHAR(30),
    datum TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    nummeriekveld INT(6),
    tekstveld VARCHAR(200),
    PRIMARY KEY(gerecht_info_id),
    FOREIGN KEY(gerecht_id) REFERENCES gerecht(gerecht_id),
    )";
    
    if ($conn->query($sql) === TRUE) {
      echo "Table gerecht_info created successfully";
    } else {
      echo "Error creating table: " . $conn->error;
    }

// table: gerecht
$sql = "CREATE TABLE gerecht (
    gerecht_id INT(6),
    keuken_id INT(6) NOT NULL,
    type_id INT(6) NOT NULL,
    user_id INT(6) NOT NULL,
    datum_toegevoegd TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    titel VARCHAR(30) NOT NULL,
    korte_omschrijving VARCHAR(200) NOT NULL,
    lange_omschrijving VARCHAR(400) NOT NULL,
    PRIMARY KEY(gerecht_id),
    FOREIGN KEY(keuken_id) REFERENCES type_keuken(type_keuken_id),
    FOREIGN KEY(type_id) REFERENCES type_keuken(type_keuken_id),
    FOREIGN KEY(user_id) REFERENCES user(user_id)
    )";
    
    if ($conn->query($sql) === TRUE) {
      echo "Table gerecht created successfully";
    } else {
      echo "Error creating table: " . $conn->error;
    }

// table: type_keuken
$sql = "CREATE TABLE type_keuken (
    type_keuken_id INT(6) NOT NULL,
    record_type VARCHAR(30) NOT NULL,
    omschrijving VARCHAR(30) NOT NULL,
    PRIMARY KEY(type_keuken_id)
    )";
    
    if ($conn->query($sql) === TRUE) {
      echo "Table type_keuken created successfully";
    } else {
      echo "Error creating table: " . $conn->error;
    }


// table: user
$sql = "CREATE TABLE gerecht (
    user_id INT(6) NOT NULL,
    user_name VARCHAR(30) NOT NULL,
    user_password VARCHAR(30) NOT NULL,
    email VARCHAR(30) NOT NULL,
    afbeelding VARCHAR(200),
    PRIMARY KEY(user_id)
    )";
    
    if ($conn->query($sql) === TRUE) {
      echo "Table gerecht created successfully";
    } else {
      echo "Error creating table: " . $conn->error;
    }

// table: ingredient
$sql = "CREATE TABLE ingredient (
    ingredient_id INT(6) NOT NULL,
    gerecht_id INT(6) NOT NULL,
    artikel_id INT(6) NOT NULL,
    aantal INT(6) NOT NULL,
    PRIMARY KEY(ingredient_id),
    FOREIGN KEY(gerecht_id) REFERENCES gerecht(gerecht_id),
    FOREIGN KEY(artikel_id) REFERENCES artikel(artikel_id)    
    )";
    
    if ($conn->query($sql) === TRUE) {
      echo "Table gerecht created successfully";
    } else {
      echo "Error creating table: " . $conn->error;
    }

// table: artikel
$sql = "CREATE TABLE gerecht (
    artikel_id INT(6) NOT NULL,
    naam VARCHAR(30) NOT NULL,
    omschrijving VARCHAR(200) NOT NULL,
    prijs INT(6) NOT NULL,
    eenheid INT(6) NOT NULL,
    verpakking INT(6) NOT NULL,
    PRIMARY KEY(artikel_id)
    )";
    
    if ($conn->query($sql) === TRUE) {
      echo "Table gerecht created successfully";
    } else {
      echo "Error creating table: " . $conn->error;
    }





// insert data

// table: gerecht_info
    //Bereidingswijze
$sql = "INSERT INTO gerecht_info (gerecht_info_id, record_type, gerecht_id, user_id, datum, nummeriekveld, tekstveld)
VALUES (1, B, 2, 1, 04-03-2023, 1, 'Olie op laag vuur.')";

$sql = "INSERT INTO gerecht_info (gerecht_info_id, record_type, gerecht_id, user_id, datum, nummeriekveld, tekstveld)
VALUES (2, B, 2, 1, 04-03-2023, 1, 'Braad het vlees.')";

$sql = "INSERT INTO gerecht_info (gerecht_info_id, record_type, gerecht_id, user_id, datum, nummeriekveld, tekstveld)
VALUES (3, B, 2, 1, 04-03-2023, 1, 'Snij de avocado.')";

$sql = "INSERT INTO gerecht_info (gerecht_info_id, record_type, gerecht_id, user_id, datum, nummeriekveld, tekstveld)
VALUES (4, B, 2, 1, 04-03-2023, 1, 'Beleg het broodje.')";

$sql = "INSERT INTO gerecht_info (gerecht_info_id, record_type, gerecht_id, user_id, datum, nummeriekveld, tekstveld)
VALUES (5, B, 2, 1, 04-03-2023, 1, 'Maak het af met saus.')";

    // Opmerkingen
$sql = "INSERT INTO gerecht_info (gerecht_info_id, record_type, gerecht_id, user_id, datum, tekstveld)
VALUES (6, O, 2, 1, 06-03-2023, 'Niet lekker.')";

$sql = "INSERT INTO gerecht_info (gerecht_info_id, record_type, gerecht_id, user_id, datum, tekstveld)
VALUES (7, O, 2, 2, 06-03-2023, 'Heel erg lekker!')";

$sql = "INSERT INTO gerecht_info (gerecht_info_id, record_type, gerecht_id, user_id, datum, tekstveld)
VALUES (8, O, 2, 3, 11-03-2023, 'Ging wel.')";

$sql = "INSERT INTO gerecht_info (gerecht_info_id, record_type, gerecht_id, user_id, datum, tekstveld)
VALUES (9, O, 2, 4, 15-03-2023, 'Best lekker!')";

    // Waardering
$sql = "INSERT INTO gerecht_info (gerecht_info_id, record_type, gerecht_id, user_id, datum, numeriekveld)
VALUES (10, W, 2, 2, 06-03-2023, 5)";

$sql = "INSERT INTO gerecht_info (gerecht_info_id, record_type, gerecht_id, user_id, datum, numeriekveld)
VALUES (11, W, 2, 3, 11-03-2023, 2)";

$sql = "INSERT INTO gerecht_info (gerecht_info_id, record_type, gerecht_id, user_id, datum, numeriekveld)
VALUES (12, W, 2, 4, 15-03-2023, 3)";

    // Favoriet
$sql = "INSERT INTO gerecht_info (gerecht_info_id, record_type, gerecht_id, user_id)    
VALUES (13, F, 2, 2)";

$sql = "INSERT INTO gerecht_info (gerecht_info_id, record_type, gerecht_id, user_id)    
VALUES (14, F, 2, 4)";


// Table: gerecht 
$sql = "INSERT INTO gerecht (gerecht_id, keuken_id, type_id, datum_toegevoegd, titel, korte_omschrijving, lange_omschrijving)
VALUES (1, 1, 4, 1, 02-03-2023, 'Eggs & Vegies', 'Ei met groente.', 'Heel lekker gerecht met ei en veel groente.')";

$sql = "INSERT INTO gerecht (gerecht_id, keuken_id, type_id, datum_toegevoegd, titel, korte_omschrijving, lange_omschrijving)
VALUES (2, 1, 4, 1, 04-03-2023, 'Vega Burger', 'Vegatarische hamburger.', 'Recept voor hamburger met vegatarisch vlees.')";

$sql = "INSERT INTO gerecht (gerecht_id, keuken_id, type_id, datum_toegevoegd, titel, korte_omschrijving, lange_omschrijving)
VALUES (3, 2, 6, 1, 12-03-2023, 'Sushi Rolls', 'Rolletjes sushi.', 'Sushi met vis en rijst in een rol gedraaid.')";

$sql = "INSERT INTO gerecht (gerecht_id, keuken_id, type_id, datum_toegevoegd, titel, korte_omschrijving, lange_omschrijving)
VALUES (4, 3, 4, 1, 16-03-2023, 'Pizza Green', 'Vega pizza.', 'Echte Italiaanse pizza, maar dan zonder vlees.')";

// Table: type_keuken
$sql = "INSERT INTO type_keuken (type_keuken_id, record_type, omschrijving)
VALUES (1, K, 'Amerikaans')";

$sql = "INSERT INTO type_keuken (type_keuken_id, record_type, omschrijving)
VALUES (2, K, 'Japans')";

$sql = "INSERT INTO type_keuken (type_keuken_id, record_type, omschrijving)
VALUES (3, K, 'Italiaans')";

$sql = "INSERT INTO type_keuken (type_keuken_id, record_type, omschrijving)
VALUES (4, T, 'Vegatarisch')";

$sql = "INSERT INTO type_keuken (type_keuken_id, record_type, omschrijving)
VALUES (5, T, 'Vlees')";

$sql = "INSERT INTO type_keuken (type_keuken_id, record_type, omschrijving)
VALUES (6, T, 'Vis')";

// Table: user
$sql = "INSERT INTO user (user_id, user_name, user_password, email, afbeelding)
VALUES (1, 'Tommie', 'WWtom', 't@gmail.com', 'https://')";

$sql = "INSERT INTO user (user_id, user_name, user_password, email, afbeelding)
VALUES (2, 'Bennie', 'WWben', 'b@gmail.com', 'https://')";

$sql = "INSERT INTO user (user_id, user_name, user_password, email, afbeelding)
VALUES (3, 'Sammy', 'WWsam', 's@gmail.com', 'https://')";

$sql = "INSERT INTO user (user_id, user_name, user_password, email, afbeelding)
VALUES (4, 'Katinka', 'WWkat', 'k@gmail.com', 'https://')";

// table: ingredient
$sql = "INSERT INTO ingredient (ingredient_id, gerecht_id, artikel_id, aantal)
VALUES (1, 2, 1, 4)";

$sql = "INSERT INTO ingredient (ingredient_id, gerecht_id, artikel_id, aantal)
VALUES (2, 2, 2, 350)";

$sql = "INSERT INTO ingredient (ingredient_id, gerecht_id, artikel_id, aantal)
VALUES (3, 2, 3, 30)";

$sql = "INSERT INTO ingredient (ingredient_id, gerecht_id, artikel_id, aantal)
VALUES (1, 2, 4, 2)";

// table: artikel
$sql = "INSERT INTO artikel (artikel_id, naam, omschrijving, prijs, eenheid, verpakking)
VALUES (1, 'Broodje', 'Broodje voor hamburgers', 6.50, 'stuks', 6)";

$sql = "INSERT INTO artikel (artikel_id, naam, omschrijving, prijs, eenheid, verpakking)
VALUES (2, 'Vega Burger', 'Vegatarische hamburgers', 6.50, 'gr', 350)";

$sql = "INSERT INTO artikel (artikel_id, naam, omschrijving, prijs, eenheid, verpakking)
VALUES (3, 'Saus', 'Saus voor op de hamburger', 6.50, 'stuks', 300)";

$sql = "INSERT INTO artikel (artikel_id, naam, omschrijving, prijs, eenheid, verpakking)
VALUES (4, 'Avocado', 'Tropische groente', 6.50, 'stuks', 1)";


if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}
          
          $conn = null;

?>

</body>
</html>
