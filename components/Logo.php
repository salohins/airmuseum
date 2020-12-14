<?php

class Logo {
    public static function render($height, $width) {
        echo "<img src='public/img/logo.svg' width='$width' height='$height'>";
    }
}