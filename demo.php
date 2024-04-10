<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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

        table tr td:last-child {
            width: 120px;
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
    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</head>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left">Pollution Details</h2>
                        <a href="create.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New Details</a>
                    </div>
                    <?php
                    // Include config file
                    require_once "config.php";

                    // Attempt select query execution
                    $sql = "SELECT * FROM pollution";
                    if ($result = mysqli_query($link, $sql)) {
                        if (mysqli_num_rows($result) > 0) {
                            echo '<table class="table table-bordered table-striped">';
                            echo "<thead>";
                            echo "<tr>";
                            echo "<th>#</th>";
                            echo "<th>source</th>";
                            echo "<th>temperature</th>";
                            echo "<th>relativehumidity</th>";
                            echo "<th>winddirection</th>";
                            echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";
                            while ($row = mysqli_fetch_array($result)) {
                                echo "<tr>";
                                echo "<td>" . $row['id'] . "</td>";
                                echo "<td>" . $row['source'] . "</td>";
                                echo "<td>" . $row['temperature'] . "</td>";
                                echo "<td>" . $row['relativehumidity'] . "</td>";
                                 echo "<td>" . $row['winddirection'] . "</td>";
                                echo "<td>";
                                echo '<a href="read.php?id=' . $row['id'] . '" class="mr-3" title="View details" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                                echo '<a href="update.php?id=' . $row['id'] . '" class="mr-3" title="Update details" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                echo '<a href="delete.php?id=' . $row['id'] . '" title="Delete details" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                                echo "</td>";
                                echo "</tr>";
                            }
                            echo "</tbody>";
                            echo "</table>";
                            // Free result set
                            mysqli_free_result($result);
                        } else {
                            echo '<div class="alert alert-danger"><em>No details were found.</em></div>';
                        }
                    } else {
                        echo "Oops! Something went wrong. Please try again later.";
                    }

                    // Close connection
                    mysqli_close($link);
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>