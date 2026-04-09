<?php

    $conn= new mysqli("localhost","root","Batman@01","exams",3307);


    $action= $_REQUEST["action"] ?? "";

    if($_SERVER["REQUEST_METHOD"]==="GET"){
        if($action==="read"){
            $query="SELECT * FROM santabox where delivered=0";
            $stm=$conn->prepare($query);
            $stm->execute();
            $res=$stm->get_result();
            while($rows=$res->fetch_assoc()){
                $id= htmlspecialchars($rows["id"]);
                $name= htmlspecialchars($rows["name"]);
                $gift= htmlspecialchars($rows["gift"]);
                $quantity= htmlspecialchars($rows["quantity"]);
                $delivered= htmlspecialchars($rows["delivered"]);

                echo"<p> <a href='BabboNatale.php?action=form&id=$id&name=$name&gift=$gift&quantity=$quantity&delivered=$delivered'>"."$id-$name-$gift-$quantity-$delivered</a></p>";
            }
        }


        if($action==="form"){
            $id=$_GET["id"]?? "";
            $name=$_GET["name"] ?? "";
            $gift=$_GET["gift"]?? "";
            $quantity=$_GET["quantity"]?? "";
            $delivered=$_GET["delivered"]?? "";

            echo" <form action='BabboNatale.php' method='POST'>";
            echo" <label for='id'>ID</label>";
            echo"<input type='text' name='id' value='$id'>";
            echo" <label for='name'>Name</label>";
            echo"<input type='text' name='name' value='$name'>";
            echo"<label for='gift'>Gift</label>";
            echo"<input type='text' name='gift' value='$gift'>";
            echo" <label for='quantity'>Quantity</label>";
            echo" <input type='text' name='quantity' value='$quantity'>";
            echo" <label for='delivered'>Delivered</label>";
            echo"<input type='text' name='delivered' value='$delivered'>";
            echo"</form>";


            echo"<form action='BabboNatale.php' method='GET'>";
            echo"<button type='submit'>Mostra</button>";
            echo"<input type='hidden' name='action' value='read'>";
            echo"</form>";
        }
    }
    if($_SERVER["REQUEST_METHOD"]==="POST"){
        if($action==="create"){
        $id=$_POST["id"];
            $name=$_POST["name"] ;
            $gift=$_POST["gift"];
            $quantity=$_POST["quantity"];
            $delivered=$_POST["delivered"];

            $query="INSERT INTO santabox (id,name,gift,quantity,delivered) VALUES(?,?,?,?,?)";
            $stm=$conn->prepare($query);
            $stm->bind_param("sssss",$id,$name,$gift,$quantity,$delivered);
            $stm->execute();
            echo"inserito con successso";
        }
    }
$conn->close();
?>