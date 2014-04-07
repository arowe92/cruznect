
<div id="main">
	<div id="main_front">
		<h1>Connect with talent at UCSC</h1>
		<br/>
				<br/>
						<br/>
								<br/>
			</div>
	<div id="main_login">
		<form method="post" action="login.php" id="main_login_form">
				<div id="main_login_form_header">
					<h3>Log in</h3>
					Or do you want to <a href="#" class="tag" id="register">Register</a>?
	   			</div>
	   			<input type="text" id="email" name="email" placeholder="@ucsc.edu" class="large_input" />
	   			<input type="password" id="password" name="password" placeholder="Password" class="large_input" />
	   			<div id="main_login_form_footer">
		   			<input type="submit" value="Log in" />
	   			</div>
		</form>
		<form method="post" action="register.php" id="main_register_form">
				<div id="main_login_form_header">
					<h3>Register</h3>
					@ucsc.edu only, sorry!
	   			</div>
	   			<input type="text" id="email" name="email" placeholder="@ucsc.edu" class="large_input" /><br/>
	   			<input type="password" id="password" name="password" placeholder="Password" class="large_input" /><br/>
	   			<input type="password" id="password" name="password" placeholder="Verify your password!" class="large_input" /><br/>
	   			<input type="text" id="name" name="name" placeholder="Full name" class="large_input" /><br/>
	   			<label for="active">Are you looking for projects?</label><br/>
	   			<input type="radio" name="active" value="1">Yes!
	   			<input type="radio" name="active" value="0">No, I've got my own.<br/><br/>
	   			<label for="talents[]">What's your main skillset? <br/> (select as many as you want!)</label><br/>
	   			<? get_talents_form(); ?>
	   			<div id="main_login_form_footer">
		   			<input type="submit" value="Register!" />
		   			Wait, no! I want to <a class="tag" href="#" id="login">log in!</a><br/>
	   			</div>
		</form>
	</div>
	<div id="main_count">
		Do you need someone for your project? <br/>
				Right now we have...
				<br/>
				<br/>
		<table>
			<tr>
				<td>
					<b><?php echo get_talent_count(1); ?></b><br/>
					<font> artists</font>
				</td>
				<td>
					<b><?php echo get_talent_count(2); ?></b><br/>

										<font> programmers</font>
				</td>
				<td>
					<b><?php echo get_talent_count(3); ?></b><br/>

										<font> film makers</font>
				</td>
				<td>
					<b><?php echo get_talent_count(4); ?></b><br/>

										<font> musicians</font>
				</td>
				<td>
					<b><?php echo get_talent_count(5); ?></b><br/>

										<font> writers</font>
				</td>
			</tr>
			<tr>
				<td>
					<img src="img/artico.png" class="main_count_img" />
				</td>
				<td>
					<img src="img/csico.png" class="main_count_img" />
					
				</td>
				<td>
					<img src="img/filmico.png" class="main_count_img" />
				</td>
				<td>
					<img src="img/musicico.png" class="main_count_img" />
				</td>
				<td>
					<img src="img/writingico.png" class="main_count_img" />
				</td>
			</tr>
		</table>
		And more!		
	</div>
	
	<div id="app">
	<img src="http://www.vectorsland.com/imgd/l62940-available-on-the-app-store-badge-logo-55039.png" width="165px"/>
	</div>
</div>