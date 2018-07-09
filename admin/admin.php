<?php
session_start();

if(isset($_SESSION['username']))
{
	if(isset($_GET['action']))
	{
		if ($_GET['action']=='add') 
		{
			if (isset($_POST['submit']))
			{
				$name=$_POST['name'];
				$description=$_POST['description'];
				$stock=$_POST['stock'];
				$prix=$_POST['prix'];

				$db = new PDO('mysql:host=localhost;dbname=e-commerce', 'root','root');
				
				$img="ECO/ECO/admin/imgs".$_FILES['img']['name'];

				$img_tmp=$_FILES['img']['tmp_name'];

				if(!empty($img_tmp))
				{
					$image = explode('.', $img);
					$image_ext =end($image);
					if(in_array(strtolower($image_ext),array ('png','jpeg','jpg')) === false)
					{
						echo "Les extension surpporter son .png, .jpeg et .jpg";
					}
					else
					{
						$img_size = getimagesize($img_tmp);

						if ($img_size['mime']=='image/jpeg')
						{
							$img_src = imagecreatefromjpeg($img_tmp);
						}
						else if ($img_size['mime']=='image/png')
						{
							$img_src = imagecreatefrompng($img_tmp);
						}
						else
						{
							$img_src = false;
							echo "l'image et no valide";
						}
						if ($img_src!== false)
						{
							$img_width=150;

							if ($img_size[0]==$img_width) 
							{
								$img_final = $img_src;
							}
							else
							{
								$new_width[0]=$img_width;
								$new_height[1]=150;

								$img_final =imagecreatetruecolor($new_width[0],$new_height[1]);
								imagecopyresampled($img_final, $img_src, 0, 0, 0, 0,$new_width[0], $new_height[1], $img_size[0], $img_size[1]);
							}
							imagejpeg($img_final,'imgs/'.$name.'.jpeg');
						}
					}
				}
				else
				{
					echo "Rentré une image";
				}

				if ($name&&$description&&$stock&&$prix) 
				{
					$db = new PDO('mysql:host=localhost;dbname=e-commerce', 'root','root');
					$db->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER); // les noms de champs seront en caractères minuscules
					$db->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION); // les erreurs lanceront des exceptions

					$insert = $db->prepare("INSERT INTO produits (name, description, prix, stock, img ) VALUES('$name','$description','$prix','$stock', '$img')");
					$insert->execute();

				}
				else
				{
					echo "Veillez remplire tous les champs";
				}
			}
			?>
			<form action="" method="post" enctype="multipart/form-data">
					<h3>Nom du produit :</h3><input type="text" name="name" >
					<h3>Description :</h3><textarea  name="description"> </textarea>
					<h3>Prix :</h3><input type="text" name="prix">
					<h3>Stock :</h3><input type="text" name="stock">
					<h3>image :</h3><input type="file" name="img">

					<br><br><br>
					
					<input type="submit" name="submit">
				
			</form>
			<?php
		}
		else if ($_GET['action']=='modifyandsupp') 
		{
			$db = new PDO('mysql:host=localhost;dbname=e-commerce', 'root','root');
			$db->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER); 		
			$db->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION); 
			
			$select = $db->prepare("SELECT * FROM produits");
			$select->execute();

			while ($s=$select->fetch(PDO:: FETCH_OBJ)) 
			{
				echo $s->name;
				?>
				<a href="?action=modify&amp;id=<?php echo $s->id; ?>">Modifier </a>
				<a href="?action=supp&amp;id=<?php echo $s->id; ?>">Supprimer </a> <br><br>
				<?php
			}
		}
		else if ($_GET['action']=='supp')
		{
			$db = new PDO('mysql:host=localhost;dbname=e-commerce', 'root','root');
			$db->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER); 		
			$db->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION); 
			
			$id=$_GET['id'];
			$supp = $db->prepare("DELETE  FROM produits WHERE id=$id");
			$supp->execute();

		}
		else if ($_GET['action']=='modify')
		{
			$db = new PDO('mysql:host=localhost;dbname=e-commerce', 'root','root');
			$db->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER); 		
			$db->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION); 
			
			$id=$_GET['id'];
			$modify = $db->prepare("SELECT * FROM produits WHERE id=$id");
			$modify->execute();

			$m =  $modify->fetch(PDO::FETCH_OBJ);
			?>
			<form action="" method="post">
					<h3>Nom du produit :</h3><input type="text" name="name" value="<?php echo $m->name; ?>">
					<h3>Description :</h3><textarea  name="description" ><?php echo $m->description; ?> </textarea>
					<h3>Prix :</h3><input type="text" name="prix"  value="<?php echo $m->prix; ?>">
					<h3>Stock :</h3><input type="text" name="stock" value="<?php echo $m->stock; ?>">
					<br>
					
					<input type="submit" name="submit" value="Modifier">
				
			</form>
			<?php
			if(isset($_POST['submit']))
			{
				$name=$_POST['name'];
				$description=$_POST['description'];
				$stock=$_POST['stock'];
				$prix=$_POST['prix'];

				$update=$db->prepare("UPDATE produits SET name='$name', description='$description', prix='$prix', stock='$stock' WHERE id=$id");
				$update->execute();
			}

		}
		else
		{
			die('ERROR');
		}
	}
}
else
{
	header('Location: ../index.html');
}
?>

<link href="../style/bootstrap.css" type="text/css" rel="stylesheet"/>

<h1>Bienvenue, <?php echo $_SESSION['username']; ?></h1>
<br/>

<a href="?action=add">Ajouter un produit</a><br/><br/>
<a href="?action=modifyandsupp">Supp/Modifierun produit</a><br/><br/>



<a href="../logout">deco</a><br/><br/>

