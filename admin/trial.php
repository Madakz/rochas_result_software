<?php
	// include "../class_lib/functions.php";
	//  $rochas_inst= new Rochas;

	//  echo $rochas_inst->formatPosition('10');

	 for ($sn=0; $sn < 1; $sn++) { 
		echo md5('jjjj').'<br>';
		echo md5('3b6281fa2ce2b6c20669490ef4b026a4');
	}

	 // $average=93.336333333333;
	 // $cost = sprintf("%.2f", $average);
	 // echo $cost;

	 // $term_records=$rochas_inst->retrieveTermRecordsForSubjectPositioning('5', '2', '1', '1', '2');
		// foreach ($term_records as $term_record) {
		// 	print_r($term_record);
		// 	// die();
		// 	$subject_id=$term_record['subject_id'];
		// 	echo '<br/>'.$subject_id.'<br/>';
		// 	// $rochas_inst->subjectPositioning($subject_id, $class_id, $class_type, $class_arm, $term_id, $session_id);
		// }

	 // $session_records=$rochas_inst->retrieveStudentSessionRecord('5', '2', '1', '2');
		// foreach ($session_records as $session_record) {
		// 	print_r($session_record);
		// 	$subject_id=$session_record['subject_id'];
		// 	echo "<h1>SUBJECT: </h1>".$subject_id;
		// 	// die();
		// 	// $rochas_inst->sessionalSubjectPositioning($subject_id, $class_id, $class_type, $class_arm, $session_id);
		// }

	// $sub_totals=$rochas_inst->trialdoPositioning();

	// $filter=array_filter($averages);

	// print_r($filter);

	// echo "<br/>";

	// echo $averages[0]['average'];
	
	// array_map(callback, arr1)
	// array_chunk(input, size)
	// array_column(input, column_key)
	// array
?>


<style>
#customers
{
font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
width:100%;
border-collapse:collapse;
}
#customers td, #customers th 
{
font-size:1.2em;
border-collapse: collapse;
padding:3px 7px 2px 7px;
}
#customers th 
{
font-size:1.4em;
text-align:left;
padding-top:5px;
padding-bottom:4px;
background-color:#A7C942;
color:#fff;
}
#customers tr.alt td 
{
color:#000;
background-color:#EAF2D3;
}
</style>





<p class="intro">The look of an HTML table can be greatly improved with CSS:</p>
<table id="customers">
<tr>
  <th>Company</th>
  <th>Contact</th>
  <th>Country</th>
</tr>
<tr>
<td>Alfreds Futterkiste</td>
<td>Maria Anders</td>
<td>Germany</td>
</tr>
<tr class="alt">
<td>Berglunds snabbköp</td>
<td>Christina Berglund</td>
<td>Sweden</td>
</tr>
<tr>
<td>Centro comercial Moctezuma</td>
<td>Francisco Chang</td>
<td>Mexico</td>
</tr>
<tr class="alt">
<td>Ernst Handel</td>
<td>Roland Mendel</td>
<td>Austria</td>
</tr>
<tr>
<td>Island Trading</td>
<td>Helen Bennett</td>
<td>UK</td>
</tr>
<tr class="alt">
<td>Königlich Essen</td>
<td>Philip Cramer</td>
<td>Germany</td>
</tr>
<tr>
<td>Laughing Bacchus Winecellars</td>
<td>Yoshi Tannamuri</td>
<td>Canada</td>
</tr>
<tr class="alt">
<td>Magazzini Alimentari Riuniti</td>
<td>Giovanni Rovelli</td>
<td>Italy</td>
</tr>
<tr>
<td>North/South</td>
<td>Simon Crowther</td>
<td>UK</td>
</tr>
<tr class="alt">
<td>Paris spécialités</td>
<td>Marie Bertrand</td>
<td>France</td>
</tr>
<tr>
<td>The Big Cheese</td>
<td>Liz Nixon</td>
<td>USA</td>
</tr>
<tr class="alt">
<td>Vaffeljernet</td>
<td>Palle Ibsen</td>
<td>Denmark</td>
</tr>
</table>
<hr>




<!-- SELECT SUM(stu_ca_assignment1 + stu_ca_assignment2) AS asignment FROM student_term_record WHERE student_id='12' AND clazz_id ='5' AND clazz_type_id='2' AND class_arm_id='1' AND term_id='1'AND sessionz_id='2' AND subject_id='6' -->
