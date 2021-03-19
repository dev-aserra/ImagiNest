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
    $images = getImageArray();
    if(empty($images))
    {
      $noPhotos = true;
    }
    else
    {
      if($_SERVER["REQUEST_METHOD"] == "POST")
      {
        if(isset($_POST['likeBtn'])) 
        {
          if(is_bool(votacioUsuari(getUserId($_SESSION['username']),$_SESSION['fotografiaNom'])))
          {
            incrementaLike($_SESSION['fotografiaNom']);
            guardaVotacio(1,getUserId($_SESSION['username']),$_SESSION['fotografiaNom']);
            actualitzaPuntuacio($_SESSION['fotografiaNom']);
        }
        else 
        {
          if(votacioUsuari(getUserId($_SESSION['username']),$_SESSION['fotografiaNom']) == 0)
          {
            incrementaLike($_SESSION['fotografiaNom']);
            decrementaDislike($_SESSION['fotografiaNom']);
            actualitzaVotacio(1,getUserId($_SESSION['username']),$_SESSION['fotografiaNom']);
            actualitzaPuntuacio($_SESSION['fotografiaNom']);
          }
        }
        }
        elseif(isset($_POST['dislikeBtn'])) {
          if(is_bool(votacioUsuari(getUserId($_SESSION['username']),$_SESSION['fotografiaNom'])))
          {
            incrementaDislike($_SESSION['fotografiaNom']);
            guardaVotacio(0,getUserId($_SESSION['username']),$_SESSION['fotografiaNom']);
            actualitzaPuntuacio($_SESSION['fotografiaNom']);
          }
          else {
            if(votacioUsuari(getUserId($_SESSION['username']),$_SESSION['fotografiaNom']) == 1)
            {
              incrementaDislike($_SESSION['fotografiaNom']);
              decrementaLike($_SESSION['fotografiaNom']);
              actualitzaVotacio(0,getUserId($_SESSION['username']),$_SESSION['fotografiaNom']);
              actualitzaPuntuacio($_SESSION['fotografiaNom']);
            }
          }
        }

        $numFotografies = getNumberOfPhotos();

        if($numFotografies > 1) 
        {
          do {
            $rand = rand(1,$numFotografies);
            $nom = getRandomPhoto($rand);
          }while($nom == $_SESSION['fotografiaNom']);
    
          $_SESSION['fotografiaNom'] = $nom;  
        }
      }else $_SESSION['fotografiaNom'] = buscaUltimaFotografia();

        $puntuacio = getPhotoRating($_SESSION['fotografiaNom']);
        $puntuacioMitja = floor($puntuacio);
        $estrelles = 5;
        $meitat = 0;
      }

    // Comprova si hi ha algun error amb la pujada d'imatges
    if(isset($_SESSION['uploadImg'])){
      array_push($errors, $_SESSION['uploadImg']);
      unset($_SESSION['uploadImg']);
    }

    if(isset($_SESSION['deleteImg'])){
      array_push($errors, $_SESSION['deleteImg']);
      unset($_SESSION['deleteImg']);
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
              <div class="col-lg-8 d-flex align-items-stretch">
                  <div class="card border-0 w-100 text-center">
                      <div class="card-header text-center">
                        <div class="rating">
                          <?php
                            if(isset($noPhotos))
                            {
                              for ($i = 0; $i < 5; $i++)
                              {
                                echo '<i class="far fa-2x fa-star"></i>';
                              }
                            }
                            else
                            {
                              if ($puntuacio == 0)
                              {
                                for ($i = 0; $i < $estrelles; $i++)
                                {
                                  echo '<i class="far fa-2x fa-star"></i>';
                                }
                              }
                              else{
                                for ($i = 0; $i < floor($puntuacioMitja); $i++)
                                {
                                  $estrelles--;
                                  echo '<i class="fas fa-2x fa-star"></i>';
                                }

                                if ($puntuacio - floor($puntuacioMitja) >= 0.5)
                                {
                                  $estrelles--;
                                  $meitat = 1;
                                  echo '<i class="fas fa-2x fa-star-half-alt"></i>';
                                }

                                for ($i = 0; $i < (ceil(5-$puntuacioMitja) - $meitat); $i++)
                                {
                                  echo '<i class="far fa-2x fa-star"></i>';
                                }

                              }
                            }
                            
                          ?>
                        </div>
                      </div>
                      <div class="card-body p-0">
                          <?php if(!isset($noPhotos)) : ?>
                            <img class="img-fluid" src="<?php echo "./" . getUrlByPhoto($_SESSION['fotografiaNom'])?>" />
                          <?php else:?>
                            <h5 class="mt-4">Encara no s'ha penjat cap imatge a la plataforma!</h5>
                          <?php endif; ?>
                      </div>
                  </div>
              </div>
              <div class="col-lg-4 d-flex align-items-stretch">
                  <div class="card w-100">
                      <div id="desc" class="card-body">
                          <div class="d-flex justify-content-center pb-3">
                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                              <button type="submit" name="likeBtn" class="btn rounded-circle border border-black <?php if(!isset($noPhotos)){if(votacioUsuari(getUserId($_SESSION['username']),$_SESSION['fotografiaNom']) == 1) echo "btn-primary";} ?>" <?php if(isset($noPhotos)) echo "disabled";?> >
                                <i class="fas fa-thumbs-up"></i>
                              </button>
                              <button type="submit" name="dislikeBtn" class="btn rounded-circle border border-black ms-5 <?php if(!isset($noPhotos)){if(votacioUsuari(getUserId($_SESSION['username']),$_SESSION['fotografiaNom']) == 0 && votacioUsuari(getUserId($_SESSION['username']),$_SESSION['fotografiaNom']) !== false) echo "btn-primary";} ?>" <?php if(isset($noPhotos)) echo "disabled";?> >
                                <i class="fas fa-thumbs-down"></i>
                              </button>
                            </form>
                          </div>
                          <?php if(!isset($noPhotos)) echo '<a class="text-decoration-none" href="./profile.php?user="'.getUserByPhoto($_SESSION['fotografiaNom']).'><h5 class="fw-bold">@'.getUserByPhoto($_SESSION['fotografiaNom']).'</h5></a>';?>
                          <p><?php if(!isset($noPhotos)) echo date('d/m/Y',strtotime(getDateByPhoto($_SESSION['fotografiaNom'])))?></p>
                          <p><?php if(!isset($noPhotos)) echo getDescriptionByPhoto($_SESSION['fotografiaNom'])?><br><?php ?></p>
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

  </body>
</html>