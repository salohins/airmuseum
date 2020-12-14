<?php

class Login {
    public static function render() {
        echo "<div class='container'>";
            echo "<div id='content' class='login'>";
            include "./config/pass.php";
                echo "<h1>Admin Login</h1><hr>";
                echo "<form action='./components/pages/login.php' method='post'>";    
                    
                    if (isset($_SESSION['login'])) {
                        echo "<h2>Hello, " . $_SESSION['login'] ."</h2>";
                        echo "<input type='submit' name='submit' value='Log Out'>";
                    }
                    else {
                        echo "<input type='text' placeholder='login' name='login' id='login' required>";                    
                        echo "<input type='password' placeholder='password' name='pass' id='pass' required>";                    
                        echo "<input type='submit' name='submit' value='Log In'>";
                    }
                    
                echo "</form>";
            echo "</div>";
        echo "</div>";
    }
}

if (isset($_POST['submit'])) {
    include "../../config/pass.php";
    
    $logged = ($_POST['login'] == getenv('LOGIN')) && ($_POST['pass'] == getenv("PASSWORD"));
    if (isset($_POST['login']) && $logged) {
         session_start();
        $_SESSION['login'] = $_POST['login'];            
     } else {
         if (ini_get("session.use_cookies")) {
             $params = session_get_cookie_params();
             setcookie(session_name(), '', time() - 42000,
                 $params["path"], $params["domain"],
                 $params["secure"], $params["httponly"]
             );
         }
         session_destroy();
     }
     Header("Location: /airmuseum/login");
 }