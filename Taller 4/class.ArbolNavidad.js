let activeObjectArbolNavidad;
let ns = "http://www.w3.org/2000/svg";

class ArbolNavidad {

    constructor() {
        activeObjectArbolNavidad = this;
        this.svg = document.createElementNS(ns, "svg");
        this.luzamarilla = [];

        // Grupos de luces
        this.grupos = [
            {ms: 400, luces: []},
            {ms: 600, luces: []},
            {ms: 1000, luces: []}
        ];

        // Indica si la animación está activa o no, inicia desactivado
        this.activo = false;
    }

    muestra(idDiv) {
        let div = document.getElementById(idDiv);
        this.svg.setAttribute("width", 500);
        this.svg.setAttribute("height", 650);

        // Árbol
        let arbol = document.createElementNS(ns, "polygon");
        let puntos = "250,60 100,400 120,400 80,500 100,500 60,600 440,600 400,500 420,500 380,400 400,400";
        arbol.setAttribute("points", puntos);
        arbol.setAttribute("fill", "#409040");
        arbol.setAttribute("onclick", "activeObjectArbolNavidad.clicEnArbol()")

        // Tronco del árbol
        let rect1 = this.crearCuadrado(200, 600, 50, "gray");
        rect1.setAttribute("id", "switch");
        rect1.setAttribute("onclick", "activeObjectArbolNavidad.clicEnSwitch('switch')");

        let rect2 = this.crearCuadrado(250, 600, 50, "brown");

        this.svg.appendChild(arbol);
        this.svg.appendChild(rect1);
        this.svg.appendChild(rect2);
        div.appendChild(this.svg);
    }

    crearCuadrado(x, y, lado, color) {
        let cuadrado = document.createElementNS(ns, "rect");
        cuadrado.setAttribute("x", x);
        cuadrado.setAttribute("y", y);
        cuadrado.setAttribute("width", lado);
        cuadrado.setAttribute("height", lado);
        cuadrado.setAttribute("fill", color);

        return cuadrado;
    }

    clicEnArbol() {
        this.ponerLuzAmarilla(event.clientX, event.clientY, this.calcularGrupo());
        this.luzamarilla.push({x:event.clientX,y:event.clientY});
        console.log(this.luzamarilla);
    }

    calcularGrupo() {
        // Usa el módulo para calcular el grupo al que pertenece esta luz
        // De este modo, la luz va alternando entre grupo 0, 1, 2, 0, 1, 2, etc...
        return this.luzamarilla.length % this.grupos.length;
    }

    ponerLuzAmarilla(x, y, grupo) {
        let luz = document.createElementNS(ns, "circle");
        luz.setAttribute("r", "5");
        luz.setAttribute("fill", "yellow");
        luz.setAttribute("cx", x);
        luz.setAttribute("cy", y);

        let id = "luz" + this.luzamarilla.length;
        luz.setAttribute("id", id);

        this.grupos[grupo].luces.push(id);

        // Si la animación está en ejecución, las luces agregadas vendrán con la animación
        if (this.activo) {
            let milisecs = this.grupos[grupo].ms;
            luz.appendChild(this.crearAnimacion(milisecs));
        }

        this.svg.appendChild(luz);
    }

    clicEnSwitch(id) {
        let cuadrado = document.getElementById(id);

        // Hacer clic en switch gris enciende el árbol
        if (cuadrado.getAttribute("fill") === "gray") {
            cuadrado.setAttribute("fill", "yellow");
            this.activo = true;
            this.iniciarParpadeo();
        }
        else {
            cuadrado.setAttribute("fill", "gray");
            this.activo = false;
            this.finalizarParpadeo();
        }
    }

    crearAnimacion(milisecs) {
        let animacion = document.createElementNS(ns, "animate");

        animacion.setAttribute("attributeType", "XML");
        animacion.setAttribute("attributeName", "visibility");
        animacion.setAttribute("values", "hidden;visible");
        animacion.setAttribute("dur", "" + milisecs + "ms")
        animacion.setAttribute("repeatCount", "indefinite");

        return animacion;
    }

    iniciarParpadeo() {
        // Inicia el parpadeo de todas las luces
        for (let i = 0; i < this.grupos.length; i++) {
            for (let idLuz of this.grupos[i].luces) {

                let luz = document.getElementById(idLuz);
                let milisecs = this.grupos[i].ms;

                luz.appendChild(this.crearAnimacion(milisecs));
            }
        }
    }

    finalizarParpadeo() {
        // Elimina las animaciones de todas las luces
        for (let i = 0; i < this.grupos.length; i++) {
            for (let idLuz of this.grupos[i].luces) {
                let luz = document.getElementById(idLuz);
                luz.innerHTML = "";
            }
        }
    }
}