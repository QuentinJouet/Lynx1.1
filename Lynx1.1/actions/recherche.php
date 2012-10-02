
<?php
	
if (empty($_POST['rech_ref'])){	
header("Location: ../index.php");
}
else {
$tableau=explode(' | ',$_POST['rech_ref']);
$ref=trim($tableau[0]);
$ref=urlencode($ref);	
header("Location: ../analyse_detail.php?ref_p={$ref}");	
}


exit;
?>
	
	