<?php include 'lib/server.php'?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inici Sessió</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Spartan:wght@300;600&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link href="./css/styles.css" type="text/css" rel="stylesheet">
</head>
    <body class="bg-dark">
        <section>
            <div class="row g-0">
                <div class="col-lg-7 d-none d-lg-block background">
                    <div class="img-1 min-vh-100 active"></div>
                </div>
                <div class="col-lg-5 d-flex flex-column align-items-end min-vh-100">
                    <div class="px-lg-5 pt-lg-4 pb-lg-3 p-4 w-50 mb-auto">
                        <img src="./img/logo.svg" class="img-fluid">
                    </div>
                    <div class="px-lg-5 py-lg-4 p-4 w-100 mb-auto">
                        <h1 class="fw-bold mb-4">Benvingut de nou</h1>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="mb-5">
                            <?php include 'lib/errors.php';?>
                            <?php if (isset($_SESSION['success'])) {?><div class="alert alert-success pt-0 pb-0 pl-1 pr-1" role="alert"><p class="pt-3"><?php echo $_SESSION['success'] ?></p></div><?php }unset($_SESSION['success']);?>
                            <div class="mb-4">
                                <label for="userMail" class="form-label fw-bold">Usuari/Correu</label>
                                <input type="text" name="userMail" class="form-control bg-dark-x border-0" id="userMail" placeholder="Introdueix el teu Usuari/Correu">
                            </div>
                            <div class="mb-4">
                                <label for="pass" class="form-label fw-bold">Contrasenya</label>
                                <input type="password" name="pass" id="pass" class="form-control bg-dark-x border-0 mb-2" placeholder="Introdueix la teva contrasenya">
                                <a href="#" class="form-text text-muted text-decoration-none">Has oblidat la teva contrasenya?</a>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 fw-bold" name="login">Iniciar sessió</button>
                        </form>
                    </div>
                    <div class="text-center px-lg-5 pt-lg-3 pb-lg-4 p-4 w-100 mt-auto">
                        <p class="d-inline-block mb-0">No tens cap compte?</p><a href="./register.php" class="text-light fw-bold text-decoration-none"> Registra't aquí</a>
                    </div>
                </div>
            </div>
        </section>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
    </body>
</html>
