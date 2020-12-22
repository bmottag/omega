<link href="<?php echo base_url("assets/bootstrap/vendor/fullcalendar/lib/main.css"); ?>" rel="stylesheet">
<script src="<?php echo base_url("assets/bootstrap/vendor/fullcalendar/lib/main.js"); ?>"></script>

<script>
	document.addEventListener('DOMContentLoaded', function() {
		var calendarEl = document.getElementById('calendar');

		var calendar = new FullCalendar.Calendar(calendarEl, {

			headerToolbar: {
				left: 'prev,next today',
				center: 'title',
				right: 'listDay,listWeek'
			},

			// customize the button names,
			// otherwise they'd all just say "list"
			views: {
				listDay: { buttonText: 'List day' },
				listWeek: { buttonText: 'List week' }
			},

			buttonText: { today:    'Today' },
			firstDay: 1, //para iniciar en lunes

			initialView: 'listDay',
			navLinks: true, // can click day/week names to navigate views
			editable: true,
			dayMaxEvents: true, // allow "more" link when too many events
			events: {
				url: 'dashboard/consulta',
				method: 'POST',
				extraParams: {
					custom_param1: 'something',
					custom_param2: 'somethingelse'
				},
				failure: function() {
					alert('There was an error while fetching events!');
				},
				color: 'green',   // a non-ajax option
				textColor: 'black' // a non-ajax option
			}
    	});
    	calendar.render();
  	});
</script>

<div id="page-wrapper">
	<br>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h4 class="list-group-item-heading">
					<i class="fa fa-gear fa-fw"></i> SETTINGS - EMPLOYEE
					</h4>
				</div>
			</div>
		</div>
		<!-- /.col-lg-12 -->				
	</div>
	
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">

			<div id='calendar'></div>
			<br>
			<!-- /.panel -->
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<!-- /.row -->
</div>
<!-- /#page-wrapper -->