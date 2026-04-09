<?php

    $conn= new mysqli("localhost","root","Batman@01","cinema",3307);


    $action=$_REQUEST["action"] ?? "";

    if($_SERVER["REQUEST_METHOD"]==="GET"){
        if($action==="read"){
            $query="SELECT * FROM film";
            $stm=$conn->prepare($query);
            $stm->execute();
            $res=$stm->get_result();
            
            while($rows=$res->fetch_assoc()){
                $titolo=htmlspecialchars($rows["titolo"]);
                $anno=htmlspecialchars($rows["anno"]);
                $paese=htmlspecialchars($rows["paese"]);
                $regista=htmlspecialchars($rows["regista"]);
                echo"<p> <a href='SimEsameBook.php?action=form&titolo=$titolo&anno=$anno&paese=$paese&regista=$regista'>"."$titolo-$anno-$paese-$regista</a></p>";
            }
        }

        if($action==="form"){
            $titolo= $_GET["titolo"] ?? "";
            $anno= $_GET["anno"] ?? "";
            $paese= $_GET["paese"] ?? "";
            $regista= $_GET["regista"] ?? "";
            echo" <form action='SimEsameBook.php' method='POST'>";
            echo"<label for='titolo'>Titolo</label><br>";
            echo"<input type='text' name='titolo' value='$titolo'>";
            echo"<label for='anno'>Anno</label><br>";
            echo"<input type='text' name='anno' value='$anno'>";
            echo" <label for='paese'>Paese</label><br>";
            echo"<input type='text' name='paese' value='$paese'>";
            echo" <label for='regista'>Regista</label><br>";
            echo"<input type='text' name='regista' value='$regista'>";
            echo"<input type='hidden' name='action' value='update'>";
            echo "<input type='submit' name='action' value='update'><br>";
            echo"</form>";

            echo"<form action='SimEsameBook.php' method='GET'>";
            echo"<button type='submit'>Mostra</button>";
            echo"<input type='hidden' name='action' value='read'>";
            echo"</form>";
        }
    }

        if($_SERVER["REQUEST_METHOD"]==="POST"){
            if($action==="create"){

            $titolo= $_POST["titolo"];
            $anno= $_POST["anno"];
            $paese= $_POST["paese"];
            $regista= $_POST["regista"];
            
            $query="INSERT INTO film (titolo,anno,paese,regista) VALUES (?,?,?,?)";
            $stm= $conn->prepare($query);
            $stm->bind_param("ssss",$titolo,$anno,$paese,$regista);
            $stm->execute();
            echo"<h2>RECORD INSERITO CON SUCCESSO!</h2>";
            }

            if($action==="update"){
            $titolo= $_POST["titolo"];
            $anno= $_POST["anno"];
            $paese= $_POST["paese"];
            $regista= $_POST["regista"];
             
            $query="UPDATE film SET anno=?,paese=?,regista=? where titolo=?";
            $stm= $conn->prepare($query);
            $stm->bind_param("ssss",$anno,$paese,$regista,$titolo);
            $stm->execute();
            echo"RECORD AGGIORNATO CON SUCCESSO!";
            }

            if($action==="delete"){
            $regista= $_POST["regista"];
             
            $query="DELETE FROM film where regista=?";
            $stm= $conn->prepare($query);
            $stm->bind_param("s",$regista);
            $stm->execute();
            echo"REGISTA ELIMINATO CON SUCCESSO!";
            }
        }
    $conn->close();
?>