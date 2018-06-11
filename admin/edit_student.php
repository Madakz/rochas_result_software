<?php
	 include "../class_lib/functions.php";
	 $logged_in_user = $_SESSION['logged_user_id'];
	 $rochas_inst = new Rochas;
	 $id=$_GET['student'];
	 $table='student';
	$student = $rochas_inst->findById($id, $table);

	if (isset($_POST['edit'])) {
		$surname=trim($_POST['surname']);
		$firstname=trim($_POST['firstname']);
		$othername=trim($_POST['othername']);
		$address=trim($_POST['address']);
		$student_id=trim($_POST['student']);

		$birthdate=trim($_POST['birth_date']);		//check for datepicker correctionsssss
		
		$insert=$rochas_inst->editStudent($surname, $firstname, $othername, $birthdate, $address, $student_id);
		// die($insert);
		if ($insert) {
?>
			<script>
				alert("student record updated successful");
				window.location.href='view_students.php';
			</script>
<?php		
		}else{
?>
			<script>
				alert("student's record update failed");
			</script>
<?php
		}		
	}

?>
	<a href="register_teacher.php">register teacher</a>
	<a href="view_teachers.php">view teachers</a>
	<a href="view_students.php">view student</a>






	<link rel="stylesheet" type="text/css" href="../css/jquery.datetimepicker.css"/>
	<style type="text/css">

		.custom-date-style {
			background-color: red !important;
		}

		.input{	
		}
		.input-wide{
			width: 500px;
		}

	</style>




	<h2>Edit Student</h2>
	<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>"  method="POST" enctype="multipart/form-data">
		<label>Surname:</label>
		<input type="text" name="surname" value="<?php echo $student['surname']; ?>" placeholder="<?php echo $student['surname']; ?>" class="form-control" required="">
		<br/>
		<label>First Name:</label>
		<input type="text" name="firstname" value="<?php echo $student['firstname']; ?>" placeholder="<?php echo $student['firstname']; ?>" class="form-control" required="">
		<br/>
		<label>Othername:</label>
		<input type="text" name="othername" value="<?php echo $student['othername']; ?>" placeholder="<?php echo $student['othername']; ?>" class="form-control" >
		<br/>
		<label>Address:</label>
		<textarea cols="20" rows="6" name="address" required="" placeholder="<?php echo $student['address']; ?>" value="<?php echo $student['address']; ?>"><?php echo $student['address']; ?></textarea><br/>
		<label>Date of birth:</label>
		<input type="text" name="birth_date" id="datetimepicker2" required="" value="<?php echo $student['birth_date']; ?>" />
		<input type="hidden" name="student" value="<?php echo $id;?>">
		<br/><br/>
	   

		<input type="submit" class="btn btn-primary" name="edit" value="submit">
	</form>


	<script src="../js/jquery.js"></script>
	<script src="../js/php-date-formatter.min.js"></script>
	<script src="../js/jquery.datetimepicker.js"></script>


	<script>/*
		window.onerror = function(errorMsg) {
			$('#console').html($('#console').html()+'<br>'+errorMsg)
		}*/

		$.datetimepicker.setLocale('en');

		$('#datetimepicker_format').datetimepicker({value:'2015/04/15 05:03', format: $("#datetimepicker_format_value").val()});
		console.log($('#datetimepicker_format').datetimepicker('getValue'));

		$("#datetimepicker_format_change").on("click", function(e){
			$("#datetimepicker_format").data('xdsoft_datetimepicker').setOptions({format: $("#datetimepicker_format_value").val()});
		});
		$("#datetimepicker_format_locale").on("change", function(e){
			$.datetimepicker.setLocale($(e.currentTarget).val());
		});

		$('#datetimepicker').datetimepicker({
		dayOfWeekStart : 1,
		lang:'en',
		disabledDates:['1986/01/08','1986/01/09','1986/01/10'],
		startDate:	'1986/01/05'
		});
		$('#datetimepicker').datetimepicker({value:'2015/04/15 05:03', step:10});

		$('.some_class').datetimepicker();

		$('#default_datetimepicker').datetimepicker({
			formatTime:'H:i',
			formatDate:'d.m.Y',
			//defaultDate:'8.12.1986', // it's my birthday
			defaultDate:'+03.01.1970', // it's my birthday
			defaultTime:'10:00',
			timepickerScrollbar:false
		});

		$('#datetimepicker10').datetimepicker({
			step:5,
			inline:true
		});
		$('#datetimepicker_mask').datetimepicker({
			mask:'9999/19/39 29:59'
		});

		$('#datetimepicker1').datetimepicker({
			datepicker:false,
			format:'H:i',
			step:5
		});
		$('#datetimepicker2').datetimepicker({
			// yearOffset:222,   //setting the offset gives you the starting of the year
			lang:'ch',
			timepicker:false,
			format:'d/m/Y',
			formatDate:'Y/m/d',
			// minDate:'-1970/01/02', // yesterday is minimum date
			// maxDate:'+1970/01/02' // and tommorow is maximum date calendar
		});
		$('#datetimepicker3').datetimepicker({
			inline:true
		});
		$('#datetimepicker4').datetimepicker();
		$('#open').click(function(){
			$('#datetimepicker4').datetimepicker('show');
		});
		$('#close').click(function(){
			$('#datetimepicker4').datetimepicker('hide');
		});
		$('#reset').click(function(){
			$('#datetimepicker4').datetimepicker('reset');
		});
		$('#datetimepicker5').datetimepicker({
			datepicker:false,
			allowTimes:['12:00','13:00','15:00','17:00','17:05','17:20','19:00','20:00'],
			step:5
		});
		$('#datetimepicker6').datetimepicker();
		$('#destroy').click(function(){
			if( $('#datetimepicker6').data('xdsoft_datetimepicker') ){
				$('#datetimepicker6').datetimepicker('destroy');
				this.value = 'create';
			}else{
				$('#datetimepicker6').datetimepicker();
				this.value = 'destroy';
			}
		});
		var logic = function( currentDateTime ){
			if (currentDateTime && currentDateTime.getDay() == 6){
				this.setOptions({
					minTime:'11:00'
				});
			}else
				this.setOptions({
					minTime:'8:00'
				});
		};
		$('#datetimepicker7').datetimepicker({
			onChangeDateTime:logic,
			onShow:logic
		});
		$('#datetimepicker8').datetimepicker({
			onGenerate:function( ct ){
				$(this).find('.xdsoft_date')
					.toggleClass('xdsoft_disabled');
			},
			minDate:'-1970/01/2',
			maxDate:'+1970/01/2',
			timepicker:false
		});
		$('#datetimepicker9').datetimepicker({
			onGenerate:function( ct ){
				$(this).find('.xdsoft_date.xdsoft_weekend')
					.addClass('xdsoft_disabled');
			},
			weekends:['01.01.2014','02.01.2014','03.01.2014','04.01.2014','05.01.2014','06.01.2014'],
			timepicker:false
		});
		var dateToDisable = new Date();
			dateToDisable.setDate(dateToDisable.getDate() + 2);
		$('#datetimepicker11').datetimepicker({
			beforeShowDay: function(date) {
				if (date.getMonth() == dateToDisable.getMonth() && date.getDate() == dateToDisable.getDate()) {
					return [false, ""]
				}

				return [true, ""];
			}
		});
		$('#datetimepicker12').datetimepicker({
			beforeShowDay: function(date) {
				if (date.getMonth() == dateToDisable.getMonth() && date.getDate() == dateToDisable.getDate()) {
					return [true, "custom-date-style"];
				}

				return [true, ""];
			}
		});
		$('#datetimepicker_dark').datetimepicker({theme:'dark'})


	</script>