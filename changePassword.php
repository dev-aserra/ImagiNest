<?php
  session_start();
  include dirname(__FILE__) . "\\" . '\lib\statements.php';
  
  $errors = array();

  // Si no s'ha loginat, retorna a index.php
  if (!isset($_SESSION['username'])) {
      header('Location: index.php');
      exit;
  }
  else {
    if (isset($_POST['chgPassword'])) {
        $currentPassword = filter_input(INPUT_POST, 'oldPwd');
        $newPassword = filter_input(INPUT_POST, 'newPwd');
        $verifyNewPassword = filter_input(INPUT_POST, 'vNewPwd');

        $currentUser = $_SESSION['username'];

        if(!empty($currentPassword) && !empty($newPassword) && !empty($verifyNewPassword)) {
            if(!comprovaContrasenya($currentUser,$currentPassword)) array_push($errors, "La contrasenya actual no és correcte");
            else {
                if (!preg_match("/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{6,20}$/", $newPassword)) {
                    array_push($errors, "La contrasenya hauria de tenir entre 6 i 20 caràcters i contenir almenys un caràcter especial, una minúscula, una majúscula i un dígit");
                }
                elseif ($newPassword != $verifyNewPassword) array_push($errors, "Les contrasenyes no coincideixen");
                elseif($newPassword == $currentPassword) array_push($errors, "La nova contrasenya no pot ser igual a l'actual");
                else {
                    $password_hash = password_hash($newPassword, PASSWORD_DEFAULT);
                    actualitzarContrasenyaSettings($currentUser,$password_hash);
                    $_SESSION['success'] = "S'ha actualitzat correctament la contrasenya";
                } 
            }
        }
    }
  }

?>
<!DOCTYPE html>
<html lang="ca">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ImagiNest</title>
    <link rel="shortcut icon" href="./img/favicon.svg" type="image/x-icon"/>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
    <link href="https://fonts.googleapis.com/css2?family=Spartan:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/home.css">
    <link rel="stylesheet" href="./css/preloader.css">
  </head>

  <body class="bg-grey">
    <nav class="navbar navbar-expand navbar-dark bg-dark">
        <div class="container">
          <a class="navbar-brand border-end pe-4" href="./home.php"><img src="./img/favicon.svg" class="img-fluid" width="50"></i></a>
          <img src="./img/logoText.svg" class="d-inline-block align-top" width="120">
          <div>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0" id="navButtons">
              <li class="nav-item">
                <a class="nav-link" href="./home.php"><i class="fas fa-home lead text-white me-3"></i></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-bs-toggle="modal" data-bs-target="#addModal"><i class="fas fa-plus-circle lead text-white me-3"></i></a>
              </li>
              <li id="profile" class="nav-item dropdown">
                <i class="fas fa-user-circle lead text-white nav-link" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"></i>
                <ul class="dropdown-menu dropdown-menu-end shadow-lg" aria-labelledby="dropdownMenuButton1">
                    <div id="square" class="square"></div>
                    <li><p id="dropdownUsername" class="fw-bold"><?php echo "@".$_SESSION['username']; ?></p></li>
                    <li><a class="dropdown-item" href="./profile.php"><i class="fas fa-user-circle pe-2"></i>Perfil</a></li>
                    <li><a class="dropdown-item" href="./explore.php"><i class="fas fa-search pe-2"></i>Explora</a></li>
                    <li><a class="dropdown-item" href="./settings.php"><i class="fas fa-cog pe-2"></i>Configuració</a></li>
                    <hr>
                    <li><a class="dropdown-item" href="./logout.php"><i class="fas fa-sign-out-alt pe-2"></i>Tancar sessió</a></li>
                </ul>
              </li>
            </ul>
          </div>
        </div>
    </nav>
    <section id="main" class="py-5">
      <?php include 'lib/errors.php';?>
        <div class="container">
          <?php if (isset($_SESSION['success'])) {?><div class="my-3 alert alert-success pt-0 pb-0 pl-1 pr-1" role="alert"><p class="pt-3"><?php echo $_SESSION['success'] ?></p></div><?php }unset($_SESSION['success']);?>
            <div class="row">
              <div class="col-lg-12">
                <div class="card border-0">
                    <div class="card-body p-0">
                        <div class="m-3 p-3 bg-white d-flex justify-content-between border-bottom">
                          <div>
                              <h4 class="pb-2 mb-0 fw-bold">Contrasenya</h4>
                          </div>
                          <div id="settingsIcons" class="justify-content-between">
                              <a class="text-decoration-none float-end ps-3" href="./deleteAccount.php"><i class="fas fa-2x fa-trash-alt"></i></a>
                              <a class="text-decoration-none float-end ps-3" href="./changePassword.php"><i class="fas fa-2x fa-key"></i></a>
                              <a class="text-decoration-none float-end" href="./settings.php"><i class="fas fa-2x fa-wrench"></i></a>
                          </div>
                        </div>
                        <div class="container">
                            <div class="row">
                                <div class="col-12 div-wrapper d-flex flex-column justify-content-center align-items-center">
                                    <h5 class="pb-2 mb-0 fw-bold"><?php echo "@".$_SESSION['username']; ?></h5>
                                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="mt-2 mb-5 w-75">
                                        <?php include 'lib/errors.php';?>
                                        <?php if (isset($_SESSION['success'])) {?><div class="alert alert-success pt-0 pb-0 pl-1 pr-1" role="alert"><p class="pt-3"><?php echo $_SESSION['success'] ?></p></div><?php }unset($_SESSION['success']);?>
                                        <div class="mb-4">
                                          <label for="oldPwd" class="form-label fw-bold">Contrasenya actual</label>
                                          <input id="oldPwd" class="form-control border rounded" type="password" name="oldPwd">
                                        </div>
                                        <div class="mb-4">
                                            <label for="newPwd" class="form-label fw-bold">Nova contrasenya</label>
                                            <input id="newPwd" class="form-control border rounded" type="password" name="newPwd">
                                        </div>
                                        <div class="mb-4">
                                            <label for="vNewPwd" class="form-label fw-bold">Verificar nova contrasenya</label>
                                            <input id="vNewPwd" class="form-control border rounded" type="password" name="vNewPwd">
                                        </div>
                                        <button type="submit" class="btn btn-primary w-100 fw-bold" name="chgPassword">Canviar contrasenya</button>
                                      </form>
                              </div>
                          </div>
                      </div>
                  </div>
                </div>
              </div>
          </div>
      </section>
      <div class="preloader js-preloader flex-center">
        <div class="dots">
          <div class="dot"></div>
          <div class="dot"></div>
          <div class="dot"></div>
        </div>
      </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
    <script src="./js/my.js"></script>
    <script src="./js/settings.js"></script>
    <script src="./js/preloader.js"></script>

    <div id="addModal" class="modal text-white" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content bg-dark">
          <div class="modal-header border-bottom-0">
            <h5 class="modal-title fw-bold">Puja una imatge</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="col-md-12">
              <div class="panel panel-default">
                <div class="panel-body">
                  <div>
                    <div class="panel-body">
                      <form action="./uploadImage.php" id="uploadImg" method="POST" class="mb-3" autocomplete="off"  enctype="multipart/form-data">
                        <div class="mb-4">
                          <label for="imatge">Imatge</label>
                          <input type="file" name="imatge" class="form-control border-0 mb-2" id="imatge">
                          <label for="descripcio">Descripció</label>
                          <textarea maxlength="255" rows="6" class="w-100 rounded mb-2" name="descripcio" form="uploadImg" placeholder="Escriu la descripció..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 fw-bold" name="updImg">Puja la imatge</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div id="imageModal" class="modal" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-body image-popup m-3">
          </div>
        </div>
      </div>
    </div>

  </body>
</html>