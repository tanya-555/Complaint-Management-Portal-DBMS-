<?php
ob_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>INCOME TAX MANAGEMENT PORTAL</title>
    <link href="styling.css" rel="stylesheet">
     <link href="css/bootstrap.min.css" rel="stylesheet">
    
    <link href='https://fonts.googleapis.com/css?family=Arvo' rel='stylesheet' type='text/css'>
     <script src="js/jquery-3.3.1.min.js"></script>
   
       <style>
        #adder{
            color:red;
           transform:translate(550px,17px);  
        }
        #addmail{
            color:red;
            transform:translate(600px,17.5px); 
        }
        #addpr{
            color:black;
          transform:translate(542px,18px);   
        }
    </style>
    
    </head>
    <body>
    <div id="contain">
    <div id="head">
        <h5 id="add"><span class="add1">Income Tax Calculator ->  </span>Home | Admin | Add Staff<span class="back"><a href="admin1.php" class="link"><u>BACK</u></a></span></h5>
        
        <br /><br />
        <h2 id="add2"><u>Enter credentials of the staff :</u></h2>    
    </div>    
    </div>
       <?php
$link=mysqli_connect("localhost","root","","tax") or die("Error:Unable to connect: " . mysqli_connect_error());
$name = isset($_POST["name"])?$_POST["name"]:" ";
$password = isset($_POST["pass"])?$_POST["pass"]:" ";
 $mail = isset($_POST["mail"])?$_POST["mail"]:" ";
$mob = isset($_POST["mob"])?$_POST["mob"]:" ";        

//if the user has submitted the form
if(isset($_POST["submit"])){
    //check for errors
    if(!$name || !$mob || !$mail || !$password){
        echo "<p id='adder'>You are required to fill all the entries!</p>";  
    }
    else if(!filter_var($mail,FILTER_VALIDATE_EMAIL)){
        echo "<p id='addmail'>Enter a valid email id!</p>"; 
    }
   else
    {   
      $name=mysqli_real_escape_string($link,$name);
 $password=mysqli_real_escape_string($link,$password);
     $mob=mysqli_real_escape_string($link,$mob);
     $mail=mysqli_real_escape_string($link,$mail);  
         $sql="INSERT into users (user_name) VALUES ('$name')";
        if($result=mysqli_query($link,$sql)){
        $count="SELECT user_id from users order by user_id desc";
       if($res=mysqli_query($link,$count)){
           $rows=mysqli_fetch_array($res,MYSQLI_ASSOC);
           $c=$rows["user_id"];
       $sql1="INSERT into employee(emp_id,name,password,mobile,email) VALUES ('$c','$name','$password','$mob','$mail')";
       if($result1=mysqli_query($link,$sql1)){
           echo "<p id=addpr>You have successfully added new staff!</p>";
        $subject="Employee Notification";
        $message="You have been added to the Income Tax Management Portal.Your password is:".$password;
        $headers = "Content-type: text/html";
        mail($mail, $subject, $message, $headers);
       }
        
        }
        }
    }
}
mysqli_close($link);
?>  
    <div class="adds" id="adds1">  
    <form method="post" action="addstaff.php">
        <div class="form-group">
            <input type="text" class="ut" name="name" placeholder="Enter staff name" size="30px" maxlength="100" class="form-control" value="<?php if(isset($_POST["name"])) echo $_POST["name"];?>"> </div> <br /> 
        <div class="form-group">
            <input type="password" class="ut" name="pass" placeholder="Enter password" size="30px" maxlength="100" class="form-control" value="<?php if(isset($_POST["pass"])) echo $_POST["pass"];?>"></div>
         <br />
        <div class="form-group">
             <input type="text" class="ut" name="mob" placeholder="Enter mobile number"  size="30px" maxlength="100" class="form-control" value="<?php if(isset($_POST["mail"])) echo $_POST["mob"];?>"> 
    
        </div> <br />
        <div class="form-group">
            <input type="text" class="ut" name="mail" placeholder="Enter e-mail id"  size="30px" maxlength="100" class="form-control" value="<?php if(isset($_POST["mob"])) echo $_POST["mail"];?>" > </div> <br />
   <input type="submit" name="submit" class="btn btn-success btn-lg" id="button1" value="ADD" style="background-color:#e8bd78;">
   
          </form>
    </div>
    
    </body>
</html>