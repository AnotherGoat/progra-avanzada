class AmbienteConway {
    constructor(alto, ancho) {
        this.alto = alto;
        this.ancho = ancho;
        this.celula = [];
        this.creaCelulas();
    }

    creaCelulas() {
        var i, j;
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
        var tabla, fila, celd, i, j;
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
        document.getElementById(idDiv).appendChild(tabla);
    }
}