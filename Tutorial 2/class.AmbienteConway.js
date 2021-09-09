class AmbienteConway {
    constructor(alto, ancho) {
        this.alto = alto;
        this.ancho = ancho;
        this.celula = [];
        this.creaCelulas();
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
                if (this.estaViva(i, j)) {
                    celd.setAttribute("class", "celula viva");
                }
                else {
                    celd.setAttribute("class", "celula muerta");
                }
                fila.appendChild(celd);
            }
            tabla.appendChild(fila);
        }
        document.getElementById(idDiv).appendChild(this.generarLink());
        document.getElementById(idDiv).appendChild(tabla);
    }

    generarLink() {
        let link = document.createElement("LINK");
        link.setAttribute("rel", "stylesheet");
        link.setAttribute("type", "text/css");
        link.setAttribute("href", "./conway.css")
        return link;
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

    estaMuerta() {
        return !this.estaViva();
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
}