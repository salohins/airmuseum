<?php

class Gallery {
    public static function render() {
        echo "<div class='container'>";
            echo "<div id='content'>";
                echo "<h1>Gallery</h1>";
                $i = 0;
                if ($handle = opendir('./public/img/')) {
                    while (false !== ($entry = readdir($handle))) {
                        if ($i < 2)
                            $i++;
                        else 
                            echo "<img src='./public/img/$entry' width='30%' height='auto'>";
                    }
                }
            echo "</div>";
        echo "</div>";
    }
}