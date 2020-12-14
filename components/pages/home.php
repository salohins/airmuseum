<?php

class Home {
    public static function render() {
        echo "<div class='container'>";
            echo "<div id='content' class='jumbotron'>";
                echo "<h1>Header</h1>";
                echo "<p>Paragraph</p>";
                echo "<hr>";
                echo "<p>Paragraph</p>";
                echo "<button><a href='objects'>Articles</a></button>";
                echo "<button><a href='objects'>Objects</a></button>";
            echo "</div>";
    }
}