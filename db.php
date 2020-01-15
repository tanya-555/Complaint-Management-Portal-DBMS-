<!DOCTYPE html>
<head>
<title>Student Database</title>
<style>
table,td,th
{
border:1px solid black;
width:30%;
border-collapse:collapse;
bckground-color:blue;
text-align:center;
}
table
{
margin:auto;
}
</style>
</head>
<body>
<?php
$sn="localhost";
$un="root";
$pass="";
$dname="student";
$a=[];
$conn=mysqli_connect($sn,$un,$pass,$dname);
if($conn->connect_error)
{
die("Connection failed!");
}
$sql="Select * from student";
$res=$conn->query($sql);
echo "<center>Before Sorting:</center>";
echo "<table border='2'>";
echo "<tr><th>USN</th><th>Name</th><th>Address</th></tr>";
if($res->num_rows>0)
{
while($row=$res->fetch_assoc())
{
echo "<tr><td>".$row["usn"]."</td><td>".$row["name"]."</td><td>".$row["addr"]."</td></tr>";
array_push($a,$row["usn"]);
}
}
echo "</table>";
$n=count($a);
$c=[];
$d=[];
for($i=0;$i<($n-1);$i++)
{
$pos=$i;
for($j=($i+1);$j<$n;$j++)
{
if($a[$pos]>$a[$j])
{
$pos=$j;
}
}
if($pos!=$i)
{
$temp=$a[$pos];
$a[$pos]=$a[$i];
$a[$i]=$temp;
}
}
$res=$conn->query($sql);
if($res->num_rows>0)
{
while($row=$res->fetch_assoc())
{
for($i=0;$i<$n;$i++)
{
if($row["usn"]==$a[$i])
{
$c[$i]=$row["name"];
$d[$i]=$row["addr"];
}
}
}
}
echo "<center>After Sorting:</center>";
echo "<table border='2'>";
echo "<tr><th>USN</th><th>Name</th><th>Address</th></tr>";
for($i=0;$i<$n;$i++)
{
echo "<tr><td>".$a[$i]."</td><td>".$c[$i]."</td><td>".$d[$i]."</td></tr>";
}
echo "</table>";
$conn->close();
?>
</body>
</html>