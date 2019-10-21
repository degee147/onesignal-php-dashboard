<!--header-->
<?php include 'header.php'; ?>
<!--header-->



<!--sidebar-->
<?php include 'sidebar.php'; ?>
<!--sidebar-->

<!--content-->
<div class="content">

	<link rel="stylesheet" href="./assets/picker/wickedpicker.min.css">


	<div class="box-container container-25">
		<?php
		// $schedule = [
		// 	"feed" => "",
		// 	"sent_posts" => [

		// 	]
		// ];
		$file = file_get_contents('./schedule.json', FILE_USE_INCLUDE_PATH);
		$json = json_decode($file, true);
		// var_dump($json['feed']);
		// die();

		?>
		<div class="box" id="div-1">
			<h3>
				Send Notification
			</h3>
			<div class="box-content">
				<form class="form" id="scheduleform">
					<input type="hidden" name="dailyschedule" value="true">
					<ul>
						<li>
							<input name="feed" type="url" value="<?= !empty($json['feed']) ? $json['feed'] : '' ?>" id="input" placeholder="RSS Feed Url" maxlength="50" required>
						</li>

						<li>
							<!-- <input id="datetimepicker_dark" type="text" name="time" required> -->
							<input id="timepicker" type="text" name="time" class="timepicker" required>
						</li>

						<?php if (!empty($json['status'])) : ?>
							<li>Current Status: <?= $json['status'] == "stop" ? "stopped" : "in progress" ?></li>

						<?php endif; ?>

						<li>
							<button type="submit" id="startschedule" name="status" value="start">Start schedule</button>
							<button type="submit" id="stopschedule" name="status" value="stop">Stop schedule</button>
							<br><br> <i id="result"></i>
						</li>


					</ul>
				</form>
			</div>
		</div>
	</div>

	<div class="box-container container-75">
		<div class="box" id="div-2">
			<h3>
				Last 10 Sent Notifications
			</h3>
			<div class="box-content">
				<div class="table">
					<table>
						<thead>
							<tr>
								<th>Delivered</th>
								<th class="hide">Title</th>
								<th class="hide">Content</th>
								<th>Sent Date</th>
							</tr>
						</thead>
						<tbody>

							<?php
							$response = Notifications(10);

							$return = json_decode($response);
							foreach ($return->notifications as $notifi) {
								if ($notifi->data == null) {


									?>
									<tr>
										<td> <?= $notifi->successful; ?> </td>
										<td class="hide"> <?= $notifi->headings->en; ?> </td>
										<td class="hide"> <?= $notifi->contents->en; ?> </td>
										<td><span class="date"><?= gmdate("d-m-Y / H:i:s", $notifi->send_after); ?></span></td>
									</tr>
							<?php
								}
							}
							?>
						</tbody>
					</table>
				</div>

			</div>
		</div>
	</div>



</div>
<!-- <script src="./assets/datebuild/jquery.datetimepicker.min.js"></script> -->
<script src="./assets/picker/wickedpicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.js"></script>

<script>
	// $.datetimepicker.setDateFormatter({
	// 	parseDate: function(date, format) {
	// 		var d = moment(date, format);
	// 		return d.isValid() ? d.toDate() : false;
	// 	},

	// 	formatDate: function(date, format) {
	// 		return moment(date).format(format);
	// 	},

	// 	//Optional if using mask input
	// 	formatMask: function(format) {
	// 		return format
	// 			.replace(/Y{4}/g, '9999')
	// 			.replace(/Y{2}/g, '99')
	// 			.replace(/M{2}/g, '19')
	// 			.replace(/D{2}/g, '39')
	// 			.replace(/H{2}/g, '29')
	// 			.replace(/m{2}/g, '59')
	// 			.replace(/s{2}/g, '59');
	// 	}
	// });

	// jQuery('#datetimepicker_dark').datetimepicker({
	// 	format: "YYYY-MM-DD HH:mm:00 ZZ",
	// 	formatTime: 'HH:mm',
	// 	formatDate: 'DD-MM-YYYY',
	// 	//   minTime: moment().add(1, 'H').toDate(),
	// 	minDate: moment().add(1, 'H').toDate(),
	// 	inline: true,
	// 	useCurrent: true,
	// 	theme: 'dark',
	// 	lang: 'tr'
	// }).on("change", function(e) {
	// 	console.log("Date changed: ", e.target.value);
	// });


	$(function() {

		now = moment("<?= !empty($json['time']) ? $json['time'] : '' ?>", "h:mm:ss A").format("HH:mm:ss")

		var options = {
			now: now, //hh:mm 24 hour format only, defaults to current time
			// twentyFour: false, //Display 24 hour format, defaults to false
			// upArrow: 'wickedpicker__controls__control-up', //The up arrow class selector to use, for custom CSS
			// downArrow: 'wickedpicker__controls__control-down', //The down arrow class selector to use, for custom CSS
			// close: 'wickedpicker__close', //The close class selector to use, for custom CSS
			hoverState: 'hover-state', //The hover state class to use, for custom CSS
			title: 'Time for the schedule to run daily', //The Wickedpicker's title,
			// showSeconds: false, //Whether or not to show seconds,
			// timeSeparator: ' : ', // The string to put in between hours and minutes (and seconds)
			// secondsInterval: 1, //Change interval for seconds, defaults to 1,
			// minutesInterval: 1, //Change interval for minutes, defaults to 1
			// beforeShow: null, //A function to be called before the Wickedpicker is shown
			// afterShow: null, //A function to be called after the Wickedpicker is closed/hidden
			// show: null, //A function to be called when the Wickedpicker is shown
			clearable: false, //Make the picker's input clearable (has clickable "x")
		};
		$('.timepicker').wickedpicker(options);



		$('#scheduleform').on("submit", function() {
			// var sent = $(this).serialize();


			status = $(document.activeElement).val();
			// var sent = $(this).serialize();
			var sent = $(this).serializeArray();
			sent.push({
				name: "status",
				value: status
			});
			console.log(sent);
			$.ajax({
				type: "POST",
				url: "./notification_api.php",
				data: sent,
				dataType: "json",
				beforeSend: function() {
					$(':input[type="submit"]').prop('disabled', true);
					// $(':input[type="submit"]').fadeIn().html('Sending <i class="fa fa-spinner fa-spin hidespin"></i>');
					$('.hidespin').fadeIn().css('display', 'inherit');
				},
				success: function(result) {
					$(':input[type="submit"]').prop('disabled', false);
					$('.hidespin').css('display', 'none');
					// $(':input[type="submit"]').fadeIn().html('Send Notification');
					if (result.schedule) {
						$('#result').html(result.schedule).fadeIn();
					} else {
						$('#result').html("Notification sent to <strong>" + result + "</strong> devices!").fadeIn();

					}
				}

			});


			return false;
		});
		// $('#stopschedule').on("click", function() {
		// 	// var sent = $(this).serialize();
		// 	// console.log(sent);

		// 	// postForm(true)
		// 	alert("clicked stop")

		// 	return false;
		// });



		// $('#scheduleform').on("submit", function() {
		// 	var sent = $(this).serialize();
		// 	console.log(sent);
		// 	$.ajax({
		// 		type: "POST",
		// 		url: "./notification_api.php",
		// 		data: sent,
		// 		dataType: "json",
		// 		beforeSend: function() {
		// 			$(':input[type="submit"]').prop('disabled', true);
		// 			$(':input[type="submit"]').fadeIn().html('Sending <i class="fa fa-spinner fa-spin hidespin"></i>');
		// 			$('.hidespin').fadeIn().css('display', 'inherit');
		// 		},
		// 		success: function(result) {
		// 			$(':input[type="submit"]').prop('disabled', false);
		// 			$('.hidespin').css('display', 'none');
		// 			$(':input[type="submit"]').fadeIn().html('Send Notification');
		// 			if (result.schedule) {
		// 				$('#result').html("Notification scheduled successfully").fadeIn();
		// 			} else {
		// 				$('#result').html("Notification sent to <strong>" + result + "</strong> devices!").fadeIn();

		// 			}
		// 		}

		// 	});
		// 	return false;
		// });

	});
</script>
</body>

</html>