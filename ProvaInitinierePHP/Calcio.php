<?php

    $conn= new mysqli("localhost","root","Batman@01","football_db",3307);

    $action=$_REQUEST["action"] ?? "";

    if($_SERVER["REQUEST_METHOD"]==="GET"){
        if($action==="read"){
            $query="SELECT * FROM players";
            $stm=$conn->prepare($query);
            $stm->execute();
            $res=$stm->get_result();
            while($rows=$res->fetch_assoc()){
                $first_name= htmlspecialchars($rows["first_name"]);
                $last_name= htmlspecialchars($rows["last_name"]) ;
                $team= htmlspecialchars($rows["team"]);
                $position= htmlspecialchars($rows["position"]);
                $nationality= htmlspecialchars($rows["nationality"]);
                $birth_year= htmlspecialchars($rows["birth_year"]) ;
                echo"<p> <a href='Calcio.php?action=form&first_name=$first_name&last_name=$last_name&team=$team&position=$position&nationality=$nationality&birth_year=$birth_year'>"."$first_name-$last_name-$team-$position-$nationality</a></p>";
            }
        }


        if($action==="form"){
            $first_name= $_GET["first_name"]?? "";
                $last_name= $_GET["last_name"] ?? "";
                $team= $_GET["team"]?? "";
                $position= $_GET["position"]?? "";
                $nationality= $_GET["nationality"]?? "";
                $birth_year= $_GET["birth_year"] ?? "";

            echo"<form action='Calcio.php' method='POST'>";
            echo"<label for='first_name'>Nome</label>";
            echo"<input type='text' name='first_name' value='$first_name'>";
            echo"<label for='last_name'>Cognome</label>";
            echo"<input type='text' name='last_name' value='$last_name'>";
            echo"<label for='team'>Squadra</label>";
            echo"<input type='text' name='team' value='$team'>";
            echo"<label for='position'>Ruolo</label>";
            echo" <input type='text' name='position' value='$position'>";
            echo" <label for='nationality'>Nazionalita</label>";
            echo" <input type='text' name='nationality' value='$nationality'>";
            echo"<label for='birth_year'>Compleanno</label>";
            echo"<input type='text' name='birth_year' value='$birth_year'>";
            echo"<button type='submit'>Aggiorna</button>";
            echo"<input type='hidden' name='action' value='update'>";
            echo" <button type='submit' name='action' value='delete'>Elimina</button>";
            echo"</form>";


            echo"<form action='Calcio.php' method='GET'>";
            echo"<button type='submit'>MOSTRA I CALCIATORI</button>";
            echo"<input type='hidden' name='action' value='read'>";
            echo"</form>";
        }
    }



    if($_SERVER["REQUEST_METHOD"]==="POST"){
    if($action==="create"){
            $first_name= $_POST["first_name"];
            $last_name= $_POST["last_name"];
            $team= $_POST["team"];
            $position= $_POST["position"];
            $nationality= $_POST["nationality"];
            $birth_year= $_POST["birth_year"];


            $query="INSERT INTO players (first_name,last_name,team,position,nationality,birth_year)  VALUES(?,?,?,?,?,?)";
            $stm=$conn->prepare($query);
            $stm->bind_param("sssssi",$first_name,$last_name,$team,$position,$nationality,$birth_year);
            $stm->execute();
            echo"inserito con successo";
        }

        if($action==="delete"){
            $first_name= $_POST["first_name"];

            $query="DELETE FROM players where first_name=?";
            $stm=$conn->prepare($query);
            $stm->bind_param("s",$first_name);
            $stm->execute();
            echo"eliminato con successo";
        }
        if($action==="update"){
            $first_name= $_POST["first_name"];
            $last_name= $_POST["last_name"];
            $team= $_POST["team"];
            $position= $_POST["position"];
            $nationality= $_POST["nationality"];
            $birth_year= $_POST["birth_year"];

            $query="UPDATE players SET first_name=?,last_name=?,team=?,position=?,nationality=? where birth_year=?";
            $stm=$conn->prepare($query);
            $stm->bind_param("ssssss",$first_name,$last_name,$team,$position,$nationality,$birth_year);
            $stm->execute();
            echo"aggiornato con successo";
        }
    }
    $conn->close();
?>