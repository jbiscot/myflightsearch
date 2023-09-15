<?php 
declare(strict_types=1);

use Amadeus\Amadeus;
use Amadeus\Exceptions\ResponseException;

function loadAmadeus() {
	try {
			return Amadeus::builder($_ENV['AMADEUS_API_KEY'], $_ENV['AMADEUS_API_SECRET'])
			->build();
	} catch (ResponseException $e) {
		print $e;
	}
}

function getFlightOffers($params = []) {
	try {
		$amadeus = loadAmadeus();
		$payload = [
			"originLocationCode" => substr(htmlspecialchars($params['searchFieldFrom']), -4, 3),
			"destinationLocationCode" => substr(htmlspecialchars($params['searchFieldTo']), -4, 3),
			"departureDate" => htmlspecialchars($params['dateDepart']),
			"adults" => 1,
			"max" => 3
		];

		if(!empty($params["dateReturn"])) {
			$payload["returnDate"] = htmlspecialchars($params['dateReturn']);
		}

		if ($GLOBALS['testEnv']) {
			$payload = [
				"originLocationCode" => "CWB",
				"destinationLocationCode" => "GRU",
				"departureDate" => "2023-09-25",
				"returnDate" => "2023-12-25",
				"adults" => 1,
				"max" => 3
			];	
		}

		$init = $amadeus->getShopping()->getFlightOffers()->get($payload);
		$resultBody = $init[0]->getResponse()->getBody();
		$flightOfferData = (json_decode($resultBody))->data;
		$flightOfferDictionaries = (json_decode($resultBody))->dictionaries;

		return ['flightOfferData' => $flightOfferData, 'flightOfferDictionaries' => $flightOfferDictionaries];
	} catch (ResponseException $e) {
		echo "<br> --------- <br>";
		echo 'Error <br>';
		print $e;
		echo "<br> --------- <br>";
	}
} 