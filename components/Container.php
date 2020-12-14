<?php

include 'pages/home.php';
include 'pages/about.php';
include 'pages/author.php';
include 'pages/gallery.php';
include 'pages/login.php';
include 'pages/record.php';

class Container {
    public function __call($method, $args) {
        include './config/connect.php';
        $currentPage = basename($_SERVER['REQUEST_URI']);
        
        switch ($method) {
            case 'home':
                Home::render();;
            break;

            case 'about':
                About::render();
            break;

            case 'author': 
                Author::render();
            break;

            case 'login':
                Login::render();
            break;

            case 'gallery': 
                Gallery:: render();
            break;

            case 'newArticle': 
                $table = substr($currentPage, strlen("new-"));

                Record::render($table, 'new');
            break;

            case 'editArticle': 
                $params = explode("-", $currentPage);
                if (count($params) == 4) {
                    Record::render(substr($params[3], 0, -1), $params[1] ."-" .$params[2]);
                }
                else if (count($params) == 3) {
                    Record::render(substr($params[2], 0, -1), $params[1]);
                }
                
            break;

            case 'search':                
                $input = urldecode(substr($currentPage, strlen("search-"), 
                    strlen($currentPage)));

                $input = mb_strtolower($input);
                  
                $sql = "SELECT *, 'object' as source FROM object WHERE title LIKE '%{$input}%'
                    UNION SELECT *, 'article' as source FROM article WHERE title LIKE '%{$input}%'";
                $stmt = $db->prepare($sql);
                $stmt->execute(); 
                $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                echo "<div class='container'>";
                    echo "<div id='content'>";
                        echo "<h1>" .count($res) ." Results Found</h1>";
                        echo "<hr>";
                        foreach ($res as $row)
                            echo "<a href='" .$row['source'] ."s-" .$row['name'] 
                                ."'>" .$row['title'] ."<br><i>" .$row['source'] ."</i></a>";
                    echo "</div>";
                echo "</div>";                   
            break;

            case 'content':                 
                echo "<div class='explorer-content'>";
                    $single = (strlen($currentPage) == strlen("articles")) || 
                        (strlen($currentPage) == strlen("objects"));

                    $article = "";                    
                    $object = "";    
                        
                    $sql = '';                    
                    if ($args[0] == 'articles') {
                        # Getting Article ID
                        $article = substr($currentPage, strlen("articles-"), strlen($currentPage));

                        if ($single)
                            $sql = "SELECT * FROM article limit 2";
                        else 
                            $sql = "SELECT * FROM article";
                    }
                    else if ($args[0] == 'objects') {
                        # Gettimg Object ID
                        $object = substr($currentPage, strlen("objects-"), strlen($currentPage));

                        if ($single)
                            $sql = "SELECT * FROM object limit 2";
                        else 
                            $sql = "SELECT * FROM object";
                    }

                    $stmt = $db->prepare($sql);
                    $stmt->execute();
                    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);  
                    $keys = array_keys($res);
                    $i = 0;      
                    $exists = false;
                    echo "<div id='explorer-heading'><h1>$args[0]</h1><hr><br><br></div>";          
                    
                    foreach(array_keys($keys) as $k) {
                        $i++;
                        
                        if ($single || $res[$keys[$k]]['name'] == $object || $res[$keys[$k]]['name'] == $article) {
                            $exists = true;
                            echo "<div class='content-controlls'>";

                                if ($i > 1) { # Link to the previous page of the Article/Content
                                    echo "<a href='$args[0]-" .$res[$keys[$k - 1]]['name'] ."'>
                                        <i class='fas fa-arrow-left fa-lg'></i></a>";
                                }
                                if ($i < count($res)) # Link to the next page of the Article/Content
                                    echo "<a style='margin-left: auto' href='$args[0]-". 
                                        $res[$keys[$k + 1]]['name']."'>
                                            <i class='fas fa-arrow-right fa-lg'></i></a>";

                            echo "</div><br><br>";
                        
                            echo "<h1>" . $res[$keys[$k]]['title'] . "</h1>";        
                            echo "<p><i>" . $res[$keys[$k]]['author'] . "</i></p>";        
                            echo "<p>" . $res[$keys[$k]]['gps'] . "</p>";

                            if ($res[$keys[$k]]['image1']) { # Check if image1 exists
                                echo "<img src='./public/img/" . $res[$keys[$k]]['image1']
                                    ."'witdh='auto' height='auto'>";
                                
                                echo "<p>" . $res[$keys[$k]]['image1Text'] ."</p><br>";       
                            }
                            if ($res[$keys[$k]]['image2']) { # Check if image2 exists
                                echo "<img src='./public/img/" . $res[$keys[$k]]['image2'] 
                                    ."'witdh='auto' height='auto'>";
                
                                echo "<p>" . $res[$keys[$k]]['image2Text'] ."</p><br>";   
                            }
                            echo $res[$keys[$k]]['data'];
                        }
                        if ($single) # foreach break if url has no Article/Object ID
                            break;
                    } 
                    if (!$exists) { // If the id in url does not exist in database
                        echo "<h1>Page Not Found</h1><hr>";
                        echo "<i>Sorry, the page you are looking for does not exist.</i>";
                    }                                    
                echo "</div>";
            break;
        }
    }
}