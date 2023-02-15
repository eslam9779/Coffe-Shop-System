<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Coffee Shop - Users</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous" />
    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Page icon -->
    <link rel="shortcut icon" href="Assets/Images/icon.png" type="image/x-icon">
    <!-- Main Style CSS -->
    <link rel="stylesheet" href="Assets/Styles/style_main.css">

</head>

<body>

    <div class="m-0 p-3 h-100 w-100 d-flex">
        <!-- Right Side Section -->
        <div class="right_side_style pe-3 pt-3 pt-lg-2">
            <div class="user_info_style p-lg-4">
                <img src="Assets/Images/user.png" alt="User Picture" class="rounded-circle w-100">
                <h4 class="mt-2 m-0 text-light d-none d-lg-block text-center">User Name</h4>
                <h5 class="m-0 text-secondary d-none d-lg-block text-center">Admin</h5>
            </div>
            <div class="btn-group-vertical w-100 pt-4 pt-lg-1 p-2">
                <a href="Admin_Home.html" class="btn btn-outline-light text-start p-2 my-1"><i
                        class="fa-solid fa-house mx-2"></i><span class="d-none d-lg-inline">Home</span></a>
                <a href="Add_Product.html" class="btn btn-outline-light text-start p-2 my-1"><i
                        class="fa-solid fa-mug-saucer mx-1"></i><span class="d-none d-lg-inline">Products</span></a>
                <a href="All_Users.html" class="btn btn-outline-light text-start p-2 my-1 active"><i
                        class="fa-solid fa-user mx-2"></i><span class="d-none d-lg-inline">Users</span></a>
                <a href="Admin_Orders.html" class="btn btn-outline-light text-start p-2 my-1"><i
                        class="fa-solid fa-bag-shopping mx-2"></i><span class="d-none d-lg-inline">Orders</span></a>
                <a href="Cheeks.html" class="btn btn-outline-light text-start p-2 my-1"><i
                        class="fa-solid fa-circle-check mx-2"></i><span class="d-none d-lg-inline">Cheeks</span></a>
                <a href="Login.html" class="btn btn-outline-light text-start p-2 my-1"><i
                        class="fa-solid fa-right-from-bracket mx-2"></i><span class="d-none d-lg-inline">Sign
                        Out</span></a>
            </div>
        </div>
        <!-- Main Section -->
        <div class="main_section_style m-0 p-3">

            <?php
                  $id =$_GET["updateid"];
                  $con = new PDO('mysql:host=localhost;dbname=coffee_shop', 'root', '');
                  $x = " SELECT * FROM users where id= '$id'; ";
                  $y = $con->prepare($x);
                  $y->execute();
                  $all= $y->fetchAll(PDO::FETCH_ASSOC);
                  $oldemail=$all[0]["email"];
                  
      
      $nameErr = $emailErr = $fileErr = $room_err=$passwordErr = $confirm_password_err= "";
      $name = $email  = $confirm_password = $password =$room= "";
      if (isset($_POST["submit"])) {
        $type = $_POST["type"];
      
        if (empty($_POST["name"])) {
          $nameErr = "Name is required";
        } else {
          $name = $_POST["name"];
          // check if name only contains letters and whitespace
          if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
            $nameErr = "Only letters and white space allowed";
          }
        }
        ///////////////////////////////////////////////////////////////////
        if (empty($_POST["email"])) {
          $emailErr = "Email is required";
        } else {
          $email = $_POST["email"];
          // check if e-mail address is well-formed
          if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
          }
          else
          {
            $con = new PDO('mysql:host=localhost;dbname=coffee_shop', 'root', '');
            $query = " SELECT email FROM users where email= '$email'; ";
            $sql = $con->prepare($query);
            $sql->execute();
            $check= $sql->fetchAll(PDO::FETCH_ASSOC);
            $newemail=$check[0]["email"];
            if(!empty($check))
            {
              if (!$newemail==$oldemail){
                
                     $emailErr="Email already exist";
                   }     
            }
           
          }
  }
  //////////////////////////////////////////////////////////////////
    
  if (empty($_POST["password"])) {
    $passwordErr = "password is required";
    }
     else {
    $password = $_POST["password"];

    if (!preg_match("/[a-zA-Z0-9]{8,}$/",$password)) {
      $passwordErr = "Invalid password";
    }
  }

  ///////////////////////////////////////////////////
  
    if (empty($_POST["confirmpassword"])) {
      $confirm_password_err = "password is required";
      }
       else {
      $confirm_password = $_POST["confirmpassword"];
  
      if ($_POST["password"]!=$_POST["confirmpassword"] ) {
        $confirm_password_err = "passwords doesn't match";
        }
      }
    
  
///////////////////////////////////////////////////////////
if (empty($_POST["roomnum"])) {
  $room_err = "Room number is required";
  }
   else {
  $room = $_POST["roomnum"];

  if (!preg_match("/[a-zA-Z0-9]{1,6}$/",$room)) {
    $room_err  = "Invalid room numer";
  }
  }

////////////////////////////////////////////////////////////////
$_FILES;
$tmp_path=$_FILES['photo']['tmp_name'];       //pic path on pc
$_file_name = $_FILES['photo']['name'];        //img name and extension
$photo_size =$_FILES['photo']['size'];
$arr = explode('.', $_file_name);                         // separate words from extension                           
$extension=end($arr);                                       // extension

$extension_arr =array("jpg","jpeg","png","csv","gif");    //   extension arr to check pic
global $x;
for($i=0;$i<count($extension_arr);$i++)
{
    if ($extension_arr[$i]==$extension)
    {
         $x=1;
        break;

    }
}
    
    if($x !=1)
{
    $fileErr= "this is not an img";
}
$time=microtime().('.').$extension;
$timeph="./Assets/Images/".$time;

 /////////////////////////////////////////////////////////////////////////////////////

 if ($nameErr=="" && $emailErr=="" && $fileErr=="" && $room_err=="" &&$passwordErr=="" &&$confirm_password_err== "")
 {
 
  move_uploaded_file($tmp_path,$timeph);
  $con = new PDO('mysql:host=localhost;dbname=coffee_shop', 'root', '');
  $query = " UPDATE users SET name='$name',email ='$email',password='$password',room='$room',type='$type',picture='$time' WHERE id=$id ";
  $sql = $con->prepare($query);
  $sql->execute();
  echo "<div class='alert alert-success'>User added Successfully</div> ";
  echo "<br>";
  header('Location:All_Users.php');
  die();

 }
 
}
?>

         

     <h3 style="margin-top:25px">Update USER</h3>
            <div class="containeer-fluid w-75 mx-5  mt-4  ">
                <form method="post" enctype="multipart/form-data">
                    <div class=" mb-2">
                        <label class="form-floating">Name</label>
                        <input type="text" name="name" class="form-control" value="<?php echo $all[0]["name"]; ?>" >
                        <span class="error" style="color:red;"><?php echo $nameErr ?></span>
                    </div>
                    <div class=" mb-2">
                        <span >Email</span>
                        <input type="email" name="email" class="form-control"  value="<?php echo $oldemail ?>">
                        <span class="error" style="color:red;"><?php echo $emailErr ?></span>

                    </div>
                    <div class=" mb-1">
                        <span>Password</span>
                        <input type="password" name="password" class="form-control" placeholder="Please Enter a password">
                        <span class="error" style="color:red;"><?php echo $passwordErr ?></span>

                    </div>
                    <div class=" mb-1">
                        <span >Confirm Password</span>
                        <input type="password" name="confirmpassword" class="form-control" placeholder="Confirm password">
                        <span class="error" style="color:red;"><?php echo $confirm_password_err ?></span>

                    </div>
                    <div class=" mb-1">
                        <span >Room Number</span>
                        <input type="text" name="roomnum" class="form-control" value=<?php echo $all[0]["room"]; ?>>
                        <span class="error" style="color:red;"><?php echo $room_err ?></span>

                    </div>
                    <div class=" mb-1">
                        <span >Type</span>
                        <select name="type" class="form-select " >
                            <option  value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class=" mb-1">

                        <input type="file" name="photo" class="form-control mt-2">
                        <span class="error" style="color:red;"><?php echo $fileErr; ?></span>

                    </div>

                    <div class=" mt-4">
                    <input type="submit" class="btn btn-primary" name="submit" value="Update">
                    <input type="reset" class="btn btn-success" name="submit" value="Reset">
                    </div>
                </form>

            </div>





        </div>
    </div>



    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>