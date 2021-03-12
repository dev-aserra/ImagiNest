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
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
      $numFotografies = getNumberOfPhotos();

      do {
        $rand = rand(1,$numFotografies);
        $nom = getRandomPhoto($rand);
      }while($nom == $_SESSION['fotografiaNom']);

      $_SESSION['fotografiaNom'] = $nom;    
    }
    else $_SESSION['fotografiaNom'] = buscaUltimaFotografia();
  }

  // Comprova si hi ha algun error amb la pujada d'imatges
  if(isset($_SESSION['uploadImg'])){
    array_push($errors, $_SESSION['uploadImg']);
    unset($_SESSION['uploadImg']);
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
  </head>

  <body class="bg-grey">
    <nav class="navbar navbar-expand navbar-dark bg-dark">
        <div class="container">
          <a class="navbar-brand border-end pe-4" href="<?php dirname(__FILE__) . '/home.php'?>"><img src="./img/favicon.svg" class="img-fluid" width="50"></i></a>
          <img src="./img/logoText.svg" class="d-inline-block align-top" width="120">
          <div>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0" id="navButtons">
              <li class="nav-item">
                <a class="nav-link" href="#"><i class="fas fa-home lead text-white me-3"></i></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-bs-toggle="modal" data-bs-target="#addModal"><i class="fas fa-plus-circle lead text-white me-3"></i></a>
              </li>
              <li id="profile" class="nav-item dropdown">
                <i class="fas fa-user-circle lead text-white nav-link" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"></i>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
                    <li><a class="dropdown-item" href="./logout.php">Tancar sessió</a></li>
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
              <div class="col-lg-8 d-flex align-items-stretch">
                  <div id="img" class="card border-0 w-100 text-center">
                      <div class="card-header text-center">
                        <div class="rating">
                          <input id="rating-5" type="radio" name="rating" value="5"/><i class="fas fa-2x fa-star"></i></label>
                          <input id="rating-4" type="radio" name="rating" value="4" checked /><i class="fas fa-2x fa-star"></i></label>
                          <input id="rating-3" type="radio" name="rating" value="3"/><i class="fas fa-2x fa-star"></i></label>
                          <input id="rating-2" type="radio" name="rating" value="2"/><i class="fas fa-2x fa-star"></i></label>
                          <input id="rating-1" type="radio" name="rating" value="1"/><i class="fas fa-2x fa-star"></i></label>
                        </div>
                      </div>
                      <div class="card-body p-0">
                          <img class="img-fluid rounded-bottom" src="<?php echo "./" . getUrlByPhoto($_SESSION['fotografiaNom'])?>" />
                      </div>
                  </div>
              </div>
              <div class="col-lg-4 d-flex align-items-stretch">
                  <div class="card w-100">
                      <div id="desc" class="card-body">
                          <div class="d-flex justify-content-center pb-3">
                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                              <button type="submit" name="likeBtn" class="btn rounded-circle border border-black me-4">
                                <i class="fas fa-thumbs-up"></i>
                              </button>
                              <button type="submit" name="dislikeBtn" class="btn rounded-circle border border-black ms-4">
                                <i class="fas fa-thumbs-down"></i>
                              </button>
                            </form>
                          </div>
                          <h5 class="fw-bold"><?php echo "@" . getUserByPhoto($_SESSION['fotografiaNom']);?></h5>
                          <p><?php echo date('d/m/Y',strtotime(getDateByPhoto($_SESSION['fotografiaNom'])))?></p>
                          <p class="margin-top-s"><?php echo getDescriptionByPhoto($_SESSION['fotografiaNom'])?><br><?php ?></p>
                      </div>
                  </div>
              </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
    <script>
        var win = $(this);
        var nav = $('#navButtons');
        var navDropdown = $('#profile');
        var mainSection = $('#main');

        function switchNavbar() {
            if (win.width() < 768) {
                nav.removeClass();
                nav.addClass('navbar navbar-expand fixed-bottom navbar-dark mb-0 bg-dark ms-auto list-unstyled d-flex justify-content-center');
                mainSection.removeClass('py-5');
                mainSection.addClass('py-m');
                navDropdown.removeClass('dropdown');
                navDropdown.addClass('dropup');
            } else {
                nav.removeClass('navbar navbar-expand fixed-bottom navbar-dark mb-0 bg-dark ms-auto list-unstyled d-flex justify-content-center');
                nav.addClass('navbar-nav ms-auto mb-2 mb-lg-0');
                mainSection.removeClass('py-m');
                mainSection.addClass('py-5');
                navDropdown.removeClass('dropup');
                navDropdown.addClass('dropdown');
            }
        }

        $(function() {
            switchNavbar();
        });

        $(window).on('resize', function(){
            switchNavbar();
        });

    </script>
    <script type="text/javascript">
        // Mostrar el modal amb id "modal"
        $(document).ready(function(){
            $("#modal").modal("show");
        });
    </script>

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

  </body>
</html>