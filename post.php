<?php
	include_once("back.php");

	$description=$_POST['description'];
	$title=$_POST['title'];
	$category=$_POST['category'];
	$lat=$_POST['lat'];
	$lng=$_POST["lng"];
	$image=$_POST["image"];

	echo $description;
	echo $lat;
	echo $lng;

	$obj_post= new post();
	$obj=$obj_post->insertPost($description,$title,$category,$image,$lat,$lng);
	



?>
