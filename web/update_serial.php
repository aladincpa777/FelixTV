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

$PROCESS_INDEX = 1;

$season = 1;
$last_serial = 10;
$actual_explored = 1;
$episode_explored = mysqli_query($conn,"SELECT * FROM episodes WHERE seasons_id = '{$season}'"); // Get list of all                                                                              == PRŮMĚRŇÁKOVI                   = 2 ŘADA
while($last_serial < $actual_explored){
	if (mysqli_num_rows($episode_explored) > 0) {
		while($row = mysqli_fetch_assoc($episode_explored)) {
			if ($actual_explored !== $row["season_id"]){
				$actual_explored = $row["season_id"]; // Update new season :)
			} else {
				if (mysqli_query($conn, "UPDATE episodes SET real_episode_id = '$PROCESS_INDEX' WHERE episodes_id = '{$row["episodes_id"]}'")) {
	               		echo "Record updated successfully";
	            } 
			}
		}
	}
}
?>