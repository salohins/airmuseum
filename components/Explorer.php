<?php

include "ExplorerNav.php";

class Explorer {
    public static function render($table) {
        echo "<div class='container'>";
            $container = new Container();    
            if ($table == 'objects') {
                ExplorerNav::render('objects');                
                $container->content('objects');
            }
            else {
                ExplorerNav::render('articles');
                $container->content('articles');
            }
        echo "</div>";
    }
}
