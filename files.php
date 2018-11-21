<?php
if(! isset($_GET['is'])) 	
	$_GET['is'] = '';


if($_GET['is'] == 'ekle')	
{ekle(); form();}


else
	form();	
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Folders </title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
</head>
<body>
	
<?php
function form (){$connect = mysqli_connect('localhost','root','','excel1');
	if(! $connect)
		echo "connect error:" . mysqli_error($connect);
	$kayitKumesi = mysqli_query($connect, "SELECT  * FROM files;");
	if(! $kayitKumesi)
		echo "SQL error:" . mysqli_error($connect);
	$i=1;
	echo "<h1>Floders</h1>
	<table id=myTablef style='border:2px solid ;'>";
	while($kayit = mysqli_fetch_array($kayitKumesi)){
		echo "<tr id={$kayit[1]}>
				<td>". $i ."</td>
				<td><a href='/index.php?filena={$kayit[0]}&fileid={$kayit[1]}'>". $kayit[0] ."</a></td>
			</tr> ";
$i++;}
	echo"</table>";
	echo "
	<br>
    New Folder
	<form action=''>
	<input type=hidden name=is value=ekle><br>
	
	Name: <input name=filena type=text> <br>
	
	<input name=gonder type=submit value=Make>	
</form>";}
	
	function ekle()
	{
	$c = mysqli_connect('localhost','root','','excel1');
	$sql = "INSERT INTO files (filesname) VALUES( '{$_GET['filena']}');";
	$sonuc = mysqli_query($c, $sql);
	$kayitKumesi1 = mysqli_query($c, "SELECT  * FROM files where filesname='{$_GET['filena']}'");
	$kayit1 = mysqli_fetch_array($kayitKumesi1);
	$sql = "INSERT INTO yapraklar (id,filesid) VALUES( 1,'{$kayit1[1]}');";
	$sonuc = mysqli_query($c, $sql);
    $sql = "INSERT INTO yaprak (rowid,colid,yap,filesid) VALUES(1,1, 1,'{$kayit1[1]}');";
	$sonuc = mysqli_query($c, $sql);
	mysqli_close($c);
}
	?>
    </body>
</html>
