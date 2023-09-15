function setupSearch(searchField, resultsList) {
	let selectedOptionIndex = -1;

	function filterResults(searchTerm) {
		const filteredData = data.filter(item => item.toLowerCase().includes(searchTerm.toLowerCase()));
		displayResults(filteredData.slice(0, 5));
	}

	function displayResults(results) {
		resultsList.innerHTML = '';
		if (results.length === 0) {
			resultsList.style.display = 'none';
		} else {
			resultsList.style.display = 'block';

			results.forEach((result, index) => {
				const li = document.createElement('li');
				li.textContent = result;
				li.classList.add('list-group-item');
				li.addEventListener('click', () => {
					searchField.value = result;
					resultsList.style.display = 'none';
				});

				li.addEventListener('mouseenter', () => {
					selectedOptionIndex = index;
					updateSelectedOption();
				});

				resultsList.appendChild(li);
			});
		}
		selectedOptionIndex = -1;
	}

	searchField.addEventListener('input', () => {
		const searchTerm = searchField.value.trim();
		if (searchTerm === '') {
			resultsList.style.display = 'none';
		} else {
			filterResults(searchTerm);
		}
	});

	searchField.addEventListener('keydown', (e) => {
		if (e.key === 'ArrowDown') {
			e.preventDefault();
			selectedOptionIndex = Math.min(selectedOptionIndex + 1, resultsList.children.length - 1);
			updateSelectedOption();
		} else if (e.key === 'ArrowUp') {
			e.preventDefault();
			selectedOptionIndex = Math.max(selectedOptionIndex - 1, -1);
			updateSelectedOption();
		} else if (e.key === 'Enter') {
			e.preventDefault();
			if (selectedOptionIndex >= 0) {
				const selectedOption = resultsList.children[selectedOptionIndex];
				searchField.value = selectedOption.textContent;
				resultsList.style.display = 'none';
			}
		}
	});

	resultsList.addEventListener('mouseleave', () => {
		selectedOptionIndex = -1;
		updateSelectedOption();
	});

	function updateSelectedOption() {
		for (let i = 0; i < resultsList.children.length; i++) {
			const li = resultsList.children[i];
			li.classList.toggle('active', i === selectedOptionIndex);
		}
	}
}

// Add event listeners to all tab links
var allTabs = document.querySelectorAll(".nav-link");

allTabs.forEach(function (tab) {
	tab.addEventListener("click", function () {
		updateActiveTab(tab);
	});
});

function updateActiveTab(clickedTab) {
	// Remove the "active" class from all tab links
	var tabLinks = document.querySelectorAll(".nav-link");

	tabLinks.forEach(function (link) {
		link.classList.remove("active");
		link.removeAttribute("aria-current");
	});

	// Add the "active" class to the clicked tab link
	clickedTab.classList.add("active");
	clickedTab.setAttribute("aria-current", "page");

	// Update the hidden input value when a tab is clicked
	var activeTabInput = document.getElementById("activeTab");
	activeTabInput.value = clickedTab.id;

	// Handle the dateReturn toggle functionality
	var dateReturnElements = document.getElementById("dateReturnElements");
	if (clickedTab.id === "oneWayTab") {
		dateReturnElements.style.display = "none";
	} else {
		dateReturnElements.style.display = "block";
	}
}

// Usage example for two elements
const searchFields = document.getElementsByClassName('searchDrop');
const resultsLists = document.getElementsByClassName('resultsList');

// Loop through the elements and set up the search functionality for each
for (let i = 0; i < searchFields.length; i++) {
	setupSearch(searchFields[i], resultsLists[i]);
}

document.addEventListener("DOMContentLoaded", function () {
	const departureDateInput = document.getElementById("dateDepart");
	const returnDateInput = document.getElementById("dateReturn");

	// Set minimum and maximum dates
	const today = new Date();
	const maxDepartureDate = new Date(today);

	maxDepartureDate.setFullYear(today.getFullYear() + 1);

	departureDateInput.min = today.toISOString().split("T")[0];
	departureDateInput.max = maxDepartureDate.toISOString().split("T")[0];

	returnDateInput.min = today.toISOString().split("T")[0];
	returnDateInput.max = maxDepartureDate.toISOString().split("T")[0];

	// Add event listener for departureDate change
	departureDateInput.addEventListener("blur", function() {
		if (this.value < today.toISOString().split("T")[0]) {	
			this.value = "";

			return;
		} 

		// Update minimum returnDate based on departureDate
		returnDateInput.min = this.value;

		// Clear returnDate value if it's invalid based on new departureDate
		if (returnDateInput.value < this.value) {
			returnDateInput.value = "";
		}
	});

	// Add event listener for returnDate change
	returnDateInput.addEventListener("change", function () {
		// Check if returnDate is valid based on departureDate
		if (this.value < departureDateInput.value) {
			this.value = "";
		}
	});
});
