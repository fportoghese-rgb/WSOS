<?php

$conn = new mysqli("localhost", "root", "Batman@01","cinema",3307 );

// Controllo connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

$action = $_REQUEST["action"] ?? "";

if ($_SERVER["REQUEST_METHOD"] === "GET") {

    // LEGGI TUTTI I FILM
    if ($action === "read") {
        $query = "SELECT * FROM film";
        $stm = $conn->prepare($query);
        $stm->execute();
        $res = $stm->get_result();

        while ($row = $res->fetch_assoc()) {
            $titolo = htmlspecialchars($row["titolo"]);
            $anno = htmlspecialchars($row["anno"]);
            $paese = htmlspecialchars($row["paese"]);
            $regista = htmlspecialchars($row["regista"]);

            echo "<p><a href='/Films.php?action=form&titolo=$titolo&anno=$anno&paese=$paese&regista=$regista'>"
                . "$titolo - $anno - $paese - $regista</a></p>";
        }
    }

    // FORM DI MODIFICA/INSERIMENTO
    if ($action === "form") {
        $titolo = $_GET["titolo"] ?? "";
        $anno = $_GET["anno"] ?? "";
        $paese = $_GET["paese"] ?? "";
        $regista = $_GET["regista"] ?? "";

        echo "<form action='/Films.php' method='POST'>";
        echo "<label>Titolo</label><input type='text' name='titolo' value='$titolo'><br>";
        echo "<label>Anno</label><input type='text' name='anno' value='$anno'><br>";
        echo "<label>Paese</label><input type='text' name='paese' value='$paese'><br>";
        echo "<label>Regista</label><input type='text' name='regista' value='$regista'><br>";
        echo "<input type='submit' name='action' value='inserisci'>";
        echo "<input type='submit' name='action' value='aggiorna'>";
        echo "<input type='submit' name='action' value='delete'>";
        echo "</form>";
    }

}


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // ELIMINA FILM
    if ($action === "delete") {
        $titolo = $_POST["titolo"];
        $query = "DELETE FROM film WHERE titolo=?";
        $stm = $conn->prepare($query);
        $stm->bind_param("s", $titolo);
        $stm->execute();
        echo "Titolo eliminato con successo!";
    }

    // AGGIORNA FILM
    if ($action === "aggiorna") {
        $titolo = $_POST["titolo"];
        $anno = $_POST["anno"];
        $paese = $_POST["paese"];
        $regista = $_POST["regista"];

        $query = "UPDATE film SET anno=?, paese=?, regista=? WHERE titolo=?";
        $stm = $conn->prepare($query);
      
        $stm->bind_param("ssss", $anno, $paese, $regista, $titolo);
        $stm->execute();
        echo "Titolo aggiornato con successo!";
    }

    // INSERISCI NUOVO FILM
    if ($action === "inserisci") {
        $titolo = $_POST["titolo"];
        $anno = $_POST["anno"];
        $paese = $_POST["paese"];
        $regista = $_POST["regista"];

        $query = "INSERT INTO film (titolo, anno, paese, regista) VALUES (?, ?, ?, ?)";
        $stm = $conn->prepare($query);
    
        $stm->bind_param("ssss", $titolo, $anno, $paese, $regista);
        $stm->execute();
        echo "Record inserito con successo!";
    }
}

// Chiudi connessione
$conn->close();
?>