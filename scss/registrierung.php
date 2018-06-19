<--!<?php
session_start();
//include "configuration.php";


<!DOCTYPE html>
<html>
<head>
    <title>Registrierung</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link rel="stylesheet" href="vendor/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="vendor/simple-line-icons/css/simple-line-icons.css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Muli" rel="stylesheet">

    <!-- Plugin CSS -->
    <link rel="stylesheet" href="device-mockups/device-mockups.min.css">

    <!-- Custom styles for this template -->
    <link href="css/new-age.min.css" rel="stylesheet">
    <link href="css/new-age.css" rel="stylesheet">

    <!--Fuer login-->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link href='http://fonts.googleapis.com/css?family=Varela+Round' rel='stylesheet' type='text/css'>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.min.js"></script>
    <script src="js/vendor/modernizr-3.5.0.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="js/vendor/jquery-3.2.1.min.js"><\/script>')</script>
    <script src="js/plugins.js"></script>
    <script src="js/main.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

</head>

<body id="page-top">

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="#page-top">Startseite</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="fa fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="login.php">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="#features">Registrieren</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="#contact">Kontakt</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<header class="masthead">
    <div class="container h-100">
        <div class="row h-100">
            <div class="col-lg-7 my-auto">
                <div class="header-content mx-auto"
            </div>
        </div>
        <div class="col-lg-5 my-auto">
        </div>
    </div>
    </div>
</header>

<?php
$showFormular = true;
if(isset($_GET['datenbank'])) {
    $error = false;
    $email = $_POST['email'];
    $passwort = $_POST['passwort'];
    $passwort2 = $_POST['passwort2'];
    $vorname = $_POST ['vorname'];
    $nachname = $_POST ['nachname'];
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo 'Bitte eine gültige E-Mail-Adresse eingeben<br>';
        $error = true;
    }
    if(strlen($passwort) == 0) {
        echo 'Bitte ein Passwort angeben<br>';
        $error = true;
    }
    if($passwort != $passwort2) {
        echo 'Die Passwörter müssen übereinstimmen<br>';
        $error = true;
    }
    //Überprüfe, dass die E-Mail-Adresse noch nicht registriert wurde
    if(!$error) {
        $statement = $pdo->prepare("SELECT * FROM datenbank WHERE email = :email");
        $result = $statement->execute(array('email' => $email));
        $user = $statement->fetch();
        if($user !== false) {
            echo 'Diese E-Mail-Adresse ist bereits vergeben<br>';
            $error = true;
        }
    }
    //Keine Fehler, wir können den Nutzer registrieren
    if(!$error) {
        $passwort_hash = password_hash($passwort, PASSWORD_DEFAULT);
        $statement = $pdo->prepare("INSERT INTO datenbank (email, passwort) VALUES (:email, :passwort)");
        $result = $statement->execute(array('email' => $email, 'passwort' => $passwort_hash));
        if($result) {
            echo 'Du wurdest erfolgreich registriert. <a href="login.php">Zum Login</a>';
            $showFormular = false;
        } else {
            echo 'Beim Abspeichern ist leider ein Fehler aufgetreten<br>';
        }
    }
}
if($showFormular) {
    ?>

    <!-- REGISTRATION FORM -->
    <div class="text-center" style="padding:50px 0">
        <div class="logo">register</div>
        <!-- Main Form -->
        <div class="login-form-1">
            <form id="register-form" class="text-left">
                <div class="login-form-main-message"></div>
                <div class="main-login-form">
                    <div class="login-group">
                        <div class="form-group">
                            <label for="reg_email" class="sr-only">Email</label>
                            <input type="text" class="form-control" id="reg_email" name="reg_email" placeholder="email">
                        </div>
                        <div class="form-group">
                            <label for="reg_passwort" class="sr-only">Passwort</label>
                            <input type="password" class="form-control" id="reg_passwort" name="reg_passwort" placeholder="passwort">
                        </div>
                        <div class="form-group">
                            <label for="reg_password_confirm" class="sr-only">Passwort bestätigen</label>
                            <input type="password" class="form-control" id="reg_password_confirm" name="reg_password_confirm" placeholder="confirm password">
                        </div>

                        <div class="form-group">
                            <label for="reg_email" class="sr-only">Email</label>
                            <input type="text" class="form-control" id="reg_email" name="reg_email" placeholder="email">
                        </div>
                        <div class="form-group">
                            <label for="reg_fullname" class="sr-only">Full Name</label>
                            <input type="text" class="form-control" id="reg_fullname" name="reg_fullname" placeholder="full name">
                        </div>

                        <div class="form-group login-group-checkbox">
                            <input type="radio" class="" name="reg_gender" id="male" placeholder="username">
                            <label for="male">male</label>

                            <input type="radio" class="" name="reg_gender" id="female" placeholder="username">
                            <label for="female">female</label>
                        </div>

                        <div class="form-group login-group-checkbox">
                            <input type="checkbox" class="" id="reg_agree" name="reg_agree">
                            <label for="reg_agree">i agree with <a href="#">terms</a></label>
                        </div>
                    </div>
                    <button type="submit" class="login-button"><i class="fa fa-chevron-right"></i></button>
                </div>
                <div class="etc-login-form">
                    <p>already have an account? <a href="#">login here</a></p>
                </div>
            </form>
        </div>
        <!-- end:Main Form -->
    </div>

    <?php
} //Ende von if($showFormular)
?>

<script src="login.js"></script>

<footer>
    <div class="container">
        <p>&copy; DropCloud 2018. All Rights Reserved.</p>
        <ul class="list-inline">
            <li class="list-inline-item">
                <a href="#">Impressum</a>
            </li>
            <li class="list-inline-item">
                <a href="#">Über uns</a>
            </li>
            <li class="list-inline-item">
                <a href="#">Hilfe</a>
            </li>
        </ul>
    </div>
</footer>

<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Plugin JavaScript -->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for this template -->
<script src="js/new-age.min.js"></script>

</body>
</html>

