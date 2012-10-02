<?php 
class MailLynx {
	
	protected static $SMTPAuth=true;
	protected static $Host = "in.mailjet.com";
	protected static $IsSMTP = true;
	protected static $SMTPSecure='tls';
	protected static $Port = 587;
	protected static $Username = '8bdd8f9f3b6de612ccf3103f2a385a98';
	protected static $Password = '2fb23a5b31ae1df99a641a07ff1d14a2';
	public static $frommail='lynx.alertes@anotherwayin.fr';
	public static $fromnom='Lynx - Alertes';
	public static $replyto='contact@anotherwayin.fr';
	public static $replynom='Another Way In';
	public $sujet='';
	public $body='';
	public $message_texte;
	public $message_titre;
	public $message_soustitre;
	public $destinataires=array(); //DE LA FORME 'mail@mail.com'=>'Jean Dupont'
	

	
	public function generer(){
		$mail=new PHPMailer();
		$mail -> CharSet = 'utf-8';
		$mail->IsSMTP(); 
		
		$mail->Host=self::$Host;
		$mail->SMTPAuth=self::$SMTPAuth;
		$mail->SMTPSecure=self::$SMTPSecure;
		$mail->Port = self::$Port;
		$mail->Username = self::$Username;
		$mail->Password = self::$Password;
		$mail->SetFrom(self::$frommail,self::$fromnom);
		$mail->Subject=$this->sujet;
		$mail->MsgHTML($this->template());
		$mail->AddAddress('commande@thecakeshop.fr','The Cake Shop - Commande');
		
			return $mail;		
	}
	

	public function template(){
	
	
	$code='<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <title>'.($this->sujet).'</title>
</head>
<body>
	<div style="color: #505050;font-family: Arial;font-size: 14px;line-height: 150%;text-align: center;">
	<h2 class="h2" style="color: #202020;display: block;font-family: Arial;font-size: 22px;font-weight: bold;line-height: 100%;margin-top: 0;margin-right: 0;margin-bottom: 10px;margin-left: 0;text-align: center;">'.($this->message_titre).'</h2><strong>'.($this->message_soustitre).'</strong><br />
	
	'.($this->message_texte).'
	<br/>
	<br/>
	<h4>Ceci est un message automatique généré par Lynx</h4>
	</div>
</body>
</html>
';
		
		return $code;
		
		
	}
	
	
	
	
	
}