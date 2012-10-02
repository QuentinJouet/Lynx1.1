<?php require_once( "includes/initialize.php"); ?><?php include(LIB_PATH.DS."header.php");?><?php

  
    
    //4. On rappatrie les objets qui nous interesse (pas optimisé, mais plus souple pour nb objet <<10 000)
   // $clients = Client::find_all();
    
      
?>

    <div class="nine columns" id="contenu">
            <h2>Clients</h2>

                 <div class="row">

                <div class="five columns">
                    <a href="#" class="small secondary button" data-reveal-id="date">Analyse du <?php echo $session->datedebut->texte() . ' au '.$session->datefin->texte();?></a>
                </div>


            <div class="row">
                <div class="twelve columns">
                    <table class="nice" id="tableautriclient">
                    <thead>
                        <tr>
                            <th>Ref</th>

                            <th>Nom</th>

                            <th>Chiffre<br />d'affaires</th>

                            <th>Mail</th>
                            
                            <th>Nombre de <br />commandes</th>
                         </tr>
                    </thead>
                    <tbody>
                    <?php /*
                            <?php foreach($clients as $client): ?>
                        

                        <tr>
                        
                            <td><a href="detail_client.php?id_c=<?php echo $client->id; ?>"><?php echo $client->ref; ?></a></td>

                            <td><?php echo ($client->nom_complet()); ?></td>

                            <td><?php echo $client->ca(); ?></td>
                            
                            <td><?php echo $client->email; ?></td>
                            
                            <td><?php echo $client->nb_commandes(); ?></td>
                        </tr>
                          <?php endforeach; ?>
                          */ ?>
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
