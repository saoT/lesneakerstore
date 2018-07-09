<?php

function creationPanier(){
   $db = new PDO('mysql:host=localhost;dbname=e-commerce', 'root','root');

   if (!isset($_SESSION['panier'])){
      $_SESSION['panier']=array();
      $_SESSION['panier']['nomProduit'] = array();
      $_SESSION['panier']['qteProduit'] = array();
      $_SESSION['panier']['prixProduit'] = array();
      $_SESSION['panier']['verrou'] = false;
      $select = $db->query("SELECT tva FROM products");
      $data = $select->fetch(PDO::FETCH_OBJ);
      $_SESSION['panier']['tva'] = $data->tva;
   }
   return true;
}

function ajouterArticle($nomProduit,$qteProduit,$prixProduit){
   $db = new PDO('mysql:host=localhost;dbname=e-commerce', 'root','root');

   if (creationPanier() && !isVerrouille())
   {
      $positionProduit = array_search($nomProduit,  $_SESSION['panier']['nomProduit']);

      if ($positionProduit !== false)
      {
         $_SESSION['panier']['qteProduit'][$positionProduit] += $qteProduit ;
      }
      else
      {  
         array_push( $_SESSION['panier']['nomPmProduit'],$nomProduit);
         array_push( $_SESSION['panier']['qteProduit'],$qteProduit);
         array_push( $_SESSION['panier']['prixProduit'],$prixProduit);
      }
   }
   else
   {
      echo "Un problème est survenu veuillez contacter l'administrateur du site.";
   }
}

function modifierQTeArticle($slugProduit,$qteProduit){
   //Si le panier éxiste
   if (creationPanier() && !isVerrouille())
   {
      //Si la quantité est positive on modifie sinon on supprime l'article
      if ($qteProduit > 0)
      {
         //Recharche du produit dans le panier
         $positionProduit = array_search($_SESSION['panier']['nomProduit']);

         if ($positionProduit !== false)
         {
            $_SESSION['panier']['qteProduit'][$positionProduit] = $qteProduit ;
         }
      }
      else
      {
         supprimerArticle($nomProduit);
      }
   }
   else{
   echo "Un problème est survenu veuillez contacter l'administrateur du site.";
   }
}

function supprimerArticle($nomProduit){

   if (creationPanier() && !isVerrouille())
   {
      $tmp = array();
      $tmp['nomProduit'] = array();
      $tmp['qteProduit'] = array();
      $tmp['prixProduit'] = array();
      $tmp['verrou'] = array();
      for($i = 0; $i < count($_SESSION['panier']['nomProduit']); $i++)
      {
         if ($_SESSION['panier']['nomProduit'][$i] !== $nomProduit)
         {
            array_push( $_SESSION['panier']['nomProduit'],$_SESSION['panier']['nomProduit'][$i]);
            array_push( $_SESSION['panier']['qteProduit'],$_SESSION['panier']['qteProduit'][$i]);
            array_push( $_SESSION['panier']['prixProduit'],$_SESSION['panier']['prixProduit'][$i]);
         }


      }
      $_SESSION['panier'] = $tmp;
      unset($tmp);

   }
   else
   {
      echo "Un problème est survenu veuillez contacter l'administrateur du site.";
   }
}

function MontantGlobal(){
   $total=0;
   for($i = 0; $i < count($_SESSION['panier']['slugProduit']); $i++)
   {
      $total += $_SESSION['panier']['qteProduit'][$i] * $_SESSION['panier']['prixProduit'][$i];
   }
   return $total;
}

function MontantGlobalTva(){

   $total=0;
   for($i = 0; $i < count($_SESSION['panier']['slugProduit']); $i++)
   {
      $total += $_SESSION['panier']['qteProduit'][$i] * $_SESSION['panier']['prixProduit'][$i];
   }
   return $total + $total*$_SESSION['panier']['tva']/100;
}

function supprimerPanier()
{
   unset($_SESSION['panier']);
}

function isVerrouille()
{
    if (isset($_SESSION['panier']) && $_SESSION['isVerrouille'])
   {
      return true;
   }
   else
   {
      return false;
   }  
}

function compterArticles()
{
   if (isset($_SESSION['panier']))
   {
      return count($_SESSION['panier']['nomProduit']);
   }
   else
   {
      return 0;
   }

}

?>