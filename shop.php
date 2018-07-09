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



  
  $new = $db->prepare("SELECT * FROM produits ");
  $new->execute();



  while ($n=$new->fetch(PDO::FETCH_OBJ))
  {
    ?>
    <h1><?php echo $n->name; ?></h1>
    <h1><?php echo $n->description; ?></h1>
    <h1><?php echo $n->prix; ?></h1>
    <h1><?php echo $n->img; ?></h1>
    <a href="produc.php?produc=<?php echo $n->name; ?>"><button type="button" class="btn">Voir détail</button></a>

    <br><br>
<br>


    <?php
  }

 



?>


