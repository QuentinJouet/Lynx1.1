<?php
	session_start();
	
	function logged_in() {
		return isset($_SESSION['id']);
	}
	
	function confirm_logged_in() {
		if (!logged_in()) {
			redirect_to("http://client.anotherwayin.fr");
		}
	}
	
	function logged_awi(){
		
		return ($_SESSION['id'] == 3);
				
	}
	
	function confirm_admin() {
		if (!logged_awi()) {
			redirect_to("http://client.anotherwayin.fr");
		}
	}
	
?>
