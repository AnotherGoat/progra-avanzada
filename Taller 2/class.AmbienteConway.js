let objActivoAmbienteConway;
class AmbienteConway {
    constructor(alto, ancho) {
        objActivoAmbienteConway=this;
        this.alto = alto;
        this.ancho = ancho;
        this.celula = [];
        this.creaCelulas();

        // Se mueve el <link> acá para eliminar el parpadeo
        document.getElementById("link").appendChild(this.generarLink());
    }

    creaCelulas() {
        let i, j;
        for (i = 0; i < this.alto; i++) {
            this.celula[i] = [];
            for (j = 0; j < this.ancho; j++) {
                this.celula[i][j] = false;
            }
        }
    }

    activa(i, j) {
        if (this.posicionOK(i, j)) {
            this.celula[i][j] = true;
        }
    }

    estaViva(i, j) {
        if (this.posicionOK(i, j))
            return this.celula[i][j];
        else
            return false;
    }

    posicionOK(i, j) {
        return (i >= 0 && i < this.alto && j >= 0 && j < this.ancho);
    }

    inyectaAmbiente(idDiv) {
        let tabla, fila, celd, i, j;
        tabla = document.createElement("TABLE");
        tabla.setAttribute("class", "ambiente");
        for (i = 0; i < this.alto; i++) {
            fila = document.createElement("TR");
            for (j = 0; j < this.ancho; j++) {
                celd = document.createElement("TD");

                // Almacena el ID de la celda nueva
                celd.setAttribute("id", "celda_" + i + "_" + j)
                
                if (this.estaViva(i, j)) {
                    celd.setAttribute("class", "celula viva");
                }
                else {
                    celd.setAttribute("class", "celula muerta");
                }
                objActivoAmbienteConway = this;
                let st = "objActivoAmbienteConway.cambiaEstado(" + i + "," + j + ")";
                celd.setAttribute("onclick", st);
                fila.appendChild(celd);
            }
            tabla.appendChild(fila);
        }
        document.getElementById(idDiv).appendChild(tabla);
    }

    generarLink() {
        let link = document.createElement("LINK");
        link.setAttribute("rel", "stylesheet");
        link.setAttribute("type", "text/css");
        link.setAttribute("href", "./conway.css")
        return link;
    }

    // i = fila, j = columna
    cambiaEstado(i, j) {
        // Obtiene la celda según el id que se le asignó en inyectaAmbiente()
        let celda = document.getElementById("celda_" + i + "_" + j);

        // Si la célula está marcada, la desmarca
        if (this.celula[i][j]) {
            this.celula[i][j] = false;
            // Cambia la clase para que se dibuje como célula muerta (gris)
            celda.setAttribute("class", "celula muerta");
        }
        // En caso contrario, la marca
        else {
            this.celula[i][j] = true;
            // Cambia la clase para que se dibuje como célula viva (verde)
            celda.setAttribute("class", "celula viva");
        }
    }

    proximoTurno() {
        let celu = [];
        for (let i = 0; i < this.alto; i++) {
            celu[i] = [];
            for (let j = 0; j < this.ancho; j++) {
                let v = this.vecinasVivas(i, j);
                if (this.estaMuerta(i, j) && v == 3)
                    celu[i][j] = true;
                else if (this.estaViva(i, j) && (v == 2 || v == 3))
                    celu[i][j] = true;
                else
                    celu[i][j]  = false;
            }
        }
        this.celula = celu;
    }

    estaMuerta(i, j) {
        return !this.estaViva(i, j);
    }

    vecinasVivas(i, j) {
        let total = 0;
        if (this.estaViva(i-1, j-1)) total ++;
        if (this.estaViva(i  , j-1)) total ++;
        if (this.estaViva(i+1, j-1)) total ++;
        if (this.estaViva(i-1, j  )) total ++;
        if (this.estaViva(i+1, j  )) total ++;
        if (this.estaViva(i-1, j+1)) total ++;
        if (this.estaViva(i  , j+1)) total ++;
        if (this.estaViva(i+1, j+1)) total ++;
        return total;
    }

    agregaPatron(fila, columna, nombrePatron) {
        let y = fila;
        let x = columna;

        if (nombrePatron == "pentaDecatlon") {
            console.log("llega");
            for (let i = x; i < (x+8); i++) {
                for (let j = y; j < (y+3); j++) {
                    console.log("activando " + i + " , " + j);
                    this.activa(i,j);
                }
            }
            this.celula[x+1][y+1] = false;
            this.celula[x+6][y+1] = false;
        }

        // https://www.conwaylife.com/wiki/Kok's_galaxy
        if (nombrePatron == "galaxiaDeKok") {
            for (let i = 0; i < galaxiaDeKok.length; i++) {
                for (j of galaxiaDeKok[i]) {
                    this.activa(x+i, y+j);
                }
            }
        }

        // https://www.conwaylife.com/wiki/Figure_eight
        if (nombrePatron == "figuraOcho") {
            for (let i = 0; i < figuraOcho.length; i++) {
                for (j of figuraOcho[i]) {
                    this.activa(x+i, y+j);
                }
            }
        }

        if (nombrePatron == "boom") {
            for (let i = 0; i < boom.length; i++) {
                for (j of boom[i]) {
                    this.activa(x+i, y+j);
                }
            }
        }
    }
}

// https://www.conwaylife.com/wiki/Kok's_galaxy
const galaxiaDeKok = [
    [2, 5, 7],
    [0, 1, 3, 5, 6, 7],
    [1, 8],
    [0, 1, 7],
    [],
    [1, 7, 8],
    [0, 7],
    [1, 2, 3, 5, 7, 8],
    [1, 3, 6]
]

// https://www.conwaylife.com/wiki/Figure_eight
const figuraOcho = [
    [0, 1],
    [0, 1, 3],
    [4],
    [1],
    [2, 4, 5],
    [4, 5]
]

const boom = [
    [0, 1, 2, 4, 5, 6],
    [0, 2, 4, 6],
    [0, 1, 2, 4, 5, 6]
]
