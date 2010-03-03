<?php
/*
These are the various functions that are used by the profile editors.
*/

function build_dropdown($name, $options, $default = "", $selectproperties = "") {
	$menu = "<select name=\"" . $name . "\"";
	if($selectproperties != "") {
		$menu .= " " . $selectproperties;
	}
	$menu .= ">\n";
	foreach($options as $option) {
		$menu .= "<option";
		if($default == $option) {
			$menu .= " selected=\"selected\"";
		}
		$menu .= ">" . $option . "</option>\n";
	}
	$menu .= "</select>";
	return $menu;
}

function build_face_table($sel_race, $sel_gender, $sel_face, $sel_hair) {
	$faces = get_faces();
	$hairs = get_facetypes();
	$prefix = get_face_prefix($sel_race, $sel_gender);	
	$output = "<table id=\"ffxifacestable\">\n";
	foreach($hairs as $hair) {
		$output .= "<tr>\n";
		foreach($faces as $face) {
			$output .= "<td style=\"text-align: center;\" name=\"" . $face . $hair . "\"><input type=\"radio\" name=\"face\" value=\"" . $face . $hair . "\"";
			if($face == $sel_face && $hair == $sel_hair) $output .= " checked";
			$output .= "/><br /><img src=\"" . get_bloginfo(wpurl) . "/wp-content/plugins/ffxi-char-profile/img/" . $prefix . $face . $hair . ".jpg\" width=\"70\" height=\"65\" style=\"border: 1px solid #000000;\"></td>\n";
		}
		$output .= "</tr>\n";
	}
	$output .= "</table>";
	return $output;
}

function get_genders() {
	return array("Male", "Female");
}

function get_races() {
	return array("Elvaan", "Galka", "Hume", "Mithra", "Tarutaru");
}

function get_faces() {
	return array(1, 2, 3, 4, 5, 6, 7, 8);
}

function get_facetypes() {
	return array(a, b);
}

function get_nations() {
	return array("Bastok", "San d'Oria", "Windurst");
}

function get_worlds() {
	return array("Alexander", "Asura", "Bahamut", "Bismarck", "Caitsith", "Carbuncle", "Cerberus", "Diabolos", "Fairy", "Fenrir", "Garuda", "Gilgamesh", "Hades", "Ifrit", "Kujata", "Lakshmi", "Leviathan", "Midgardsormr", "Odin", "Pandemonium", "Phoenix", "Quetzalcoatl", "Ragnarok", "Ramuh", "Remora", "Seraph", "Shiva", "Siren", "Sylph", "Titan", "Unicorn", "Valefor");
}

function get_jobs() {
	return array(
	"WAR" => "Warrior",
	"MNK" => "Monk",
	"THF" => "Thief",
	"WHM" => "White Mage",
	"BLM" => "Black Mage",
	"RDM" => "Red Mage",
	"PLD" => "Paladin",
	"BST" => "Beast Master",
	"RNG" => "Ranger",
	"BRD" => "Bard",
	"DRK" => "Dark Knight",
	"NIN" => "Ninja",
	"SAM" => "Samurai",
	"DRG" => "Dragoon",
	"SMN" => "Summoner",
	"BLU" => "Blue Mage",
	"PUP" => "Puppetmaster",
	"COR" => "Corsair",
	"DNC" => "Dancer",
	"SCH" => "Scholar"
	);
}

function get_face_prefix($race, $gender) {
	if($race != "Galka" && $race != "Mithra") {
	  $prefix = substr($race, 0, 1) . strtolower(substr($gender, 0, 1));
	} else {
	  $prefix = substr($race, 0, 1);
	}
	return $prefix;
}

function calcSub($mainlevel, $sublevel) {
	$max = floor($mainlevel/2);
	if($sublevel < $max) {
		return $sublevel;
	} else {
		return $max;
	}
}

function strip_all_slashes($arr) {
	foreach($arr as $id => $value) {
		$newarr[$id] = stripslashes($value);
	}
	return $newarr;
}
?>