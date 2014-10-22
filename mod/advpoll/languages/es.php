<?php
/**
 * Polls plugin for elgg-1.8
 * Copyright 2012 Lorea, DRY Team
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301, USA.
 */
/**
 * The core language file is in /languages/en.php and each plugin has its
 * language files in a languages directory. To change a string, copy the
 * mapping into this file.
 *
 * For example, to change the blog Tools menu item
 * from "Blog" to "Rantings", copy this pair:
 * 			'blog' => "Blog",
 * into the $mapping array so that it looks like:
 * 			'blog' => "Rantings",
 *
 * Follow this pattern for any other string you want to change. Make sure this
 * plugin is lower in the plugin list than any plugin that it is modifying.
 *
 * If you want to add languages other than English, name the file according to
 * the language's ISO 639-1 code: http://en.wikipedia.org/wiki/List_of_ISO_639-1_codes
 */

$mapping = array(
	'advpoll:title' => 'Votaciones',
	'advpoll:menu' => 'Votaciones',
	'item:object:advpoll' => 'Votación',
	'advpoll:new' => 'Nueva Votación',
	'advpoll:none' => 'No hay ninguna votación',
	'advpoll:one_winner' => 'Hay un único ganador: ',
	'advpoll:many_winners' => 'Las siguientes opciones han empatado como ganadoras: ',
	'advpoll:editing' => 'Editor de votaciones',
	'advpoll:new:poll' => 'Votación creada satisfactoriamente',
	'advpoll:discusion:previa' => 'Dirección de enlace a la discusión previa a la votación',
	'advpoll:candidates' => 'Opciones de la votación: ',
	'advpoll:candidate:new' => '+',
	'advpoll:results' => 'Resultados de la votación',
	'advpoll:candidate:vote' => 'Elige la opción que prefieras',
	'advpoll:respuesta' => 'Opción',
	'advpoll:previous:discussion:link' => 'Enlace al debate previo',
	'advpoll:warning:edit' => 'Por motivos de seguridad no se pueden modificar las opciones de una votación una vez creada',
	'advpoll:pregunta' => 'Título de la pregunta',
	'advpoll:warning:edit:title' => 'Por motivos de seguridad no se puede modificar la pregunta de la votación una vez creada',
	'advpoll:warning:edit:audit' => 'Por motivos de privacidad no se puede modificar esta opción una vez creada la votación',
	'advpoll:filters:current' => 'En Curso',
	'advpoll:filters:ended' => 'Finalizadas',
	'advpoll:filters:all' => 'Todas',
	'advpoll:filters:friends' => 'De Amigos',
	'advpoll:filters:owner' => 'Mías',
	'advpoll:filters:not_initiated' => 'No Iniciadas',
	'advpoll:candidate:deleteme' => 'Bórrame',
	'advpoll:condorcet:legend:candidate' => 'Opción ',
	'advpoll:condorcet:leyenda' => 'Leyenda',
	'advpoll:condorcet:candidates:elegidas:usuario' => 'Estas son las opciones que eligió ',
	'advpoll:condorcet:results:final' => 'Resultados',
	'advpoll:condorcet:candidates:elegidas:papeleta' => 'Papeleta de voto en forma de matriz de ',
	'advpoll:condorcet:candidate:vote' => 'Ordena las opciones según tus preferencias y pulsa el botón "votar"',
	'advpoll:condorcet:audit:mostrar' => 'Mostrar auditoría',
	'advpoll:condorcet:pulsar:cambio' => 'Cambiar votación',
	'advpoll:anteriores:borradas:ok' => 'Se ha borrado tu elección anterior',
	'advpoll:pulsar:cambio' => 'Pulsa aquí para cambiar tu voto anterior',
	'advpoll:results:graphic:title' => 'Resultados de la votación',
	'advpoll:group' => 'Votaciones del grupo',	
	'advpoll:condorcet:info' => 'info',
	'advpoll:condorcet:help:title' => '¿Cómo funciona una votación preferencial?',
	'advpoll:condorcet:help:ballots:seguramente' => 'Seguramente te estarás preguntando qué significa una tabla como ésta:',
	'advpoll:condorcet:help:ballots:notemas' => 
		'No temas, es bastante sencillo, básicamente esta tabla representa una papeleta de voto preferencial. El método inicial 
		que utilizaremos para representar los votos	es conocido como el método de <a href="http://es.wikipedia.org/wiki/M%C3%A9todo_de_Condorcet"> condorcet</a>
		 y es el método que explicaremos aquí.<br>',
	'advpoll:condorcet:help:ballots:explicacion:title' => 'Cómo se crea una papeleta de condorcet',
		
	'advpoll:condorcet:help:ballots:supongamos' => 'Supongamos que tenemos una lista de 4 opciones: <br/> A, B, C y D <br/>
		De las cuales queremos sacar a votación para ver qué preferencias tiene una comunidad con respecto a ellas. <br/>
		En una votación preferencial lo que importa es el orden en que coloques las opciones, ya que no estás votando
		por una sóla, sino por una lista ordenada según tus preferencias. <br/>
		Supongamos que el habitante <em>Face-Lance</em> prefiere los candidatos anteriores en el siguiente orden: <br><br>
		1. B <br/>
		2. A <br/>
		3. C <br/>
		4. D <br><br>
		En este caso la manera de hallar la matriz o tabla que representa su papeleta puede realizarse del siguiente modo: <br><br>
		1. Hacemos una tabla colocando las opciones A, B, C, y D tanto en las filas como en las columnas en el mismo orden en ambas.<br/>
		Nos quedará algo como lo siguiente:',
	'advpoll:condorcet:help:ballots:paso2' => '2. El siguiente paso consiste en ir comparando la opción de la fila con la opción de la columna,
		escribiendo un 1 en el caso en el que la fila gane a la columna en la elección de <em>Face-Lance</em> y escribiendo un 0 en el caso contrario.<br>
		Por ejemplo, en la votación que hizo <em>Face-Lance</em> la opción B gana a la opción A, por lo que escribiremos un 1 en la casilla correspondiente,
		con lo que nos quedará algo así:',
	'advpoll:condorcet:help:ballots:paso3' => '3. Lo que nos queda ahora es ir rellenando todas las casillas con el método anterior,
		con una anotación más:<br> En las casillas donde se enfrentan opciones iguales siempre se escribe un 0, por lo que es una condición indispensable
		que la diagonal principal sea una diagonal compuesta de ceros.<br>
		Por ejemplo en la casilla de la fila A columna A tendremos que escribir un 0. <br>
		Completando poco a poco la tabla nos irá quedando lo siguiente: <br>',
	'advpoll:condorcet:help:ballots:candidatea' => ' La opción A pierde con B, y gana a C, y D. Su fila se completa así:',
	'advpoll:condorcet:help:ballots:candidateb' => ' La opción B gana a todas las demás. Su fila se completa así:',
	'advpoll:condorcet:help:ballots:candidatec' => ' La opción C pierde con A y con B, pero gana a D. Su fila se completará así:',
	'advpoll:condorcet:help:ballots:candidated' => ' La opción D pierde con todas las demás, por lo que su fila sólo contiene ceros:',
	'advpoll:condorcet:help:ballots:paso4' =>	'<br> 4. El siguiente paso es una cuestión de visibilización que nos servirá posteriormente para sacar conclusiones
		del método de condorcet. Consiste en colorear de verde aquellas casillas cuya puntuación sea mayor que la casilla simétrica con respecto a la diagonal.<br>
		<em>¿y eso qué significa?</em> En este paso inicial, simplemente significa que coloreemos de verde los 1 
		y de rojo los 0, salvo aquellos ceros que están en la diagonal. <br>
		Si nos fijamos, por ejemplo la casilla "Fila A, Columna B" tiene distinto color que la casilla simétrica "Fila B, Columna A".<br>
		Esto va a ser una regla de este tipo de tablas, y nos va a servir posteriormente para detectar si ha habido algún error en el proceso, pero
		también nos servirá para calcular el resultado final.',
	'advpoll:condorcet:help:suma:explicacion:title' => 'Cómo se suman los votos en una votación de condorcet',
	'advpoll:condorcet:help:suma:explicacion:maspapeletas' => 'Ahora que sabemos como se crean las papeletas, vamos a ver cómo operar con ellas,
		es decir, cómo podemos sumar los votos y sacar conclusiones. <br><br>
		Supongamos para ello que el héroe de nuestra fábula, encuentra un <em>bug</em> en el sistema que le permite crear tantas
		papeletas de votos como quisiera y que en lugar de reportar el error al lugar donde podrían solucionarlo, 
		su destino de héroe trágico se apodera de él y al igual que Aquiles despedazando troyanos, <em>Face-Lance</em>, rápido con el ratón,
		comienza a crear papeletas a diestro y siniestro.<br><br>
		Inicialmente crea sólo 4 papeletas distintas que se corresponden con las siguientes elecciones (se leen de izquierda a derecha):<br>
		A B C D <br>
		C D A B <br>
		C A B D <br>
		A B D C <br><br>
		Las tablas correspondientes a cada uno de estas elecciones serán las siguientes:',
	'advpoll:owner' => 'Votación creada por ',
	'advpoll:action:voto:ok' => 'Tu voto se ha guardado correctamente',
	'advpoll:friends' => 'Amigos',
	'advpoll:activas' => 'Activas',
	'polls' => 'Votaciones',
	
	'advpoll:view:cerrada' => 'Finalizada: ',
	'advpoll:view:audit' => ' Auditoría pública: ',
	'advpoll:view:type' => ' Tipo: ',
	'advpoll:type:normal' => ' Normal',
	'advpoll:type:condorcet' => ' Preferencial',
	'advpoll:closed' => '¿Votación cerrada? (nadie podrá votar hasta que se active)',
	'advpoll:audit' => '¿Realizar auditoría pública? (los votos serán publicados detalladamente)',
	'advpoll:type' => 'Tipo de votación',
	'advpoll:option:normal' => 'Normal: se vota una opción entre varias',
	'advpoll:option:condorcet' => 'Preferencial: se vota el orden de todas las opciones',
	'advpoll:start_date' => 'La votación comienza el día ',
	'advpoll:end_date' => ' y termina el día ',
	'advpoll:help:date' => 'Dejar en blanco para controlar la votación de manera manual',
	'advpoll:access:ver' => '¿Quién puede ver los resultados de la votación?',
	'advpoll:access:vote' => '¿Quién puede votar?',
	'advpoll:view:time:from' => ' Periodo de votación desde el ',
	'advpoll:view:time:to' => ' hasta el ',
	'advpoll:view:ended:si' => 'Finalizada',
	'advpoll:view:ended:no' => 'Activa',
	'advpoll:view:ended:lessthanend:lessthanstart' => 'No iniciada',
	'advpoll:view:ended:lessthanend:morethanstart' => 'Activa',
	'advpoll:view:ended:morethanend:lessthanstart' => 'Imposible',
	'advpoll:view:ended:morethanend:morethanstart' => 'Finalizada',
	'advpoll:groups:enablepolls' => 'Activar las votaciones de grupo',
	'advpoll:action:error:permisos' => 'Lo sentimos, no tienes permisos para votar',
	'advpoll:show:results:ongoing' => '¿Mostrar resultados durante la votación (y auditoría si está activada)?',
	'advpoll:can:change:vote' => '¿Se permite que los usuarios cambien su voto una vez emitido?',
	'advpoll:warning:edit:show:results' => 'Por cuestiones de privacidad no se permite modificar este parámetro una vez creada la votación',
	'advpoll:view:show:results' => ' Resultados antes de finalizar:',
	'advpoll:view:can:change:vote' => ' Cambiar voto:',
	'advpoll:show:yes' => ' Sí',
	'advpoll:show:no' => ' No',
	'advpoll:delete:success' => 'Votación borrada correctamente',
	'advpoll:candidate:delete:success' => 'Opción de la votación borrada correctamente',
	'advpoll:candidate:delete:fail' => 'No se ha podido eliminar la opción',
	'advpoll:normal:audit:nick' => 'Nick',
	'advpoll:normal:audit:name' => 'Nombre',
	'advpoll:normal:audit:date' => 'Fecha del voto',
	'advpoll:normal:audit:candidate' => 'Sentido del voto',
	'advpoll:normal:audit:user' => 'Habitante',
	'advpoll:action:error:cant_change_vote' => 'Esta votación no permite cambiar el voto',
	'advpoll:action:error:permisos' => 'No tienes permiso para votar',
	'advpoll:action:error:must_select_candidate' => 'Tienes que elegir una opción',
	'advpoll:error:number_of_candidates' => 'Tienen que haber al menos dos opciones posibles',
	'advpoll:error:duplicated_candidates' => 'No pueden haber opciones repetidas',
	'advpoll:error:wrong_dates' => 'La fecha de inicio es posterior a la fecha de finalización',
	'advpoll:quorum_count' => 'Han votado %d habitantes de un censo de %d, cosa
	que representa un quórum del %.1f%%.',
	'advpoll:vote_count' => 'Se han registrado %d votos.'

);

add_translation('es', $mapping);
