<?php include('connection.php') ?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Login</title>
</head>

<body>
<?php
    if (isset($_POST['submit'])) {
        extract($_POST);
        $user_qry = mysqli_query($con,"SELECT * FROM `user` WHERE `username` ='$username' and `password`= '$password' ");
		if(mysqli_num_rows($user_qry)>0){
            $row = mysqli_fetch_assoc($user_qry);
            session_start();
           $_SESSION['username'] = $username;
           $_SESSION['role'] = $row['role'];
            //header("location:index.php");												
            echo "<script>window.open('welcome.php','_self');</script>";
        }else{
            $msg="<h3 class='text-center'>Something Error</h3>";
        }
    }else{
        $msg="";
    }
    echo $msg;
    ?>

    <h1 class="text-center">Login</h1>
    <div class="d-flex justify-content-center">
        <form  style="width:500px;border:2px solid red;padding:20px;" method="post" action="">
            <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" name="username" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
            </div>
            
            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
        </form>
        
    </div>
    <h6 class="text-center">Create Account ?<a href="register.php" >Register</a></h6>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>