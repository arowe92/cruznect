<?php

function getSQL(){
	$DB_NAME = "hackathon";
	$DB_HOST = "127.0.0.1";
	$DB_USER = "root";
	$DB_PASS = "root";
	
	return new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
}

function Query($query){
	$sql = getSQL();
	$result = $sql->query($query);
	if(!$result){
	    die('There was an error running the query [' . $sql->error . ']. The query was ' .$query);
	}
	return $result;
}

//input[0] is the post number
//input[1] is the array of talents



function getPost($input){
	//if there is a second argument, filter by those talents
	if($input[1]){
		$tlist="'".join("','" , $input[1])."'";
			$query = sprintf("SELECT projects.id
			FROM 
			projects, project_required, talents
			WHERE 
			projects.id=project_id
			AND
			talents.id=talent_id
			AND
			talents.id IN ($tlist)
			");
		}
		else
			$query = sprintf("SELECT projects.id
			FROM 
			projects, project_required, talents
			WHERE 
			projects.id=project_id
			AND
			talents.id=talent_id
			");
	

		$result = Query($query);

	if (!$result) {
    	//No projects avaliable
	}

	$count=0;

	while ($row = mysqli_fetch_assoc($result)) {


		if($count==$num)
			return $row;

		$count++;
	}
		
}

function getTalents($email){

	//Determine user ID
	$query = sprintf("SELECT id
		FROM 
		users
		WHERE 
		email='$email' 
		");
	$result = Query($query);
	$row = mysqli_fetch_assoc($result);
	$id=$row['id'];


	$query = sprintf("SELECT talents.id
		FROM 
		users, user_talents, talents
		WHERE 
		users.id=$id 
		AND
		user_id=users.id
		AND
		talent_id=talents.id
		");
		//talents.id = user_talents.talent_id,
		//users.active='1'
		//");


	
	$result = Query($query);
	$column = array();

	while($row  = mysqli_fetch_assoc($result)){
		$str = $row['id'];
		$column[] = "$str";
	}

	return $column;

}



function getCount($talent){

	$query = sprintf("SELECT name 
		FROM 
		talent
		WHERE 
		name='$talent'
		");


	$result = Query($query);

	if (!$result) {
    	return 0;
	}

	$i=0;
	while ($row = mysqli_fetch_assoc($result)) {
		$i++;
	}

	return $i;

}

function print_rows($id){

	if ($id == 0){
	$query = sprintf("SELECT * FROM projects WHERE active = 1");
	}
	else {
		$query = "SELECT project_id as id, projects.name as name, description, projects.imageURL as imageURL
	FROM project_required, projects, talents 
	WHERE project_required.project_id = projects.id
	AND projects.active = 1
	AND project_required.talent_id = talents.id
	AND talents.id = $id";
	}
	$result = Query($query);
	while ($row = mysqli_fetch_assoc($result)) {
		echo "
		<a href='project.php?id=".$row['id']."'><div class='main_content_row'>
			<table class='main_content_table'>
				<tr>
					<td>
						<img src='".$row["imageURL"]."' class='project_img'/>
					</td>
					<td class='main_content_text'>
					<h3> ".$row["name"]."</h3><br/>
					".substr($row["description"], 0, 100)."...
					</td>
					<td>".get_project_talents_tag($row["id"])."</td>
					<td>
						<a href='#' class='project_btn' id='".$row["id"]."'>JOIN</a>
					</td>
				</tr>
			</table>
		</div></a>";
			}
}

function get_project_name($id){
	$query = "SELECT name FROM projects WHERE id = $id";
	$result = Query($query);
	$row = mysqli_fetch_assoc($result);
	return $row["name"];
}

function get_project_description($id){
	$query = "SELECT description FROM projects WHERE id = $id";
	$result = Query($query);
	$row = mysqli_fetch_assoc($result);
	return $row["description"];
}


function get_project_talents_tag($id){
	$query = "SELECT talents.id, talents.name, talents.imageurl, number_of_people 
	FROM projects, project_required, talents 
	WHERE projects.id = project_required.project_id
	AND talents.id = project_required.talent_id
	AND projects.id = $id";
	$top_row = "";
	$bottom_row = "";
	$result = Query($query);
	while ($row = mysqli_fetch_assoc($result)) {
		$bottom_row .= "<td><a href='index.php?talent=".$row["id"]."' class='tag'>".$row["name"]." </a></td>";
	}
	
	return "
	<p class='main_content_text'><b>Talents needed:</b></p>
	<table class='tag_table'>
				<tbody>
					<tr>
					".$bottom_row."
					</tr>
				</tbody>
			</table>";
}


function get_project_talents($id){
	$query = "SELECT talents.name, talents.imageurl, number_of_people 
	FROM projects, project_required, talents 
	WHERE projects.id = project_required.project_id
	AND talents.id = project_required.talent_id
	AND projects.id = $id";
	$top_row = "";
	$bottom_row = "";
	$result = Query($query);
	while ($row = mysqli_fetch_assoc($result)) {
		$top_row .= "<td>".$row["number_of_people"]."</td>";
		$bottom_row .= "<td><img src=".$row["imageurl"]." class='project_content_img' /></td>";
	}
	
	return "<table>
				<tbody>
					<tr>
					".$bottom_row."
					</tr>
				</tbody>
			</table>";
}

function get_project_people($id){
	$query = "SELECT name, email FROM user_projects, users WHERE user_projects.user_id = users.id AND project_id = $id";
	$result = Query($query);
	$people_list = "";
	if ($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			$people_list .= "<li>".$row["name"];
			if (is_owner($id)){
				$people_list .= " - ". $row["email"];
			}
			$people_list .= "</li>";
		}
		$people_list = "<ul>" .$people_list. "</ul>";
	} else {
		$people_list = "Be the first to join!";
	}
	
	return $people_list;
	
}

function insert_user(){
	$query = "";
	$result = Query($query);
	return $result;
}

function insert_user_talent(){
	$query = "";
	$result = Query($query);
	return $result;
}

function insert_project($name, $description){
	$user_id = get_user_id($_COOKIE['email']);
	$query = "INSERT INTO projects(name, description, owner, active) VALUES ('$name','$description',$user_id,1);";
	$result = Query($query);
	return $result;
}

function insert_user_project($id_user, $id_project){
	$query = "INSERT INTO user_projects (user_id, project_id) VALUES ($id_user, $id_project)";
	$result = Query($query);
	return $result;
}

function get_user_id($email){
	$query = "SELECT id FROM users WHERE email= '$email'";
		$result = Query($query);
		$row = mysqli_fetch_assoc($result);
		return $row["id"];
}

function get_project_id($name){
	$query = "SELECT id FROM projects WHERE name= '$name'";
		$result = Query($query);
		$row = mysqli_fetch_assoc($result);
		return $row["id"];
}

function get_talents_form(){
	$query = "SELECT * FROM talents";
	$result = Query($query);
	
	$output = "<select style='width:90%; height:90; color:#666' name='talents[]' multiple>";
	while ($row = $result->fetch_assoc()){
		$output .= "<option value=".$row["id"].">".$row["name"]."<br/>";
	}
	$output .= "</select>";
	return $output;	
}

function is_owner($projectid){
	$query = "SELECT owner FROM projects WHERE id = $projectid";
	$result = Query($query);
	$row = $result->fetch_assoc();
	if(get_user_id($_COOKIE['email'])  == $row["owner"]){
		return true;
	} else {
		return false;
	}
}

function get_owner($projectid){
	$query = "SELECT owner FROM projects WHERE id = $projectid";
	$result = Query($query);
	$row = $result->fetch_assoc();
	return $row['owner'];
}

function get_talent_count($talentid){
	$query = "SELECT * FROM project_required WHERE talent_id = $talentid";
	$result = Query($query);
	
	$count=0;
	while($row = mysqli_fetch_assoc($result)){
		$count++;
	}
	return $count;

}


?>