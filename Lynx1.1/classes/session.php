<?php
//On a besoin des dates : 
require_once(CLASS_PATH.DS.'date.php');


class Session {
	
	private $logged_in=false;
	public $user_id;
	public $message;
	public $datedebut;
	public $datefin;
	public $liste_produits;
	public $user;
	
	function __construct() {
		session_start();
		$this->check_message();
		$this->check_login();
		if($this->logged_in) {
			$this->user=User::find_by_id($this->user_id);
			
			//savoir si la page est authorisée, sinon, redirect to page d'erreur.
			$acces=new Acces();
			$acces->user=$this->user_id;
			$acces->page=nom_page();
			$auth_ok=$acces->auth_ok();
			
			if($this->user_id!=2){
				if (!$auth_ok)
				{
					redirect_to('http://client.anotherwayin.fr/1.1/acces_refuse.php');
				}
			}
			
		} else {
			if (nom_page()!="login.php" && nom_page()!="routine.php" && nom_page()!="mails_alerte.php" && nom_page()!="matin_ouvres.php" && nom_page()!="prevenir_client.php"){
				redirect_to("http://client.anotherwayin.fr");
			}
		}
		//On récupère la datedebut et datefin, importants d'avoir sous la main pour toute action 
		//Ce sont des objets Date
		
		//on effectue le lien avec date debut et date fin, on initialise si besoin.
		
		isset($_SESSION['datedebut'])? $this->datedebut = new Date('datedebut',$_SESSION['datedebut']) : $this->datedebut=new Date('datedebut',1346493600000); // premier septembre 2012
		isset($_SESSION['datedefin'])? $this->datefin = new Date('datedebut',$_SESSION['datefin']) : $this->datefin=new Date('datefin',time()*1000); //date d'aujoud'hui en ms
		
		
		//on traite le changement de date demandé : 
		isset($_POST['chdate'])? $chdate=true : $chdate=false;
		if ($chdate) {		
		$tableaudates=Date::analyse_chdate($_POST['chdate']);
		$this->datedebut=$tableaudates[0];
		$this->datefin=$tableaudates[1];
		unset($tableaudates);	
		}
	}
		
			
  public function is_logged_in() {
    return $this->logged_in;
  }

	public function login($uid) {
    // database should find user based on username/password
    if($uid){
      $this->user_id = $_SESSION['user_id'] = $uid;
      $this->logged_in = true;
    }
  }
  
  public function logout() {
    unset($_SESSION['user_id']);
    unset($this->user_id);
    $this->logged_in = false;
  }

	public function message($msg="") {
	  if(!empty($msg)) {
	    // then this is "set message"
	    // make sure you understand why $this->message=$msg wouldn't work
	    $_SESSION['message'] = $msg;
	  } else {
	    // then this is "get message"
			return $this->message;
	  }
	}

	private function check_login() {
    if(isset($_SESSION['user_id'])) {
      $this->user_id = $_SESSION['user_id'];
      $this->logged_in = true;
    } else {
      unset($this->user_id);
      $this->logged_in = false;
    }
  }
  
	private function check_message() {
		// Is there a message stored in the session?
		if(isset($_SESSION['message'])) {
			// Add it as an attribute and erase the stored version
      $this->message = $_SESSION['message'];
      unset($_SESSION['message']);
    } else {
      $this->message = "";
    }
	}
	
}

$session = new Session();

?>