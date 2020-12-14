<?php

include './components/Nav.php';
include './components/Container.php';
include './components/SearchBar.php';
include './components/Explorer.php';
include './components/Footer.php';
include './components/pages/404.php';

class App {
    public static function render() {        
        $currentPage = basename($_SERVER['REQUEST_URI']);
        
        Nav::render();
        echo "<div class='app'>";
            SearchBar::render();
            $container = new Container();

            switch ($currentPage) {
                case 'airmuseum' :
                case 'home' :
                    $container->home();
                break;
                case 'about' :
                    $container->about();
                break;
                case 'author' :
                    $container->author();
                break;
                case 'login' : 
                    $container->login();
                break;
                case 'gallery':
                    $container->gallery();
                break;
                default: //Objects and Articles
                    if (substr($currentPage, 0, strlen('objects')) == 'objects')
                        Explorer::render("objects");
                    else if (substr($currentPage, 0, strlen('articles')) == 'articles') {                   
                        Explorer::render("article");
                    }
                    else if (substr($currentPage, 0, strlen('search-')) == 'search-') {                        
                        $container->search();
                    }
                    else if (substr($currentPage, 0, strlen('new-')) == 'new-') {
                        $container->newArticle();
                    }
                    else if (substr($currentPage, 0, strlen('edit-')) == 'edit-')
                        $container->editArticle();
                    else if (substr($currentPage, 0, strlen('delete-')) == 'delete-') {
                        if (isset($_SESSION['login'])) {
                            include "./config/connect.php";
                            $params = explode("-", $currentPage);
                            $table = substr($params[count($params) - 1], 0, -1);                            

                            $name = '';
                            for ($i = 0; $i < count($params); $i++) {
                                if ($i > 0 && $i < count($params) - 1)
                                    $name .= $params[$i] ."-";  
                            }
                            $name = substr($name, 0, -1);
                            echo $name;

                            $sql = "DELETE FROM $table WHERE name='{$name}'";
                            $stmt = $db->prepare($sql);

                            try {
                                $stmt-> execute();
                            } catch (PDOException $e) {
                                echo "<p>Failed to delete row";
                                throw $e;
                            }

                        }
                    }
                        
                    else { // Page Not Found
                        PageNotFound::render();
                    }
                break;
            }
        echo "</div>";
        Footer::render();
    }
}
