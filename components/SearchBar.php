<?php

class SearchBar {
    public static function render() {
        echo "<form type='submit' method='POST' action='./components/SearchBar.php'>";
            echo "<input type='text' placeholder='search...' id='searchbar' name='searchbar'>";
        echo "</form>";
    }
}

if (isset($_POST['searchbar'])) {
    $objectId = urlencode(strtolower($_POST['searchbar']));
    Header("Location: /airmuseum/search-" . $objectId);
}