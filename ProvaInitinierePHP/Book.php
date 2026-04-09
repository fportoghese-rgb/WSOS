<?php

    $conn = new mysqli("localhost", "root", "root", "Biblioteca");

    if ($_SERVER["REQUEST_METHOD"] === "GET") {

        if ($_GET["action"] === "read") {
            $query = "SELECT * FROM books";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $res = $stmt->get_result();
            while ($rows = $res->fetch_assoc()) {
                $isbn = $rows["isbn"];
                $titolo = $rows["titolo"];
                $autore = $rows["autore"];
                $prezzo = $rows["prezzo"];
                print("<p>ISBN: <a href='/book.php?action=form&titolo=".$titolo."&autore=".$autore."&prezzo=".$prezzo."&isbn=".$isbn."'>".$isbn."</a> | Titolo: ".$titolo." | Autore: ".$autore." | Prezzo: ".$prezzo."</p>");
            }
        }

        if ($_GET["action"] === "form") {
            $isbn = $_GET["isbn"];
            $titolo = $_GET["titolo"];
            $autore = $_GET["autore"];
            $prezzo = $_GET["prezzo"];
            print("<form action='/book.php' method='POST'>");
            print("<label for='titolo'>Titolo:</label>");
            print("<input type='text' name='titolo' value=".$titolo."><br>");
            print("<label for='autore'>Autore:</label>");
            print("<input type='text' name='autore' value=".$autore."><br>");
            print("<label for='prezzo'>Prezzo:</label>");
            print("<input type='text' name='prezzo' value=".$prezzo."><br><br>");
            print("<input type='submit' name='action' value='Aggiorna'>");
            print("<input type='submit' name='action' value='Rimuovi'>");
            print("<input type='hidden' name='isbn' value=".$isbn.">");
            print("</form>");
        }
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if ($_POST["action"] === "create") {
            $titolo = $_POST["titolo"];
            $autore = $_POST["autore"];
            $prezzo = $_POST["prezzo"];

            $query = "INSERT INTO books (titolo, autore, prezzo) VALUES (?,?,?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sss", $titolo, $autore, $prezzo);
            $stmt->execute();
            print("<p>Libro inserito con successo</p>");
        }

        if ($_POST["action"] === "Aggiorna") {
            $isbn = $_POST["isbn"];
            $titolo = $_POST["titolo"];
            $autore = $_POST["autore"];
            $prezzo = $_POST["prezzo"];

            $query = "UPDATE books SET titolo=?, autore=?, prezzo=? WHERE isbn=?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssss", $titolo, $autore, $prezzo, $isbn);
            $stmt->execute();
            print("<p>Libro aggiornato con successo</p>");
        }

        if ($_POST["action"] === "Rimuovi") {
            $isbn = $_POST["isbn"];

            $query = "DELETE FROM books WHERE isbn=?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $isbn);
            $stmt->execute();
            print("<p>Libro rimosso con successo</p>");
        }
    }

    print("<a href='index.html'><button>Torna alla homepage</button></a>");
    $conn->close();
?>