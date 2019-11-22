<?php
// JSON YEAR API
//header('Content-type: application/json');
// %DATABASE%
$servername = "md21.wedos.net";
$username = "a194060_felix";
$password = "%DELETED%";
$dbname = "d194060_felix";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$year = $_GET['r'];
if (strtotime($year) === false) {
  die("Prosim zadejte spravny rok.");
}
$sql = "SELECT * FROM videos WHERE `release` = '".$year."' AND is_tvseries = '0'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
    	$stream_payload = file_get_contents('http://89.203.248.240/streamuj_get.php?q='.$row["stream"]);
    	$video_stream = "http://89.203.248.240/web_stream.php?q=".$stream_payload;
    	$data = [ 'name' => $row["title"], 'genre' => '', 'description' => $row["description"], 'thumb' => 'https://felixtv.cz/uploads/video_thumb/'.$row["videos_id"].'.jpg', 'video' => $video_stream ];
    	echo json_encode( $data );
    }
} else {
    echo "Nebylo nic nalezeno";
}
$conn->close();
?>