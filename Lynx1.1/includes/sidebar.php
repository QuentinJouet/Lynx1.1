
<div id="sidenav_header" style="text-align:center"> <img src="images/lynx.jpg" alt="Another Way In" /> <br />
    <p>
    <strong><?php echo $session->user->nom; ?></strong>	        
    </p>
    <a href="logout.php" class="small  secondary radius button">Se déconnecter</a> <br/>
    <br/>
    <ul class="vertical nav-bar">
        <li<?php echo (nom_page()=='index.php')? ' class="active"' : '';?> ><a href="index.php">Tableau de bord</a></li>
        <li <?php echo (nom_page()=='liste_clients.php' || nom_page()=='detail_client.php')? ' class="active"' : '';?>><a href="liste_clients.php" >Clients</a></li>
        
        
        <li<?php echo (nom_page()=='liste_produits.php' || nom_page()=='analyse_detail.php' || nom_page=='produits_attendus.php' || nom_page=='liste_categories_virtuelle.php')? ' class="active has-flyout"' : ' class="has-flyout"';?>>
        <a href="liste_produits.php">Produits</a>
        <a href="#" class="flyout-toggle"><span> </span></a>
            <ul class="flyout vertical">
                <li><a href="liste_produits.php">Liste des produits</a></li>
                <li><a href="produits_attendus.php">Produits attendus</a></li>
                <li><a href="liste_categories_virtuelle.php">Catégories virtuelles</a></li>
            </ul>
        </li>

        <li<?php echo (nom_page()=='liste_fournisseurs.php' || nom_page()=='liste_commandes_fournisseurs.php' )? ' class="active has-flyout"' : ' class="has-flyout"';?>>
        <a href="liste_fournisseurs.php">Fournisseurs</a>
        <a href="#" class="flyout-toggle"><span> </span></a>
            <ul class="flyout vertical">
                <li><a href="liste_fournisseurs.php">Liste des fournisseurs</a></li>
                <li><a href="liste_commandes_fournisseurs.php">Liste des commandes fournisseur</a></li>
            </ul>
        </li>

        <li<?php echo (nom_page()=='liste_commandes.php' || nom_page()=='commande_detail.php' )? ' class="active has-flyout"' : ' class="has-flyout"';?>>
        <a href="liste_commandes.php">Ventes</a>
        <a href="#" class="flyout-toggle"><span> </span></a>
            <ul class="flyout vertical">
                <li><a href="liste_commandes.php">Liste des ventes web</a></li>
             </ul>
        </li>
        <li<?php echo (nom_page()=='stocks.php' || nom_page()=='urgences.php' )? ' class="active has-flyout"' : ' class="has-flyout"';?>>
        <a href="stocks.php">Gestion des stocks</a>
        <a href="#" class="flyout-toggle"><span> </span></a>
            <ul class="flyout vertical">
                <li><a href="stocks.php">Analyse des stocks</a></li>
		<li><a href="urgences.php">Urgences</a></li>
             </ul>
        </li>



        <li><a href="reception.php">Reception commande</a></li>

        <li><a href="awi.php">Aide et support</a></li>
    </ul>
</div>
<a href="#" class="radius button" data-reveal-id="date">Changer les dates de calcul</a>
<h5>Analyse d'un produit</h5>
<form class="nice" method="post" id="recherche_ref" action="actions/recherche.php">
    <label>Recherche par Ref ou Nom</label>
    <div class="row collapse">
        <div class="nine columns">
            <input placeholder="Recherche" type="text" name="rech_ref" id="autocomplete">
        </div>
        <div class="three columns" >
            <button type="submit" class="postfix button" name="submit">ok</button>
        </div>
    </div>
</form>
<h5>Produits favoris</h5>
<?php

$favoris=Favori::find_all();
foreach($favoris as $favori){
	echo '<a class="small nice radius white button" href="analyse_detail.php?id_p='.$favori->id_p.'">'.($favori->ref).'<br/>'.($favori->titre).'</a><br/>';
}


?>
