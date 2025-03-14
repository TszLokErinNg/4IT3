<!DOCTYPE html>
<html>
<head>
    <title>12 x 12 Times Table</title>
    <style>
        table {
            width: 50%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<table>
    <tr>
        <th></th>
        <?php for ($head = 1; $head <= 12; $head++): ?>
            <th></th>
        <?php endfor; ?>
    </tr>
    <?php for ($row = 1; $row <= 12; $row++): ?>
        <tr>
            <th></th>
            <?php for ($col = 1; $col <= 12; $col++): ?>
                <td></td>
            <?php endfor; ?>
        </tr>
    <?php endfor; ?>
</table>

</body>
</html>
