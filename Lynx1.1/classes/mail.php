<?php 
class Mail {
	
	protected static $SMTPAuth=true;
	protected static $Host = "in.mailjet.com";
	protected static $IsSMTP = true;
	protected static $SMTPSecure='tls';
	protected static $Port = 587;
	protected static $Username = '8bdd8f9f3b6de612ccf3103f2a385a98';
	protected static $Password = '2fb23a5b31ae1df99a641a07ff1d14a2';
	public static $frommail='contact@anotherwayin.fr';
	public static $fromnom='The Cake Shop';
	public static $replyto='info@thecakeshop.fr';
	public static $replynom='The Cake Shop';
	public $sujet='';
	public $body='';
	public $message_texte;
	public $message_titre;
	public $message_soustitre;
	public $destinataires=array(); //DE LA FORME 'mail@mail.com'=>'Jean Dupont'
	
	
	//Retourne un objet PHP MAILER prêt à Send()
	public static function nouveau($sujet,$message,$tomail,$tonom){
		$mail=new PHPMailer();
		$mail->IsSMTP(); 
		$mail->Host=Mail::$Host;
		$mail->SMTPAuth=Mail::$SMTPAuth;
		$mail->SMTPSecure=Mail::$SMTPSecure;
		$mail->Port = Mail::$Port;
		$mail->Username = Mail::$Username;
		$mail->Password = Mail::$Password;
		$mail->SetFrom(Mail::$frommail,Mail::$fromnom);
		$mail->Subject=$sujet;
		$mail->MsgHTML($message);
		$mail->AddAddress($tomail,$tonom);
		
			return $mail;
		
	} //OLD
	
	public function generer(){
		$mail=new PHPMailer();
		$mail -> CharSet = 'utf-8';
		$mail->IsSMTP(); 
		
		$mail->Host=Mail::$Host;
		$mail->SMTPAuth=Mail::$SMTPAuth;
		$mail->SMTPSecure=Mail::$SMTPSecure;
		$mail->Port = Mail::$Port;
		$mail->Username = Mail::$Username;
		$mail->Password = Mail::$Password;
		$mail->SetFrom(Mail::$frommail,Mail::$fromnom);
		$mail->Subject=$this->sujet;
		$mail->MsgHTML($this->template());
		
		
		foreach ($this->destinataires as $email=>$nom){
			$mail->AddAddress($email,$nom);
		}
		//$mail->AddAddress('info@thecakeshop.fr','The Cake Shop');
			return $mail;
		
	}
	

	public function template(){
	
	
	$code='<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <title>The Cake Shop</title>
    <style type="text/css">
/*<![CDATA[*/
        #outlook a{
            padding:0;
        }
        body{
            width:100% !important;
        }
        .ReadMsgBody{
            width:100%;
        }
        .ExternalClass{
            width:100%;
        }
        body{
            -webkit-text-size-adjust:none;
        }
        body{
            margin:0;
            padding:0;
        }
        img{
            border:0;
            height:auto;
            line-height:100%;
            outline:none;
            text-decoration:none;
        }
        table td{
            border-collapse:collapse;
        }
        #backgroundTable{
            height:100% !important;
            margin:0;
            padding:0;
            width:100% !important;
        }
        body,#backgroundTable{
            background-color:#FAFAFA;
        }
        #templateContainer{
            border:0;
        }
        h1,.h1{
            color:#202020;
            display:block;
            font-family:Arial;
            font-size:34px;
            font-weight:bold;
            line-height:100%;
            margin-top:0;
            margin-right:0;
            margin-bottom:10px;
            margin-left:0;
            text-align:left;
        }
        h2,.h2{
            color:#202020;
            display:block;
            font-family:Arial;
            font-size:30px;
            font-weight:bold;
            line-height:100%;
            margin-top:0;
            margin-right:0;
            margin-bottom:10px;
            margin-left:0;
            text-align:left;
        }
        h3,.h3{
            color:#202020;
            display:block;
            font-family:Arial;
            font-size:26px;
            font-weight:bold;
            line-height:100%;
            margin-top:0;
            margin-right:0;
            margin-bottom:10px;
            margin-left:0;
            text-align:left;
        }
        h4,.h4{
            color:#202020;
            display:block;
            font-family:Arial;
            font-size:22px;
            font-weight:bold;
            line-height:100%;
            margin-top:0;
            margin-right:0;
            margin-bottom:10px;
            margin-left:0;
            text-align:left;
        }
        #templatePreheader{
            background-color:#ff91ae;
        }
        .preheaderContent div{
            color:#505050;
            font-family:Arial;
            font-size:10px;
            line-height:100%;
            text-align:left;
        }
        .preheaderContent div a:link,.preheaderContent div a:visited,.preheaderContent div a .yshortcuts {
            color:#336699;
            font-weight:normal;
            text-decoration:underline;
        }
        #templateHeader{
            background-color:#379dbd;
            border-bottom:0;
        }
        .headerContent{
            color:#202020;
            font-family:Arial;
            font-size:34px;
            font-weight:bold;
            line-height:100%;
            padding:0;
            text-align:center;
            vertical-align:middle;
        }
        .headerContent a:link,.headerContent a:visited,.headerContent a .yshortcuts {
            color:#336699;
            font-weight:normal;
            text-decoration:underline;
        }
        #headerImage{
            height:auto;
            max-width:600px;
        }
        #templateContainer,.bodyContent{
            background-color:#FFFFFF;
        }
        .bodyContent div{
            color:#505050;
            font-family:Arial;
            font-size:14px;
            line-height:150%;
            text-align:left;
        }
        .bodyContent div a:link,.bodyContent div a:visited,.bodyContent div a .yshortcuts {
            color:#336699;
            font-weight:normal;
            text-decoration:underline;
        }
        .bodyContent img{
            display:inline;
            height:auto;
        }
        .leftColumnContent{
            background-color:#FFFFFF;
        }
        .leftColumnContent div{
            color:#505050;
            font-family:Arial;
            font-size:14px;
            line-height:150%;
            text-align:left;
        }
        .leftColumnContent div a:link,.leftColumnContent div a:visited,.leftColumnContent div a .yshortcuts {
            color:#336699;
            font-weight:normal;
            text-decoration:underline;
        }
        .leftColumnContent img{
            display:inline;
            height:auto;
        }
        .rightColumnContent{
            background-color:#FFFFFF;
        }
        .rightColumnContent div{
            color:#505050;
            font-family:Arial;
            font-size:14px;
            line-height:150%;
            text-align:left;
        }
        .rightColumnContent div a:link,.rightColumnContent div a:visited,.rightColumnContent div a .yshortcuts {
            color:#336699;
            font-weight:normal;
            text-decoration:underline;
        }
        .rightColumnContent img{
            display:inline;
            height:auto;
        }
        #templateFooter{
            background-color:#379dbd;
            border-top:0;
        }
        .footerContent div{
            color:#707070;
            font-family:Arial;
            font-size:12px;
            line-height:125%;
            text-align:left;
        }
        .footerContent div a:link,.footerContent div a:visited,.footerContent div a .yshortcuts {
            color:#336699;
            font-weight:normal;
            text-decoration:underline;
        }
        .footerContent img{
            display:inline;
        }
        #social{
            background-color:#379dbd;
            border:0;
        }
        #social div{
            text-align:center;
        }
        #utility{
            background-color:#379dbd;
            border:0;
        }
        #utility div{
            text-align:center;
        }
        #monkeyRewards img{
            max-width:190px;
        }
        body,#backgroundTable{
            background-color:#ff91ae;
        }
        .headerContent a:link,.headerContent a:visited,.headerContent a .yshortcuts{
            color:#336699;
        }
    /*]]>*/
    </style>
</head>

<body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0" style="-webkit-text-size-adjust: none;margin: 0;padding: 0;background-color: #ff91ae; width: 100% !important;">
    <center>
        <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="backgroundTable" style="margin: 0;padding: 0;background-color: #ff91ae;height: 100% !important;width: 100% !important; background-image:url(\'http://client.anotherwayin.fr/1.1/newsletter/2_prevenirclient/bg-cakeshop.jpg\');background-repeat:repeat-x;background-position:center top;">
            <tr>
                <td align="center" valign="top" style="border-collapse: collapse;">
                    <table border="0" cellpadding="0" cellspacing="0" width="600" id="templateContainer" style="border:0;background-color: #FFFFFF;border-top: none !important;border-bottom: none !important;">
                        <tr>
                            <td align="center" valign="top" style="border-collapse: collapse;">
                                <table border="0" cellpadding="0" cellspacing="0" width="600" id="templateContainer" style="border:0;background-color: #FFFFFF;border-top: none !important;border-bottom: none !important;">
                                    <tr>
                                        <td align="center" valign="top" style="border-collapse: collapse;">
                                            <!-- // Begin Template Header \\ -->

                                            <table border="0" cellpadding="0" cellspacing="0" width="600" id="templateHeader" style="border-bottom: 0;">
                                                <tr>
                                                    <td class="headerContent" style="border-collapse: collapse;color: #202020;font-family: Arial;font-size: 34px;font-weight: bold;line-height: 100%;padding: 0;text-align: center;vertical-align: middle;"><!-- // Begin Module: Standard Header Image \\ -->
                                                    <img src="http://client.anotherwayin.fr/1.1/newsletter/2_prevenirclient/header.jpg" style=" max-width:600px;" id="headerImage campaign-icon" mc:label="header_image" mc:edit="header_image" mc:allowdesigner="" mc:allowtext="" /> <!-- // End Module: Standard Header Image \\ --></td>
                                                </tr>
                                            </table><!-- // End Template Header \\ -->
                                        </td>
                                    </tr><!-- // Begin Template Preheader \\ -->
                                </table><!-- // End Template Preheader \\ -->
                            </td>
                        </tr>

                        <tr>
                            <td align="center" valign="top" style="border-collapse: collapse;">
                                <!-- // Begin Template Body \\ -->

                                <table border="0" cellpadding="0" cellspacing="0" width="600" id="templateBody">
                                    <tr>
                                        <td colspan="3" valign="top" class="bodyContent" style="border-collapse: collapse;background-color: #FFFFFF;">
                                            <!-- // Begin Module: Standard Content \\ -->

                                            <table border="0" cellpadding="20" cellspacing="0" width="100%">
                                                <tr>
                                                    <td valign="top" style="border-collapse: collapse;">
                                                        <div style="color: #505050;font-family: Arial;font-size: 14px;line-height: 150%;text-align: center;">
                                                            <h2 class="h2" style="color: #202020;display: block;font-family: Arial;font-size: 22px;font-weight: bold;line-height: 100%;margin-top: 0;margin-right: 0;margin-bottom: 10px;margin-left: 0;text-align: center;">'.$this->message_titre.'</h2><strong>'.$this->message_soustitre.'</strong><br />
                                                            
                                                      '.$this->message_texte.'
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table><!-- // End Module: Standard Content \\ -->
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                        <tr>
                            <td align="center" valign="top" style="border-collapse: collapse;">
                                <!-- // Begin Template Footer \\ -->

                                <table border="0" cellpadding="10" cellspacing="0" width="600" id="templateFooter" style="background-color: #379dbd;border-top: 0;">
                                    <tr>
                                        <td valign="top" class="footerContent" style="border-collapse: collapse;">
                                            <!-- // Begin Module: Standard Footer \\ -->

                                            <table border="0" cellpadding="10" cellspacing="0" width="100%">
                                                <tr>
                                                    <td valign="top" width="350" style="border-collapse: collapse;">
                                                        <div style="color: #DDD;font-family: Arial;font-size: 12px;line-height: 125%;text-align: center;">
                                                            <em>Copyright &copy; 2012 The Cake Shop</em><br />
                                                            Webdesign et réalisation par Another Way In<br />
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2" valign="middle" id="utility" style="border-collapse: collapse;background-color: #379dbd;border: 0;">
                                                        <div style="color: #707070;font-family: Arial;font-size: 12px;line-height: 125%;text-align: center;">
                                                            &nbsp;<a href="[[UNSUB_LINK_FR]]" style="color: #336699;font-weight: normal;text-decoration: underline;">Je souhaite me désinscrire définitivement de la mailing-list de The Cake Shop</a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table><!-- // End Module: Standard Footer \\ -->
                                        </td>
                                    </tr>
                                </table><!-- // End Template Footer \\ -->
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </center>
</body>
</html>
';
		
		return $code;
		
		
	}
	
	
	
	
	
}