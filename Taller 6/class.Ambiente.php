<?php
include_once("class.Ente.php");

class Ambiente {
    private $ancho;
    private $alto;
    private $entes;
    private $radio;
    private $pref_sintomaticos; // Tasa de sintomáticos preferida
    private $mortalidad_natural;
    
    // Contadores
    private $sanos;
    private $contagiados;
    private $inmunes;
    private $sintomaticos;
    private $falleceran; // Entes marcados como muertos
    private $muertos;

    function __construct($ancho_x, $alto_y, $radio, $sintomaticos, $tasa_mortalidad) {
        $this->ancho = $ancho_x;
        $this->alto = $alto_y;
        $this->radio = $radio;
        $this->entes = [];
        $this->inmunes = 0;
        $this->sintomaticos = 0;
        $this->muertos = 0;
        $this->pref_sintomaticos = $sintomaticos;
        $this->mortalidad_natural = $tasa_mortalidad;
    }

    function getMuertos() {
        return $this->muertos;
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

    function estadisticas($ciclo) {
        $ret = "<h2>Estadísticas históricas</h2>";
        $ret .= "Ciclo: ".$ciclo."<br>";
        $ret .= "Sanos: ".$this->sanos."<br>";
        $ret .= "Contagiados: ".$this->contagiados."<br>";
        $ret .= "Inmunes: ".$this->inmunes."<br>";
        $ret .= "Sintomáticos: ".$this->sintomaticos."<br>";
        $ret .= "Tasa de sintomáticos: ".$this->tasaSintomaticos()."<br>";
        $ret .= "Vivos: ".$this->vivos()."<br>";
        $ret .= "Muertos: ".$this->muertos."<br>";
        $ret .= "Marcados para fallecer: ".$this->falleceran."<br>";
        $ret .= "Tasa de mortalidad: ".$this->tasaMortalidad()."<br>";
        return $ret;
    }

    function vistaSVG($ciclo) {
        $ret = $this->estadisticas($ciclo);
        $ret .= "<svg width='".$this->ancho."' height='".$this->alto."'>"."\n";
        foreach($this->entes as $ente) {
            $ret .= $ente->svg()."\n";
        }
        $ret .= "</svg>";
        return $ret;
    }

    function tasaSintomaticos() {
        return $this->sintomaticos / ($this->total());
    }

    function tasaMortalidad() {
        return $this->falleceran / ($this->total());
    }

    function total() {
        return $this->sanos + $this->contagiados + $this->inmunes + $this->muertos;
    }

    function vivos() {
        return $this->sanos + $this->contagiados + $this->inmunes - $this->muertos;
    }

    function mueve() {
        foreach($this->entes as $ente) {
            $ente->mueve(0, 0, $this->ancho, $this->alto);

            // Revisa todos los entes, para realizar contagios
            foreach ($this->entes as $otro) {
                $result = $ente->contagia($otro);

                // Si ocurrió un nuevo contagio
                if ($result) {
                    
                    // Revisa si el siguiente contagio debe ser sintomático o no
                    if ($this->tasaSintomaticos() < $this->pref_sintomaticos) {
                        $otro->hacerSintomatico();
                        $this->sintomaticos++;

                        // Revisa si el siguiente deberá morir o no y lo marca
                        if ($this->tasaMortalidad() < $this->mortalidad_natural) {
                            $otro->hacerMortal();
                            $this->falleceran++;
                        }
                    }

                    // Aumenta los contadores después del paso anterior, lo cual es importante
                    $this->sanos--;
                    $this->contagiados++;
                }
            }
        }
    }

    function inmunizar() {
        foreach ($this->entes as $ente) {
            $result = $ente->inmunizar();

            if ($result) {
                $ente->fijaColor("purple");
                $ente->sanar();

                // Ajusta los contadores
                $this->contagiados--;
                $this->inmunes++;

                // Esta vez se modificó el programa, no se cuenta a los inmunes como sanos también
            }
        }
    }

    function revisarMuertes() {
        foreach ($this->entes as $ente) {
            
            $resultado = $ente->revisarMuerte();

            if ($resultado) {
                // Elimina al elemento
                $indice = array_search($ente, $this->entes);
                array_splice($this->entes, $indice, 1);
                $this->contagiados--;
                $this->muertos++;
            }
        }
    }
}
?>