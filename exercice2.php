<?php
$pdo = new PDO('mysql:dbname=colyseum;host=localhost; charset=utf8', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

$typedecarte = [];
$statement = $pdo->query('SELECT id, type FROM cardTypes');
$typedecarte = $statement->FetchAll();


?>
<!DOCTYPE html>
<html>
<head>
	<title>FORMAULAIRE</title>
		<link rel="stylesheet" type="text/css" href="style/css/style.css">
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="	sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>

<body>

<a href="index.php"> Retour sommaire</a>

<?php

$erreur = [];
if (isset($_POST) && !empty($_POST)) {
	$donner=[];

		if (isset($_POST["nom"]) && $_POST['nom']!='') {
			$donner['lastname'] = $_POST["nom"];
		}else{
			$erreur[] = 'merci de mettre un nom';
		}

		if (isset($_POST["prenom"]) && $_POST['prenom']!='') {
			$donner['firstName'] = $_POST["prenom"];
		}else{
			$erreur[] = 'merci de mettre un prenom';
		}

		if (isset($_POST["naissance"]) && $_POST['naissance']!='') {
			$donner['birthDate'] = $_POST["naissance"];
		}else{
			$erreur[] = 'merci de mettre une date naissance';
		}

		if (isset($_POST["card"])) {
			$donner['card'] = 1;
		
				if (isset($_POST["numeCard"])) {
				$donner['cardNumber'] = $_POST["numeCard"];
				}else{
				$erreur[] = 'merci de mettre un numéro carte';
				}
		}else{
			$donner['card'] = 0;
			$donner['cardNumber'] = null;
		}


		if (empty($erreur)) {

			/*INSERT TO INTO nomdelatable SET*/
			$statement = $pdo->prepare("
				INSERT INTO clients
				SET lastname = :lastname,
				firstName = :firstName,
				birthDate = :birthDate,
				card = :card,
				cardNumber = :cardNumber");

			$statement->execute($donner);



$erreur[] = "<div class='list-group-item list-group-item-success'>le client est bien ADD'</div>";
			
		}
	}


?>

<h1> Ajout de client + Carde Fidéliter </h1>
	<nav class="navbar navbar-inverse">
 	 ...
	</nav>





<?php foreach ($erreur as $value) {
	echo "<li class='list-group-item list-group-item-danger'> $value <li> <br>" ;
}
?>
<div class="row">
<form method="post" class="form-inline">
	<div class="form-group">
		<div class="col-sm-12 ">
			<label class="col-sm-3 control-label"> Votre nom : <input type="text" class="form-control" name="nom" placeholder="Nom"></label>
		</div>
 		<div class="col-sm-12">
			<label class="col-sm-3 control-label"> Votre Prenom : <input type="text" class="form-control" name="prenom" placeholder="Prenom"></label>
		</div>
 		<div class="col-sm-12">
			<label class="col-sm-3 control-label"> Date de naissance : <input type="date" class="form-control" name="naissance"></label>
		</div>
	 	<div class="col-sm-12">
			<label class="col-sm-3 control-label"> Carte de fidélité ? : <input type="checkbox" name="card"> </label>
 		
			<label class="col-sm-3 control-label"> Le numéro de carte : <input type="number" class="form-control" name="numeCard" placeholder="Numéro"></label>
		</div>
				  <select class="col-sm-3" name="typecarte">
				  <?php foreach ($typedecarte as $value) {
				  	echo "<option valueur=$value->id>.$value->type.</option>";
				  }
				  ?>

  </select>
  <br>
		<div class="form-group">

 
    		<div class="col-sm-offset-2 col-sm-10">
				<button class="btn btn-default" type="submit">OK</button>
			</div>
		</div>
	</div>
</div>
</form>
</body>
</html>