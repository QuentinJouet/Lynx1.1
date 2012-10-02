<?php require_once( "../includes/initialize.php"); ?>
  
    <?php
     // START FORM PROCESSING
     
        if (isset($_POST['submit'])) { // Form has been submitted.
            
	        $user=new User();
	        $user->username = $_POST['username'];
	        $user->password= $_POST['password'];
	        $verif=$user->verifier();
	        
	        if ($verif==false){
	        $_SESSION['erreur']='Erreur d\'identification';
		       redirect_to("http://client.anotherwayin.fr");
		       exit;
		        
	        }
	        else
	        $session->login($verif);
	        redirect_to("http://client.anotherwayin.fr");
	        exit;
	        
	        
                        
        } 
        else         
        { // Form has not been submitted.
         $_SESSION['erreur']='Merci de vous identifier';
            redirect_to("http://client.anotherwayin.fr");
            exit;
        }
        
 
        ?>
    
          