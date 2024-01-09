<?php
	// connecting the database
	$conn = new PDO('sqlite:'.__DIR__.'/../database/database.db');
	//Setting connection attributes
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
