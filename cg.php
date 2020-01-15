<?php
ob_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>ONLINE FOOD ORDER AND DELIVERY</title>
    <link href="styling.css" rel="stylesheet">
     <link href="css/bootstrap.min.css" rel="stylesheet">
    
    <link href='https://fonts.googleapis.com/css?family=Arvo' rel='stylesheet' type='text/css'>
    <style>
        body{
             background:url(imgs/plain.jpg) no-repeat center center;
    background-attachment:fixed;
    background-size:cover;
        }
        #p5{
            color:white;
        }
        #leg{
            color:white;
            font-size:30px;
        }
        fieldset{
            width:330px;
        }
        #errp1{
            color:red;
            transform:translate(890px,100px);
        }
    </style>
    </head>
<body> 
    <?php 
    $restid=101;
   $tot=$_COOKIE["total"]; $link=@mysqli_connect("localhost","root","","quikchef") or die("Erro:Unable to connect: " . mysqli_connect_error());
      $sql="select item_id,iname,price from menu where rest_id=101";
         if($result=mysqli_query($link,$sql)){
           if(mysqli_num_rows($result)>0){
               echo "<center><table class='tabl table table-stripped table-hover table-condensed table-bordered'>
               <tr>
               <th>ITEM ID</th>
               <th>ITEM</th>
               <th >PRICE</th>
               </tr>
               ";
               while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
                   echo "<tr>";
                   echo "<td>".$row["item_id"]."</td>";
                   echo "<td>".$row["iname"]."</td>";
                   echo "<td>".$row["price"]."</td>";
                   echo "</tr>";
               }
               echo "</table></center>";
                mysqli_free_result($result);
           }
         }
    if(isset($_POST["add"]))
    {
         if(isset($_POST["id"]))
    {
        $id=$_POST["id"];
    }
   if(isset($_POST["qty"]))
    {
        $qty=$_POST["qty"];
    }
        $sql1="SELECT price from menu where item_id='$id'";
         if($result1=mysqli_query($link,$sql1)){
           if(mysqli_num_rows($result1)>0){while($row1=mysqli_fetch_array($result1,MYSQLI_ASSOC)){
                $tot=$tot+$row1["price"]*$qty;
        setcookie("total",$tot,time()+9600);
            }
           }
         }
    }
    if(isset($_POST["cont"]))
    {
        $val=$_COOKIE["total"];
        setcookie("price",$val,time()+9600);
        $user=$_COOKIE["ename"];
        $sql2="Select user_id from users where name='$user'";
        if($result2=mysqli_query($link,$sql2)){
           if(mysqli_num_rows($result2)>0){while($row2=mysqli_fetch_array($result2,MYSQLI_ASSOC)){
               $i=$row2["user_id"];
           }
                                          }
        }
        $sql3="Insert into orders(rest_id,user_id,status) values('$restid','$i','pending')";
        if($result3=mysqli_query($link,$sql3)){

        header("Location:summary.php");
        exit();
           }
                                    
    }
    ?>
  
    <div class="main" id="main1">
    <form name="myForm" method="post" action="cg.php" >
     <input type="text" class="ut" name="id" placeholder="item_id" size="30px" maxlength="100" class="form-control">
        <br />
        <input type="text" class="ut" name="qty" placeholder="quantity" size="30px" maxlength="20" >
        <br />
     <input type="submit" name="add" class="btn btn-success btn-lg" id="button1" value="ADD" style="background-color:#ff0041;">
        <input type="submit" name="cont" class="btn btn-success btn-lg" id="button1" value="PROCEED" style="background-color:#ff0041;">
        </form>
    </div>    
    
</body>
</html>
<?php
ob_flush();
?>