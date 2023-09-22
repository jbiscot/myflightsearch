<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>myflightsearch</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
			integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

	<!-- LocalStyles -->
	<link href="/assets/css/flightSearchView.css" rel="stylesheet" class="rel">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

	<style>
		/* Set of background card colors */
		.segment:nth-child(6n + 1) {
			background-color: #FFFFCC;
		}

		.segment:nth-child(6n + 2) {
			background-color: #FFFF;
		}

		.segment:nth-child(6n + 3) {
			background-color: #CFD2CF;
		}

		.segment:nth-child(6n + 4) {
			background-color: #ffd1b0; 
		}

		.segment:nth-child(6n + 5) {
			background-color: #FF9999;
		}

		.segment:nth-child(6n + 6) {
			background-color: #ada0d8;
		}

		.list-inline-item {
			padding-left:0.5rem;
		}

		.dashed {
			border: none;
			height: 1px;
			background: #000;
			background: repeating-linear-gradient(90deg,#000,#000 6px,transparent 6px,transparent 12px);
		}

		.searchCardBody {
			background: rgb(255,255,255);
			background: linear-gradient(180deg, rgba(255,255,255,1) 0%, rgba(70,125,170,1) 79%);
		}

		.footer {
			margin-top: 1%;
			background: rgb(255,255,255);
			background: linear-gradient(0deg, rgba(255,255,255,1) 26%, rgba(255,245,225,1) 100%);
		}
	</style>

</head>
<body class="d-flex flex-column vh-100" style="background-color:#FFF5E1">
<?php
	$searchData = array_key_exists('searchData', $data) ? $data['searchData'] : [];
	$searchDictionaries = array_key_exists('searchDictionaries', $data) ? $data['searchDictionaries'] : [];
?>

<header>
	<div class="bg-light collapse" id="navbarHeader" style="">
		<div class="container">
			<div class="row">
				<div class="col-sm-8 col-md-7 py-4">
					<h4 class="text-dark mb-3">about</h4>
					<p class="text-muted fs-sm"  style ="text-indent:2rem">
						Welcome to MyFlightSearch, a <strong><em>PHP</em></strong> project designed using the <strong><em>MVC architecture</em></strong>. This website is currently hosted on <strong><em>Heroku</em></strong>, where it integrates the robust <strong><em>Amadeus Flight Search API</em></strong> and <strong><em>Bootstrap</em></strong>, aiming to deliver a sleek and user-friendly interface.
					</p>
					<p class="text-muted fs-sm"  style ="text-indent:2rem">
						To embark on this project was to fully immerse myself in the world of PHP, embracing its fundamentals in the most 'vanilla' way possible. It's still a work in progress, but it serves as a testament to my commitment to ongoing growth and refinement :)
					</p>
					<p class="text-muted fs-sm"  style ="text-indent:2rem">
						I'd love to hear your thoughts on my project!
					</p>
				</div>
				<div class="col-sm-4 offset-md-1 py-4 d-flex align-items-center justify-content-center">
					<div>
						<h4 class="text-dark fs-6">contact me</h4>
						<ul class="list-unstyled text-muted">
						<li><a href="https://github.com/jbiscot" rel="noopener" target="_blank" class="text-dark text-muted" style="text-decoration: none"><i class="bi bi-github pe-2"></i>jbiscot</a></li>
						<li><i class="bi bi-envelope-at pe-2 text-muted" ></i>biscodev@gmail.com</a></li>
						</ul>
					</div>
			</div>
			</div>
	</div>
	</div>
	<div class="navbar navbar-light bg-light shadow-sm">
	<div class="container">
		<a href="#" class="navbar-brand d-flex align-items-center">
			<i class="bi bi-airplane pe-2"></i>
			<strong>myflightsearch</strong>
		</a>
		<button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
	</div>
	</div>
</header>
  
<main class="container mt-5 mb-5 px-sm-1 px-md-0 col-md-8 col-lg-7">
	<!-- search form -->
	<div class="card text-center">
		<div class="card-header">
			<ul class="nav nav-tabs card-header-tabs">
				<li class="nav-item">
				<a class="nav-link active" id="roundTripTab" aria-current="page" href="#">Round Trip</a>
				</li>
				<li class="nav-item">
				<a class="nav-link" id="oneWayTab" href="#">One Way</a>
				</li>
			</ul>
		</div>
	
		<div class="card-body searchCardBody rounded" >
				<form class="row g-3"  action="<?= ROOT ?>/flightSearch/search" method="post">
					<!-- test mode toggle -->
					<div class="col-md-12 form-check form-switch d-flex justify-content-end">
						<input type="checkbox" id="togTestMode" name="togTestMode" class="form-check-input" style="margin-inline: 0.5rem;">
						<label class="form-check-label" for="flexSwitchCheckDefault">test mode</label>
					</div>

					<input type="hidden" id="activeTab" name="activeTab" value="roundTripTab">

					<div class="col-md-12">
						<label for="inputState" class="form-label">From</label>
						<input type="text" id="searchFieldFrom" name="searchFieldFrom" class="form-control searchDrop" accessibility.tabfocus=1 autocomplete="off" placeholder="Search...">
						<ul class="list-group mt-2 dropdown-menu dropdown-menu-start resultsList" id="resultsList" style="display: none"></ul>
					</div>

					<div class="col-md-12">
						<label for="inputState" class="form-label">To</label>
						<input type="text" id="searchFieldTo" name="searchFieldTo" class="form-control searchDrop" accessibility.tabfocus=2 autocomplete="off" placeholder="Search...">
						<ul class="list-group mt-2 dropdown-menu dropdown-menu-start resultsList" id="resultsList" style="display: none;"></ul>
					</div>

					<div class="col-6">
						<label for="inputAddress" class="form-label">Depart</label>
						<input type="date" name="dateDepart" class="form-control" id="dateDepart" accessibility.tabfocus=3 placeholder="">
					</div>

					<div class="col-6" id="dateReturnElements">
						<label for="inputAddress" class="form-label">Return</label>
						<input type="date" name="dateReturn" class="form-control" id="dateReturn" accessibility.tabfocus=4 placeholder="">
					</div>

					<div class="col-12">
						<button type="submit" class="btn btn-outline-light mt-4 btn-lg" style="border-color: #ffff !important; background: #e66d3d !important;" accessibility.tabfocus=5>Search Flights</button>
					</div>
				</form>
		</div>
	</div>

	<!-- search results -->
	<div class="card text-center mb-5" style="display: contents">
		<div class="card text-center" style="display: contents; background: #467daa">
		<?php
			if ($searchData) {
				foreach ($searchData as $row) {
					echo '<div class="card">';
					echo '<div class="card-body border-0 rounded" style="background: #467daa">';
					echo '<form class="row g-2 m-0" action="' . $_SERVER['REQUEST_URI'] . '" method="POST">';
					echo '<div class="border border-dark py-1" style="background-color: lemonchiffon">';

					$printItineraryDirection = printItineraryDirection();
					
					foreach ($row->itineraries as $itinerary) {
						echo '<div class="itineraryDirection">';
						echo '<div class="itineraryDirectionTitle mt-2 small lh-sm">' . $printItineraryDirection() . '</div>';

						foreach ($itinerary->segments as $segment) {
							echo '<div class="segment row border border-dark rounded mb-2 small lh-sm" style="background-color: ">';
							echo '<div class="carrier-info col-sm-3 pt-2">';
							echo '<div class="row">';
							echo '<div class="col-2 col-sm-3 d-flex justify-content-center align-items-center">';
							echo '<div class="carrier-logo image">';
							echo 'LOGO';
							echo '</div>';
							echo '</div>';
							echo '<div class="col-10 col-sm-9">';
							echo '<div class="carrier-name text-start">' . getCarrierName($searchDictionaries->carriers, $segment->carrierCode) . '</div>';
							echo '<div class="carrier-flight-number text-start"><span>Flight </span>' . $segment->number . '</div>';
							echo '</div>';
							echo '</div>';
							echo '</div>';
							echo '<div class="col-sm-9 py-2">';
							echo '<div class="row">';
							echo '<div class="flight-location-details col-8 col-sm-6 text-start">';
							echo '<ul class="flight-departure list-inline mb-2">';
							echo '<li class="flight-direction text-muted">Departure</li>';
							echo '<li class="flight-airport list-inline-item">' . $segment->departure->iataCode . '</li>';
							echo '<li class="flight-date list-inline-item">' . getFlightTime($segment->departure->at, 'date') . '</li>';
							echo '<li class="flight-time list-inline-item fw-bold">' . getFlightTime($segment->departure->at, 'time') . '</li>';
							echo '</ul>';
							echo '<hr class="my-1 dashed">';
							echo '<ul class="flight-arrival list-inline mb-2">';
							echo '<li class="flight-direction text-muted">Arrival</li>';
							echo '<li class="flight-airport list-inline-item">' . $segment->arrival->iataCode . '</li>';
							echo '<li class="flight-date list-inline-item">' . getFlightTime($segment->arrival->at, 'date') . '</li>';
							echo '<li class="flight-time list-inline-item fw-bold">' . getFlightTime($segment->arrival->at, 'time') . '</li>';
							echo '</ul>';
							echo '</div>';
							echo '<div class="col-4 col-sm-6 text-end">';
							echo '<ul class="list-group">';
							echo '<ui class="flight-class">Economy</ui>';
							echo '<ui class="flight-duration">' . getFlightDuration($segment->duration) . '</ui>';
							echo '</ul>';
							echo '</div>';
							echo '</div>';
							echo '</div>';
							echo '</div>';
						}
						echo '</div>';	
					}

					// <!-- price and selection -->
					echo '<div class="row mb-2 mx-2">';
					echo '<div class="itineraryPrice col-sm-9 d-flex align-items-center justify-content-center fs-5">';
					echo '<span> Total: <span class="final-price fw-bold">' . $row->price->grandTotal . ' ' . '</span> <span>' . $row->price->currency . '</span>';
					echo '</div>';
					echo '<div class="col-sm-3 d-grid rounded p-0" style="background-color:lemonchiffon">';
					echo '<button class="btn-select-flight btn btn-outline-success btn-md fw-bold text-nowrap" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">SELECT FLIGHT</button>';
					echo '</div>';
					echo '</div>';
					echo '</div>';
					echo '</form>';
					echo '</div>';
					echo '</div>';
				}
			}
		?>
		</div>		
	</div>

	<!-- offcanvas flight selection -->
	<div class="card text-center" style="display: contents">
		<div class="offcanvas offcanvas-start" data-bs-scroll="false" data-bs-backdrop="true" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
			<div class="offcanvas-header pb-2" style="background-color:">
				<h5 class="offcanvas-title" id="offcanvasWithBothOptionsLabel">Reservation Details</h5>
				<button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
			</div>
			<div class="offcanvas-body pt-0" id="offcanvasInfo">
				<div class="container" id="formReserveAndPay">
					<form>
						<div class="row" id="cardRow"></div>
						<div class="d-grid py-2">
								<p id="reservationPrice" class="h5 fst-italic">...</p>
						</div>
						<div class="border rounded d-grid shadow" style="background-color:#fbd75f">
								<button type="submit" id="btnConfirmAndReserve" class="btn btn-outline-success btn-sm font-m-1 fs-6">Confirm and Reserve</button>
						</div>
					</form>
				</div>			
			</div>
		</div>
	</div>
	
</main>

<footer class="footer py-5 px-3 vh-100 text-center font-monospace d-flex flex-column">
	<div class="container mt-auto"> 
	  <p class="float-end">
		<p class="mb-0">built by
			<a href="https://github.com/jbiscot" rel="noopener" target="_blank" class="text-dark" style="text-decoration: "><i class="bi bi-github pe-1"></i>jbiscot</a>
		</p>
	 	<p class="mb-0">using
			<a href="https://developers.amadeus.com" rel="noopener" target="_blank">Amadeus</a> flight search api.
		</p>
	</p>
	</div> 
</footer>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>	
	<script>var data=<?php echo json_encode($data['airports']) ?>;</script>
	<script src="/assets/javascripts/flightSearch.js"></script>

	<!-- script on search result -->
	<script>
		document.addEventListener("DOMContentLoaded", function() {
			const selectFlightButtons = document.querySelectorAll(".btn-select-flight");
			const offcanvas = document.getElementById("offcanvasWithBothOptions");

			// -------------------------------------------------------------------- SELECT FLIGHT -->
			selectFlightButtons.forEach(selectFlightButton => {
				selectFlightButton.addEventListener("click", function(event) {
					//event.preventDefault(); --> apparently not necessary

					const form = this.closest("form");
					if (!form) return;

					const itineraryPrice = form.querySelector(".itineraryPrice");
					const reservationTotalPrice = document.getElementById("reservationPrice");				
					reservationTotalPrice.innerText = itineraryPrice.innerText ? itineraryPrice.innerText : "";

					const itineraryDirections = form.querySelectorAll(".itineraryDirection");
						if (!itineraryDirections) return;

						itineraryDirections.forEach(itinerary => {
							const flightReserveCard = document.createElement("div");
							flightReserveCard.className = "flightReserveCard col-sm-12 my-2 mx-auto";

							const cardDiv = document.createElement("div");
							cardDiv.className = "card shadow-sm";
							flightReserveCard.appendChild(cardDiv);

							const cardTitle = document.createElement("h5");
							cardTitle.className = "card-title small mt-2";
							cardTitle.innerText = itinerary.querySelector(".itineraryDirectionTitle").innerText;
							cardDiv.appendChild(cardTitle);

							const cardBody = document.createElement("div");
							cardBody.className = "card-body text-start small lh-1";
							cardDiv.appendChild(cardBody);

							const flightSegments = itinerary.querySelectorAll(".segment");
							var segmentCounter = flightSegments.length;

							flightSegments.forEach(segment => {
								segmentCounter--;

								const flightElement1 = document.createElement("p");
								const flightAiportDeparture = segment.querySelector(".flight-departure .flight-airport");
								flightElement1.className = "card-text mb-2";
								flightElement1.innerText = "From: " + (flightAiportDeparture.innerText ? flightAiportDeparture.innerText : "");
								cardBody.appendChild(flightElement1);

								const flightElement2 = document.createElement("p");
								const flightAiportArrival = segment.querySelector(".flight-arrival .flight-airport");
								flightElement2.className = "card-text mb-2";
								flightElement2.innerText = "To: " + (flightAiportArrival.innerText ? flightAiportArrival.innerText : "");
								cardBody.appendChild(flightElement2);

								const flightElement3 = document.createElement("p");
								const flightDepartureDate = segment.querySelector(".flight-departure .flight-date");
								const fligthDepartureTime = segment.querySelector(".flight-departure .flight-time");
								flightElement3.className = "card-text mb-2";
								flightElement3.innerText = "Departure: " + (flightDepartureDate.innerText ? flightDepartureDate.innerText : "") + " at " + fligthDepartureTime.innerText;
								cardBody.appendChild(flightElement3);

								const flightElement4 = document.createElement("p");
								const flightArrivalDate = segment.querySelector(".flight-arrival .flight-date");
								const fligthArrivalTime = segment.querySelector(".flight-arrival .flight-time");
								flightElement4.className = "card-text mb-2";
								flightElement4.innerText = "Arrival: " + (flightArrivalDate.innerText ? flightArrivalDate.innerText : "") + " at " + fligthArrivalTime.innerText;
								cardBody.appendChild(flightElement4);

								const flightElement5 = document.createElement("p");
								const flightCarrier = segment.querySelector(".carrier-name");
								flightElement5.className = "card-text mb-2";
								flightElement5.innerText = "Flying: " + (flightCarrier.innerText ? flightCarrier.innerText : "");
								cardBody.appendChild(flightElement5);

								const flightElement6 = document.createElement("p");
								const flightNumber = segment.querySelector(".carrier-flight-number");
								flightElement6.className = "card-text mb-2";
								flightElement6.textContent = (flightNumber.innerText ? flightNumber.innerText : "");
								cardBody.appendChild(flightElement6);

								if(segmentCounter) {
									cardBody.appendChild(document.createElement("hr"));
								}
							});

							const cardRow = document.getElementById("cardRow");
							cardRow.appendChild(flightReserveCard);
						});
					//offcanvas.show(); --> apparently not necessary
				});
			});

			// -------------------------------------------------------------------- HIDE OFFCANVAS -->
			const hideOffcanvasHandler = () => {
				const confirmationMessage = document.querySelector(".successMessage");
				const formReserveAndPay = document.getElementById("formReserveAndPay");
				const cardRow = document.getElementById("cardRow");

				confirmationMessage ? confirmationMessage.remove() : null;
				formReserveAndPay.style.display = "block";
				cardRow.innerHTML = "";
			};

			offcanvas.addEventListener("hidden.bs.offcanvas", hideOffcanvasHandler);

			// -------------------------------------------------------------------- TRIP CONFIRM AND RESERVE BUTTON -->
			const confirmAndReserveButton = document.getElementById("btnConfirmAndReserve");

			confirmAndReserveButton.addEventListener("click", function(event) {
				event.preventDefault();
				 
				const successMessage = document.createElement("div");

				successMessage.className = "successMessage py-5";
				successMessage.textContent  = "Thanks for your reservation!";


				const formReserveAndPay = document.getElementById("formReserveAndPay");
				formReserveAndPay.style.display = 'none';
				formReserveAndPay.parentElement.appendChild(successMessage);
			});
		});
	</script>
</body>
</html>