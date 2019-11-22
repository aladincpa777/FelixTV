<?php
// %DATABASE%
$servername = "md21.wedos.net";
$username = "a194060_felix";
$password = "%DELETED%";
$dbname = "d194060_felix";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$PROCESS_INDEX = 1; // PASS
$season = 53;
$actual_explored_season = 1;

//while ($actual_explored_season !== 121){
	//$episode_explored = mysqli_query($conn,"SELECT * FROM episodes WHERE seasons_id = '{$season}'"); // Get list of all                                                                              == PRŮMĚRŇÁKOVI                   = 2 ŘADA
	
	$episode_explored = mysqli_query($conn,"SELECT * FROM episodes WHERE real_episode_id IS NULL");
	if (mysqli_num_rows($episode_explored) > 0) { // When rows exists in SQL
		while($row = mysqli_fetch_assoc($episode_explored)) { // Get data from SQL
			//if ($actual_explored_season !== $row["seasons_id"]){
			//	$actual_explored_season = $row["seasons_id"]; // Update new season eg. Průměrňákovi 5 série:)
			//	$season++;
			//	$PROCESS_INDEX = 1;
			//} else {
			$episode_id_var = $row["episodes_id"];
				if (mysqli_query($conn, "UPDATE episodes SET real_episode_id = '{$PROCESS_INDEX}' WHERE episodes_id = '{$episode_id_var}'")) {
			//if (mysqli_query($conn, "UPDATE episodes SET real_episode_id = '1' WHERE real_episode_id IS NULL")) {
	               		echo "Record updated successfully";
	            } else {
	            	echo "Something wrong";
	            }
	            $PROCESS_INDEX++;
			}
	}