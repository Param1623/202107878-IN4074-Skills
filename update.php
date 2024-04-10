<?php
// Include config file
require_once "config.php"; 

// Define variables and initialize with empty values
$source = $temperature = $relativehumidity = $winddirection = "";
$source_err = $temperature_err = $relativehumidity_err = $winddirection_err = "";

// Processing form data when form is submitted
if (isset($_POST["id"]) && !empty($_POST["id"])) {
    // Get hidden input value
    $id = $_POST["id"];

     // Validate Source
     $input_source = trim($_POST["source"]);
     if (empty($input_source)) {
         $source_err = "Please enter the Source.";
     } else {
         $source = $input_source;
     }

    // Validate Temperature
    $input_temperature = trim($_POST["temperature"]);
    if (empty($input_temperature)) {
        $temperature_err = "Please enter a Temperature.";
    } elseif (!filter_var($input_temperature, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $temperature_err = "Please enter a valid Temperature.";
    } else {
        $temperature = $input_temperature;
    }

    // Validate relativehumidity
    $input_relativehumidity = trim($_POST["relativehumidity"]);
    if (empty($input_relativehumidity)) {
        $relativehumidity_err = "Please enter an relativehumidity.";
    } else {
        $relativehumidity = $input_relativehumidity;
    }

    // Validate winddirection
    $input_winddirection = trim($_POST["winddirection"]);
    if (empty($input_winddirection)) {
        $winddirection_err = "Please enter the winddirection amount.";
    } else {
        $winddirection = $input_winddirection;
    }

    // Check input errors before inserting in database
    if (empty($source_err) && empty($temperature_err) && empty($relativehumidity_err) && empty($winddirection_err)) {
        // Prepare an update statement
$sql = "UPDATE pollution SET source=?, temperature=?, relativehumidity=?, winddirection=? WHERE id=?";

if ($stmt = mysqli_prepare($link, $sql)) {
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "ssssi", $param_source, $param_temperature, $param_relativehumidity, $param_winddirection, $param_id);

    // Set parameters
    $param_source = $source;
    $param_temperature = $temperature;
    $param_relativehumidity = $relativehumidity;
    $param_winddirection = $winddirection;
    $param_id = $id;

    // Attempt to execute the prepared statement
    if (mysqli_stmt_execute($stmt)) {
        // Detailss updated successfully. Redirect to landing page
        header("location: index.php");
        exit();
    } else {
        echo "Oops! Something went wrong. Please try again later.";
    }
}

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($link);
} else {
    // Check existence of id parameter before processing further
    if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
        // Get URL parameter
        $id =  trim($_GET["id"]);

        // Prepare a select statement
        $sql = "SELECT * FROM pollution WHERE id = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);

            // Set parameters
            $param_id = $id;

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
                    // URL doesn't contain valid id. Redirect to error page
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
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Update Details</title>
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
</head>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Update Details</h2>
                    <p>Please edit the input values and submit to update the pollution Details.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                    <div class="form-group">
                            <label>Source</label>
                            <input type="text" name="source" class="form-control <?php echo (!empty($source_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $source; ?>">
                            <span class="invalid-feedback"><?php echo $source_err; ?></span>
                        </div>   
                    <div class="form-group">
                            <label>Temperature</label>
                            <input type="text" name="temperature" class="form-control <?php echo (!empty($temperature_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $temperature; ?>">
                            <span class="invalid-feedback"><?php echo $temperature_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>relative humidity</label>
                            <input type="text" name="relativehumidity" class="form-control <?php echo (!empty($relativehumidity_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $relativehumidity; ?>">
                            <span class="invalid-feedback"><?php echo $relativehumidity_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>wind direction</label>
                            <input type="text" name="winddirection" class="form-control <?php echo (!empty($winddirection_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $winddirection; ?>">
                            <span class="invalid-feedback"><?php echo $winddirection_err; ?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>" />
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>