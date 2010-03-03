function ffxi_update_genders(races, genders)
{
    if(races.value == "Mithra" || races.value == "Galka") {
		genders.disabled = true;
		if(races.value == "Mithra") {
			genders.selectedIndex = 1;
		} else {
			genders.selectedIndex = 0;
		}
	} else {
		genders.disabled = false;
	}
	ffxi_update_faces(races.value, genders.value);
}

function ffxi_update_faces(race, gender)
{
	var faces_tab = document.getElementById("ffxifacestable");
	var prefix = race.substring(0, 1);
	if(race != "Mithra" && race != "Galka") {
		prefix += gender.substring(0, 1).toLowerCase();
	}
	for (var row = 0; row < faces_tab.rows.length; row++ ) {
		for(var face_cell = 0; face_cell < faces_tab.rows[row].cells.length; face_cell++) {
			var image = faces_tab.rows[row].cells[face_cell].getElementsByTagName("img")[0];
			var lastslash = image.src.lastIndexOf("/");
			var lastdot = image.src.lastIndexOf(".");
			image.src = image.src.substring(0, lastslash + 1) + prefix + image.src.substring(lastdot - 2);
		}
	} 
}

function ffxi_update_subjob(subjobdd, subjobtb) {
	if(subjobdd.value == "<None>") {
		subjobtb.value = 0;
		subjobtb.disabled = true;
	} else if(subjobtb.disabled) {
		subjobtb.value = 1;
		subjobtb.disabled = false;
	}
}

function ffxi_job_level_validate(job_textbox) {
	var pint = parseInt(job_textbox.value);
	if(!isNaN(pint)) {
		if(pint < 1) {
			job_textbox.value = 1;
		} else if(pint > 75) {
			job_textbox.value = 75;
		} else {
			job_textbox.value = pint;
		}
	} else {
		job_textbox.value = 1;
	}
}