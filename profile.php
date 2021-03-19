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
      if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['user']) && !empty($_GET['user']))
      {
        $username = $_GET['user'];
        if(existeixUsername($username)) $images = getImageArrayByUser(getUserId($_GET['user']));
        else $errorUsuari = "No existeix aquest usuari!";
      }      
      else
      {
        $images = getImageArrayByUser(getUserId($_SESSION['username']));
        $username = $_SESSION['username'];
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
                        <div class="my-3 p-3 bg-white rounded">
                            <h4 class="border-bottom pb-2 mb-0 fw-bold">Perfil de <?php echo "@".$username ?></h4>
                        </div>
                        <div class="images text-center pb-4">
                            <?php if(empty($images)):?>
                              <?php if(isset($errorUsuari)):?>
                                <h5><?$errorUsuari?></h5>
                              <?php else:?>
                                <h5>Encara no has penjat cap imatge!</h5>
                              <?php endif; ?>
                            <?php else:?>
                              <?php foreach ($images as $image): ?>
                                <?php if (file_exists($image['url'])): ?>
                                <a href="#" class="text-decoration-none">
                                    <img src="<?=$image['url']?>" data-url="<?=$image['url']?>" data-descripcio="<?=$image['descripcio']?>" data-userlogged="<?=(isset($_SESSION['username'])) ? $_SESSION['username']: ""; ?>" data-id="<?=getUsernameById($image['usuariId'])?>" data-date="<?= date('d/m/Y',strtotime($image['data']))?>" width="300" height="200" class="pb-1" data-bs-toggle="modal" data-bs-target="#imageModal">
                                </a>
                                <?php endif; ?>
                              <?php endforeach; ?>
                            <?php endif; ?>
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
    <script src="./js/gallery.js"></script>
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