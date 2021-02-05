<?php
session_start();

// Si no s'ha loginat, retorna a index.php
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ImagiNest</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Spartan:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link href="./css/offcanvas.css" rel="stylesheet">
    <link rel="shortcut icon" href="./img/favicon.svg" type="image/x-icon"/>
</head>
    <body class="bg-light">
        <nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark" aria-label="Main navigation">
            <div class="container-fluid">
                <img src="./img/logo.svg" class="d-inline-block align-top" width="120">
                <button class="navbar-toggler p-0 border-0" type="button" data-bs-toggle="offcanvas" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="navbar-collapse offcanvas-collapse">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <!-- Possible ampliació -->
                        <!--<li class="nav-item active">
                            <a class="nav-link" aria-current="page" href="#">Inici</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Notifications</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Perfil</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-bs-toggle="dropdown" aria-expanded="false">Configuració</a>
                            <ul class="dropdown-menu" aria-labelledby="dropdown01">
                                <li><a class="dropdown-item" href="#">Action</a></li>
                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                            </ul>
                        </li>-->
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="./logout.php">Tancar Sessió</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Possible ampliació -->
        <!--<div class="nav-scroller bg-white shadow-sm">
            <nav class="nav nav-underline" aria-label="Secondary navigation">
                <a class="nav-link active" aria-current="page" href="#">Inici</a>
                <a class="nav-link" href="#">
                    Amics
                    <span class="badge bg-light text-dark rounded-pill align-text-bottom">27</span>
                </a>
                <a class="nav-link" href="#">Explorar</a>
                <a class="nav-link" href="#">Suggerències</a>
            </nav>
        </div>-->
        
        <main class="container">
            <?php if (isset($_SESSION['success'])) {?><div class="my-3 alert alert-success pt-0 pb-0 pl-1 pr-1" role="alert"><p class="pt-3"><?php echo $_SESSION['success'] ?></p></div><?php }unset($_SESSION['success']);?>

            <div class="my-3 p-3 bg-white rounded shadow-sm">
                <h6 class="border-bottom pb-2 mb-0">Inici</h6>
                <div class="d-flex text-muted pt-3">
                    <p>Benvingut, <strong><?=$_SESSION['username']?></strong>!</p>
                </div>
            </div>
        </main>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
        <script src="./scripts/offcanvas.js"></script>
    </body>
</html>
