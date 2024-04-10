<?php
// Check existence of id parameter before processing further
if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    // Include config file
    require_once "config.php";

    // Prepare a select statement
    $sql = "SELECT * FROM pollution WHERE id = ?";

    if ($stmt = mysqli_prepare($link, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);

        // Set parameters
        $param_id = trim($_GET["id"]);

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) == 1) {
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                // Retrieve individual field value
                $source = $row["source"];
                $temperature = $row["temperature"];
                $relativehumidity = $row["relativehumidity"];
                $winddirection = $row["winddirection"];
            } else {
                // URL doesn't contain valid id parameter. Redirect to error page
                header("location: error.php");
                exit();
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }

    // Close statement
    mysqli_stmt_close($stmt);

    // Close connection
    mysqli_close($link);
} else {
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>View Details</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <td colspan="6" align="center"><img src="images/logo.png" style= "height:100px"></td>
    <ul>
<li><a href="index.php">Index</a></li> 
<li><a href="me.html" >About me</a></li> 
<li><a href="demo.php">Demonstration</a></li> 
<li><a href="resources.html" >Resources</a></li> 
<li><a href="landpollution.html" >Land Pollution</a></li> 
<li><a href="waterpollution.html" >Water Pollution</a></li> 
<li><a href="airpollution.html" >Air Pollution</a></li> 
<li><a href="noicepollution.html" >Noise Pollution</a></li> 
<li><a href="contact.html" >Contact</a></li> 
</ul>
  <style>
        .wrapper {
            width: 600px;
            margin: 0 auto;
        }
        ul{
       list-style-type: circle;
       margin: 10px; 
       padding:20 px;
       overflow: hidden;
       border-style:solid;
       border-color: black;
    }
    li{
        float: left;
    }
    li a{
        display: block;
        text-align:center;
        padding: 10px 80px;
    }  
    img{
        display: block;
  margin:  auto;

  border: 3px solid black;
    } 
    </style>
      <img src="Images/museum.jpeg" alt="museum",</img>
</head>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="mt-5 mb-3">View Details</h1>
                    <div class="form-group">
                        <label>Source</label>
                        <p><b><?php echo $row["source"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Temperature</label>
                        <p><b><?php echo $row["temperature"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Relative Humidity</label>
                        <p><b><?php echo $row["relativehumidity"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>wind direction</label>
                        <p><b><?php echo $row["winddirection"]; ?></b></p>
                    </div>
                    <p><a href="index.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>