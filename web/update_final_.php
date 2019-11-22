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
// PREPARE
$NUMBER = -1;
$movie_id = "";
/////////////////
while($NUMBER < 511){
	$NUMBER++;
$felix_movie = mysqli_query($conn,"SELECT * FROM videos WHERE videos_id = '{$NUMBER}'"); // Get english name E.g. The middle
// MOVIE UPDATER
$update_movie_en = "";
if (mysqli_num_rows($felix_movie) > 0) {
            while($row = mysqli_fetch_assoc($felix_movie)) {
               $update_movie_en = $row["title_en"]; // Now we know 
               $update_movie_year = $row["release"];
               $full_streamuj_url = "http://tv.sosac.to/jsonsearchapi.php?q=".$update_movie_en;
               $streamuj_json = file_get_contents($full_streamuj_url);
               $data = json_decode($streamuj_json, true);
               foreach ($data as $emp) {
	               	if ($emp['y'] == $update_movie_year){
	               		$movie_id = "http://www.streamuj.tv/video/".$emp['l']; // Now we know Streamuj.tv video id
	               	} else { //skip }
	               }
	               if (mysqli_query($conn, "UPDATE videos SET stream = '$movie_id' WHERE videos_id = '$NUMBER'")) {
	               		echo "Record updated successfully";
	               } else {
	               	echo "Update not successfull :(";
	               }
	               //echo $update_movie_en;
            	}
         	}
         }
}
mysqli_close($conn);










//$full_streamuj_url = "http://tv.sosac.to/jsonsearchapi.php?q=".urlencode($_GET['q']);
//$streamuj_json = file_get_contents($full_streamuj_url);
//$data = json_decode($streamuj_json, true);
//foreach ($data as $emp) {
//  $movie_id = $emp['l']; // streamuj.tv video id
//}
//$sql = "UPDATE videos SET stream = '$movie_id' WHERE videos_id = $NUMBER";
//if (mysqli_query($conn, $sql)) {
//    echo "Record updated successfully";
//} else {
//    echo "Error updating record: " . mysqli_error($conn);
//}
?>