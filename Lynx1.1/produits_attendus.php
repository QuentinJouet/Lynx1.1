<?php require_once( "includes/initialize.php"); ?><?php include(LIB_PATH.DS."header.php");?><?php

$produits=Produit::produits_par_sql();

   ?>
   
   
    <div class="nine columns" id="contenu">
            <h2>Produits attendus</h2>
            <h5>Il y a actuellement <?php echo PrevenirClient::nb_clients_attente();?> clients en attente de <?php echo PrevenirClient::nb_produits_attente();?> produits en rupture de stock.</h5>
            <div class="row">
                <div class="twelve columns">
                    <table class="nice" id="tableautri">
                    <thead>
                        <tr>
                            <th>Ref</th>

                            <th>Produit</th>
                            
                            <th>Stock web actuel</th>

                            <th>Nb D'attentes</th>

                            <th>Clients en attente</th>
                            
                            <th>Envoyer le mail</th>
  </tr>
                    </thead>
                    <tbody>
                                                                            
                            <?php foreach($produits as $produit): ?>
                            
                            	<?php if($produit->nb_attentes()>0): ?>
                            
		                           		
		                        <tr>
		                           		
		                            <td><?php echo $produit->ref; ?></td>
		
		                            <td><a href="analyse_detail.php?id_p=<?php echo $produit->id;?>"><?php echo ($produit->titre); ?></a></td>
		                            
		                            <td><?php echo $produit->stock_web; ?></td>
		
		                            <td><?php echo $produit->nb_attentes() ?></td>
		                            
		                            <td>
		                            	<?php //ON AFFICHE LE NOM DE TOUS LES CLIENTS EN ATTENTE 
			                            	$attentes=PrevenirClient::attentes_produit($produit->id);
			                            	foreach ($attentes as $attente){
			                            		$client=Client::find_by_id($attente->client);	
			                            		echo $client->nom_complet();
			                            		echo '</br>';	                            	
			                            	}
			                            	
			                            	
		                            	?>
		                            	
		                            </td>
		                            
		                            <td>
		                            <form method="post" action="actions/prevenir_client_mail.php">
			                            <input type="hidden" name="produit" value="<?php echo $produit->id ?>">
			                            <button type="submit" class="small radius button">Envoyer mail</button>
		                            </form>
		                            </td>
		                        </tr>
		                        <?php endif;?>
                          <?php endforeach; ?>
                    </tbody>
                    </table>
                </div>
            </div>


        </div><?php // IL FAUT PEUT ETRE RAMENER AU GLOBAL SCOPE LES VARIABLE NEXT ET PREV PAGE ?><script type="text/javascript">
$(function() {
        $(document).keydown(function(event) {
        //alert(event.keyCode);
        switch (event.keyCode) {
            case 37: case 74:
                window.location.href = '<?php echo URL_SITE.$prevpage; ?>';
                break;
            case 39: case 75:
                window.location.href = '<?php echo URL_SITE.$nextpage; ?>';
                break;
        }
        });
        });

        </script> 
        <?php include(LIB_PATH.DS."footer.php");?>
         <?php include(LIB_PATH.DS."finalize.php");?>
