<?php

$site_url = elgg_get_site_url();

global $CONFIG;
$text = elgg_get_plugin_setting("maintenance_text", "maintenance");

?>
<html>
	<head>
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
		<script type="text/javascript">
			function maintenance_showAdmin(){
				$("#admin_login").toggle("slow");
			}
		</script>
		
		<style type="text/css">
			body {
				text-align:center;
				font: 80%/1.4  "Lucida Grande", Verdana, sans-serif;
			}
			
			#maintenance_box {
				margin: 15% auto;
				position:relative;
				border: 1px solid #DEDEDE;

			}
			#maintenance_box td {
				padding: 1em;
				vertical-align: top;
			}
			
			#image_container {
				vertical-align:top;
			}
			
			#admin_login{
				display: none;
			}
			
			img {
				margin-right: 20px;
			}
			fieldset {
				border: 0;
				padding: 0;
			}
		</style>
	</head>
	<body>
		<table id="maintenance_box">
		<tr>
			<td id="image_container">
				<img src="<?php echo $site_url;?>mod/maintenance/_graphics/maintenance.png" alt="">
			</td>
			<td>
				<h1>
				<?php echo elgg_echo("maintenance:info");?>
				</h1>
				<p>
					<?php echo $text; ?>
				</p>
				<p>
					<?php echo sprintf(elgg_echo("maintenance:adminlogin"), "<a href='javascript:maintenance_showAdmin()'>" , "</a>");?>
				</p>
				<div id="admin_login">
					<?php echo elgg_view_form('login'); ?>
				</div>
			</td>
		</tr>
		</table>
	</body>
</html>
<?php

exit();
