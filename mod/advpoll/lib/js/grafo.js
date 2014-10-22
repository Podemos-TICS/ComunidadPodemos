// Código de referencia: http://webofilia.com/js/demo/RegularPolygon.js
function grafo_condorcet (id, votaciones) {
//function grafo_condorcet (id) {
	var canvas = document.getElementById(id),
	ancho = canvas.width,
	alto = canvas.height,
	nodos = [],
	radionodo = 20;
	
	canvas = canvas.getContext("2d");

	var dame_vertices_poligono = function (inicial_x, inicial_y, num_vertices, longitud_arista) {
		var punto = {x: inicial_x, y: inicial_y},
		poligono = [],
		w = 2 * Math.PI / num_vertices;
		
		poligono.push(punto);
	
		for (var i=1; i < num_vertices; i++){
			var x = parseInt(Math.cos(w * (i-1)) * longitud_arista + poligono[i-1].x);
			var y = parseInt(Math.sin(w * (i-1)) * longitud_arista + poligono[i-1].y);
			punto = {x: x, y: y};
			poligono.push(punto);
		}
		
		return poligono;
	}
	
	var dame_posicion_nodos = function (num_nodos) {
		var resultados = dame_vertices_poligono (0, 0, num_nodos, ancho/(num_nodos/2)),
		menor_x = 0,
		mayor_x = 0,
		menor_y = 0,
		mayor_y = 0,
		inicial_x = 0,
		inicial_y = 0;
		
		radionodo = ancho/(num_nodos*2.5);
		
		//Escogemos el menor
		for (var i=1; i < num_nodos; i++){
			if (resultados[i].x < menor_x) menor_x = -resultados[i].x;
			if (resultados[i].x > mayor_x) mayor_x = resultados[i].x;
			if (resultados[i].y < menor_y) menor_y = -resultados[i].y;
			if (resultados[i].y > mayor_y) mayor_y = resultados[i].y;
		}
		
		inicial_x = (menor_x+ancho-mayor_x)/2;
		inicial_y = (menor_y+ancho-mayor_y)/2;

		resultados = dame_vertices_poligono (inicial_x, inicial_y, num_nodos, ancho/(num_nodos/2));
		
		nodos = resultados;
		return resultados;
	}

	var dibuja_nodo = function (centro, etiqueta) {
		var radio = radionodo;
		canvas.beginPath();
		canvas.arc(centro.x, centro.y, radio, 0 , 2 * Math.PI, false);
		canvas.lineWidth = 2;
		canvas.strokeStyle = "#f00";
		canvas.stroke();
		canvas.font = parseInt(radio)+'px Arial';
		canvas.fillText(etiqueta, centro.x-(radio/3), centro.y+(radio/3));
	}

	var dibuja_flecha = function (origen, destino, etiqueta) {

		var angulo = Math.atan2(destino.y-origen.y,destino.x-origen.x),
		tam_cabeza = 15,
		origen_x = origen.x + radionodo*Math.cos(angulo),
		origen_y = origen.y + radionodo*Math.sin(angulo),
		destino_x = destino.x - radionodo*Math.cos(angulo),
		destino_y = destino.y - radionodo*Math.sin(angulo);
		
		canvas.beginPath();		
		canvas.moveTo(origen_x, origen_y);
		canvas.lineTo(destino_x, destino_y);
		canvas.lineTo(destino_x-tam_cabeza*Math.cos(angulo-Math.PI/6), destino_y-tam_cabeza*Math.sin(angulo-Math.PI/6));
		canvas.moveTo(destino_x, destino_y);
		canvas.lineTo(destino_x-tam_cabeza*Math.cos(angulo+Math.PI/6), destino_y-tam_cabeza*Math.sin(angulo+Math.PI/6));
		canvas.lineWidth = 2;
		canvas.strokeStyle = "#f00";
		canvas.stroke();
		canvas.font = parseInt(radionodo/1.5)+'px Arial';
		canvas.fillText(etiqueta, (destino_x+origen_x)/2, (destino_y+origen_y)/2);
	}
/*
	//Probando dame_vertices_poligono
	var vertices = dame_posicion_nodos (7);
	var texto_array = function (vertices) {
		var texto = "\n";
		for(var i=0;i<vertices.length;i++){
			texto += '('+parseInt(vertices[i].x)+' , '+parseInt(vertices[i].y)+")\n";
			dibuja_nodo (vertices[i], i+1);
		}
		return texto;
	}
	dibuja_flecha(vertices[0],vertices[1],"44");
	dibuja_flecha(vertices[0],vertices[4],"33");
	alert ("ancho: "+ancho+" alto: "+alto+texto_array(vertices));
*/

	var num_nodos = votaciones.length;
	var vertices = dame_posicion_nodos (num_nodos);
	
	for (var i=0; i<num_nodos; i++) {
		dibuja_nodo (vertices[i], votaciones[i][0]);
		for (var j=1; j<=num_nodos; j++) {
			var valor = votaciones[i][j];
			if ((valor != 0) && (valor > votaciones[j-1][i+1])) {
				dibuja_flecha(vertices[i], vertices[j-1], valor);
			}
		}
	}
	//Devolvemos la referencia al lienzo para permitir dibujar desde fuera
	return canvas;

}

