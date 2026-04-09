<?php

        $conn= new mysqli("localhost","root","Batman@01","cinema",3307);



        $action= $_REQUEST["action"] ?? "";

        if($_SERVER["REQUEST_METHOD"]==="GET"){
            if($action==="read"){
                $query = "SELECT * FROM film";
                $stm = $conn->prepare($query);
                $stm->execute();
                $res = $stm->get_result();

        while ($row = $res->fetch_assoc()) {
            $titolo = htmlspecialchars($row["titolo"]);
            $anno = htmlspecialchars($row["anno"]);
            $paese = htmlspecialchars($row["paese"]);
            $regista = htmlspecialchars($row["regista"]);

            echo "<p><a href='provaFilms.php?action=form&titolo=$titolo&anno=$anno&paese=$paese&regista=$regista'>"
                . "$titolo - $anno - $paese - $regista</a></p>";
                }
            }

            if($action==="form"){
                $titolo = $_GET["titolo"] ?? "";
                $anno = $_GET["anno"] ?? "";
                 $paese = $_GET["paese"] ?? "";
                $regista = $_GET["regista"] ?? "";

                echo " <form action='provaFilms.php' method='POST'><br>";
                echo "<label for='titolo'>Titolo</label>";
                echo"<input type='text' name='titolo' value='$titolo'<br>";
                echo "<label for='anno'>Anno</label>";
                echo"<input type='text' name='anno' value='$anno'><br>";
                echo "<label for='paese'>Paese</label>";
                echo"<input type='text' name='paese' value='$paese'><br>";
                echo"<input type='hidden' name='action' value='Aggiorna'>";
                echo "<input type='submit' name='action' value='Aggiorna'><br>";
                echo "<label for='regista'>Regista</label><br>";
                echo"<input type='text' name='regista' value='$regista'><br>";
                echo"</form>";

                echo " <form action='provaFilms.php' method='GET'>";
                echo "<input type='submit' name='action' value='read'><br>";
                echo"<input type='hidden' name='action' value='read'>";
                echo"</form>";
            }
        }

        if($_SERVER["REQUEST_METHOD"]==="POST"){
            if($action==="create"){
            $titolo= $_POST["titolo"];
            $anno= $_POST["anno"];
            $paese=$_POST["paese"];
            $regista= $_POST["regista"];

            $query="INSERT INTO film (titolo,anno,paese,regista)  VALUES(?,?,?,?)";
            $stm= $conn->prepare($query);
            $stm->bind_param("ssss", $titolo,$anno,$paese,$regista);
            $stm->execute();
            echo"inserito bene";
            }
             if($action==="delete"){
            $titolo= $_POST["titolo"];

            $query="DELETE FROM film where titolo=?";
            $stm= $conn->prepare($query);
            $stm->bind_param("s", $titolo);
            $stm->execute();
            echo"titolo eliminato!";
            }

            if($action==="Aggiorna"){
            $titolo= $_POST["titolo"];
            $anno= $_POST["anno"];
            $paese=$_POST["paese"];
            $regista= $_POST["regista"];
            
                $query="UPDATE film SET anno=?, paese=?, regista=? where titolo=?";
                $stm= $conn->prepare($query);
                $stm->bind_param("ssss", $anno,$paese, $regista, $titolo);
                $stm->execute();
                echo"titolo aggiornato!";
            }
        }

        $conn->close();
?>