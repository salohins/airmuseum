<?php

include './components/Logo.php';

# TOPBAR NAVIGATION

class Nav {
    public static function render() {
        $headings = array( // Navigation Layout
           "Home",
           "Articles",
           "Objects",
           "About",
        );
        $currentPage = basename($_SERVER['REQUEST_URI']);
        
        echo "<nav class='nav-bar'>";
            echo "<div class='nav-content'>";
                Logo::render("auto", "auto"); // printing logo 
                echo "<ul>";
                    foreach ($headings as $heading) { // printing headings
                        $link = strtolower($heading); //link to the heading URL                                               
    
                        if ($currentPage == $link) {
                            echo "<li class='selected'><a href='$link'>$heading</a></li>";
                        }
                        else {
                            echo "<li><a href='$link'>$heading</a></li>";
                        }
                    }

                    // Author Link
                    echo "<li ".($currentPage == 'author' ? "class='selected'" : "")."><a href='author'><i class='fas fa-user'></i></a></li>";

                    // Login Link
                    echo "<li ".($currentPage == 'login' ? "class='selected'" : "")."><a href='login'><i class='fas fa-key'></i></a></li>";
                echo "</ul>";
            echo "</div>";
        echo "</nav>";
        echo "<hr>";
    }
}


    