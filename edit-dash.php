<?php
/*
This is the code for the dashboard widget that allows the main level and 'bio' text to be updated easily.
*/
function ffxi_char_profile_dash_display() {
	$dbinfo = get_option("ffxi_char_profile");
	if(!is_array($dbinfo)) {
	  ?><p><strong>No character information has been set yet.</strong><br/>
	  Click <a href="themes.php?page=?page=ffxi_char_profile_edit_page">here</a> to configure your character now.</p><?php
	} else {
		$charinfo = strip_all_slashes($dbinfo);
		if($_POST["ffxi_char_profile_submitted"] == 'Y') {
				$charinfo["mainlevel"] = $_POST["mainlevel"];
				$charinfo["bio"] = $_POST["character_bio"];
				
				// Save the posted value in the database
				update_option("ffxi_char_profile", $charinfo);
				
				// Put an options updated message on the screen
			?><div class="updated"><p><strong>Profile Saved!</strong></p></div><?php
		}
		?>
		<div class="wrap">
			<script type="text/javascript" src="<?php echo get_bloginfo(wpurl); ?>/wp-content/plugins/ffxi-char-profile/ffxi-char.js"></script>
			<form method="post" action="">
				<input type="hidden" name="ffxi_char_profile_submitted" value="Y" />
				<?php wp_nonce_field('update-options'); ?>
				<table class="form-table">
					<tr valign="top">
						<th scope="row">Main Job Level</th>
						<td><input type="text" name="mainlevel" maxlength="2" value="<?php echo $charinfo["mainlevel"]; ?>" onblur="ffxi_job_level_validate(this.form.mainlevel)"/></td>
					</tr>
					<tr valign="top">
						<th scope="row">Character Bio</th>
						<td><input type="text" name="character_bio" maxlength="100" size="30" value="<?php echo $charinfo["bio"]; ?>" /></td>
					</tr> 
					<tr>
						<td style="font-size: smaller; font-style: italic; padding: 2px; padding-left: 2em; line-height: 1em; color: #666666;" colspan="2">A brief bit of text describing what you're up to, what you're looking for, achievements etc.</td>
					</tr>
				</table>
				<input type="hidden" name="action" value="update" />
				<p class="submit">
					<input type="submit" class="button-primary" value="<?php echo _e('Save Changes'); ?>" />
				</p>
			</form>
		</div>
	<?php				
	}
}
?>