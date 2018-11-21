<html>
<body>
<head>   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <title>Excel project- php and javascript</title>
</head>
 <h1>Excel Project </h1> 
 <?php 
if(! isset($_GET['is'])) 	
	$_GET['is'] = '';
if(! isset($_GET['yaprak'])) 	
	$_GET['yaprak'] = 1;
if(! isset($_GET['st'])) 	
	$_GET['st'] = '';
if($_GET['is']=="guncelle") 	
{

guncelle();}

if($_GET['is']=="silrow") 	
{
silrow();}
if($_GET['is']=="silyaprak") 	
{
silyaprak();}
if($_GET['is']=="ekle") 	
{
ekle();}
if($_GET['is']=="silcol") 	
{
silcol();}
if($_GET['is']=="eklerow")
	eklerow();
if($_GET['is']=="eklecol")
	eklecol();
if(! isset($_GET['filena']))
{ header("location:files.php");}
?>
file:<h2 id=' <?php echo $_GET['fileid']; ?>'><?php echo $_GET['filena']; ?></h2> 
<?php
function inc(){

    $connect = mysqli_connect('localhost','root','','excel1');
   $connect1 = mysqli_connect('localhost','root','','information_schema');
    if(! $connect)
        echo "connect error:" . mysqli_error($connect);
    if(! $connect1)
     echo "connect error:" . mysqli_error($connect);
    $kayitKumesi = mysqli_query($connect, "SELECT  * FROM yaprak where yap={$_GET['yaprak']} and filesid={$_GET['fileid']} ORDER BY rowid ASC ,colid ;");
    $col=mysqli_query($connect,"SELECT * FROM yaprak where yap={$_GET['yaprak']} and filesid={$_GET['fileid']} ORDER BY colid DESC LIMIT 1;");
    $co=mysqli_fetch_array($col);
    $row=mysqli_query($connect,"SELECT * FROM yaprak  where yap={$_GET['yaprak']} and filesid={$_GET['fileid']} ORDER BY rowid DESC LIMIT 1;");
    $ro=mysqli_fetch_array($row);
    if(! $kayitKumesi)
        echo "SQL error:" . mysqli_error($connect);
    echo "<table id=myTable style='border:2px solid black; border-collapse: collapse;'> <tr>";
    while($kayit = mysqli_fetch_array($kayitKumesi)){$arrayVals[] = $kayit;}
$t=1;
echo"<th id='{$_GET['yaprak']}yap'>page:{$_GET['yaprak']}</th><th> </th>";
for ($y = 1; $y <= $co[1]; $y++)
    {
    echo"<th><button onclick='silcol({$y})' >Delete</button></th>";
    }echo"</tr><tr><td> </td><td></td>";
    for ($x = 1; $x <= $co[1]; $x++)
    {
    echo"<td>".($x)."</td>";
    }echo"<td><a style='border:2px solid black;' onclick='myFunc()' style='text-decoration: underline;color:blue'>Add Column</a></td></tr>";
$t=0;

for ($x = 1; $x <= $ro[2]; $x++)
{
    echo"<tr id='{$x}'><td><button onclick='myFunction({$x})' >Delete row</button></td><td>".($x)."</td>";
for($y=1;$y<=$co[1];$y++){


    if(($x==$arrayVals[$t][2]) &&($y==$arrayVals[$t][1]))
    {echo "<td><input type='text' value='{$arrayVals[$t][3]}'  id='{$x}?{$y}' onblur='save({$x},{$y})'/></td>";$t++;
if($t>=sizeof($arrayVals))
    $t=0;}
        else 
        {echo "<td><input type='text' id='{$x}?{$y}' onblur='save({$x},{$y})'></td>";
    }
    
    }

echo"</tr>";}

    echo"
    <tr><td><a style='border:2px solid black;' onclick='myFun()' style='text-decoration: underline;color:blue'>Add Row</a></td></tr>
    
    </table>";
    $count=1;
    $yapraklar = mysqli_query($connect, "SELECT  * FROM yapraklar where filesid={$_GET['fileid']} ORDER BY id ASC  ;");
    echo"<div class='col-md-7'><table id='links' class='table-responsive table-sm'><tr>";
    while($yaprak = mysqli_fetch_array($yapraklar)){
    echo "<td><a href='index.php?is=inc&yaprak={$yaprak[0]}&filena={$_GET['filena']}&fileid={$_GET['fileid']}'   style='text-decoration: underline;color:blue'id='?{$yaprak[0]}'>PAGE_{$yaprak[0]} </a></td>";
$count++;
    
    }
    echo"    <td><a onclick='ekle()'   style='text-decoration: underline;color:blue'>Add Page</a></td></tr><tr>";
    $yapraklar = mysqli_query($connect, "SELECT  * FROM yapraklar where filesid={$_GET['fileid']} ORDER BY id ASC  ;");
    while($yaprak = mysqli_fetch_array($yapraklar)){
    echo "<td><a onclick='silyaprak({$yaprak[0]})' id='!{$yaprak[0]}' style='text-decoration: underline;color:blue' >Delete </a></td>";
    }echo"</tr></table> </div>";?>

    <br>

<a href='files.php'> Back To Files</a>
<script>
    function myFun() {

        var table = document.getElementById('myTable');
        var row = table.rows[table.rows.length - 1];
        row.parentNode.removeChild(row);
        var lastRow = table.rows[table.rows.length - 1];
        var row = table.insertRow(-1);
        if (table.rows.length - 4 < 0)
            row.id = '1';
        else {
            row.id = parseInt(lastRow.id) + 1;
        }
        var cellsil = row.insertCell(0);
        var t = document.createElement('button')
        t.setAttribute('onclick', 'myFunction(' + row.id + ')');
        t.innerHTML = 'Delete row';
        cellsil.appendChild(t);
        var cell1 = row.insertCell(1);
        var id = parseInt(row.id);
        cell1.innerHTML = id;
        for (i = 2; i < table.rows[2].cells.length; i++) {
            j = i - 1;

            var cell2 = row.insertCell(i);
            var t2 = document.createElement('input');
            t2.id = row.id + '?' + j;

            t2.setAttribute('onblur', 'save(' + row.id + ',' + j + ')');
            cell2.appendChild(t2);

        }

        var row = table.insertRow(-1);
        var cell = row.insertCell(0);
        var t = document.createElement('a');
        t.setAttribute('onclick', 'myFun()');
        t.innerHTML = 'Addrow';
        cell.appendChild(t);
        var row0 = document.getElementById('myTable').rows[0];
        var yap1 = row0.getElementsByTagName('th')[0].innerHTML;
        var yap = parseInt(yap1.slice(-1));

        var xmlhttp = new XMLHttpRequest();
        i = i - 2;
        rowid = table.rows.length - 3;
        var file = document.getElementsByTagName('h2')[0];
        var fileid = parseInt(file.id);
        if (rowid != 0 && i != 0) {
            xmlhttp.open('GET', 'index.php?is=guncelle&colid=' + i + '&rowid=' + rowid + '&new=' + ' ' + '&yaprak=' + yap + '&fileid=' + fileid, true);
            xmlhttp.send();
        }
    }

    function myFunc() {

        var tbl = document.getElementById('myTable'); // table reference
        var row = tbl.rows[1];
        if (tbl.rows[1].cells.length - 3 == 0)
            myFun();

        if (tbl.rows[1].cells.length - 2 < 2)
            text = 1;
        else
            var text = parseInt(row.getElementsByTagName('td')[tbl.rows[1].cells.length - 2].innerHTML) + 1;

        

        var cell2 = row.insertCell(tbl.rows[1].cells.length - 1);

        cell2.innerHTML = text;

        var row0 = tbl.rows[0];
        var cellsil = row0.insertCell(tbl.rows[1].cells.length - 2);
        var t = document.createElement('button')
        t.setAttribute('onclick', 'silcol(' + (tbl.rows[1].cells.length - 4) + ')');
        t.innerHTML = 'Delete';
        cellsil.appendChild(t);

        // open loop for each row and append cell
        for (i = 2; i < tbl.rows.length - 1; i++) {
            createCell(tbl.rows[i].insertCell(tbl.rows[i].cells.length), i, tbl.rows[i].cells.length - 1);
        }
        var row0 = document.getElementById('myTable').rows[0];
        var yap1 = row0.getElementsByTagName('th')[0].innerHTML;
        var yap = parseInt(yap1.slice(-1));
        var xmlhttp = new XMLHttpRequest();
        i = i - 2;
        colid = tbl.rows[i].cells.length - 2;
        var file = document.getElementsByTagName('h2')[0];
        var fileid = parseInt(file.id);
        if (tbl.rows.length - 4 == 0)
            colid = colid - 1;
        if (colid != 0) {
            xmlhttp.open('GET', 'index.php?is=guncelle&colid=' + colid + '&rowid=' + i + '&new=' + ' ' + '&yaprak=' + yap + '&fileid=' + fileid, true);
            xmlhttp.send();
        }

    }

    function createCell(cell, id, no) {
        id = id - 1;
        no = no - 1;
        var inp = document.createElement('input'); // create DIV element  
        inp.setAttribute('onblur', 'save(' + id + ',' + no + ')');
        inp.id = id + '?' + no;
        cell.appendChild(inp);
        // append DIV to the table cell
    }

    function deleteColumns() {

        var tbl = document.getElementById('myTable'), // table reference
            lastCol = tbl.rows[0].cells.length - 1, // set the last column index
            i, j;
        // delete cells with index greater then 0 (for each row)
        for (i = 0; i < 1; i++) {
            j = lastCol;
            tbl.rows[i].deleteCell(j);
        }
    }



    function save(id, no) {
        var row0 = document.getElementById('myTable').rows[0];
        var yap1 = row0.getElementsByTagName('th')[0].innerHTML;
        var yap = parseInt(yap1.slice(-1));
        var row = document.getElementById(id);
        var x = document.getElementById(id + '?' + no).value;
        var row0 = document.getElementById(0);
        var file = document.getElementsByTagName('h2')[0];

        var fileid = parseInt(file.id);
        if (x != ' ') {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.open('GET', 'index.php?is=guncelle&colid=' + no + '&rowid=' + id + '&new=' + x + '&yaprak=' + yap + '&fileid=' + fileid, true);
            xmlhttp.send();
        }
    }

    function myFunction(no) {
        var row1 = document.getElementById('myTable').rows[0];
        var yap1 = row1.getElementsByTagName('th')[0].innerHTML;
        var yap = parseInt(yap1.slice(-1));
        var row = document.getElementById(no);

        row.parentNode.removeChild(row);
        var file = document.getElementsByTagName('h2')[0];
        var fileid = parseInt(file.id);
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open('GET', 'index.php?is=silrow&no=' + no + '&yaprak=' + yap + '&fileid=' + fileid, true);
        xmlhttp.send();
    }

    function silcol(no) {

        nojs = no + 1;
        var row0 = document.getElementById('myTable').rows[0];
        var yap1 = row0.getElementsByTagName('th')[0].innerHTML;
        var yap = parseInt(yap1.slice(-1));
        var table = document.getElementById('myTable'),
            rows = table.rows;
        no1 = no;

        for (var i = 0; i < rows.length - 1; i++) {


            rows[i].deleteCell(nojs);
        }
        var file = document.getElementsByTagName('h2')[0];
        var filena = file.innerHTML;
        var fileid = parseInt(file.id);
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open('GET', 'index.php?is=silcol&no=' + no1 + '&yaprak=' + yap + '&fileid=' + fileid, true);
        xmlhttp.send();
        window.location.href = "index.php?is=inc&yaprak=" + yap + "&filena=" + filena + "&fileid=" + fileid;
    }

    function ekle() {
        var table = document.getElementById('links');
        var row = table.rows[0];
        var links = row.getElementsByTagName('a');
        var no = links.length;

        row.deleteCell(-1);
        var newCell = table.rows[0].insertCell(-1);
        var a = document.createElement('a');
        var linkText = document.createTextNode('PAGE' + no);
        a.appendChild(linkText);
        var file = document.getElementsByTagName('h2')[0];
        var fileid = parseInt(file.id);
        a.href = 'index.php?is=inc&yaprak=' + no + '&fileid=' + fileid + '&filena=' + file.innerHTML;
        newCell.appendChild(a);
        var newCell = table.rows[0].insertCell(-1);
        var a = document.createElement('a');
        var linkText = document.createTextNode('add page');
        a.appendChild(linkText);
        a.setAttribute('onclick', 'ekle()');
        newCell.appendChild(a);

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open('GET', 'index.php?is=ekle&filesid=' + fileid + '&filena=' + file.innerHTML + '&yaparakd=' + no, true);
        xmlhttp.send();
    }

    function silyaprak(no) {
        
        var element = document.getElementById('?' + no);
        element.parentNode.removeChild(element);
        
        var element = document.getElementById('!' + no);
        element.parentNode.removeChild(element);
        var file = document.getElementsByTagName('h2')[0];
        var fileid = parseInt(file.id);
        
        var filena = file.innerHTML;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open('GET', 'index.php?is=silyaprak&yaparakd=' + no + '&filesid=' + fileid, true);
        xmlhttp.send();
        var pre = no - 1;
        window.location.href = "index.php?is=inc&yaprak=" + pre + "&filena=" + filena + "&fileid=" + fileid;
    }
</script>
	
	
	
	<?php
}
function silrow()
{
    $c     = mysqli_connect('localhost', 'root', '', 'excel1');
    $sql   = "DELETE FROM yaprak WHERE yap={$_GET['yaprak']} and filesid={$_GET['fileid']} and rowid= {$_GET['no']} ;";
    $sonuc = mysqli_query($c, $sql); 
    if (!$sonuc) // komutu calistirirken hata olustumu?
        echo "SQL error:" . mysqli_error($c);
    //$sql   = "UPDATE yaprak SET rowid = rowid - 1 WHERE  yap={$_GET['yaprak']} and filesid={$_GET['fileid']} and rowid> {$_GET['no']} ;";
   // $sonuc = mysqli_query($c, $sql)ir
    if (!$sonuc)
        echo "SQL error:" . mysqli_error($c);
    mysqli_close($c); 
   
}
function silcol()
{
    $c     = mysqli_connect('localhost', 'root', '', 'excel1');
    $sql   = "DELETE FROM yaprak WHERE colid={$_GET['no']} and yap={$_GET['yaprak']}  and filesid={$_GET['fileid']};";
    $sonuc = mysqli_query($c, $sql); 
    $sql   = "UPDATE yaprak SET colid = colid - 1 WHERE colid>{$_GET['no']} and  yap={$_GET['yaprak']} and and filesid={$_GET['fileid']} ;";
    $sonuc = mysqli_query($c, $sql); 
    if (!$sonuc)
        echo "SQL error:" . mysqli_error($c);
    mysqli_close($c); 
   
}
function silyaprak()
{
    $c     = mysqli_connect('localhost', 'root', '', 'excel1');
    $sql   = "DELETE FROM yapraklar WHERE id={$_GET['yaparakd']} and filesid={$_GET['filesid']}";
    $sonuc = mysqli_query($c, $sql); 
    $sql   = "DELETE FROM yaprak WHERE yap={$_GET['yaparakd']} and filesid={$_GET['filesid']}";
    $sonuc = mysqli_query($c, $sql); // SQL komutunu calistir
    $sql   = "UPDATE yapraklar SET id = id - 1 WHERE id>{$_GET['yaparakd']} and filesid={$_GET['filesid']} ;";
    $sonuc = mysqli_query($c, $sql); 
    if (!$sonuc)
        echo "SQL error:" . mysqli_error($c);
    mysqli_close($c); 
   
    
}
function guncelle()
{
    
    $c = mysqli_connect('localhost', 'root', '', 'excel1');
    
    $sql   = "UPDATE yaprak SET data='{$_GET['new']}' WHERE colid={$_GET['colid']} and rowid={$_GET['rowid']} and yap={$_GET['yaprak']} and filesid={$_GET['fileid']};";
    //echo $sql;exit;
    $sonuc = mysqli_query($c, $sql);
    if (mysqli_affected_rows($c) == 0)
        $sql = "INSERT INTO yaprak (data,colid,rowid,yap,filesid) values('{$_GET['new']}',{$_GET['colid']},{$_GET['rowid']},{$_GET['yaprak']},{$_GET['fileid']});";
    $sonuc = mysqli_query($c, $sql);
    mysqli_close($c);
}
function ekle()
{
    
    $c = mysqli_connect('localhost', 'root', '', 'excel1');
    
    
    $sql   = "INSERT INTO yapraklar (id,filesid)  values('{$_GET['yaparakd']}','{$_GET['filesid']}') ;";
    $sonuc = mysqli_query($c, $sql);
    mysqli_close($c);
}
inc();
?>
</body>
</html>