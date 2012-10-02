<?php require_once( "includes/initialize.php"); ?>
<?php 
global $session;
if ($session->is_logged_in()) {
	redirect_to('index.php');
}


?>
<html>
<head>


<script src="../javascripts/jquery.min.js"></script>
<script src="../javascripts/modernizr.foundation.js"></script>
<script src="../javascripts/foundation.js"></script>
<script src="../javascripts/app.js"></script>
<link rel="stylesheet" href="../stylesheets/foundation.css">
<link rel="stylesheet" href="../stylesheets/app.css">
<link rel="stylesheet" href="../stylesheets/style.css">


    
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Another way in</title>
</head>

<body>

    <div class="container">
    
               <div class="row">
                <div class="seven centered columns" id="headerawi">
                <img src="http://code.anotherwayin.fr/logos/logo_300.png" style="" /> 
                </div>
            </div>
             <div class="row">
                <div class="three centered columns">
            			<?php
            	if(!empty($_GET['logout'])){
                if ($_GET['logout']==1) {
                echo('<div class="alert-box success">
                                Vous avez été déconnecté.
                                <a href="" class="close">&times;</a>
                            </div>');	
                }
                }
                if (!empty($_SESSION['erreur'])){
	                echo '<div class="alert-box alert">
                               '.$_SESSION['erreur'].'
                                <a href="" class="close">&times;</a>
                            </div>';
                }
                
                ?>
                </div>
             </div>
            
            
        <div class="row">
            <div class="panel six columns centered" id="login_index">
                <h5>Espace client</h5>
               
                <p>Veuillez vous identifier</p>
                    <div class="row">
                        <div class="seven centered columns">
                        <form class="nice" method="post" id="login_index" action="actions/login.php">
                        <!--<label for="identifiant">Identifiant :</label>-->
                        <input type="text" placeholder="Identifiant" class="input-text" name="username" maxlength="30" />
                        <!--<label for="password">Mot de passe :</label>-->
                        <input type="password" placeholder="Mot de passe" class="input-text"  name="password" maxlength="30" /><br />
                        <input type="submit" class="nice small radius blue button" name="submit" value="Login" />&nbsp;&nbsp;<a href="http://www.anotherwayin.fr" class="nice small radius red button">Quitter</a>
                        </form>
                        </div>
                    </div>
            </div>
        
        </div>
 	<div id="footer">   
            
            Copyright Another Way In 2012
            
	</div>    
       
	</div>


</body>
</html>
