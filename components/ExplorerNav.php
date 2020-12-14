<?php
session_start();
class ExplorerNav {
    public static function render($table) {
        include "./config/connect.php";
        $sql = "";
        if ($table == 'objects')
            $sql = "SELECT * FROM object";
        else if ($table == 'articles')
            $sql = "SELECT * FROM article"; 
            
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $sections = array();
        echo "<aside class='explorer-nav'><ul>";
            echo "<h1>" .ucfirst($table) ."</h1><hr>";

            $logged = isset($_SESSION['login']);
            foreach($res as $row) {
                echo "<li><a href='" .strtolower($table) # Navigation Heading
                                    ."-" .$row['name'] 
                                    ."'>" .$row['title'] 
                                    ."<a/></li>";

                if ($logged) { # If logged In
                    echo "<div class='controlls'>";
                        echo "<a href='delete-". $row['name'] ."-". $table ."'>Delete</a>";
                        echo "<a id='blue' href='edit-". $row['name'] ."-". $table ."'>Edit</a>";
                    echo "</div>";
                }
            }
            if ($logged) {
                echo "<br><br><a href='new-$table' id='new'>Add New</a><br>";
            }
        echo "</ul></aside>";
    }
}