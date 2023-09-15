<?php
	require_once '../vendor/autoload.php';
	require_once 'config.php';
	require_once 'database.php';
	require_once 'core/App.php';
	require_once 'core/Controller.php';
	require_once 'utils.php';

	use Dotenv\Dotenv;

	//Starting the .env variable
	$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
	$dotenv->safeLoad();
?>