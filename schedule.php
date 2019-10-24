<!--header-->
<?php include 'header.php'; ?>
<!--header-->



<!--sidebar-->
<?php include 'sidebar.php'; ?>
<!--sidebar-->

<style>
	#time-range p {
		font-family: "Arial", sans-serif;
		font-size: 14px;
		color: #333;
	}

	.ui-slider-horizontal {
		height: 8px;
		background: #D7D7D7;
		border: 1px solid #BABABA;
		box-shadow: 0 1px 0 #FFF, 0 1px 0 #CFCFCF inset;
		clear: both;
		margin: 8px 0;
		-webkit-border-radius: 6px;
		-moz-border-radius: 6px;
		-ms-border-radius: 6px;
		-o-border-radius: 6px;
		border-radius: 6px;
	}

	.ui-slider {
		position: relative;
		text-align: left;
	}

	.ui-slider-horizontal .ui-slider-range {
		top: -1px;
		height: 100%;
	}

	.ui-slider .ui-slider-range {
		position: absolute;
		z-index: 1;
		height: 8px;
		font-size: .7em;
		display: block;
		border: 1px solid #5BA8E1;
		box-shadow: 0 1px 0 #AAD6F6 inset;
		-moz-border-radius: 6px;
		-webkit-border-radius: 6px;
		-khtml-border-radius: 6px;
		border-radius: 6px;
		background: #81B8F3;
		background-image: url('data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgi…pZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiIGZpbGw9InVybCgjZ3JhZCkiIC8+PC9zdmc+IA==');
		background-size: 100%;
		background-image: -webkit-gradient(linear, 50% 0, 50% 100%, color-stop(0%, #A0D4F5), color-stop(100%, #81B8F3));
		background-image: -webkit-linear-gradient(top, #A0D4F5, #81B8F3);
		background-image: -moz-linear-gradient(top, #A0D4F5, #81B8F3);
		background-image: -o-linear-gradient(top, #A0D4F5, #81B8F3);
		background-image: linear-gradient(top, #A0D4F5, #81B8F3);
	}

	.ui-slider .ui-slider-handle {
		border-radius: 50%;
		background: #F9FBFA;
		background-image: url('data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgi…pZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiIGZpbGw9InVybCgjZ3JhZCkiIC8+PC9zdmc+IA==');
		background-size: 100%;
		background-image: -webkit-gradient(linear, 50% 0, 50% 100%, color-stop(0%, #C7CED6), color-stop(100%, #F9FBFA));
		background-image: -webkit-linear-gradient(top, #C7CED6, #F9FBFA);
		background-image: -moz-linear-gradient(top, #C7CED6, #F9FBFA);
		background-image: -o-linear-gradient(top, #C7CED6, #F9FBFA);
		background-image: linear-gradient(top, #C7CED6, #F9FBFA);
		width: 22px;
		height: 22px;
		-webkit-box-shadow: 0 2px 3px -1px rgba(0, 0, 0, 0.6), 0 -1px 0 1px rgba(0, 0, 0, 0.15) inset, 0 1px 0 1px rgba(255, 255, 255, 0.9) inset;
		-moz-box-shadow: 0 2px 3px -1px rgba(0, 0, 0, 0.6), 0 -1px 0 1px rgba(0, 0, 0, 0.15) inset, 0 1px 0 1px rgba(255, 255, 255, 0.9) inset;
		box-shadow: 0 2px 3px -1px rgba(0, 0, 0, 0.6), 0 -1px 0 1px rgba(0, 0, 0, 0.15) inset, 0 1px 0 1px rgba(255, 255, 255, 0.9) inset;
		-webkit-transition: box-shadow .3s;
		-moz-transition: box-shadow .3s;
		-o-transition: box-shadow .3s;
		transition: box-shadow .3s;
	}

	.ui-slider .ui-slider-handle {
		position: absolute;
		z-index: 2;
		width: 22px;
		height: 22px;
		cursor: default;
		border: none;
		cursor: pointer;
	}

	.ui-slider .ui-slider-handle:after {
		content: "";
		position: absolute;
		width: 8px;
		height: 8px;
		border-radius: 50%;
		top: 50%;
		margin-top: -4px;
		left: 50%;
		margin-left: -4px;
		background: #30A2D2;
		-webkit-box-shadow: 0 1px 1px 1px rgba(22, 73, 163, 0.7) inset, 0 1px 0 0 #FFF;
		-moz-box-shadow: 0 1px 1px 1px rgba(22, 73, 163, 0.7) inset, 0 1px 0 0 white;
		box-shadow: 0 1px 1px 1px rgba(22, 73, 163, 0.7) inset, 0 1px 0 0 #FFF;
	}

	.ui-slider-horizontal .ui-slider-handle {
		top: -.5em;
		margin-left: -.6em;
	}

	.ui-slider a:focus {
		outline: none;
	}

	#slider-range {
		width: 90%;
		margin: 0 auto;
	}

	#time-range {
		/* width: 400px; */
		width: 100%;
	}
</style>
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
							<!-- <input id="timepicker" type="text" name="time" class="timepicker" required> -->

							<input type="hidden" name="time_from" value="<?= !empty($json['time_from']) ? $json['time_from'] : '9:00 AM' ?>">
							<input type="hidden" name="time_to" value="<?= !empty($json['time_to']) ? $json['time_to'] : '5:00 PM' ?>">

							<div id="time-range">
								<p>Time Range: <span class="slider-time"><?= !empty($json['time_from']) ? $json['time_from'] : '9:00 AM' ?></span> - <span class="slider-time2"><?= !empty($json['time_to']) ? $json['time_to'] : '5:00 PM' ?></span>

								</p>
								<br>
								<div class="sliders_step1">
									<div id="slider-range"></div>
								</div>
							</div>
							<br>
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
<!-- <script src="./assets/picker/wickedpicker.min.js"></script> -->
<script src="./assets/scripts/jquery-ui.js"></script>
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

		// now = moment("<?= !empty($json['time']) ? $json['time'] : '' ?>", "h:mm:ss A").format("HH:mm:ss")

		// var options = {
		// 	now: now, //hh:mm 24 hour format only, defaults to current time
		// 	// twentyFour: false, //Display 24 hour format, defaults to false
		// 	// upArrow: 'wickedpicker__controls__control-up', //The up arrow class selector to use, for custom CSS
		// 	// downArrow: 'wickedpicker__controls__control-down', //The down arrow class selector to use, for custom CSS
		// 	// close: 'wickedpicker__close', //The close class selector to use, for custom CSS
		// 	hoverState: 'hover-state', //The hover state class to use, for custom CSS
		// 	title: 'Time for the schedule to run daily', //The Wickedpicker's title,
		// 	// showSeconds: false, //Whether or not to show seconds,
		// 	// timeSeparator: ' : ', // The string to put in between hours and minutes (and seconds)
		// 	// secondsInterval: 1, //Change interval for seconds, defaults to 1,
		// 	// minutesInterval: 1, //Change interval for minutes, defaults to 1
		// 	// beforeShow: null, //A function to be called before the Wickedpicker is shown
		// 	// afterShow: null, //A function to be called after the Wickedpicker is closed/hidden
		// 	// show: null, //A function to be called when the Wickedpicker is shown
		// 	clearable: false, //Make the picker's input clearable (has clickable "x")
		// };
		// $('.timepicker').wickedpicker(options);


		$("#slider-range").slider({
			range: true,
			min: 0,
			max: 1440,
			step: 15,
			values: [540, 1020],
			slide: function(e, ui) {
				var hours1 = Math.floor(ui.values[0] / 60);
				var minutes1 = ui.values[0] - (hours1 * 60);

				if (hours1.length == 1) hours1 = '0' + hours1;
				if (minutes1.length == 1) minutes1 = '0' + minutes1;
				if (minutes1 == 0) minutes1 = '00';
				if (hours1 >= 12) {
					if (hours1 == 12) {
						hours1 = hours1;
						minutes1 = minutes1 + " PM";
					} else {
						hours1 = hours1 - 12;
						minutes1 = minutes1 + " PM";
					}
				} else {
					hours1 = hours1;
					minutes1 = minutes1 + " AM";
				}
				if (hours1 == 0) {
					hours1 = 12;
					minutes1 = minutes1;
				}



				$('.slider-time').html(hours1 + ':' + minutes1);
				$("input[name=time_from]").val(hours1 + ':' + minutes1);

				var hours2 = Math.floor(ui.values[1] / 60);
				var minutes2 = ui.values[1] - (hours2 * 60);

				if (hours2.length == 1) hours2 = '0' + hours2;
				if (minutes2.length == 1) minutes2 = '0' + minutes2;
				if (minutes2 == 0) minutes2 = '00';
				if (hours2 >= 12) {
					if (hours2 == 12) {
						hours2 = hours2;
						minutes2 = minutes2 + " PM";
					} else if (hours2 == 24) {
						hours2 = 11;
						minutes2 = "59 PM";
					} else {
						hours2 = hours2 - 12;
						minutes2 = minutes2 + " PM";
					}
				} else {
					hours2 = hours2;
					minutes2 = minutes2 + " AM";
				}

				$('.slider-time2').html(hours2 + ':' + minutes2);
				$("input[name=time_to]").val(hours2 + ':' + minutes2);
			}
		});


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