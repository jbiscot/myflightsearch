<?php
	Global $client;

	$client = new MongoDB\Client($_ENV['URI']);

	function loadCollection($collection) {	
		global $client;
		$databaseName = $_ENV['DB_NAME'];
		$database = $client->$databaseName;

		return $database->$collection;
	}

	function isDocumentInCollection($collection, $fieldName, $value) {
		$collection = loadCollection($collection);
		$criteria = [$fieldName => $value];
		$result = $collection->countDocuments($criteria);

		return $result;
	}

	function isCollectionEmpty($collection) {
		$collection = loadCollection($collection);
		$result = $collection->countDocuments();
		
		return $result == 0;
	}

