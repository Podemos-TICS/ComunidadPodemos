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
	'advpoll:type:candidature' => ' Candidatura',
	'advpoll:closed' => '¿Votación cerrada? (nadie podrá votar hasta que se active)',
	'advpoll:audit' => '¿Realizar auditoría pública? (los votos serán publicados detalladamente)',
	'advpoll:type' => 'Tipo de votación',
	'advpoll:option:normal' => 'Normal: se vota una opción entre varias',
	'advpoll:option:condorcet' => 'Preferencial: se vota el orden de todas las opciones',
        'advpoll:option:candidature' => 'Candidatura: se vota un candidato entre varios',
	'advpoll:start_date' => 'La votación comienza el día ',
	'advpoll:end_date' => ' y termina el día ',
	'advpoll:help:date' => 'Dejar en blanco para controlar la votación de manera manual',
	'advpoll:access:ver' => '¿Quién puede ver los resultados de la votación?',
	'advpoll:access:vote' => '¿Quién puede votar?',
	'advpoll:view:time:from' => ' Periodo de votación empieza ',
	'advpoll:view:time:to' => ' termina ',
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
	'advpoll:vote_count' => 'Se han registrado %d votos.',
        'advpoll:postulate' => 'Postular para candidatura',
        'advpoll:depostulate' => 'Despostular',
        'advpoll:candidature:votation_begun' => 'Lo siento, la votación ya ha empezado',
        'advpoll:candidature:empty_fields' => 'Rellena los campos «sobre ti» y «descripción corta» y luego prueba a postular de nuevo.',
        'advpoll:candidature:success' => 'Ahora eres candidato para esta elección',
        'advpoll:candidature:depostulate:success' => 'Ya no eres candidato para esta elección',
        'advpoll:candidature:error' => 'Por alguna razón no se puede postular',

	'friendlytime:future:minutes' => "en %s minutos",
	'friendlytime:future:minutes:singular' => "en un minuto",
	'friendlytime:future:hours' => "en %s horas",
	'friendlytime:future:hours:singular' => "en una hora",
	'friendlytime:future:days' => "en %s días",
	'friendlytime:future:days:singular' => "mañana",
);

add_translation('es', $mapping);
