<?php

        $conn= new mysqli("localhost","root","","");

$action = $_REQUEST["action"] ?? "";

        if($_SERVER["REQUEST_METHOD"] === "GET"){
            if($action === "read"){
                $query="SELECT * FROM Offers";
                $stm= $conn->prepare($query);
                $stm->execute();
                $res= $stm->get_result();
                while($rows= $res->fetch_assoc()){
                    $id= $rows["id"];
                    $descrzione= $rows["descrizione"];
                    $prezzo= $rows["prezzo"];
                    $validita= $rows["validita"];
                    $acquistato= $rows["acquistato"];
                    print("<p> Id : <a href='/Offers.php?action=form&descrizione=".$descrzione."&prezzo=".$prezzo."&validita=".$validita." &acquistato=".$acquistato"</a> |descrizione".$descrzione." Prezzo".$prezzo." Validita".$validita." acquistato".$acquistato."</p>");

                }
            }

            if($action=== "form"){
                $id= $_GET["id"];
                $descrzione= $_GET["descrizione"];
                $prezzo= $_GET["prezzo"];
                $validita= $_GET["validita"];
                $acquistato= $_GET["acquistato"];
                print("<form action='/Offers.php' method='POST'>");
                print("<label for='Id' >ID</label>");
                print("<input type='text' name='Id' value=".$id."> <br>");
                print("<label for='Descrizione' >Descrizione</label>");
                print("<input type='text' name='Descrizione' value=".$descrzione."> <br>");
                print("<label for='prezzo' >Prezzo</label>");
                print("<input type='text' name='Prezzo' value=".$prezzo."> <br>");
                print("<label for='prezzo' >Acquistato</label>");
                print("<input type='text' name='Acquistato' value=".$acquistato."> <br>");
                print("<input type='submit' name='action' value='Aggiorna' <br>");
                print("<input type='submit' name='action' value='Elimina' <br>");
                print("<label for='validita' >Validita</label>");
                print("<input type='text' name='Validita' value=".$validita."> <br>");
                print("</form>");
            }
        }


        if($_SERVER["REQUEST_METHOD"]=== "POST"){
            if($action === "elimina"){
                 $id= $_POST["id"];
                $query="DELETE FROM Offers WHERE id=?";
                $stm= $conn->prepare($query);
                $stm-> bind_param("s", $id);
                $stm->execute();
            }
            print("<p>record eliminato con successo </p>");
        }
 print("<a href='indexO.html'> <button> Cancella </button></a>");
           
                if($action === "Aggiorna"){
                $prezzo= $_POST["prezzo"];
                $validita= $_POST["validita"];
                $acquistato= $_POST["acquistato"];

                $query="UPDATE Offers SET prezzo=?, validita=?, acquistato=? WHERE id=?";
                $stm= $conn->prepare($query);
                $stm-> bind_param("sss", $prezzo,$validita,$acquistato,$id);
                $stm->execute();
                print("<p>record aggiornato con successo </p>");
           }  
 print("<a href='indexO.html'> <button> Aggiorna </button></a>");

           if($action === "create"){
                $prezzo= $_POST["prezzo"];
                $validita= $_POST["validita"];
                $acquistato= $_POST["acquistato"];

                $query="INSERT INTO Offers (prezzo,validità,acquistato) VALUES(?,?,?)";
                $stm= $conn->prepare($query);
                $stm-> bind_param("sss", $prezzo,$validita,$acquistato);
                $stm->execute();
                print("<p>record aggiunto con successo </p>");
           }  
    $conn->close();
?>