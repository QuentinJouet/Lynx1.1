<?php require_once( "includes/initialize.php"); ?><?php include(LIB_PATH.DS."header.php");?><?php

    // 1. On récupère le num de page
    $page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;

    // 2. On recupère les infos de tri
    !empty($_GET['p_p'])? $per_page = $_GET['p_p'] : $per_page = 10; 
    !empty($_GET['tri'])? $tri = $_GET['tri'] : $tri = 'ca';
    !empty($_GET['o'])? $dec = $_GET['o'] : $dec = 1;
    !empty($_GET['fltr'])? $filtre = $_GET['fltr'] : $filtre = '0';
    !empty($_GET['vlr'])? $valeur = $_GET['vlr'] : $valeur = '0';
    

    
    //4. On rappatrie les objets qui nous interesse (pas optimisé, mais plus souple pour nb objet <<10 000)
    $produits = Produit::produits_par_sql();
    
    //4.2 On enleve les éléments que l'on ne veut pas $filtre et $valeur doivent etre vérifiés.
    $filtrage=false;
    if ($filtre!='0'){
   	    $produits=filtrer_objets($produits,$filtre,$valeur);
	    $filtrage=true;
    }


    //5. On trie le tableau d'objets selon le critère $tri  
    $produits = tri_objets($produits,$tri);
    if ($dec==1) {$produits = array_reverse($produits);}
    
    // 5.2 On compte le nb d'objets pour nb de pages correct
    $total_count = count($produits);
    
    $pagination = new Pagination($page, $per_page, $total_count);
    
    //6. On tranche le tableau pour afficher uniquement ceux choisis.
    $produits = array_slice($produits,$pagination->offset(),$pagination->per_page);
    
?>

    <div class="nine columns" id="contenu">
            <h2>Produits</h2>

                 <div class="row">

                <div class="five columns">
                    <a href="#" class="small secondary button" data-reveal-id="date">Analyse du <?php echo $session->datedebut->texte() . ' au '.$session->datefin->texte();?></a>
                </div>

                <div href="#" class="secondary small button dropdown four columns end">
                    Tri par : <?php echo Produit::$elements_tri[$tri];?>

                    <ul>
                    <?php foreach(Produit::$elements_tri as $key=>$value){
	                    echo '<li><a href="'.nom_page().'?'.tri_get($key,$dec,$per_page,$filtre,$valeur).'">'.$value.'</a></li>';
	                    }
	                 ?>
                   
                    </ul>
                </div>

                <div class="three columns end">
	                <a href="
	                <?php echo nom_page().'?';
	                if ($dec==2){
	               echo tri_get($tri,1,$per_page,$filtre,$valeur);
	                } else {
	                echo tri_get($tri,2,$per_page,$filtre,$valeur);}?>
	                " class="secondary button small">
	                	<?php 
	                	               	
	                	if ($dec==2){
		                	echo 'Croissant';
	                	} else {
	                	echo 'Décroissant';}?>
	                </a>
                </div>
            </div>


            <div class="row">
                <div class="twelve columns">
                    <table id="tableautri">
                    <thead>
                        <tr>
                            <th>Image</th>

                            <th>Titre</th>

                            <th>Ref</th>

                            <th>Stock<br/>Web</th>

                            <th>Stock<br/>Boutique</th>
                            
                            <th>Stock<br/> op</th>
                            
                            <th>Quantité<br/>commandée</th>
                            
                            <th>Alerte stock</th>
                            
                            <th>Ventes<br/> Moyennes (/s)</th>

                            <th>Ventes<br/>Web</th>

                            <th>CA<br/>Web</th>                            
                            
                            <th>Ventes<br/>Shop</th>

                            <th>CA<br/>Shop</th>
                            
                            <th>CA</th>
                            </tr>
                         </thead>
                         <tbody>
                            <?php foreach($produits as $produit): ?>
                        

                        <tr>
                            <td><img src="<?php echo $produit->image; ?>" width="50"></td>

                            <td><a href="analyse_detail.php?id_p=<?php echo $produit->id; ?>"><?php echo ($produit->titre); ?></a></td>

                            <td><?php echo $produit->ref; ?></td>

                            <td><?php echo $produit->stock_web; ?></td>

                            <td><?php echo $produit->stock_boutique; ?></td>
                            
                            <td><?php echo $produit->stock_op; ?></td>
                            
                            <td><?php echo $produit->quantite_commandee(); ?></td>
                            
                            <td><a href="stocks.php"><div class="case_alerte_stock" style="background-color:<?php echo Produit::$couleurs[$produit->alerte_stock()];?>"></div></a></td>
                             
                            <td><?php echo $produit->conso_moy(); ?></td>

                            <td><?php echo $produit->nb_ventes_web();?></td>

                            <td><?php echo $produit->ca_web()?>€</td>
                            
                            <td><?php echo $produit->nb_ventes_boutique();?></td>

                            <td><?php echo $produit->ca_boutique();?>€</td>

                            <td><?php echo $produit->ca();?>€</td>
                        </tr>
                          <?php endforeach; ?>
                         </tbody>
                    </table>
                </div>
            </div>

            <div class="row" style="text-align:center">
                <div class="twelve columns">
                    <?php include(LIB_PATH.DS."pagination.php");?>
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
