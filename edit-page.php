<?php
/*
This is where the main profile editor is defined. The profile editor can be found under the 'Appearance' tab
in WordPress administration.
*/

function ffxi_char_profile_edit_page() {
	if( $_POST["ffxi_char_profile_submitted"] == 'Y' ) {
			$charinfo["name"] = $_POST["character_name"];
			$charinfo["race"] = $_POST["race"];
			if($_POST["race"] == "Mithra") {
				$charinfo["gender"] = "Female";
			} else if($_POST["race"] == "Galka") {
				$charinfo["gender"] = "Male";
			} else {
				$charinfo["gender"] = $_POST["gender"];
			}
			$charinfo["face"] = substr($_POST["face"], 0, 1);
			$charinfo["faceversion"] = substr($_POST["face"], 1, 1);
			$charinfo["allegiance"] = $_POST["allegiance"];
			$charinfo["world"] = $_POST["world"];
			$charinfo["mainjob"] = $_POST["mainjob"];
			$charinfo["subjob"] = $_POST["subjob"];
			$charinfo["mainlevel"] = $_POST["mainlevel"];
			if($_POST["sublevel"] == "") {
				$charinfo["sublevel"] = 0;
			} else {
				$charinfo["sublevel"] = $_POST["sublevel"];
			}
			$charinfo["linkshell"] = $_POST["linkshell"];
			$charinfo["bio"] = $_POST["character_bio"];
			if($_POST["show_level_by_name"] == "1") {
				$charinfo["showlevelbyname"] = "1";
			} else {
				$charinfo["showlevelbyname"] = "0";
			}
			if($_POST["show_level_in_details"] == "1") {
				$charinfo["showlevelindetails"] = "1";
			} else {
				$charinfo["showlevelindetails"] = "0";
			}
			$charinfo["title"] = $_POST["widget_title"];
			
			// Save the posted value in the database
			update_option("ffxi_char_profile", $charinfo);

			// Put an options updated message on the screen
		?><div class="updated"><p><strong>Profile Saved!</strong></p></div><?php
	} else {
		$dbinfo = get_option("ffxi_char_profile");
		if(!is_array($dbinfo)) {
		  $charinfo = array(
			"name" => "",
			"race" => "Hume",
			"gender" => "Male",
			"face" => "1",
			"faceversion" => "a",
			"allegiance" => "Bastok",
			"world" => "Alexander",
			"mainjob" => "Warrior",
			"subjob" => "<None>",
			"mainlevel" => "1",
			"sublevel" => "0",
			"showlevelbyname" => "1",
			"showlevelindetails" => "1",
			"title" => "Final Fantasy XI Character Profile",
			"bio" => "",
			"linkshell" => ""
		  );
		} else {
			$charinfo = strip_all_slashes($dbinfo);
		}
	}
	?>
	<div class="wrap">
		<h2>Final Fantasy XI Character Profile</h2>
		<script type="text/javascript" src="<?php echo get_bloginfo(wpurl); ?>/wp-content/plugins/final-fantasy-xi-character-profile/ffxi-char.js"></script>
		<form method="post" action="">
			<input type="hidden" name="ffxi_char_profile_submitted" value="Y" />
			<?php wp_nonce_field('update-options'); ?>
			<h3>Character Configuration</h3>
			<table class="form-table">
				<tr valign="top">
					<th scope="row">Character Name</th>
					<td><input type="text" name="character_name" maxlength="15" value="<?php echo $charinfo["name"]; ?>" /></td>
				</tr> 
				<tr valign="top">
					<th scope="row">Race</th>
					<td><?php echo build_dropdown("race", get_races(), $charinfo["race"], "onChange=\"ffxi_update_genders(this.form.race, this.form.gender);\""); ?></td>
				</tr>
				<tr valign="top">
					<th scope="row">Gender</th>
					<td><?php 
					$onchange = "onChange=\"ffxi_update_faces(this.form.race.value, this.form.gender.value);\"";
					if($charinfo["race"] == "Galka") {
						echo build_dropdown("gender", get_genders(), "Male", "disabled " . $onchange);
					} else if($charinfo["race"] == "Mithra") {
						echo build_dropdown("gender", get_genders(), "Female", "disabled " . $onchange);
					} else {
						echo build_dropdown("gender", get_genders(), $charinfo["gender"], $onchange);
					}
					?></td>
				</tr>
				<tr valign="top">
					<th scope="row">Face</th>
					<td><?php echo build_face_table($charinfo["race"], $charinfo["gender"], $charinfo["face"], $charinfo["faceversion"]); ?></td>
				</tr>
				<tr valign="top">
					<th scope="row">Allegiance</th>
					<td><?php echo build_dropdown("allegiance", get_nations(), $charinfo["allegiance"]); ?></td>
				</tr>
				</tr>
				<tr valign="top">
					<th scope="row">World</th>
					<td><?php echo build_dropdown("world", get_worlds(), $charinfo["world"]); ?></td>
				</tr>
				<tr valign="top">
					<th scope="row">Main Job</th>
					<td><?php echo build_dropdown("mainjob", get_jobs(), $charinfo["mainjob"]); ?>&nbsp;
					<input type="text" name="mainlevel" maxlength="2" value="<?php echo $charinfo["mainlevel"]; ?>" onblur="ffxi_job_level_validate(this.form.mainlevel)"/></td>
				</tr>
				<tr valign="top">
					<th scope="row">Sub Job</th>
					<td><?php
					$jobs = array_merge((array)"&lt;None&gt;", get_jobs());
					echo build_dropdown("subjob", $jobs, $charinfo["subjob"], "onchange=\"ffxi_update_subjob(this.form.subjob, this.form.sublevel)\""); ?>&nbsp;
					<input type="text" name="sublevel" maxlength="2" value="<?php echo $charinfo["sublevel"]; ?>" onblur="ffxi_job_level_validate(this.form.sublevel)" 
					<?php if($charinfo["subjob"] == "<None>") echo " disabled"; ?>/></td>
				</tr>
				<tr>
					<td style="font-size: smaller; font-style: italic; padding: 2px; padding-left: 2em; line-height: 1em; color: #666666;" colspan="2">Just put in the actual level, it'll be rounded down to half if needed - saves you having to update both boxes every time!</td>
				</tr>
				<tr valign="top">
					<th scope="row">Linkshell</th>
					<td><input type="text" name="linkshell" maxlength="20" value="<?php echo $charinfo["linkshell"]; ?>" /></td>
				</tr> 
				<tr valign="top">
					<th scope="row">Character Bio</th>
					<td><input type="text" name="character_bio" maxlength="100" size="30" value="<?php echo $charinfo["bio"]; ?>" /></td>
				</tr> 
				<tr>
					<td style="font-size: smaller; font-style: italic; padding: 2px; padding-left: 2em; line-height: 1em; color: #666666;" colspan="2">A brief bit of text describing what you're up to, what you're looking for, achievements etc.</td>
				</tr>
			</table>
			<h3>Display Configuration</h3>
			<table class="form-table">
				<tr valign="top">
					<th scope="row">Show jobs next to name</th>
					<td><input type="checkbox" name="show_level_by_name" value="1"<?php if($charinfo["showlevelbyname"] == "1") echo " checked"; ?>" /></td>
				</tr>
				<tr valign="top">
					<th scope="row">Show jobs in details</th>
					<td><input type="checkbox" name="show_level_in_details" value="1"<?php if($charinfo["showlevelindetails"] == "1") echo " checked"; ?>" /></td>
				</tr>
				<tr valign="top">
					<th scope="row">Widget Title</th>
					<td><input type="text" name="widget_title" maxlength="40" value="<?php echo $charinfo["title"]; ?>" /></td>
				</tr> 
			</table>
			<input type="hidden" name="action" value="update" />
			<input type="hidden" name="page_options" value="character_name,race,gender" />
			<p class="submit">
				<input type="submit" class="button-primary" value="<?php echo _e('Save Changes'); ?>" />
			</p>
		</form>
	</div>
	<?php
}
?>