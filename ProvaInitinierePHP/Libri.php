<?php

    $conn= new mysqli("localhost","root","Batman@01","exam",3307);

    $action= $_REQUEST["action"] ?? "";

    if($_SERVER["REQUEST_METHOD"]==="GET"){
        if($action==="read"){
            $query="SELECT * FROM books";
            $stm= $conn->prepare($query);
            $stm->execute();
            $res=$stm->get_result();
            while($rows= $res->fetch_assoc()){
                $id= htmlspecialchars($rows["id"]);
                $isbn= htmlspecialchars($rows["isbn"]);
                $title= htmlspecialchars($rows["title"]);
                $author= htmlspecialchars($rows["author"]);
                $publisher= htmlspecialchars($rows["publisher"]);
                $ranking= htmlspecialchars($rows["ranking"]);
                $year= htmlspecialchars($rows["year"]);
                $price= htmlspecialchars($rows["price"]);
                echo"<p> <a href='Libri.php?action=form&id=$id&isbn=$isbn&title=$title&author=$author&publisher=$publisher&ranking=$ranking&year=$year&price=$price'>" ."$id-$isbn-$title-$author-$publisher-$ranking-$year-$price</a></p>";

            }
        }

        if($action==="form"){
            $id= $_GET["id"] ?? "";
            $isbn= $_GET["isbn"] ?? "";
            $title= $_GET["title"]?? "";
            $author= $_GET["author"]?? "";
            $publisher= $_GET["publisher"] ?? "";
            $ranking= $_GET["ranking"] ?? "";
            $year= $_GET["year"]?? "";
            $price= $_GET["price"] ?? "";

            echo"<form action='Libri.php' method='POST'>";
            echo"<label for='id'>Id</label>";
            echo"<input type='text' name='id' value='$id'>";
            echo" <label for='isbn'>Isbn</label>";
            echo" <input type='text' name='isbn' value='$isbn'>";
            echo"<label for='title'>Title</label>";
            echo" <input type='text' name='title' value='$title'>";
            echo"<label for='author'>Author</label>";
            echo" <input type='text' name='author' value=$author>";
            echo"<label for='publisher'>Publisher</label>";
            echo"<input type='text' name='publisher' value='$publisher'>";
            echo" <label for='ranking'>Ranking</label>";
            echo"<input type='text' name='ranking' value='$ranking'>";
            echo" <label for='year'>Year</label>";
            echo" <input type='text' name='year' value='$year'>";
            echo"<label for='price'>Price</label>";
            echo"<input type='text' name='price' value='$price'>";
            echo"</form>";


            echo"<form action='Libri.php' method='GET'>";
            echo" <button type='submit'>DAMMI TUTTI I RECORDS DI EXAM</button>";
            echo" <input type='hidden' name='action' value='read'>";
            echo"</form>";
        }
    }

    if($_SERVER["REQUEST_METHOD"]==="POST"){
        if($action==="create"){
            $id= $_POST["id"] ;
            $isbn= $_POST["isbn"] ;
            $title= $_POST["title"];
            $author= $_POST["author"];
            $publisher= $_POST["publisher"] ;
            $ranking= $_POST["ranking"];
            $year= $_POST["year"];
            $price= $_POST["price"];
            
            $query="INSERT INTO books (id,isbn,title,author,publisher,ranking,year,price) VALUES (?,?,?,?,?,?,?,?)";
            $stm=$conn->prepare($query);
            $stm->bind_param("ssssssss",$id,$isbn,$title,$author,$publisher,$ranking,$year,$price);
            $stm->execute();
            echo"inserito con successo";
            }
            if($action==="delete"){
                $id= $_POST["id"] ;

                $query="DELETE FROM books WHERE id = ?";
                $stm=$conn->prepare($query);
                $stm->bind_param("i",$id);
                $stm->execute();
                echo"eliminato con successo";
            }
        }
    $conn->close();
?>