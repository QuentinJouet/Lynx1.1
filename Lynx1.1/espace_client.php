<?php 
require_once("ressources/session.php");
require_once("ressources/fonctions.php");
confirm_logged_in();
require_once("ressources/connection.php");

include('includes/header.php');
include('includes/sidebar.php');
?>

            
        
        <div class="nine columns" id="contenu"> 
            <div class="row">
                      <?php
                     dates_session_from_post();
                     ?>
                        <div class="ten columns centered panel" style="margin-bottom:10px; margin-top:10px;">
                        <h5 style="text-align:center;">Choix de la periode à analyser</h5>
                        		        <form class="nice" method="post" id="login_index">
                                        <input type="text" placeholder="<?php echo 'Du : ';echo $_SESSION['date_debut']; ?>" class="input-text" name="date_debut" id="date_debut" style="max-width:150px; display:inline-block;" >
                                        <input type="text" placeholder="<?php echo 'Au : ';echo $_SESSION['date_fin']; ?>" class="input-text" name="date_fin" id="date_fin" style="max-width:150px; display:inline-block;">
                                        <input type="submit" class="small radius white nice button" name="submit" value="ok"/>
                                        </form>
                                        
                         </div>
                         
            </div>
        
            <div id="accordion">
         
            
              <?php 
				
				         //DEBUT ACCORDION
						 	//section 0
							
                        echo'<h3><a href="#section1">';
                        echo'Chiffre d\'affaires du ';
                        echo $_SESSION['date_debut'];	
                        echo ' au ';
                        echo $_SESSION['date_fin'];	
                        echo '</a></h3><div>';
                            //DIV0
                        
                        global $connection_cakeshop;	
                        
                        $query = "SELECT SUM(total_art_ttc), SUM(quantite), date_cde From `cakeshop`.`commandes_sf` WHERE date_cde >= '";
                        $query .= $_SESSION['date_debut_db'];
                        $query .= "' AND date_cde <= '";
                        $query .= $_SESSION['date_fin_db'];
                        $query .= "' GROUP BY date_cde ORDER BY date_cde ASC";
                    
                    $result_set = mysql_query($query ,$connection_cakeshop);
                    while($data = mysql_fetch_array($result_set)) {
                    
                        $donnees[]=floatval(number_format(($data['SUM(total_art_ttc)']),2));
                        $categories[]=($data['date_cde']);
                        $donnees_q[]=intval(($data['SUM(quantite)']));
                        }
                        
                    
                        
                    ?>
                    <script type="text/javascript">
                    <?php include ('graphiques/chiffre_affaires.php'); 
						$ca_cumule = array_sum($donnees);
					   unset($donnees);
					   unset($categories);
					   unset($donnees_q);
					   
					?>
                    </script>
            
                        <div id="chiffre_affaires" style="width:inherit; min-width: 400px; height: 400px; margin: 0 auto">
                        </div>
                    <?php 
					echo '<p> Chiffre d\'affaires total durant cette periode : ' . number_format($ca_cumule,0,',',' ') . ' €';
					?>
                        
                    </div>
						
						 
						 
						 
						 <?php
						 
						 
						// Premiere section 
                        echo'<h3><a href="#section2">';
                        echo'Top 10 du ';
                        echo $_SESSION['date_debut'];	
                        echo ' au ';
                        echo $_SESSION['date_fin'];	
                        echo '</a></h3><div>';
                            //DIV1
                        
                        global $connection_cakeshop;	
                        
                        $query = "SELECT libelle_interne, SUM(total_art_ttc), SUM(quantite) From `cakeshop`.`commandes_sf` WHERE date_cde >= '";
                        $query .= $_SESSION['date_debut_db'];
                        $query .= "' AND date_cde <= '";
                        $query .= $_SESSION['date_fin_db'];
                        $query .= "' GROUP BY ref_interne ORDER BY SUM(total_art_ttc) DESC LIMIT 10";
                    
                    $result_set = mysql_query($query ,$connection_cakeshop);
                    while($data = mysql_fetch_array($result_set)) {
                    
                        $donnees[]=floatval(($data['SUM(total_art_ttc)']));
                        $categories[]=($data['libelle_interne']);
                        $donnees_q[]=intval(($data['SUM(quantite)']));
                        }
                        
                    
                        
                    ?>
                    <script type="text/javascript">
                    <?php include ('graphiques/colonne_simple.php'); ?>
                    </script>
            
                        <div id="graph_colonnes_simples" style="width:inherit; min-width: 400px; height: 400px; margin: 0 auto">
                        </div>
                    </div>
                 <?php 
                //FIN PREMIERE SECTION
                
                //DEUXIEME TITRE
                echo '<h3><a href="#section3">';
                echo'Top 50 du ';
                echo $_SESSION['date_debut'];	
                echo ' au ';
                echo $_SESSION['date_fin'];	
                echo '</a></h3><div>';
               
                //DIV2
                
                    if ($_SESSION['id']==2) {
                    
                    global $connection_cakeshop;
                    echo $_SESSION['date_debut_db'];
                    
                    
                    $query = "SELECT libelle_interne, SUM(total_art_ttc), SUM(quantite) From `cakeshop`.`commandes_sf` WHERE date_cde >= '";
                    $query .= $_SESSION['date_debut_db'];
                    $query .= "' AND date_cde <= '";
                    $query .= $_SESSION['date_fin_db'];
                    $query .= "' GROUP BY ref_interne ORDER BY SUM(total_art_ttc) DESC LIMIT 50";
                
                    $result_set = mysql_query($query , $connection_cakeshop);
                    
                    $colonnes = array('Produit','Chiffre d\'affaires', 'Quantité vendue');
                
                    // on fait une boucle qui va faire un tour pour chaque enregistrement
                    echo'<table  border="1">';
                    echo'<tr>';
                    foreach($colonnes as $champ=>$chaine)
                        {
                        echo("<td style=\"font-weight:bold;\">");
                        echo($chaine);
                        echo("</td>");
                        } 
                    echo('</tr>');
                    
                    while($data = mysql_fetch_assoc($result_set))
                    {
                        echo('<tr>');
                        foreach($data as $champ=>$chaine)
                        {
                        echo("<td>");
                        echo(htmlentities($chaine));
                        echo("</td>");
                        } 
                        echo('</tr>');
                    }
                    echo'</table>';	
                    echo '</div>';
                    //Fin 2eme Section
                    
             //FIN ACCORDION            
            }
            ?>
            </div>
            
            <?php include('includes/footer.php'); ?>

