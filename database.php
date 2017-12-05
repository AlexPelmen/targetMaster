<?php
	function link_db(){
		
		$server = "localhost";
		$login = "root";
		$password = "";
		$DB = "targetMaster";

		
		return new mysqli($server,$login,$password,$DB);		
	} 
