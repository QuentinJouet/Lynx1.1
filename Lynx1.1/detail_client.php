<?php require_once( "includes/initialize.php"); ?>

<?php

//On initialise la page :
if (isset($_GET['id_c'])){
	$getid=(int)$_GET['id_c'];
	unset($_GET['id_c']);
	$_SESSION['id_client']=$getid;
}
else {
	$getid=false;
}


//On choisi quoi mettre en fournisseur.
//Si on initialise avec un id
if ($getid){
	$client=Client::find_by_id($getid);
	$serial=serialize($client);
	$_SESSION['client']=$serial;
	unset($serial);
}

//Sinon on récupère celui en session
if ($getid==false && isset($_SESSION['client'])==true){
	$client=unserialize($_SESSION['client']);
	unset($deserial);
}



// 1. On récupère le num de page
$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;

// 2. On recupère les infos de tri
!empty($_GET['p_p'])? $per_page = $_GET['p_p'] : $per_page = 10;
!empty($_GET['tri'])? $tri = $_GET['tri'] : $tri = 'id';
!empty($_GET['o'])? $dec = $_GET['o'] : $dec = 1;
!empty($_GET['fltr'])? $filtre = $_GET['fltr'] : $filtre = '0';
!empty($_GET['vlr'])? $valeur = $_GET['vlr'] : $valeur = '0';



//4. On rappatrie les objets qui nous interesse (pas optimisé, mais plus souple pour nb objet <<10 000)
$commandes = $client->commandes();



//4.2 On enleve les éléments que l'on ne veut pas $filtre et $valeur doivent etre vérifiés.
$filtrage=false;
if ($filtre!='0'){
	$commandes=filtrer_objets($commandes,$filtre,$valeur);
	$filtrage=true;
}


//5. On trie le tableau d'objets selon le critère $tri
$commandes = tri_objets($commandes,$tri);
if ($dec==1) {$commandes = array_reverse($commandes);}

// 5.2 On compte le nb d'objets pour nb de pages correct
$total_count = count($commandes);

$pagination = new Pagination($page, $per_page, $total_count);

//6. On tranche le tableau pour afficher uniquement ceux choisis.
$commandes = array_slice($commandes,$pagination->offset(),$pagination->per_page);


/*
	public $nom;
	public $telephone;
	public $siret;
	public $mail;
	public $fax;
	public $siteweb;
	public $commentaire;
	public $adresse;
	public $pays;
	public $devise;
*/

?>




<?php include(LIB_PATH.DS."header.php");?>


<div class="nine columns" id="contenu">
	<div class="row"> <br/>
		<div class="panel twelve centered columns">
			<div class="row">
				<div class="ten columns">
					<h3>Client : <?php echo $client->nom_complet();?></h3>
					<ul class="nopus">
						<li>Chiffre d'affaires : <?php echo $client->ca(); ?> €</li>
						<li>Adresse mail : <?php echo $client->email; ?></li>
						<li>Nombre de commandes : <?php echo $client->nb_commandes(); ?></li>
					</ul>
				</div>
			</div>

			<div class="row">
				<div class="twelve columns " style="text-align:center;">
					<a href="liste_clients.php" class="small radius button ">
					Retour à la liste
					</a>
					<a target="_blank" href="<?php echo URL_THELIA.'admin_cakeshop/client_visualiser.php?ref='.$client->ref ; ?>" class="small radius button">
					Voir Client sous Thelia
					</a>

				</div>
			</div>
		</div>
	</div>



	<div class="row">

		<div class="five columns">
			<a href="#" class="small secondary button" data-reveal-id="date">Analyse du <?php echo $session->datedebut->texte() . ' au '.$session->datefin->texte();?></a>
		</div>

		<div href="#" class="secondary small button dropdown four columns end">
		Tri par : <?php echo CommandeThelia::$elements_tri[$tri];?>

			<ul>
				<?php foreach(CommandeThelia::$elements_tri as $key=>$value){
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




	<div class="row">
	    <div class="twelve columns">
	        <table class="nice">
	            <tr>
	                <th>Date</th>

	                <th>Référence</th>

	                <th>Thelia</th>

	                <th>Port</th>

	                <th>Remise</th>

	                <th>Total</th>

	                <th>Paiement</th>

	                <th>Statut</th>
	             </tr>

	             <?php if(empty($commandes)){
	echo '<tr><td>Aucune commande pour ce client </td></tr>';
}
?>


	                <?php foreach($commandes as $commande): ?>


	            <tr>

	                <td><?php echo $commande->date; ?></td>

	                <td><?php echo $commande->ref; ?></td>

	                <td><a target="_blank" href="<?php echo URL_THELIA.'admin_cakeshop/commande_details.php?ref='.$commande->ref ; ?>"><?php echo "voir la commande sous Thelia"; ?></a></td>

	                <td><?php echo $commande->port; ?>€</td>

	                <td><?php echo $commande->remise; ?>€</td>

	                <td><?php echo $commande->total_ttc(); ?>€</td>

	                <td><?php echo $commande->moyenpaiement(); ?></td>

	                <td><?php echo $commande->statut(); ?></td>
	            </tr>
	              <?php endforeach; ?>
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
