<?php
require_once '../app/components/amadeusApi.php';

use GuzzleHttp\Client;
use GuzzleHttp\Promisse;
use Psr\Http\Message\ResponseInterface;

$globals = $GLOBALS;
$globals['testEnv'] = false;

class flightSearch extends Controller {

	public function __construct() {
		//fill database with aiports data
		if(isCollectionEmpty($_ENV['airportsCol'])) {
			$airports = [];
			
			try {
				$client = new Client(['base_uri' => 'http://api.travelpayouts.com']);
				$response = $client->request('GET', '/data/en/airports.json');

				if (200 == $response->getStatusCode()) {
					$body = $response->getBody();	
					$arr_body = json_decode($body);

					
					foreach ($arr_body as $airport) {
						array_push($airports, $airport->name . ' (' . $airport->code . ')');
					}

					sort($airports);
				}
				
				$insertCollection = loadCollection($_ENV['airportsCol']);
				$insertCollection->insertOne([$airports]);
			} catch (\Throwable $th) {
				throw new Exception("Error Processing Request", 1);
			}
		}
	}

	public function index() {
		$airports = loadAirports();

		$this->view('flight/flightSearch', ['airports' => $airports]);
	}

	public function search() {
		$searchData = [];
		$searchDictionaries = [];

		if (isset($_POST['togTestMode'])){
			$GLOBALS['testEnv'] = true;
		}

		if ($_SERVER["REQUEST_METHOD"] === "POST" && isValidSearch($_POST)) {
			$searchData = getFlightOffers($_POST)['flightOfferData'];
			$searchDictionaries = getFlightOffers($_POST)['flightOfferDictionaries'];
		}

		$airports = loadAirports();

		$this->view('flight/flightSearch', ['searchData' => $searchData, 'searchDictionaries' => $searchDictionaries, 'airports' => $airports]);
	}
}


function loadAirports() {
	//Load Db Airport Document
	$collection = loadCollection($_ENV['airportsCol']);
	$airports = $collection->findOne()[0];
	$airports->bsonSerialize();

	return $airports;
}

function isValidSearch($params) {
	if($GLOBALS['testEnv']) {
		return true;
	}

	if (!$_POST['searchFieldFrom']) {
		echo 'search field params empty';

		return;
	}

	return !empty($params["searchFieldFrom"]) && !empty($params["searchFieldTo"]) && !empty($params["dateDepart"]);
}

function getCarrierName($searchResultDictionary, $carrierCode) {
	try {
		$carrierName = $searchResultDictionary->$carrierCode ?
			ucwords(strtolower($searchResultDictionary->$carrierCode)) :
			'';

		if ($carrierName && strtolower(substr($carrierName, -3)) == ('s/a' || 'ltd')) {
			$carrierName = substr($carrierName, 0, -3);
		}
	} catch (\Throwable $th) {
		throw new Exception("Error Getting Carrier Name", 1);
	}

	return $carrierName;
}

function getCarrierLogo($searchResultDictionary, $carrierCode){
}

function getFlightTime($flightTime, $convertToType)
{
	$dateTime = new DateTime($flightTime);

	if ($convertToType === 'time') {	
		// Format time as lowercase and determine 'am' or 'pm'
		$formattedTime = strtolower($dateTime->format('h:ia'));

		return $formattedTime;
	} elseif ($convertToType === 'date') {
		// Format date as 'D, M d'
		$formattedDate = $dateTime->format('D, M d');
		return $formattedDate;
	} else {
		return "Invalid type parameter";
	}
}

function getFlightDuration($flightDuration){
	return strtolower(str_replace(['PT', 'H'], ['', 'h '], $flightDuration));
}

function printItineraryDirection()
{
	$counter = 0;

	return function () use (&$counter) {
		$counter++;

		if ($counter == 1) {
			return "Outbound Flight";
		} elseif ($counter == 2) {
			$counter = 0;

			return "Inbound Flight";
		}
	};
}