$(document).ready(function(){
	$.ajax({
		url: "https://mywalletx.000webhostapp.com/dataChart.php",
		method: "GET",
		success: function(data) {
			console.log(data);
			var cats = [];
			var sums = [];

			for(var i in data) {
				cats.push("Category " + data[i].cat_name);
				sums.push(data[i].sumAx);
			}

			var chartdata = {
				labels: cats,
				datasets : [
					{
						label: 'cat_name sumAx',
						backgroundColor: 'rgba(200, 200, 200, 0.75)',
						borderColor: 'rgba(200, 200, 200, 0.75)',
						hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
						hoverBorderColor: 'rgba(200, 200, 200, 1)',
						data: sums
					}
				]
			};

			var ctx = $("#mycanvas");

			var barGraph = new Chart(ctx, {
				type: 'bar',
				data: chartdata
			});
		},
		error: function(data) {
			console.log(data);
		}
	});
});