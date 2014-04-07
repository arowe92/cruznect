<?php 
	include 'functions.php';

	$id= $_GET['id'];

	$query=sprintf("
		UPDATE projects
		SET active=0 
		WHERE id='$id'
		");

	Query($query);

	header('Location: index.php');

?>