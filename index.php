<?php

define("publicKey", "public.pem");


class servidorA{
	
	private $msj;

	public function __construct($msj){
		$this->msj = $msj;
		$this->encriptarA();
	}

	private function encriptarA(){

		$publicKeys = openssl_get_publickey(file_get_contents(publicKey));
		openssl_seal($this->msj, $encryptedText, $encryptedKeys, array($publicKeys), "RC4");
		$hexpic = base64_encode($encryptedKeys[0]);
		$this->msj = base64_encode($encryptedText);
		$dataResponder = array("encryptedText" => $this->msj, "bodyKey" => $hexpic);
		echo json_encode($dataResponder);
		die();
	}

}

if(isset($_POST['json'])){
	new servidorA($_POST['json']);
}
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Comunicacion</title>
	<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
	<style>
		#app{
			width: 830px;
			height: auto;
			display: inline-block;
			white-space: normal;
			overflow-wrap: break-word;
		}
	</style>
</head>
<body>
	<div id="app">Loading...</div>
	<script type="text/javascript">
		$(document).ready(function(){
			let globalUser = [];
			fetch('https://dummyjson.com/users/')
			.then(res => res.json())
			.then((data) => {
				for(let i = 0; i < 10; i++){
					globalUser.push(data["users"][Math.floor((Math.random() * 30))])
				}
				$.ajax({
		            type: "POST",
		            url: '',
		            data: {"json": JSON.stringify(globalUser)},
		            success: function(response){
						$("#app").html(response)
					}
				})
			});
		})
	</script>
</body>
</html>