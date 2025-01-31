<?php 

function genTable($arrayd, int $tableNum = 0)
{
    if($tableNum == 0)
    {
        echo "<table class=\"table table-dark table-striped table-hover\"<tr>";
    }
    else
    {
        echo "<table class=\"table table-bordered table-secondary table-striped\"><tr>";
    }
    echo "<thead><th>Parameter</th><th>Type</th><th>Value</th></tr></thead><tr>";
    $i = 1;
    foreach ($arrayd as $paramName=>$paramVal){
        echo "<tr><td>{$paramName}</td>";
        echo "<td>"; 
        echo gettype($paramVal); 
        echo "</td>";
        if(is_array($paramVal))
        {
            echo "<td>";
            genTable($paramVal, $i);
            $i++;
            echo "</td></tr>";
            continue;
        }
        echo "<td>{$paramVal}</td></tr>";
    }
    echo "</tr></table>";
}

?>

<!DOCTYPE html>
<html>
    <head>
            <title>Data</title>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    </head>
<header>
    
</header>
<body>
    <div class="container mt-3 container-fluid">
        <h2 class="text-center">Data Submitted</h2>
        <?php
            $arrayData = $_POST;
            genTable($arrayData);
        ?>
    </div>

</body>
</html>
