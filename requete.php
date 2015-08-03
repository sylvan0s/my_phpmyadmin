<?php

	//affichage des bases disponibles 
	echo "Veuillez selectionner une base avant d'executer une requête SQL  :";
	try
	{

		// $db = new PDO('mysql:host=localhost;', 'root', 'root');
		$db = new PDO('mysql:host=localhost;', 'root', '');
 	
 		$q = $db->query('SHOW DATABASES');
	}
	catch (PDOException $e) {
    echo 'Echec de la connexion : ' . $e->getMessage();
    exit;
	}
 		while ($donnees = $q->fetch()) {
	    echo '<li><a href="dashboard.php?sql=' . $donnees[$count] . '">' . $donnees[$count] . '</a></li>';
		$nbDB++;
	}
 echo "<br/>";



echo "<p> Exécuter une requête SQL sur la base " .$_GET["sql"].":</p>"

?>

<!DOCTYPE html>
<html lang="fr">
<body>
	<div  class="formulaire_requete"> 
						<FORM method ="post" >
						<TEXTAREA name="req" rows="10" cols="15" value='req'></TEXTAREA>
						<button type="submit" name="execute" value="Excuter" >Executer</button> 
						</FORM>
	</div>
</body>
</html>

<?php
//gestion du  formulaire de requete sql 
if(isset($_POST['execute']) && $_POST['execute'] == 'Excuter')
{
	if(((isset($_POST['req']) && !empty($_POST['req']))))
	{
	
		try
		{
			// $db = new PDO('mysql:host=localhost;dbname=' . $_GET["sql"] . ';', 'root', 'root');
			$db = new PDO('mysql:host=localhost;sql=' . $_GET["sql"] . ';', 'root', '');
 			$requete = $_POST['req'];
 			$q = $db->query($requete);
			

		}
			catch (PDOException $e) {
    		echo 'Erreur  : Aucune base sélectionnée ' ;
    		exit;
		}
	
		if ($q == false)
		  echo "Erreur de syntaxe SQL. Merci de corriger ;)";
		else 

		{	
			
		
			 echo "<p>Votre requête SQL a été exécutée avec succès.</p>";
			 echo "<br/>";
			if(!preg_match("#select#", $requete))
  			{

  				if (count($donnees = $q->fetch()) == 1)
  				{  	
  					echo "<p>La base est vide </p>";
  					exit;
  				} 
  				echo " Resulats: ";
			   while ($donnees = $q->fetch()) 
 				{
	    		 echo '<li>'.$donnees[$count].'</li>' ;
				}
			 }
			 else 
			 { 

			 	$donnees = $q->fetch();
				$totalColumns = $q->columnCount();

				$nbLignes = (count($donnees) / 2);

				echo "Colonnes :".$totalColumns."</br>";
				 echo "Lignes:".$nbLignes."</br>"; 

				echo '<table>';

				for ( $j = 0; $j < $totalColumns; $j++ ) {
				    $meta = $request->getColumnMeta($j);
				    $column[] = $meta['name'];
				    echo '<th>' . $column[$j] .'</th>';
				}

				while ($donnees = $request->fetch()) {
					echo '<tr>';
					for ($i = 0; $i < $nbLignes; $i++)
						echo '<td>' . $donnees[$i] . '</td>';
					echo '</tr>';
				}

				echo '</table>';
			
			  }	
		}
	 echo '</br>';
	 $q->closeCursor();
 	}
 	else 
	{
			echo '</br>';
 			echo "Attention le champ est vide";
 			echo '</br>';
 	}
}
?>

