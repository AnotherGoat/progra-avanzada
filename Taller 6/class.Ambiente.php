<?php
include_once("class.Ente.php");

class Ambiente {
    private $ancho;
    private $alto;
    private $entes;
    private $radio;

    // Contadores
    private $sanos;
    private $contagiados;
    private $inmunes;

    function __construct($ancho_x, $alto_y, $radio) {
        $this->ancho = $ancho_x;
        $this->alto = $alto_y;
        $this->radio = $radio;
        $this->entes = [];
        $this-> inmunes = 0;
    }

    function getContagiados() {
        return $this->contagiados;
    }

    function generaEnte($sano, $inmunidad) {
        $delx = rand(0, 10) - 5;
        $dely = rand(0, 10) - 5;
        $cel = new Ente(rand(0, $this->ancho), rand(0, $this->alto), $delx, $dely, $sano, $inmunidad);
        $cel->fijaRadio($this->radio);
        array_push($this->entes, $cel);
    }

    function generaEntesAlAzar($cantidad, $sano, $inmunidad) {
        if ($sano) {
            $this->sanos = $cantidad;
        } else {
            $this->contagiados = $cantidad;
        }

        for ($j = 0; $j < $cantidad; $j++) {
            $this->generaEnte($sano, $inmunidad);
        }
    }

    function vistaSVG($ciclo) {
        $ret = "Ciclo (actual): ".$ciclo."<br>";
        $ret .= "Sanos (actual): ".$this->sanos."<br>";
        $ret .= "Contagiados (actual): ".$this->contagiados."<br>";
        $ret .= "Inmunes (actual): ".$this->inmunes."<br>";
        $ret .= "<svg width='".$this->ancho."' height='".$this->alto."'>"."\n";
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
                $result = $ente->contagia($otro);

                // Ajusta los contadores
                if ($result) {
                    $this->sanos--;
                    $this->contagiados++;
                }
            }
        }

        // Empieza la inmunización después de hacer todos los movientos
        foreach($this->entes as $ente) {
            $result = $ente->inmunizar();

            if ($result) {
                $ente->fijaColor("purple");
                $ente->sanar();

                // Ajusta los contadores
                $this->contagiados--;
                $this->inmunes++;
                $this->sanos++;
            }
        }
    }
}
?>