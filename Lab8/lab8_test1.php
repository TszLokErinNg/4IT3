<?php
define('FILENAME', 'lab8.txt');
$errorMessage="";
$errorClass="";
$data='';
$check='';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employeeName = trim($_POST["employeeName"]);
    if (empty($employeeName)) {
        $errorMessage = "ID not filled in. Nothing Recorded.";
        $errorClass = "alert-danger";
        $check = false;
    }
    else {
        $timeStamp = date("m/d/y h:i:s a");
        $errorMessage = "Form updated and logged at: ".$timeStamp;
        $errorClass = "alert-success";
        $Cookie_Name = "PROCTECH4IT3_400388316";
        $Cookie_Value = $_POST['employee_name'];
        setcookie($Cookie_Name, $Cookie_Value, time() + 120, "/");
        $check = true;
    }
}
function addRecord($filename) {
    $message = '';
    // Check if the file exists and is writable or if it does not exist, create it.
    if ((!is_file($filename) || is_writable($filename) && trim($_POST["employeeName"]) != '')) {
        // Open the file in append mode or create it if it does not exist
        $file = fopen($filename, 'a');
        // Write the current formatted date and time to the file
        fprintf($file, "%s_%s_%s_%s_%s_%s_%s\n",
            date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']),
            $_POST['s1'],$_POST['s2'],$_POST['s3'],$_POST['s4'],$_POST['s5'],$_POST['employeeName']);
        // Close the file
        $data = listRecords($filename);
        fclose($file);
        return [$message, $data];
    } else {
        return "Error: File is not writable.";
    }
}
function listRecords($filename) {
    // Check if the file exists and is readable
    if (is_file($filename) && is_readable($filename)) {
        // Open the file in read mode
        $file = fopen($filename, 'r');
        $list = '';
        if ($file) {
            while (($line = fgets($file)) !== false) {
                // process the line read.
                $list .= '<tr>';
                $array = explode("_", $line);
                foreach($array as $value) {
                    $list .= '<td>'.$value.'</td>';
                }
                $list .= "</tr>";
            }
            echo $list;
            fclose($file);
        } else {
            return "Error: File does not exist or is not readable.";

        }

        return $list;
    } else {
        return "Error: File does not exist or is not readable.";
    }
}
function resetRecords($filename) {
    // Check if the file exists
    if (is_file($filename)) {
        // Open the file in write mode, which will truncate the file to zero length
        $file = fopen($filename, 'w');
        fclose($file);
        return "Records cleared.";
    } else {
        return "Error: File does not exist.";
    }
}
if (isset($_GET['option']))
{
    $option = $_GET['option'];
    switch ($option) {
        case 'home':
            break;
        case 'clear':
            $message = resetRecords(FILENAME);
            break;
        case 'display':
            $data = listRecords(FILENAME);
            break;
        case 'on':
            $message = "Toggle all buttons ON.";
            $on = true;
            break;
        case 'off':
            $message = "Toggle all buttons OFF.";
            $off = true;
            break;
        case 'update':
            list($message,$data) = addRecord(FILENAME);
            break;
        default:
            $message = "No valid option selected.";
            break;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!--HTML BoilerPlate Content" -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Lab 8">
    <meta name="author" content="Calvin Wong">
    <meta keywords="Lab 8, PROCTECH 4IT3, SEP 6IT3, McMaster University, HTML, CSS, JavaScript">
    <meta name="robots" content="index, follow">

    <!--
    BoilerPlate items for Social Media Robots
    -->
    <meta property="og:title" content="Lab 8 - Calvin Wong"/>
    <meta property="og:type:article:author" content="Calvin Wong"/>
    <meta property="og:type:article:section" content="Lab 8"/>
    <meta property="og:url" content="https://webdev.sept.mcmaster.ca/400388316/"/>

    <link href="images/mcmaster.png" rel="icon" type="image/png">
    <title>Calvin Wong L01</title>

    <!--SA：I Calvin Wong, 400388316 certify that this material is my original work.
    No other person's work has been used without due acknowledgement.
    I have also not made my work available to anyone else.-->

    <!--
      BoilerPlate BOOTSTRAP!
   -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        h1,footer,th{
            text-align: center;
        }
        th{
            align-content: center;
        }
        #content{
            align-self: center;
            width: 65%;
            flex-grow: 1;
        }
        #container{
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        #switches{
            display: flex;
            flex-direction: row;
        }
        .switch{
            padding-right: 2%;
        }
        .message{
            padding-bottom: 1%;
            text-align: center;
        }
    </style>
</head>
<body>
<div id="container">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="">
                <img src="images/mcmaster.png" alt="" width="24" height="24" class="d-inline-block align-text-top">
                PROCTECH 4IT3
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?= $_SERVER['PHP_SELF'] ?>?option=clear">Clear Data File Content</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?= $_SERVER['PHP_SELF'] ?>?option=display">Display Data File Contents</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?= $_SERVER['PHP_SELF'] ?>?option=on">Toggle All Buttons On</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?= $_SERVER['PHP_SELF'] ?>?option=off">Toggle All Buttons Off</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div id="content">
        <form action="<?= $_SERVER['PHP_SELF'] ?>?option=update" method="post">
            <h1>Lab 8 - Switch Tracker</h1>
            <div class="message">
                <?php if (!empty($errorMessage)): ?>
                    <div class="<?= $errorClass ?>" role="alert"><?php echo $errorMessage; ?></div>
                <?php endif; ?>
            </div>
            <table class="table table-striped table-bordered table-hover">
                <thead class="table-dark">
                <tr>
                    <th rowspan="2">TimeStamp</th>
                    <th colspan="5">Switch ID</th>
                    <th rowspan="2">Notes</th>
                </tr>
                <tr>
                    <td>1</td>
                    <td>2</td>
                    <td>3</td>
                    <td>4</td>
                    <td>5</td>
                </tr>
                </thead>
                <?php echo $data ?>
            </table>
            <p>Current Switch State</p>
            <div class="input-group mb-3">
                <span class="input-group-text">ID</span>
                <input type="text" class="form-control" name="employeeName" placeholder="Employee Name" value="<?=$_COOKIE[$Cookie_Name]?>" aria-label="Employee Name">
                <button class="btn btn-primary" type="submit">Update</button>
            </div>
            <div id="switches">
                <div class="switch">
                    <p>Switch - 1</p>
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <label class="btn btn-success" for="radio1on">
                            <input class="form-check-input" type="radio" name="s1" id="radio1on" value="on" required <?= isset($on) && $on ? 'checked' : '' ?>>ON</label>
                        <label class="btn btn-secondary" for="radio1off">
                            <input class="form-check-input" type="radio" name="s1" id="radio1off" value="off" required <?= isset($off) && $off ? 'checked' : '' ?>>OFF</label>
                    </div>
                </div>
                <div class="switch">
                    <p>Switch - 2</p>
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <label class="btn btn-success" for="radio2on">
                            <input class="form-check-input" type="radio" name="s2" id="radio2on" value="on" required <?= isset($on) && $on ? 'checked' : '' ?>>ON</label>
                        <label class="btn btn-secondary" for="radio2off">
                            <input class="form-check-input" type="radio" name="s2" id="radio2off" value="off" required <?= isset($off) && $off ? 'checked' : '' ?>>OFF</label>
                    </div>
                </div>
                <div class="switch">
                    <p>Switch - 3</p>
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <label class="btn btn-success" for="radio3on">
                            <input class="form-check-input" type="radio" name="s3" id="radio3on" value="on" required <?= isset($on) && $on ? 'checked' : '' ?>>ON</label>
                        <label class="btn btn-secondary" for="radio3off">
                            <input class="form-check-input" type="radio" name="s3" id="radio3off" value="off" required <?= isset($off) && $off ? 'checked' : '' ?>>OFF</label>
                    </div>
                </div>
                <div class="switch">
                    <p>Switch - 4</p>
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <label class="btn btn-success" for="radio4on">
                            <input class="form-check-input" type="radio" name="s4" id="radio4on" value="on" required <?= isset($on) && $on ? 'checked' : '' ?>>ON</label>
                        <label class="btn btn-secondary" for="radio4off">
                            <input class="form-check-input" type="radio" name="s4" id="radio4off" value="off" required <?= isset($off) && $off ? 'checked' : '' ?>>OFF</label>
                    </div>
                </div>
                <div class="switch">
                    <p>Switch - 5</p>
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <label class="btn btn-success" for="radio5on">
                            <input class="form-check-input" type="radio" name="s5" id="radio5on" value="on" required <?= isset($on) && $on ? 'checked' : '' ?>>ON</label>
                        <label class="btn btn-secondary" for="radio5off">
                            <input class="form-check-input" type="radio" name="s5" id="radio5off" value="off" required <?= isset($off) && $off ? 'checked' : '' ?>>OFF</label>
                    </div>
                </div>
        </form>
    </div>
</div>
<div id="footer">
    <footer class="footer mt-auto py-3 bg-dark">
        <div class="container">
            <span class="text-muted">&copy; Calvin Wong 2025</span>
        </div>
    </footer>
</div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</html>