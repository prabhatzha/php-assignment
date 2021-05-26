<?php
$conn = mysqli_connect("localhost", "root", "password", "novicecab");
?>
<?php
// define variables and set to empty values
$phoneErr = $emailErr = $imageErr  = "";
$phone = $email =  $image = "";

if (isset($_POST['submit'])) {
  if (empty($_POST["phone"])) {
    $phoneErr = "Phone number is required";
  } else {
    $phone = test_input($_POST["phone"]);
    if (!preg_match('/^[0-9]{10}+$/', $phone)) {
      $phoneErr = "Invalid phone format";
    }
  }

  if (empty($_POST["email"])) {
    $emailErr = "Email is required";
  } else {
    $email = test_input($_POST["email"]);
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format";
    }
  }



  $dir = "images/";
  $image = $_FILES['image']['name'];
  $temp_name = $_FILES['image']['tmp_name'];

  if ($image != "") {
    if (file_exists($dir . $image)) {
      // $image= time().'_'.$image;
      // move_uploaded_file($temp_name, $fdir);
    }

    $fdir = $dir . $image;
    move_uploaded_file($temp_name, $fdir);
  }




  // echo "INSERT INTO `assignment` (`phone`, `email`, `image`) VALUES ('$phone', '$email', '$image')";

  //   INSERT INTO `assignment` (`id`, `name`, `email`, `website`, `comment`, `gender`) VALUES (NULL, 'hjkn', 'jnjn', 'jnjknjkn', 'jnjknjk', 'jnjnj');

  if (!$phoneErr && !$emailErr && !$imageErr) {

    $sql = "INSERT INTO `assignment` (`phone`, `email`, `image`) VALUES ('$phone', '$email', '$image')";

    $result = mysqli_query($conn, $sql);
  }
}


function test_input($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>


<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
        integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Job Assignment </title>
</head>
<style>
.error {
    color: #FF0000;
}
</style>
<style>
.required:after {
    content: " *";
    color: red;
}
</style>

<body>

    <div class="container my-3">

        <!-- Image and text -->
        <nav class="navbar navbar-dark bg-primary" style="margin: auto;border-radius: 10px;">
            <h4 class="navbar-brand">
                Assignment &nbsp; Work
            </h4>
        </nav>

        <br>
        <form action="users.php" method="post" enctype="multipart/form-data">

            <div class="form-row">

                <div class="form-group col-md-2">
                    <select name="country" style="margin-top:30px;">
                        <option value="0" selected="selected">Choose..</option>
                        <?php
            $result = mysqli_query($conn, "SELECT id_country,phonecode FROM  `tbl_countries`");

            while ($row = mysqli_fetch_array($result)) {
              echo '<option value="' . $row['id_country'] . '">' . $row['phoncoecode'] . '</option>';
            }

            ?>
                    </select>
                </div>

                <div class="form-group col-md-4">
                    <label for="inputEmail4" class="required">Phone</label>
                    <input type="number" class="form-control" id="phone" name="phone" value="<?php echo $phone; ?>">
                    <span class="error"><?php echo $phoneErr; ?></span>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword4" class="required">Email Id</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>">
                    <span class="error"><?php echo $emailErr; ?></span>
                </div>
            </div>
            <div class="form-group">
                <label for="inputAddress" class="required">Image</label>
                <input type="file" class="form-control" id="image" name="image">
                <span class="error"> <?php echo $imageErr; ?></span>
            </div>

            <button type="submit" style="margin: auto;border-radius: 15px;border-style: double;margin-top: 25px;"
                class="btn btn-primary btn-lg" name="submit">Submit </button>
        </form>
    </div>
    <br>
    <?php   

$sql = "SELECT * FROM `assignment`";
 $res= mysqli_query($conn, $sql);
//  print_r($res);exit;

?>
    <div class="container my-2">
    <table id="productsTable" class="table table-striped table-hover table-bordered">
                <thead>
                    <th>S.No.</th>
                  
                    <th>Mobile No.</th>
                    <th>Email Id</th>
                    <th>Profile Images</th>
                   
                </thead>
                <tbody>
                        <?php
                        $i=1;
            if(mysqli_num_rows($res) > 0){

                while($row = mysqli_fetch_assoc($res)){

               ?>

                <tr id="<?php echo $row['id'] ?>">
                    <th scope="row"> <?php echo $i ?></th>
                    
                    <td><?php echo $row['phone']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    
                    <td><img src="images/<?php echo $row['image'];?>" class="php" width="60" height="50"></td>

                </tr>
                <?php $i++;
            }
            }else{
                echo "no data found";
            } 
            
            ?>
            
                </tbody>
              
            </table>
       
    </div>
    <br>
    <div class="container">
        <footer class="navbar navbar-dark bg-dark"
            style="margin: auto;border-radius: 10px;     background-color: #4589a7!important;">

            <form>
                <div class="form-row">
                    <div class="form-group">
                        <h3 style="color:white;margin-left: 45px;"><i class="fa fa-address-book" aria-hidden="true"></i>
                            Contact With Us </h3>

                        <p id="text"></p>

                        <script type="text/javascript">
                        var isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
                        var element = document.getElementById('text');
                        if (isMobile) {
                            element.innerHTML =
                                '<p style="margin-left: 80px; color:white;"><a style="color:white;" href="tel:9971077959"><i class="fa fa-phone" aria-hidden="true"></i> Click To Call</a></p>';

                        } else {
                            element.innerHTML =
                                '<p style="margin-left: 80px; color:white;"><a style="color:white;" href="mailto:pkjha825@gmail.com"><i class="fa fa-envelope" aria-hidden="true"></i> Click To Email</a></p>';

                        }
                        </script>


                    </div>



                    <div class="form-group ">
                        <h3 style="color:white;margin-left: 45px;"><i class="fa fa-share-alt" aria-hidden="true"></i>
                            Share The Link
                        </h3>

                        <p id="text2"></p>

                        <script type="text/javascript">
                        var isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
                        var element = document.getElementById('text2');
                        if (isMobile) {
                            element.innerHTML =
                                '<p style="margin-left: 80px; color:white;"><a style="color:white;" href="https://api.whatsapp.com/send?phone=9971077959&text=Hii I Am Prabhat"> <i class="fa fa-whatsapp" aria-hidden="true"></i> Share On Whatsapp </a></p> ';

                        } else {
                            element.innerHTML =
                                '<p style="margin-left: 80px; color:white;"><a  style="color:white;" href="mailto:pkjha825@gmail.com"><i class="fa fa-share-square-o" aria-hidden="true"></i> Share With Email</a></p>';

                        }
                        </script>


                    </div>

                </div>
            </form>

        </footer>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous">
    </script>

</body>

</html>