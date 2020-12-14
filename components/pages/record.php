<?php

class Record {
    public static function render($table, $id) {
        include "./config/connect.php";
        echo "<div class='container'>";            
                if (isset($_SESSION['login'])) {
                    $res = null;
                    $record = null;

                    echo "<div id='content' class='login'>";
                        if ($id == 'new') {
                            if ($table == 'objects') {
                                echo "<h1>New Object</h1>";                                                             
                            }
                            else {
                                echo "<h1>New Article</h1>";                                
                            }
                        }
                        else {                      
                            $sql = "SELECT * FROM '{$table}' WHERE name = '{$id}' limit 1";
                            $stmt = $db->prepare($sql);
                            $stmt->execute();
                            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            

                            foreach ($res as $row) {                                
                                $record = $row;
                                echo "<h1>". $row['title'] ." - edit</h1>";                                
                            }
                        }
                        
                        echo "<hr>";                        
                        echo "<form action='./components/pages/record.php' method='post'>";
                            echo "<p>Name:</p>";
                            echo "<input type='hidden' name='table' value='$table'>";
                            echo "<input type='hidden' name='id' value='" .$record['id'] ."'>";
                            echo "<input type='text' placeholder='Name' name='name' value='". $record['name'] ."'>";

                            echo "<p>Title:</p>";
                            echo "<input type='text' placeholder='Title' name='title' value='". $record['title'] ."'><br><br>";

                            echo "<p>Author</p>";
                            echo "<input type='text' placeholder='author' name='author' value='" .$record['author'] ."'>";
                            
                            echo "<p>GPS</p>";
                            echo "<input type='text' placeholder='gps' name='gps' value='" .$record['gps'] ."'>";

                            echo "<p>Image 1 File</p>";
                            echo "<input type='text' placeholder='image 1' name='image1' value='" .$record['image1'] ."'>";
                            echo "<p>Image 1 text:</p>";
                            echo "<textarea rows='5' cols='30%' name='image1text'>". $record['image1Text'] ."</textarea><br><br><br>";    
                            echo "<p>Image 2 File</p>";                                                     
                            echo "<input type='text' placeholder='image 2' name='image2' value='". $record['image2'] ."'>";
                            echo "<p>Image 2 text:</p>";
                            echo "<textarea rows='5' cols='30' name='image2text'>". $record['image2Text'] ."</textarea><br>"; 
                            echo "<p>Content:</p>";
                            echo "<textarea rows='5' cols='30' name='content'>" .$record['data'] ."</textarea>"; 
                            echo "<input type='submit' name='submit' value='" .($id == 'new' ? 'Add' : 'Update')."'>";                    
                        echo "</form>";
                    echo "</div>";
                }
                else {
                    echo "<div id='content'>";
                        echo "<h1>Page Not Found</h1><hr>";
                        echo "<i>Sorry, the page you are looking for does not exist.</i>"; 
                    echo "</div>";
                }
            
        echo "</div>";
    }
}

if (isset($_POST['submit'])) {
    include "../../config/connect.php";
    $name = $_POST['name'];
    $title = $_POST['title'];
    $image1 = $_POST['image1'];
    $image1Text = $_POST['image1text'];
    $image2 = $_POST['image2'];
    $image2Text = $_POST['image2text'];
    $table = $_POST['table'];
    $content = $_POST['content'];
    $author = $_POST['author'];
    $gps = $_POST['gps'];

    $params = [$name, $title, $image1, $image1Text, $image2, $image2Text];
    
    if ($table == 'object' || $table == 'article') {
        $sql = "UPDATE $table SET 
        name='$name',
        title='$title',
        data='$content',
        gps='$gps',
        image1='$image1',
        image1Text='$image1Text',
        image2='$image2',
        image2Text='$image2Text'
        WHERE id = '{$_POST['id']}'";

    }
    else {
        $table = substr($table, 0, -1);
        $id = rand(100, 999999);
        $sql = "INSERT INTO ". $table ." VALUES(
            $id, 
            '$name',
            '$title', 
            '$content', 
            '$author', 
            '$gps', 
            null, 
            '$image1',
            'image1Alt',
            '$image1Text',
            'Text',
            '$image2',
            'image2Alt',
            '$image2Text'
        )";
    }
    $stmt = $db->prepare($sql);
    

    try {
        $stmt-> execute();
    } catch (PDOException $e) {
        echo "<p>Failed to insert a new, row";
        throw $e;
    }
}