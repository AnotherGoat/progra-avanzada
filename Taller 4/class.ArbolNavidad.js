let activeObjectArbolNavidad;
let ns = "http://www.w3.org/2000/svg";

class ArbolNavidad {
    constructor() {
        activeObjectArbolNavidad = this;
        this.svg = document.createElementNS(ns, "svg");
        this.luzamarilla = [];
    }

    muestra(idDiv) {
        let div = document.getElementById(idDiv);
        this.svg.setAttribute("width", 500);
        this.svg.setAttribute("height", 650);

        let arbol = document.createElementNS(ns, "polygon");
        let puntos = "250,60 100,400 120,400 80,500 100,500 60,600 440,600 400,500 420,500 380,400 400,400";
        arbol.setAttribute("points", puntos);
        arbol.setAttribute("fill", "#409040");
        arbol.setAttribute("onclick", "activeObjectArbolNavidad.clicEnArbol()")

        this.svg.appendChild(arbol);
        div.appendChild(this.svg);
    }

    clicEnArbol() {
        this.ponerLuzAmarilla(event.clientX, event.clientY);
        this.luzamarilla.push({x:event.clientX,y:event.clientY});
        console.log(this.luzamarilla);
    }

    ponerLuzAmarilla(x, y) {
        let luz = document.createElementNS(ns, "circle");
        luz.setAttribute("r", "5");
        luz.setAttribute("fill", "yellow");
        luz.setAttribute("cx", x);
        luz.setAttribute("cy", y);
        this.svg.appendChild(luz);
    }
}