<?php include 'lib/server.php';?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registre</title>
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
                        <h1 class="fw-bold mb-4">Registre</h1>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="mb-5">
                            <?php include 'lib/errors.php';?>
                            <div class="mb-4">
                                <label for="username" class="form-label fw-bold">Nom d'usuari</label>
                                <input type="text" name="username" class="form-control bg-dark-x border-0 mb-2" id="username" placeholder="Introdueix un nom d'usuari" required>
                            </div>
                            <div class="mb-4">
                                <label for="email" class="form-label fw-bold">Correu electrònic</label>
                                <input type="email" name="email" class="form-control bg-dark-x border-0 mb-2" id="email" placeholder="Introdueix un correu electrònic" required>
                            </div>
                            <div class="mb-4">
                                <label for="firstName" class="form-label fw-bold">Nom</label>
                                <input type="text" name="firstName" class="form-control bg-dark-x border-0 mb-2" id="firstName" placeholder="Introdueix el teu nom">
                            </div>
                            <div class="mb-4">
                                <label for="lastName" class="form-label fw-bold">Cognoms</label>
                                <input type="text" name="lastName" class="form-control bg-dark-x border-0 mb-2" id="lastName" placeholder="Introdueix els teus cognoms">
                            </div>
                            <div class="mb-4">
                                <label for="pass" class="form-label fw-bold">Contrasenya</label>
                                <input type="password" name="pass" class="form-control bg-dark-x border-0 mb-2" id="pass" placeholder="Introdueix una contrasenya" required>
                            </div>
                            <div class="mb-4">
                                <label for="verifypass" class="form-label fw-bold">Verificar Contrasenya</label>
                                <input type="password" name="verifypass" class="form-control bg-dark-x border-0 mb-2" id="verifypass" placeholder="Torna a introduir la contrasenya" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 fw-bold" name="register">Registre</button>
                        </form>
                    </div>
                    <div class="text-center px-lg-5 pt-lg-3 pb-lg-4 p-4 w-100 mt-auto">
                        <p class="d-inline-block mb-0">Ja tens cap compte?</p><a href="./index.php" class="text-light fw-bold text-decoration-none"> Inicia sessió aquí</a>
                    </div>
                </div>
            </div>
        </section>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
    </body>
</html>
