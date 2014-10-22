function grafo_condorcet (id, votaciones) {
    window.onload = function() {
        var stage = new Kinetic.Stage({
			container: "container",
			width: 578,
			height: 578
        });
		var layer = new Kinetic.Layer();  
		var messageLayer = new Kinetic.Layer();
    
	    // Código de referencia: http://webofilia.com/js/demo/RegularPolygon.js
		var ancho = stage.getWidth();
		var alto = stage.getHeight();
		var nodos = [];
		var radionodo = 20;
		
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
			
			var nodo = new Kinetic.Circle ({
				x: centro.x,
				y: centro.y,
				radius: radionodo,
				stroke: "grey",
				strokeWidth: 4,
				name: etiqueta,
			});
			
			var etiq = new Kinetic.Text({
				x: centro.x,
				y: centro.y,
				text: etiqueta,
				fontSize: parseInt(radio),
				fontFamily: "Arial",
				textFill: "grey",
				align: "center",
				verticalAlign: "middle",
				
			});
			
			
			
			nodo.on('mouseover', function(){
				var trazas = stage.get("." + etiqueta);
				var puntos = stage.get(".puntos" + etiqueta);

				for(var n = 0; n < trazas.length; n++) {
					var traza = trazas[n];
					traza.setStrokeWidth(6);
					traza.setStroke("#4690D6");
					traza.moveToTop();
					layer.draw();
				};
				
				for(var n = 0; n < puntos.length; n++) {
					var puntuacion = puntos[n];
					puntuacion.setTextFill("#4690D6");
					puntuacion.setStroke("#4690D6");
					puntuacion.setStrokeWidth(2);
					puntuacion.setFontSize(radionodo/2);
					puntuacion.moveToTop();
					layer.draw();
				};
				this.setStrokeWidth(6);
				this.setStroke("#4690D6");
				etiq.setTextFill("#4690D6");
				layer.draw();
			});
			
			nodo.on("mouseout", function(){
				var trazas = stage.get("." + etiqueta);
				var casillas = stage.get(".casilla" + etiqueta);
				var puntos = stage.get(".puntos" + etiqueta);

				for(var n = 0; n < trazas.length; n++) {
					var traza = trazas[n];
					traza.setStrokeWidth(2);
					traza.setStroke("grey");
					layer.draw();
				};
				
				for(var n = 0; n < puntos.length; n++) {
					var puntuacion = puntos[n];
					puntuacion.setTextFill("grey");
					puntuacion.setStroke("grey");
					puntuacion.setStrokeWidth(1);
					puntuacion.setFontSize(radionodo/3);
					layer.draw();
				};
				this.setStrokeWidth(4);
				nodo.setStroke("grey");
				etiq.setTextFill("grey");
				layer.draw();
			});
			
			layer.add(etiq);
			layer.add(nodo);
			stage.add(layer);
						
		}
	
	
		var dibuja_flecha = function (origen, destino, etiqueta, nodo) {
	
			var angulo = Math.atan2(destino.y-origen.y,destino.x-origen.x),
			tam_cabeza = 15,
			origen_x = origen.x + radionodo*Math.cos(angulo),
			origen_y = origen.y + radionodo*Math.sin(angulo),
			destino_x = destino.x - radionodo*Math.cos(angulo),
			destino_y = destino.y - radionodo*Math.sin(angulo);
			
			var flecha = new Kinetic.Line({
				points: [{
					x: origen_x,
					y: origen_y,
				}, {
					x: destino_x,
					y: destino_y,
				}],
				
				stroke: "grey",
				strokeWidth: 2,
				lineCap: 'round',
				lineJoin: 'round',
				name: nodo
			});
			
			var cabeza = new Kinetic.Polygon({
				points: [{
					x: destino_x-tam_cabeza*Math.cos(angulo-Math.PI/6),
					y: destino_y-tam_cabeza*Math.sin(angulo-Math.PI/6),
				}, {
					x: destino_x,
					y: destino_y,
				}, {
					x: destino_x-tam_cabeza*Math.cos(angulo+Math.PI/6),
					y: destino_y-tam_cabeza*Math.sin(angulo+Math.PI/6),
				}, {
					x: destino_x-tam_cabeza*Math.cos(angulo-Math.PI/6),
					y: destino_y-tam_cabeza*Math.sin(angulo-Math.PI/6),
				}],
				stroke: "grey",
				fill: "grey",
				strokeWidth: 2,
				lineCap: 'round',
				lineJoin: 'round',
				name: nodo,
			});
			
				
			var texto = new Kinetic.Text({
				x: (destino_x+origen_x)/2, 
				y: (destino_y+origen_y)/2,
				text: etiqueta,
				fontSize: radionodo/3,
				fontFamily: "Arial",
				fill: "white",
				strokeWidth: 1,
				stroke: "grey",
				padding: 4,
				textFill: "grey",
				align: "center",
				verticalAlign: "middle",
				name: "puntos" + nodo,
				
			});
			
			layer.add(flecha);
			layer.add(cabeza);
			layer.add(texto);
			stage.add(layer);
		}
		

		var num_nodos = votaciones.length;
		var vertices = dame_posicion_nodos (num_nodos);
		
		for (var i=0; i<num_nodos; i++) {
			dibuja_nodo (vertices[i], votaciones[i][0]);
			for (var j=1; j<=num_nodos; j++) {
				var valor = votaciones[i][j];
				if ((valor != 0) && (valor > votaciones[j-1][i+1])) {
					dibuja_flecha(vertices[i], vertices[j-1], valor, votaciones[i][0] );
				}
			}
		}
	}
}

