// TOGGLE SIDEBAR
const menuBar = document.querySelector('#content nav .bx.bx-menu');
const sidebar = document.getElementById('sidebar');

menuBar.addEventListener('click', function () {
	sidebar.classList.toggle('hide');
})

//theme
const switchMode = document.getElementById('switch-mode');

switchMode.addEventListener('change', function () {
	if (this.checked) {
		document.body.classList.add('dark');
	} else {
		document.body.classList.remove('dark');
	}
})
//chart
document.addEventListener("DOMContentLoaded", function () {
	// start: Charts
	const labels = [
		'January',
		'February',
		'March',
		'April',
		'May',
		'June',
	];
	var salesChartBox = document.querySelector('#sales-chart');
	const salesChart = new Chart(salesChartBox, {
		type: 'bar',
		data: {
			labels: labels,
			datasets: [{
				backgroundColor: '#6610f2',
				data: [5, 10, 5, 2, 20, 30, 45],
			}]
		},
		options: {
			plugins: {
				legend: {
					display: false
				}
			},
			maintainAspectRatio: false,
			width: 450
		}
	})

	var visitorsChartBox = document.querySelector('#visitors-chart');
	const visitorsChart = new Chart(visitorsChartBox, {
		type: 'doughnut',
		data: {
			labels: ['Children', 'Teenager', 'Parent'],
			datasets: [{
				backgroundColor: ['#6610f2', '#198754', '#ffc107'],
				data: [40, 60, 80],
			}]
		},
		options: {
			plugins: {
				legend: {
					display: true
				}
			},
			maintainAspectRatio: false,
			width: 250
		}
	})
	// end: Charts

});