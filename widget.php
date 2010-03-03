<?php
/*
This is where the widget for displaying the character information is defined.
*/

function show_ffxi_char() {
	$dbinfo = get_option("ffxi_char_profile");
	$charinfo = strip_all_slashes($dbinfo);
	if(!is_array($charinfo) || count($charinfo) < 11) {
	  return "No details have been configured yet.";
	} else {
		$jobdisplay = "";
		if($charinfo["showlevelbyname"] == "1") {
			$joblist = get_jobs();
			$mainjobshort = array_search($charinfo["mainjob"], $joblist);
			$jobdisplay = " (" . $mainjobshort . " " . $charinfo["mainlevel"];
			if($charinfo["subjob"] != "<None>") {
				$subjobshort = array_search($charinfo["subjob"], $joblist);
				$jobdisplay .= "/" . $subjobshort . " " . calcSub($charinfo["mainlevel"], $charinfo["sublevel"]);
			}
			$jobdisplay .= ")";
		}
		if($charinfo["bio"] != "") {
			$bio = "<div style=\"border-top: 1px dotted\">" . $charinfo["bio"] . "</div>";
		} else {
			$bio = "";
		}
	?>
	<h4 style="border-bottom: dotted 1px;"><?php echo $charinfo["name"] . $jobdisplay ?></h4>
	<img style="float: right; border: #000000 solid 1px; margin: 4px;" src="<?php echo get_bloginfo(wpurl); ?>/wp-content/plugins/ffxi-char-profile/img/<?php
	echo get_face_prefix($charinfo["race"], $charinfo["gender"]) . $charinfo["face"] . $charinfo["faceversion"]; ?>.jpg"/>
	<ul style="margin-top: 4px;"><li><strong>Race:</strong> <?php echo $charinfo["race"]; ?></li>
		<li><strong>Gender:</strong> <?php echo $charinfo["gender"]; ?></li>
		<li><strong>Allegiance:</strong> <?php echo $charinfo["allegiance"]; ?></li>
		<li><strong>World:</strong> <?php echo $charinfo["world"]; ?></li>
		<?php if($charinfo["showlevelindetails"] == "1") { ?>
			<li><strong>Main Job:</strong> <?php echo $charinfo["mainjob"] ?> (<?php echo $charinfo["mainlevel"]; ?>)</li>
			<?php if(isset($subjobshort)) {?>
				<li><strong>Sub Job:</strong> <?php echo $charinfo["subjob"] ?> (<?php echo calcSub($charinfo["mainlevel"], $charinfo["sublevel"]); ?>)</li>
			<?php } 
		}
		if($charinfo["linkshell"] != "") { ?>
			<li><strong>Linkshell:</strong> <?php echo $charinfo["linkshell"] ?></li>
		<?php } ?>
	</ul>
	<?php
	echo $bio;
	}
}
?>