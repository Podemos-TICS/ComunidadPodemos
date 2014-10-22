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
 ?>
.choices_ul {
	list-style-position: inside;
    list-style-type: disc;
}

.elgg-subtext {
    color: #666666;
    font-size: 90%;
    font-style: normal;
    line-height: 1.5em;
}

.eliminarcontomate {
	color: red;
	cursor: pointer;
}


.candidates-condorcet {
	border-style: solid;
	border-width: 2px;
	border-color: #4D4D4D;
	border-radius: 5px;
	background: #EEEEEE;
	display: table;
	min-width: 30%;
	
}

#ordenable {
	font-weight: bold;
	list-style-image: none;
    list-style-position: outside;
    list-style-type: decimal;
    padding-left: 20px;
    
   
}
.ui-sortable {
}
.ui-objeto-ordenable {
	background: white;
	background-image: url(<?php echo elgg_get_site_url() . "mod/advpoll/_graphics/mover.png" ; ?>);
	background-position: 10px;
	background-repeat: no-repeat;
	margin: 10px;
	border-style: solid;
	border-width: 1px;
	padding: 5px;
	border-radius: 5px;
	border-color: #4D4D4D;
	cursor: move;
		
}

.ui-objeto-ordenable:hover {
	background-image: url(<?php echo elgg_get_site_url() . "mod/advpoll/_graphics/mover2.png" ; ?>);
	color: #4690D6;	
}

.parrafo-candidates {
	font-weight: normal;
	margin-left: 30px;
	margin-bottom: 0;
    margin-left: 30px;
    margin-top: 0;
    
    
}

.condorcet-papeleta-table {
    border-color: #CCCCCC;
    border-style: solid;
    border-width: 1px;
    
}

.condorcet-tr {
}

.condorcet-td {
	padding-bottom: 5px;
    padding-left: 5px;
    padding-right: 5px;
    padding-top: 5px;
    text-align: center;
    border-color: #4D4D4D;
    border-style: solid;
    border-width: 1px;
}

.rojo {
	background-color: LightPink;
}
.verde {
	background-color: PaleGreen;
}
.condorcet-thead {
}
.condorcet-th {
	padding-bottom: 5px;
    padding-left: 5px;
    padding-right: 5px;
    padding-top: 5px;
    text-align: center;
    border-color: #4D4D4D;
    border-style: solid;
    border-width: 1px;
}

.papeleta-ol {
	list-style-image: none;
    list-style-position: inside;
    list-style-type: decimal;
    margin-bottom: 20px;
    margin-right: 20px;
    padding-bottom: 10px;
}

.audit-extendible {
	display: none;
	background-color: Ivory;
	padding: 10px;
	border-style: solid;
	border-width: 1px;
	border-color: gray;
	border-radius: 10px
}

.parrafo-extendible {
	display: none;
}

.expandable-results {
	cursor: pointer;
}

.expandable-results:hover {
	color: #4690D6;
}

.pulsa-que-se-expande {
	cursor: pointer;
}
.pulsa-que-se-expande:hover {
	color: #4690D6;
}
#results-sectors {
	
}
.help-four-cols {
	padding: 10px;
}

.separador-punteado {
	border-top-color: gray;
    border-top-style: dotted;
    border-top-width: 1px;
    margin-top: 20px;
    padding-top: 10px;
}
.continuos-date {
	width: 200px;
}
.audit-normal-th {
	text-align: center;
	padding: 5px;
	background-color: white;
    border-bottom-style: solid;
    border-bottom-width: 2px;
    vertical-align: middle;
}
.audit-normal-tr {
	background-color: white;
}

.audit-normal-tr:hover {
	background-color: #8CBAE5;
}

.audit-normal-thead {
}

.audit-normal-table {
	 width: 100%;
	 border-style: solid;
	 border-width: 1px;
}

.audit-normal-td {
	text-align: center;
	padding: 5px;
	vertical-align: middle;
}


	
	





	
