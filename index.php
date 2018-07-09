<?php
session_start();

$bdd = new PDO('mysql:host=localhost;dbname=e-commerce','root','root');

if (isset($_GET['id']) AND $_GET['id'] > 0)
{
  $getid = intval($_GET['id']);
  $requser = $bdd->prepare("SELECT * FROM users WHERE id =?");
  $requser->execute(array($getid));
  $userinfo = $requser->fetch();

}

  $db = new PDO('mysql:host=localhost;dbname=e-commerce', 'root','root');
  $db->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);     
  $db->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION); 



  
  $new = $db->prepare("SELECT * FROM produits ORDER BY id DESC LIMIT 0,4");
  $new->execute();
  $prod = $new->fetchAll();
  echo $prod;
 

?>

<html lang="fr">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <link href="css/style.css" rel="stylesheet" title="Mise en forme par défaut">

    <title>Le sneakerstore</title>
  </head>
  <body>
    <div class="row" id="general">
     <header>
    <nav class="navbar navbar-expand-lg navbar-light ">
  <a class="navbar-brand" href="index.html"><img  id="logo" src="img/logo.jpg"  alt="logo"/></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <form class="form-inline">
    <input class="form-control mr-sm-2" type="search" placeholder="Recherche" aria-label="Recherche">
  </form>
  <div class="collapse navbar-collapse" id="navbarSupportedContent" >
    <ul class="navbar-nav ml-auto">
      <li class="nav-item active">
        <a class="nav-link" href="logout.php">Log out</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="panier.php?id=<?php $_SESSION['id'] ?>"><img id="card" src="img/cart_1.png" alt="image-panier"></a>
      </li>
    </ul>

  </div>
</nav>
</header>
     <div class="row contenu">
      
          <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
              <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
              </ol>
              <div class="carousel-inner">
                <div class="carousel-item active">
                  <img class="d-block w-100" src="img/slide1.jpg" alt="First slide">
                  <div class="carousel-caption d-none d-md-block">
                      <h5>ICI LE H5</h5>
                      <p>ICI LE PARAGRAPHE</p>
                  </div>
                </div>
                <div class="carousel-item">
                  <img class="d-block w-100" src="img/slide2.jpg" alt="Second slide">
                  <div class="carousel-caption d-none d-md-block">
                      <h5>ICI LE H5</h5>
                      <p>ICI LE PARAGRAPHE</p>
                  </div>
                </div>
                <div class="carousel-item">
                  <img class="d-block w-100" src="img/slide3.jpg" alt="Third slide">
                  <div class="carousel-caption d-none d-md-block">
                      <h5>ICI LE H5</h5>
                      <p> ICI LE PARAGRAPHE</p>
                  </div>
                </div>
              </div>
              <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
              </a>
              <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
              </a>
          </div>
          <div class="row index-produit">
            <h1 id="produit">Products</h1>
          <div class="card-group">



          <?php
            foreach ($prod as $p )  {
          ?>
              <div class="card">
                <img class="card-img-top" src="admin/imgs/<?php echo str_replace("ECO/ECO/admin/imgs", "", $p[img]); ?>" alt="Card image cap">
                <div class="card-body">
                  <h5 class="card-title"><?php echo $p["name"]; ?></h5>
                  <p class="card-text"><?php echo $p["prix"]; ?> €</p>
                  <div class="detailprod"><a href="produc.php?produc=<?php echo $p->name; ?>"><button type="button" class="btn">Voir détail</button></a></div>
                </div>
              </div>

          <?php
            }
          ?>




         </div>
          </div>
      
     </div> 
     <footer id="footer" class="row">
  <div class="social col-6">
    <p>Retrouver nous sur nos reseaux</p>
    <ul id="icons">
      <li>
          <a href="https://www.youtube.com/" ><img class="icon" src="img/youtube.png" alt="youtube" /></a>
      </li>
      <li>
          <a href="mail" ><img  class="icon" src="img/messenger.png" alt="messenger"   /></a>
      </li>
      <li>
          <a href="https://twitter.com/" ><img class="icon" src="img/twitter.png" alt="twitter"   /></a>
      </li>
      <li>
          <a href="https://www.linkedin.com/" ><img class="icon" src="img/linkedin.png" alt="linkedin"   /></a>
      </li>
      <li>
          <a href="https://www.facebook.com/" ><img class="icon" src="img/facebook.png" alt="facebook"  /></a>
      </li>
      <li>
          <a href="https://www.instagram.com/" ><img class="icon" src="img/instagram.png" alt="instagram"  /></a>
      </li>
      

    </ul>
  </div>
    <div class="faq col-6">
        <ul>
            <li> <a href="#">Plan du site</a> </li>
            <li> <a href="#">Mention légale</a> </li>
            <li> <a href="#">Condition général</a> </li>
            <li> <a href="#">Condition de ventes</a> </li>
        </ul>
    </div>
</footer>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
  </body>
</html>



















<?php




?>


