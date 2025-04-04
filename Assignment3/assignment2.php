<!DOCTYPE html>
<!--SA：I, Erin Ng, 400360728 certify that this material is my original work.
No other person's work has been used without due acknowledgement.
I have also not made my work available to anyone else.-->
<html lang="en">
<?php
$unitsselected ='';
$num='';
?>


<head>
    <!--HTML BoilerPlate Content" -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Assignment2">
    <meta name="author" content="Erin Ng">
    <meta keywords="Assignment2, PROCTECH 4IT3, SEP 6IT3, McMaster University, HTML, CSS, JavaScript">
    <meta name="robots" content="index, follow">

    <!--
    BoilerPlate items for Social Media Robots
    -->
    <meta property="og:title" content="Assignment2 - Erin Ng"/>
    <meta property="og:type:article:author" content="Erin Ng"/>
    <meta property="og:type:article:section" content="Assignment2"/>
    <meta property="og:url" content="https://webdev.sept.mcmaster.ca/ngt32/"/>

    <title>Assignment2</title>

    <!--
      BoilerPlate BOOTSTRAP!
   -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .centerd {
            text-align: center;
            align-content: center;
            align-items: center;
        }
    </style>
</head>
<body>

<div class="centerd bg-dark text-light">
    <h1>Water Plant Residual Chlorine Monitor</h1>
    <h2>PROCTECH 4IT3/SEPT 6IT3 Test 3</h2>
</div>

<div class="centerd">
    <p>Current Time is: <span id="dt"></span></p>
    <script>
        var x = setInterval(function () {
            var date = Date.now();
            var options = {
                weekday: 'short',
                year: 'numeric',
                month: 'short',
                day: 'numeric',
                hour: 'numeric',
                minute: 'numeric',
                second: 'numeric'
            };
            var date = new Date(date).toLocaleDateString("en-US", options);
            document.getElementById("dt").innerHTML = date;
        }, 1000);
    </script>
</div>

<div class="centerd">
    <a href="">Refresh</a>
</div>

<hr/>
<div class="container-fluid col-md-8 align-content-center">

    <form action=<?=$_SERVER['PHP_SELF']?>?option=update" method="post">
        <?php
        if(isset($_POST["unit"])){
            $unitsselected = $_POST["unit"];
        }
        ?>
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="input-group">
                    <div class="input-group-text">Flow Limit</div>
                    <input type="number" placeholder="1200" class="form-control" aria-label="FlowLimit" autofocus
                           min="0" name="flowLimit" value="<?php echo isset($_POST['flowLimit']) ? $_POST['flowLimit'] : 0; ?>">
                </div>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary">Get Data</button>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col col-md-6">
                <div class="form-check form-check-inline">
                    <label class="form-check-label" for="showall">Show All Data</label>
                    <input class="form-check-input" type="radio" id="showall" name="ShowData" value="All"
                        <?php echo ($unitsselected == "All") ? 'checked' : '' ?>>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label" for="showselect">Show only data less than flow limit</label>
                    <input class="form-check-input" type="radio" id="showselect" name="ShowData" value="select"
                        <?php echo ($unitsselected == "select") ? 'checked' : '' ?>>
                </div>

            </div>
        </div>

    </form>
</div>

<!--THIS SHOULD BE INCORPORATED INTO YOUR PHP AND ADJUSTED FOR WHAT YOU NEED. THIS IS THE BAREBONES ONLY-->
<div class="container-fluid col-md-8 align-content-center">
    <table class="table table-striped table-hover centerd">
        <thead class="table-dark">
        <tr>
            <th scope="col">Date</th>
            <th scope="col">Flow</th>
            <th scope="col">Cl</th>
            <th scope="col">Cl(Tap)</th>
        </tr>
        <tr>
            <th scope="col">dd-mm-yy</th>
            <th scope="col">1000m^3/day</th>
            <th scope="col">mg/l</th>
            <th scope="col">mg/l</th>
        </tr>
        </thead>


        <tbody>
        <!--        <tr>-->
        <!--            <td>Insert your Text here</td>-->
        <!--            <td class="table-danger">Insert your Highlighted Text Here</td>-->
        <!--        </tr>-->
        <?php
        $highlighted=0;
        $count=0;
        $total=0;
        $total_tap=0;
        $file= fopen("cl_data.csv","r");
        $flow_limit = isset($_POST['flowLimit']) ? (float)$_POST['flowLimit'] : 0;
        $filter = isset($_POST['ShowData']) ? $_POST['ShowData'] : "all";
        if (isset($_POST['ShowData']) && $_POST['ShowData'] == "All") {



            // Read and display each row
            while (($row = fgetcsv($file)) !== FALSE) {
                // Extract values
                $date = $row[0];          // First column (Date)
                $value1 = (float)$row[1]; // Second column (Numeric)
                $value2 = (float)$row[2]; // Third column (Numeric)
                if ($filter == "select" && $value1 >= $flow_limit) {
                    continue; // Skip rows above the limit
                }

                // Calculate the fourth column
                $calculated_value = $value2 - (2500 - $value1) * 0.000124;

                // Display the row
                echo "<tr>";
                echo "<td>" . htmlspecialchars($date) . "</td>";
                echo "<td>" . htmlspecialchars($value1) . "</td>";
                echo "<td>" . htmlspecialchars($value2) . "</td>";
                $total+=$value2;
                $total_tap += $calculated_value;
                $count++;
                if($calculated_value <=0.3){
                    echo "<td class='bg-warning'>" . number_format($calculated_value, 2) . "</td>";
                    $highlighted++;
                } else
                    echo "<td>" . number_format($calculated_value, 2) . "</td>";
                echo "</tr>";
            }fclose($file);

        } else if (isset($_POST['ShowData']) && $_POST['ShowData'] == "select") {
            if($flow_limit ==0){
                echo "<div class='bg-warning'>Please insert a flow limit</div>";
            }


            while (($row = fgetcsv($file)) !== FALSE) {
                // Extract values
                $date = $row[0];          // First column (Date)
                $value1 = (float)$row[1]; // Second column (Numeric)
                $value2 = (float)$row[2]; // Third column (Numeric)
                if ($value1 >= $flow_limit) { //checks if there is a flow limit, continues if not
                    continue; // Skip rows above the limit
                }

                // Calculate the fourth column
                $calculated_value = $value2 - (2500 - $value1) * 0.000124;

                if($calculated_value <=0.3){
                    // Display the row
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($date) . "</td>";
                    echo "<td>" . htmlspecialchars($value1) . "</td>";
                    echo "<td>" . htmlspecialchars($value2) . "</td>";
                    echo "<td class='bg-warning'>" . number_format($calculated_value, 2) . "</td>";
                    echo "</tr>";
                    $total+=$value2;
                    $total_tap += $calculated_value;
                    $highlighted++;
                    $count++;
                }
            }
            fclose($file);
        }
        else {
            echo "<div class ='bg-danger text-white'> Error: Please select an option.</div>";//not working
        }

        ?>

        </tbody>
        <tfoot class="table-dark">
        <tr class="centerd">
            <td colspan="2">Average</td>
            <td><?php echo number_format($average = $total /$count, 2); ?></td>
            <td><?php echo number_format($average = $total_tap /$count, 2); ?></td>
        </tr>
        <tr class="centerd">
            <td colspan="3">Number of days with LOW Cl at Tap</td>
            <td colspan="3"><?php echo $highlighted?></td>
        </tr>

        </tfoot>
    </table>
</div>
<?php

?>
<br/><br/><br/>
</body>
<footer class="footer mt-auto py-3 bg-dark centerd fixed-bottom">
    <div class="container">
        <span class="text-muted "> &copy; Erin Ng 2025</span>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</html>