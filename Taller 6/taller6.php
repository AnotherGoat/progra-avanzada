<!DOCTYPE html>
<html>
<head>
</head>
<body>
<?php
include_once "class.Ambiente.php";

$ancho = $_GET["ancho"];
$alto = $_GET["alto"];
$diametro = $_GET["diametro"];
$contagiados = $_GET["contagiados"];
$densidad = $_GET["densidad"];
$ciclos = $_GET["ciclos"];
$inmunidad = $_GET["inmunidad"];
$sintomaticos = $_GET["sintomaticos"];
$mortalidad = $_GET["mortalidad"];

// Aunque no parece obvio, el uso de paréntesis en el siguiente cálculo no altera el resultado
$maximo = intval($alto * $ancho / pow($diametro, 2) / 10 * $densidad / 100);
$sanos = $maximo - $contagiados;

echo "<h2>Configuración inicial</h2>";
echo "Ancho: ", $ancho, "<br>";
echo "Alto: ", $alto, "<br>";
echo "Diámetro: ", $diametro, "<br>";
echo "Radio: ", $diametro / 2, "<br>";
echo "Densidad: ", $densidad, "<br>";
echo "Total: ", $maximo, "<br>";
echo "Contagiados: ", $contagiados, "<br>";
echo "Sanos: ", $sanos, "<br>";
echo "Ciclos: ", $ciclos, "<br>";
echo "Ciclos para llegar a inmunidad: ", $inmunidad, "<br>";
echo "Tasa de sintomáticos preferida: ", $sintomaticos / 100, "<br>";
echo "Tasa de mortalidad natural: ", $mortalidad / 100, "<br>";

if ($sanos < 0) {
    echo "<script>\nalert('Simulación infactible para los parámetros seleccionados')\n</script>";
}

else {
    $amb = new Ambiente($ancho, $alto, $diametro / 2, $sintomaticos / 100, $mortalidad / 100);
    // Ahora no indica el color, sino que indica si está sano (verde) o no (rojo)
    $amb->generaEntesAlAzar($sanos, true, $inmunidad);
    $amb->generaEntesAlAzar($contagiados, false, $inmunidad);

    $fin = 0;

    for ($k = 0; $k < $ciclos; $k++) {
        echo "\n";
        echo '<div id="amb_'.$k.'" style="display:none">';
        echo $amb->vistaSVG($k);
        echo "\n</div>'";

        // Se detiene cuando todos se contagiaron
        if ($amb->getContagiados() == $maximo) {
            $fin = $k;
            break;
        }

        $amb->mueve();
        $amb->inmunizar();
        $amb->revisarMuertes();
    }

    echo "<div id='resultado' style='visibility: hidden'>\n";
    echo str_replace("históricas", "finales", $amb->estadisticas($fin));

    if ($amb->getContagiados() + $amb->getMuertos() == $maximo) {
        echo "<br>Finalizado: ", $fin;
    } else {
        echo "<br>Se llegó al máximo de ciclos (", $ciclos, ") sin contagiar a todos";
    }
    echo "\n</div>";
}
?>
<script>    
    var actual = 0;

    function muestraSiguiente() {
        // Se quita el operador ternario para que no se repita
        var nuevo = actual + 1;

        console.log(nuevo);
        try {
            document.getElementById("amb_" + actual).style.display = "none";
            document.getElementById("amb_" + nuevo).style.display = "";

            actual = nuevo;
            setTimeout(muestraSiguiente, 100);
        } catch(e) {
            if (e instanceof TypeError) {
                console.log("FIN");
            } else {
                console.log("Error desconocido");
            }

            // Revela el resultado cuando termina
            document.getElementById("resultado").style.visibility = "visible";
        }
    }

    muestraSiguiente();
</script>
</body>
</html>