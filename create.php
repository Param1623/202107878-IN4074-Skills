<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$source = $temperature = $relativehumidity = $winddirection= "";
$source_err = $temperature_err = $relativehumidity_err = $winddirection_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate source
    $input_source = trim($_POST["source"]);
    if (empty($input_source)) {
        $source_err = "Please enter a source.";
    } else {
        $source = $input_source;
    }

    // Validate temperature
    $input_temperature = trim($_POST["temperature"]);
    if (empty($input_temperature)) {
        $temperature_err = "Please enter an temperature.";
    } else {
        $temperature = $input_temperature;
    }

    // Validate relativehumidity
    $input_relativehumidity = trim($_POST["relativehumidity"]);
    if (empty($input_relativehumidity)) {
        $relativehumidity_err = "Please enter the relativehumidity value.";
    } else {
        $relativehumidity = $input_relativehumidity;
    }

    // Validate winddirection
    $input_winddirection = trim($_POST["winddirection"]);
    if (empty($input_winddirection)) {
        $winddirection_err = "Please enter the winddirection value.";
    } else {
        $winddirection = $input_winddirection;
    }


    // Check input errors before inserting in database
    if (empty($source_err) && empty($temperature_err) && empty($relativehumidity_err) && empty($winddirection_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO pollution (source, temperature, relativehumidity, winddirection) VALUES (?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_source, $param_temperature, $param_relativehumidity, $param_winddirection);

            // Set parameters
            $param_source = $source;
            $param_temperature = $temperature;
            $param_relativehumidity = $relativehumidity;
            $param_winddirection = $winddirection;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Detailss created successfully. Redirect to landing page
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
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create Details</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <td colspan="6" align="center"><img src="images/logo.png" style= "height:80px"></td>
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
                    <h2 class="mt-5">Create Details</h2>
                    <p>Please fill this form and submit to add pollution Details to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group">
                            <label>source</label>
                            <input type="text" name="source" class="form-control <?php echo (!empty($source_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $source; ?>">
                            <span class="invalid-feedback"><?php echo $source_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>temperature</label>
                            <input type="text" name="artistname" class="form-control <?php echo (!empty($temperature_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $temperature; ?>">
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
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>