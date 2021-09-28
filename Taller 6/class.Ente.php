<?php
class Ente {
    private $x;
    private $y;
    private $deltax;
    private $deltay;
    private $color;
    private $radio;
    private $sano; // Indica si está sano o contagiado
    private $inmunidad; // Ciclos para llegar a inmunidad

    function __construct($pos_x, $pos_y, $velocidad_x, $velocidad_y, $sano, $inmunidad) {
        $this->x = $pos_x;
        $this->y = $pos_y;
        $this->deltax = $velocidad_x;
        $this->deltay = $velocidad_y;
        $this->radio = 10;
        $this->sano = $sano;
        $this->inmunidad = $inmunidad;

        if ($this->sano) {
            $this->color = "#33AA44"; // verde
        } else {
            $this->color = "#AA3344"; // rojo
        }
    }

    function fijaColor($nuevoColor) {
        $this->color = $nuevoColor;
    }

    function fijaRadio($nuevoRadio) {
        $this->radio = $nuevoRadio;
    }

    function inmunizar() {
        if (!$this->sano && $this->inmunidad > 0) {
            $this->inmunidad--;
        }

        return $this->inmunidad == 0 && $this->color != "purple";
    }

    function sanar() {
        $this->sano = true;
    }

    function svg() {
        $ret = '<circle cx="&1" cy="&2" r="&3" stroke-width="0" fill="&4" />';
        $ret = str_replace("&1", $this->x, $ret);
        $ret = str_replace("&2", $this->y, $ret);
        $ret = str_replace("&3", $this->radio, $ret);
        $ret = str_replace("&4", $this->color, $ret);
        return $ret;
    }

    function mueve($minx, $miny, $maxx, $maxy) {
        $nuevo_x = $this->x + $this->deltax;
        $nuevo_y = $this->y + $this->deltay;
        if ($nuevo_x > $minx && $nuevo_x < $maxx) {
            $this->x = $nuevo_x;
        }
        else {
            $this->deltax *= -1;
            $this->x += $this->deltax;
        }

        if ($nuevo_y > $miny && $nuevo_y < $maxy) {
            $this->y = $nuevo_y;
        }
        else {
            $this->deltay *= -1;
            $this->y += $this->deltay;
        }
    }

    function calcularDistancia($otro) {
        $dist_x = $this->x - $otro->x;
        $dist_y = $this->y - $otro->y;

        // Pitágoras
        return sqrt(pow($dist_x, 2) + pow($dist_y, 2));
    }

    function chocaCon($otro) {
        return $this->calcularDistancia($otro) < $this->radio * 2; // diámetro
    }

    function contagia($otro) {
        if ($this->chocaCon($otro) && !$this->sano && $otro->sano && $otro->inmunidad != 0) {
            $otro->sano = false;
            $otro->color = "#AA3344";
            return true; // Hubo un nuevo contagio
        }

        return false;
    }
}
?>