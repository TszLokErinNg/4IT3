<!DOCTYPE html>

<?php

function runQuery($query){
    // Script that now processes the page - single page application

    $host = 'localhost';
    $dbuser = 'zhaos98';
    $dbpass = 'Test@123';
    $dbase = "zhaos98";

    //connect of database else display error
    $link = mysqli_connect($host, $dbuser, $dbpass, $dbase);

    if (!$link) {
        $status = 'Could not connect: ' . mysqli_error();
        echo $status;
        die();
    }

    mysqli_select_db($link, $dbase);

    $result = mysqli_query($link, $query) or die("Query failed: ". mysqli_error($link));

    $link->close();

    return $result;
}

?>


<html lang="en">
<head>
    <!--HTML BoilerPlate Content" -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="PROCTECH 4IT3 - LAB 9">
    <meta name="author" content="$STUDENT$">
    <meta keywords="PROCTECH 4IT3 - LAB 9, PROCTECH 4IT3, SEP 6IT3, McMaster University, HTML, CSS, JavaScript">
    <meta name="robots" content="index, follow">

    <!--
    BoilerPlate items for Social Media Robots
    -->
    <meta property="og:title" content="PROCTECH 4IT3 - LAB 9 - $STUDENT$"/>
    <meta property="og:type:article:author" content="$STUDENT$"/>
    <meta property="og:type:article:section" content="PROCTECH 4IT3 - LAB 9"/>
    <meta property="og:url" content="https://4IT3.sept.mcmaster.ca/$MacID$/"/>

    <title>PROCTECH 4IT3 - LAB 9</title>
    <style>
        .centerd {
            text-align: center;
            align-content: center;
            align-items: center;
        }
    </style>

    <!--
      BoilerPlate BOOTSTRAP!
   -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container-fluid centerd bg-dark text-light">
    <h2>LAB#9 - Water Readings Database</h2>
    <?php
    //find out how many entries are in the table
    // You will need to modify this query to join two tables to get the view that is required.

    $basequery = 'SELECT * FROM lab9_data';
    $result = runQuery($basequery);
    $num = mysqli_num_rows($result);
    echo "<h3>$num readings in data table</h3>";


    ?>
</div>

<?php

if (!empty($_POST)) {
    $date = $_POST['t'];
    $type = $_POST['parameterid'];
    $reading = $_POST['reading'];

    if (isset($_POST['add'])) {
        $query = "INSERT INTO `lab9_data`
        (`t`,`parameterid`,`reading`)
        VALUES
        ('$date','$type','$reading')";
        $result = runQuery($query);
    } elseif (isset($_POST['update'])) {
        $id = $_POST['update'];
        $query = "UPDATE `lab9_data` SET `t` = '$date',`parameterid`='$type',`reading`='$reading' where `id`=$id";
        $result = runQuery($query);
    }
}

if (isset($_GET['action']) and ($_GET['action'] == "delete")) {
    $id = $_GET['id'];
    $query = "DELETE FROM `lab9_data` WHERE  `id`='$id'";
    $result = runQuery($query);
    if ($result)
        printf("<div class='container-fluid col-md-5 centerd'><div class='alert alert-success'>Row %s successfully deleted</div></div>", $id);
    else {
        printf("<div class='container-fluid col-md-5 centerd'><div class='alert alert-danger'>Row %s NOT deleted</div></div>", $id);
    }
}

global $dateT, $readingT, $readingN;

if (isset($_GET['action']) and $_GET['action'] == "edit") {
    $id = $_GET['id'];
    $query = "SELECT `lab9_data`.`t`,`lab9_data`.`parameterid`,`lab9_data`.`reading` 
			from `lab9_data` 
			where `id`='$id'";
    $result = runQuery($query);
    $result = mysqli_fetch_array($result);
    $dateT = $result['t'];
    $readingT = $result['parameterid'];
    $readingN = $result['reading'];
}



?>

<div class="container-fluid col-md-5">
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
        <div class="form-control">
            <fieldset>
                <legend>Add/Update Water Data</legend>
                <div class="input-group mb-3">
                    <span class="input-group-text">Date</span>
                    <input type="date" name="t" class="form-control" required value="<?php global $dateT; echo $dateT; ?>" aria-describedby="thelp">

                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">Reading Type</span>
                    <select name="parameterid" class="form-select">
                        <option value='FLOWE' <?php global $readingT; if ($readingT == "FLOWE") echo "Selected" ?>>FLOWE</option>
                        <option value='FLOWW' <?php global $readingT; if ($readingT == "FLOWW") echo "Selected" ?>>FLOWW</option>
                        <option value='FLOWB' <?php global $readingT; if ($readingT == "FLOWB") echo "Selected" ?>>FLOWB</option>
                        <option value='TEMP' <?php global $readingT; if ($readingT == "TEMP") echo "Selected" ?>>TEMP</option>

                    </select>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">Reading</span>
                    <input type="text" name="reading" maxlength="15" class="form-control" required value="<?php global $readingN; echo $readingN; ?>" aria-describedby="rhelp" pattern="[0-9.0-9]*" placeholder="###.##">
                </div>

                <?php
                if (isset($_GET['action']) and $_GET['action'] == "edit") {
                    $id = $_GET['id'];
                    printf("<button name=\"update\" type=\"submit\" class=\"btn btn-primary\" value=\"$id\">Update Reading</button>");
                } else {
                    printf("<button name=\"add\" type=\"submit\" class=\"btn btn-primary\">Add Reading</button>");
                }
                ?>



            </fieldset>
        </div>
    </form>
</div>

<!-- Suggested that you output table last -->
<div class="container-fluid col-md-5 centerd">
    <table class="table table-striped table-bordered">

        <!--New added-->
        <thead class="table-dark">
        <tr>
            <th></th>
            <th scope="col">
                <a href="<?php echo $_SERVER['PHP_SELF']; ?>?action=sort&sortby=id&orderby=<?php echo (isset($_GET['sortby']) && $_GET['sortby'] == 'id' && $_GET['orderby'] == 'asc') ? 'desc' : 'asc'; ?>" class="text-light">ID</a>
            </th>
            <th scope="col">
                <a href="<?php echo $_SERVER['PHP_SELF']; ?>?action=sort&sortby=date&orderby=<?php echo (isset($_GET['sortby']) && $_GET['sortby'] == 'date' && $_GET['orderby'] == 'asc') ? 'desc' : 'asc'; ?>" class="text-light">Date</a>
            </th>
            <th scope="col">
                <a href="<?php echo $_SERVER['PHP_SELF']; ?>?action=sort&sortby=pm&orderby=<?php echo (isset($_GET['sortby']) && $_GET['sortby'] == 'pm' && $_GET['orderby'] == 'asc') ? 'desc' : 'asc'; ?>" class="text-light">Parameter Name</a>
            </th>
            <th>Reading</th>
            <th>Units</th>
        </tr>
        </thead>

        <tbody>
        <?php
        $query = "SELECT lab9_data.id,lab9_data.t,lab9_parm.name,lab9_data.reading,lab9_parm.units
                FROM lab9_data
                LEFT JOIN lab9_parm on lab9_data.parameterid=lab9_parm.id
        ";

        if (isset($_GET['action']) and $_GET['action'] == "sort") {
            $orderby = isset($_GET['orderby']) && $_GET['orderby'] == 'asc' ? 'ASC' : 'DESC';
            switch ($_GET['sortby']) {
                case "id":
                    $query .= " ORDER BY id $orderby";
                    break;
                case "date":
                    $query .= " ORDER BY `t` $orderby";
                    break;
                case "pm":
                    $query .= " ORDER BY `parameterid` $orderby";
                    break;
            }
        }

        $result = runQuery($query);
        $dataSet = mysqli_fetch_all($result);
        $rlen = mysqli_num_rows($result);

        for ($i = 0; $i < $rlen; $i++){
            echo "<tr>";
            for ($j = 0; $j < count($dataSet[$i]); $j++){
                if ($j == 0) {
                    printf("<th scope='row'><div class='row'>");
                    printf("<div class='col'><a href=\"%s?action=delete&id=%s\">D</a></div>",
                        $_SERVER['PHP_SELF'], $dataSet[$i][$j]);
                    printf("<div class='col'><a href=\"%s?action=edit&id=%s\">E</a></div>",
                        $_SERVER['PHP_SELF'], $dataSet[$i][$j]);
                    printf("</div></th>");
                    printf("<td>%s</td>", $dataSet[$i][$j]);
                } else {
                    printf("<td>%s</td>", $dataSet[$i][$j]);
                }
            }
        }





        ?>
        </tbody>


        <!--New added-->
    </table>
</div>
</body>
<footer class="footer mt-auto py-3 bg-dark centerd">
    <div class="container">
        <span class="text-muted"> &copy; $STUDENT$ 2024</span>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</html>
