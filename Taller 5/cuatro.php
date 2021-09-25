<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Tercer Formulario</title>
</head>
<body>
<?php
$color = $_GET["color"];
$m = $_GET["columnas"];
$n = $_GET["filas"];

$col1 = array("8F", "97", "9F", "A7", "AF", "BZ", "BF", "C7", "CF", "D7", "DF", "E7", "EF", "F7", "FF");
$col2 = array("0000", "0808", "1010", "1818", "2020", "2828", "3030", "3838", "4040", "4848", "5050", "5858", "6060", "6868", "7070");

echo "<table>";
for ($i = 0; $i < $n; $i++) {
    echo "\n<tr>";

    for ($j = 0; $j < $m; $j++) {
        
        if ($color == "rojo") {
            $c = $col1[$i].$col2[$j];
        }
        else if ($color == "azul") {
            $c = $col2[$i].$col1[$j];
        }
        else {
            $parte1 = substr($col2[$j], 2);
            $parte2 = substr($col2[$j], -2);
            $c = $parte1.$col1[$i].$parte2;  
        }

        echo "\n<td bgcolor='".$c."' width='30' height='30' onclick=\"mostrarColor('$c')\"></td>";
    }
    echo "\n</tr>";
}
echo "</table>";

echo "<script>\n",
     "function mostrarColor(color) {\n",
        "alert('El color de la celda es ' + color)\n",
     "}\n",
     "</script>";
?>
</body>
</html>
