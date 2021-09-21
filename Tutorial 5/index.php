<html>
<head>
    <title>Ejemplo prog. avanz. php 01</title>
</head>
<body>
<?php

$n = 20;
$m = 10;
$col = array("00", "35", "96", "B4", "CC", "F4", "A2", "12", "79", "D5", "E5", "AA", "5B", "7F", "5D", "9F", "88", "DE", "AB", "FF");
$col2 = array("0000", "3500", "9600", "9696", "96B4", "B4B4", "0096", "35F4", "1589", "AAFF");

echo "<table border='1'>";

for ($i = 0; $i < $n; $i++) {
    echo "\n<tr>";
    for ($j = 0; $j < $m; $j++) {
        $c = $col[$i].$col2[$j];
        echo "\n  <td bgcolor='$c'> ".$c." </td>";
    }
    echo "\n</tr>";
}
echo "</table>";
?>

</body>
</html>
