<?php
	 include "../class_lib/functions.php";
	 $logged_in_user = $_SESSION['logged_user_id'];
	 $rochas_inst = new Rochas;
	 $classes = $rochas_inst->fetchClazz();

	 $error='';
	if (isset($_POST['register'])) {
		$surname=trim($_POST['surname']);
		$firstname=trim($_POST['firstname']);
		$othername=trim($_POST['othername']);
		$address=trim($_POST['address']);

		$birthdate=trim($_POST['birth_date']);		//check for datepicker correctionsssss
		$class=trim($_POST['class']);
		$class_type=trim($_POST['class_type']);
		$class_arm=trim($_POST['class_arm']);
		$status='1';
		

		$admin = trim($_POST['admin']);

		$picture = $rochas_inst->imageUploadFunction($_FILES);
		// print_r($picture);
		// die();
		
		$insert=$rochas_inst->registerStudent($surname, $firstname, $othername, $picture, $address, $birthdate, $admin, $class, $class_type, $class_arm, $status);
		// die($insert);
		if ($insert) {
?>
			<script>
				alert("student registered successful");
				window.location.href='index.php';
			</script>
<?php		
		}else{
?>
			<script>
				alert("student's registration failed");
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




	<h2>Registration Form</h2>
	<h5>Provide your details below</h5>
	<div style="text-align:center;"><i>All fields marked with the&nbsp;<em style="color:red;" >*</em>&nbsp; symbol are compulsory fields</i></div><br/>
	<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>"  method="POST" enctype="multipart/form-data">
		<h5 style="color:red;"><?php echo $error;?></h5>
		<label>Image:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
		<input type="file" name="picture" required="" /><br/>
		<label>Surname:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
		<input type="text" name="surname" value="<?php echo !empty($_POST['surname']) ? $_POST['surname'] : ""; ?>" placeholder="surname" class="form-control" required="">
		<br/>
		<label>First Name:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
		<input type="text" name="firstname" value="<?php echo !empty($_POST['firstname']) ? $_POST['firstname'] : ""; ?>" placeholder="first name" class="form-control" required="">
		<br/>
		<label>Othername:</label>
		<input type="text" name="othername" value="<?php echo !empty($_POST['othername']) ? $_POST['othername'] : ""; ?>" placeholder="Other name" class="form-control" >
		<br/>
		<label>Address:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
		<textarea cols="20" rows="6" name="address" required="" placeholder="address"><?php echo !empty($_POST['address']) ? $_POST['address'] : ""; ?></textarea><br/>
		<!-- <label>Date of birth:</label> //use datepickerhere
		<input type="input" name="birth_date" id="" class="form-control" required=""> -->
		<label>Date of birth:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
		<input type="text" name="birth_date" id="datetimepicker2" required=""/><br/><br/>
		<label>Class:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
		<select name="class" id="clazz"  required="">
        	<option value="">-- select class --</option>
        
     	 </select>

	     <label>Class Type:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
			<select name="class_type" id="clazz_type" disabled="disabled"  required="">
		        <option value="">-- select class type --</option>
		        
		     </select>

	     <label>Class Arm:&nbsp;<em style="color:red;" >*</em>&nbsp;</label>
			<select name="class_arm"  required="">
				<?php
					$class_arms=$rochas_inst->fetchClassArm();
				?>
		        <option value="">-- select class arm --</option>
		        <?php
		        	foreach ($class_arms as $class_arm) {
		        ?>
		        		<option value="<?php echo $class_arm['id'];?>"><?php echo $class_arm['name'];?></option>
		        <?php
		        	}
		        ?>
		        
		     </select>

		<input type="hidden" name="admin" value="<?php echo $logged_in_user;?>"> 
			    	
	    <br/><br/>
	   

		<input type="submit" class="btn btn-primary" name="register" value="Register">
	</form>


	<script src="../js/jquery.js"></script>
	<script src="../js/php-date-formatter.min.js"></script>
	<script src="../js/jquery.datetimepicker.js"></script>
	<script language="JavaScript" src="../js/functionsforcascadingdropdown.js"></script>
    <script type="text/javascript" src="../js/dropdown.js"></script>


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