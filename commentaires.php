<h1>Bienvenue sur mon site internet:</h1>


<?php
	
				
				if(!isset($_SESSION)) 
    			{ 
        			session_start(); 
    			} 
    			
				if (isset($_SESSION['id']) AND isset($_SESSION['pseudo'])){
					
					echo '<form class="com" method="POST" action="BD/commentaire-ajout.php">
						<textarea name="commentaire" placeholder="Votre commentaire..."></textarea><br />
						<input type="hidden" name="page" value='.$page.' />
						<input type="submit" value="Poster mon commentaire" name="submit_commentaire" />
						</form>';
						
				}else
				{
					echo 'Vous devez vous inscrire sur le site pour écrire un message';
				}
			?>	

			<h2>Commentaires:</h2>
    
			<?php
				error_reporting(E_ALL);

				try
				{
					/* creation de la BD */
					$db = new PDO("sqlite:./BD/commentaires.sqlite");
					/* errors -> exceptions */
					$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					/* requete de selection */
					
					
					$requete = $db->prepare("SELECT * FROM commentaire WHERE page=:page ORDER BY id DESC");
					
					$requete->execute(array("page"=>$page,));
					unset($db);
					while($row = $requete->fetch())
					{
						echo '<div class="pseudo"> <p>'.$row['pseudo']. ':</div> <div class="commentaire">' .$row['texte']. '</p> </div>';
						if(!isset($_SESSION)) 
    					{ 
        					session_start(); 
    					} 
						if ($_SESSION['admin']=="oui"){
						echo '<form class="com" method="POST" action="php/supprimer-commentaire.php">
							<input type="hidden" name="choixid" value='.$row['id'].' />
							<input type="submit" value="supprimer" name="supprimer" />
							</form>';
						}
					}
				}
				catch(Exception $e)
				{
					echo $e->getMessage();
				}
			?>
