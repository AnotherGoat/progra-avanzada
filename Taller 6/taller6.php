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

// Aunque no parece obvio, el uso de paréntesis en el siguiente cálculo no altera el resultado
$maximo = intval($alto * $ancho / pow($diametro, 2) / 10 * $densidad / 100);
$sanos = $maximo - $contagiados;

echo "Ancho: ", $ancho, "<br>Alto: ", $alto, "<br>Diámetro: ", $diametro, "<br>Densidad: ", $densidad, "<br>Total: ", $maximo, "<br>Contagiados (inicio): ", $contagiados, "<br>Sanos (inicio): ", $sanos, "<br>";

$ciclos = 500;
echo "Ciclos: ", $ciclos, "<br>";

if ($sanos < 0) {
    echo "<script>\nalert('Simulación infactible para los parámetros seleccionados')\n</script>";
}

else {
    $amb = new Ambiente($ancho, $alto, $diametro / 2);
    // Ahora no indica el color, sino que indica si está sano (verde) o no (rojo)
    $amb->generaEntesAlAzar($sanos, true);
    $amb->generaEntesAlAzar($contagiados, false);

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
    }

    echo "<div id='resultado' style='visibility: hidden'>\n";
    if ($amb->getContagiados() == $maximo) {
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
            setTimeout(muestraSiguiente, 30);
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