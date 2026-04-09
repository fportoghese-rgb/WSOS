<?php

    $conn= new mysqli("localhost","root","","");


    $action= $_REQUEST["action"]?? "";

    if($_SERVER["REQUEST_METHOD"]==="GET"){
        if($action==="read"){
            $query="SELECT * From edicola";
            $stm= $conn->prepare($query);
            $stm->execute();
            $res= $stm->get_result();
            while($rows= $res->fetch_assoc()){
                $id= $rows["id"];
                $titolo = $rows["titolo"];
                $genere = $rows["genere"];
                $testata = $rows["testata"];
                $autore= $rows["autore"];
                $autore_nome = $rows["autore_nome"];
                $autore_cognome = $rows["autore_cognome"];
                $anni = $rows["anni"];
                echo "<p>{$rows['id']} - {$rows['titolo']} - {$rows['autore']} - {$rows['autore_nome']} - {$rows['autore_cognome']}</p>";
            }
        }
        if($action==="form"){
        print("<form action='/Fumetti.php'  method='POST'>");
        print("<label for='id'>Id</label>");
        print("<input type=text name=id value=".$id.">");
        print("<label for='titolo'>Titolo</label>");
        print("<input type=text name=titolo value=".$titolo.">");
        print("<label for='genere'>Genere</label>");
        print("<input type=text name=genere value=".$genere.">");
        print("<label for='testata'>Tetstata</label>");
        print("<input type=text name=testata value=".$testata.">");
        print("<label for='autore'>Autore</label>");
        print("<input type=text name=autore value=".$autore.">");
        print("<label for='autore_nome'>Autore_nome</label>");
        print("<input type=text name=autore_nome value=".$autore_nome.">");
        print("<label for='autore_cognome'>Autore_cognome</label>");
        print("<input type=text name=autore_cognome value=".$autore_cognome.">");
        print("<label for='anni'>Anni</label>");
        print("<input type=text name=anni value=".$anni.">");
        print("<input type='submit' name='action' value='aggiorna'>");
        print("<input type='submit' name='action' value='elimina'>");
        }
    }

    if($_SERVER["REQUEST_METHOD"]==="POST"){
        if($action=="elimina"){
             $id= $_POST["id"];
            
            $query=" DELETE FROM edicola where id=?";
            $stm= $conn->prepare($query);
            $stm->bind_param("s", $id);
            $stm->execute();
            print("elimanato con successo");
        }
        if($action=="aggiorna"){
             $id= $_POST["id"];
            $autore=$_POST["autore"];
            $parts = explode("-", $autore);
            $query="UPDATE edicola SET autore_nome=?, autore_cognome=? where id=?";
             $stm= $conn->prepare($query);
            $stm->bind_param("sss", $parts[0],$parts[1],$id);
            $stm->execute();
            print("aggiornato con succcesso!");
        }
    }
    $conn->close();
?>