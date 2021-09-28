<?php
include_once("class.Ente.php");

class Ambiente {
    private $ancho;
    private $alto;
    private $entes;
    private $radio;

    function __construct($ancho_x, $alto_y) {
        $this->ancho = $ancho_x;
        $this->alto = $alto_y;
        $this->radio = 7;
        $this->entes = [];       
    }

    function generaEnte($sano) {
        $delx = rand(0, 10) - 5;
        $dely = rand(0, 10) - 5;
        $cel = new Ente(rand(0, $this->ancho), rand(0, $this->alto), $delx, $dely, $sano);
        array_push($this->entes, $cel);
    }

    function generaEntesAlAzar($cantidad, $sano) {
        for ($j = 0; $j < $cantidad; $j++) {
            $this->generaEnte($sano);
        }
    }

    function vistaSVG() {
        $ret = "<svg width='".$this->ancho."' height='".$this->alto."'>"."\n";
        foreach($this->entes as $ente) {
            $ret .= $ente->svg()."\n";
        }
        $ret .= "</svg>";
        return $ret;
    }

    function mueve() {
        foreach($this->entes as $ente) {
            $ente->mueve(0, 0, $this->ancho, $this->alto);

            // Revisa todos los entes, para realizar contagios
            foreach ($this->entes as $otro) {
                $ente->contagia($otro);
            }
        }
    }
}
?>