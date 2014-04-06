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

function print_rows(){
	$query = sprintf("SELECT * FROM projects");
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
					".$row["description"]."
					</td>
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
					".$top_row."					
					</tr>
					<tr>
					".$bottom_row."
					</tr>
				</tbody>
			</table>";
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

function insert_project(){
	$query = "";
	$result = Query($query);
	return $result;
}

function insert_user_project($id_user, $id_project){
	$query = "INSERT INTO user_projects (user_id, project_id) VALUES ($id_user, $id_project)";
	$result = Query($query);
	return $result;
}

?>