<?php require_once( "includes/initialize.php"); ?>
<?php include(LIB_PATH.DS."header.php");?>
<?php

	// 1. the current page number ($current_page)
	$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;

	// 2. records per page ($per_page)
	$per_page = 50;

	// 3. total record count ($total_count)
	//$total_count = Produit::count_all($db_cakeshop_thelia);
	

	// Find all photos
	// use pagination instead
	//$photos = Photograph::find_all();
	
	//$pagination = new Pagination($page, $per_page, $total_count);
	
	// Instead of finding all records, just find the records 
	// for this page
	
	//$produits = Produit::produits_par_sql('','p.id DESC',$pagination->per_page,$pagination->offset());
	
	// Need to add ?page=$page to all links we want to 
	// maintain the current page (or store $page in $session)
	
?>

<div class="nine columns" id="contenu">




</div>
<?php include(LIB_PATH.DS."footer.php");?>
