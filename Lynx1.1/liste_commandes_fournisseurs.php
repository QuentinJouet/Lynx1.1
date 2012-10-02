<?php require_once( "includes/initialize.php"); ?>

<?php

    
    //4. On rappatrie les objets qui nous interesse (pas optimisé, mais plus souple pour nb objet <<10 000)
    $commandes_fournisseurs = CommandeFournisseur::find_all();
    
     
?>

<?php include(LIB_PATH.DS."header.php");?>

    <div class="nine columns" id="contenu">
            <h2>Commandes fournisseurs</h2>

                    
            <div class="row">
                <div class="twelve columns">
                    <table class="nice" id="tableautri">
                    <thead>
                        <tr>
                            <th>Numéro Commande</th>

                            <th>Statut</th>

                            <th>Fournisseur</th>

                            <th>Date commande</th>

                            <th>Date envoyée</th>
                            
                            <th>Date reçue</th>
                            
                            <th>Date vérification</th>

                            <th>Action</th>

                                            
                          </tr>  
                    </thead>
                     <tbody>                                   
                            <?php foreach($commandes_fournisseurs as $commande): ?>
                        
                            
                        <tr>
                            <td><?php echo $commande->id; ?></td>

                            <td><?php echo $commande->texte_statut(); ?></td>

                            <td><?php echo Fournisseur::afficher_nom($commande->fournisseur); ?></td>

                            <td><?php echo $commande->date_commande_prete; ?></td>
                            
                            <td><?php echo $commande->date_commande_passee; ?></td>
                              
                            <td><?php echo $commande->date_commande_recue; ?></td>
                            
                            <td><?php echo $commande->date_commande_stock; ?></td>
                            
                            <td><a class="small button radius" href="detail_commande.php?id_c=<?php echo $commande->id;?>">Accéder</a></td>
                            
                         </tr>
                           
                          <?php endforeach; ?>
                       </tbody>
                    </table>
                </div>
            </div>

           
        <?php // IL FAUT PEUT ETRE RAMENER AU GLOBAL SCOPE LES VARIABLE NEXT ET PREV PAGE ?><script type="text/javascript">
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
