<?php 
$id = $_GET['id'];
session_start();
if($_GET['id'] != ''){
	$_SESSION['id'] = $_GET['id'];
}
if($_GET['page'] != ''){
	$page = $_GET['page'];
} else {
	$page = 1;
}
$dbh = new PDO('pgsql:dbname=countries;host=127.0.0.1;','postgres');
$query = sprintf('SELECT city_id, title_ru FROM _cities where region_id = (%s)',$_SESSION['id']); 
$query=$dbh->prepare($query);
$query->execute();
$rows=$query->fetchAll(PDO::FETCH_ASSOC);
$dbh=null;
$query=null;

$countOfNotes = 50;
printCities($rows,$countOfNotes,$page);

function printCities($rows,$countOfNotes,$page){
	$countCity = count($rows);#к-во городов
	?>

	<div class="buttons" text align="center">
		<?php for($i = 1; $i <= round($countCity/$countOfNotes, 0); $i++){ ?>
			<a href="region.php?page=<?php echo $i?>"><?php echo $i . " " ?> </a>
		<?php } ?>
	</div>

	<?php
	$index = 0; # индекс текущего элемента массива
	$from = ($page - 1) * $countOfNotes; #с какого города по счёту выводить города
	?>
	
	<table border="1">
			<tr>
				<td>Count</td>
				<td>City</td>
			</tr>
	<?php foreach ($rows as $key => $row) {
		if($index >= $from && $index < $from + $countOfNotes){ ?>
			<tr>
				<td><?php echo $index+1 ?></td>
    		    <td><a href="/welcome.php?idCity=<?php echo $row['city_id']?>"><?php echo $row['title_ru']?></a> </td>
			</tr>
		<?php }
		
		$index++;
	}
}
?>
</table>