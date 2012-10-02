<?php require_once( "includes/initialize.php"); ?><?php include(LIB_PATH.DS."header.php");?>
    <div class="nine columns" id="contenu">
            <h2>Produits</h2>

                 <div class="row">

                <div class="five columns">
                    <a href="#" class="small secondary button" data-reveal-id="date">Analyse du <?php echo $session->datedebut->texte() . ' au '.$session->datefin->texte();?></a>
                </div>


            <div class="row">
                <div class="twelve columns">
                             
                    <table id="tableautriproduit">
                    <thead>
                        <tr>
                            <th width="15%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Titre&nbsp;du&nbsp;produit&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>

                            <th width="7%">Ref</th>

                            <th width="6%">Stock<br/>Web</th>

                            <th width="6%">Stock<br/>Boutique</th>
                            
                            <th width="6%">Stock<br/> op</th>
                            
                            <th width="6%">Quant.<br/>comm.</th>
                            
                            <th width="7%">Alerte stock</th>
                            
                            <th width="8%">Ventes<br/> Moyennes (/s)</th>

                            <th width="8%">Ventes<br/>Web</th>

                            <th width="8%">CA<br/>Web</th>                            
                            
                            <th width="7%">Ventes<br/>Shop</th>

                            <th width="8%">CA<br/>Shop</th>
                            
                            <th width="8%">CA</th>
                            </tr>
                         </thead>
                         <tbody>
                        </tbody>
                    </table>
                </div>
            </div>

        <?php include(LIB_PATH.DS."footer.php");?>
         <?php include(LIB_PATH.DS."finalize.php");?>
