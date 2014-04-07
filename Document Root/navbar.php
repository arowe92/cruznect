
<div id="header">
	<div id="header_logo">
		<a href="index.php"><img src="img/logo2.png" id="header_logo_image" style="margin-left:-100px;"/></a>
	</div>
	<div id="header_access">
	<?if($_COOKIE['email']){?>
		<img src="http://placehold.it/200x100&text=add project" id="header_project"/>
		<img src="http://placehold.it/150x100&text=profile" id="header_profile"/>
			<div id="header_add_project"/>
					<form method="post" action="add_project.php" id="add_project_form">
						<div id="header_add_form_header">
							<h3>Add a project!</h3>
			   			</div>
			   			<input type="text" name="name" placeholder="Project name" class="large_input" /><br/>
			   			<textarea name="description" placeholder="Describe your project!" class="large_input" ></textarea><br/>
			   			<label for="talents[]"><b>What are you looking for?</b> <br/> (select as many as you want!)
			   			</label><br/>
			   			<br/>
			   			<!--This will be populated from the talents database-->
			   			<div id="form_talents">
			   			<? echo get_talents_form(); ?>
			   			</div>
			   			<div id="header_add_form_footer">
				   			<input type="submit" value="Register!"/>
			   			</div>
		   			</form>
	   			</div>
	<?} else {?>
		<img src="http://placehold.it/150x100&text=login" id="header_login"/>
	<?}?>
	</div>
</div>
