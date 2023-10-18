<!--Pravin Mark Jayasinghe-->
<!--104182850-->
<!-- COS80021: Developing Web Applications -->
<!-- Project 2 -->

<!--logout.php handles the user's request to logout from the system-->

<?php

header('Content-Type: text/xml');

$HTML = "";


session_start();
if (isset($_POST["logout"])) {

    session_unset();
    session_destroy();
    $_SESSION = array();

    $HTML = "<br><span class='confirmed'>You are successfully logged out!</span></br>";
    echo $HTML;
}

?>