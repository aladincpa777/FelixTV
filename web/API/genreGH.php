<?php
// JSON GENRE API
header('Content-type: application/json');
// %DATABASE%
$servername = "md21.wedos.net";
$username = "a194060_felix";
$password = "%DELETED%";
$dbname = "d194060_felix";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$genre = strtolower($_GET['g']);
if (strlen($genre)<4) {
  die("Prosim zadejte minimalne 4 znaky.");
}
// GENRE MAP
$genre_exist = false;
$genre2_exist = false;
$genre3_exist = false;
$genre4_exist = false;
$genre5_exist = false;
$genre6_exist = false;
if ($genre == 'akční' || $genre == 'akcni' ||  $genre == 'action'){
    $genre = '1';
    $genre2 = '74';
    $genre3 = '91';
    $genre4 = '95';
    $genre5 = '107';
    $genre_exist = true;
    $genre2_exist = true;
    $genre3_exist = true;
    $genre4_exist = true;
    $genre5_exist = true;
}
if ($genre == 'tv show' || $genre == 'tv-show'){
    $genre = '2';
    $genre2 = '20';
    $genre3 = '72';
    $genre_exist = true;
    $genre2_exist = true;
    $genre3_exist = true;
}
if ($genre == 'sci-fi'){
    $genre = '3';
    $genre2 = '73';
    $genre3 = '85';
    $genre_exist = true;
    $genre2_exist = true;
    $genre3_exist = true;
}
if ($genre == 'dobrodružné' || $genre == 'dobrodruzne' || $genre == 'adventure'){
    $genre = '4';
    $genre2 = '22';
    $genre3 = '79';
    $genre4 = '83';
    $genre5 = '98';
    $genre6 = '106';
    $genre_exist = true;
    $genre2_exist = true;
    $genre3_exist = true;
    $genre4_exist = true;
    $genre5_exist = true;
    $genre6_exist = true;
}
if ($genre == 'animované' || $genre == 'animovane' || $genre == 'animation'){
    $genre = '5';
    $genre2 = '76';
    $genre3 = '110';
    $genre4 = '126';
    $genre_exist = true;
    $genre2_exist = true;
    $genre3_exist = true;
    $genre4_exist = true;
}
if ($genre == 'biografie' || $genre == 'životopisné' || $genre == 'zivotopisne'){
    $genre = '6';
    $genre2 = '86';
    $genre3 = '108';
    $genre4 = '116';
    $genre_exist = true;
    $genre2_exist = true;
    $genre3_exist = true;
    $genre4_exist = true;
}
if ($genre == 'komedie' || $genre == 'comedy'){
    $genre = '7';
    $genre2 = '78';
    $genre3 = '93';
    $genre4 = '99';
    $genre5 = '101';
    $genre_exist = true;
    $genre2_exist = true;
    $genre3_exist = true;
    $genre4_exist = true;
    $genre5_exist = true;
}
if ($genre == 'krimi' || $genre == 'crimi' || $genre == 'crime'){
    $genre = '8';
    $genre2 = '75';
    $genre3 = '89';
    $genre4 = '96';
    $genre5 = '111';
    $genre_exist = true;
    $genre2_exist = true;
    $genre3_exist = true;
    $genre4_exist = true;
    $genre5_exist = true;
}
if ($genre == 'dokumentarni' || $genre == 'dokumentární' || $genre == 'documentary'){
    $genre = '9';
    $genre2 = '61';
    $genre_exist = true;
    $genre2_exist = true;
}
if ($genre == 'drama'){
    $genre = '10';
    $genre2 = '24';
    $genre_exist = true;
    $genre2_exist = true;
}
if ($genre == 'rodinne' || $genre == 'rodinné' || $genre == 'family'){
    $genre = '11';
    $genre2 = '77';
    $genre3 = '84';
    $genre4 = '100';
    $genre5 = '127';
    $genre_exist = true;
    $genre2_exist = true;
    $genre3_exist = true;
    $genre4_exist = true;
    $genre5_exist = true;
}
if ($genre == 'fantasy'){
    $genre = '12';
    $genre2 = '25';
    $genre3 = '73';
    $genre_exist = true;
    $genre2_exist = true;
    $genre3_exist = true;
}
if ($genre == 'history' || $genre == 'historie' || $genre == 'historické' || $genre == 'historicke'){
    $genre = '13';
    $genre2 = '82';
    $genre3 = '97';
    $genre4 = '122';
    $genre_exist = true;
    $genre2_exist = true;
    $genre3_exist = true;
    $genre4_exist = true;
}
if ($genre == 'horror' || $genre == 'horrory'){
    $genre = '14';
    $genre2 = '104';
    $genre_exist = true;
    $genre2_exist = true;
}
if ($genre == 'mystery' || $genre == 'mysteriozni' || $genre == 'mysteriózní'){
    $genre = '16';
    $genre2 = '68';
    $genre3 = '105';
    $genre_exist = true;
    $genre2_exist = true;
    $genre3_exist = true;
}
if ($genre == 'hudebni' || $genre == 'hudební' || $genre == 'music'){
    $genre = '15';
    $genre2 = '88';
    $genre3 = '114';
    $genre4 = '117';
    $genre5 = '125';
    $genre_exist = true;
    $genre2_exist = true;
    $genre3_exist = true;
    $genre4_exist = true;
    $genre5_exist = true;
}
if ($genre == 'thriller'){
    $genre = '17';
    $genre2 = '23';
    $genre_exist = true;
    $genre2_exist = true;
}
if ($genre == 'valecne' || $genre == 'war' || $genre == 'válečné'){
    $genre = '18';
    $genre2 = '92';
    $genre3 = '102';
    $genre4 = '123';
    $genre_exist = true;
    $genre2_exist = true;
    $genre3_exist = true;
    $genre4_exist = true;
}
if ($genre == 'western'){
    $genre = '19';
    $genre2 = '103';
    $genre_exist = true;
    $genre2_exist = true;
}
if ($genre == 'romanticke' || $genre == 'romantické' || $genre == 'romantic' || $genre == 'romance'){
    $genre = '21';
    $genre2 = '80';
    $genre3 = '94';
    $genre_exist = true;
    $genre2_exist = true;
    $genre3_exist = true;
}
if ($genre == 'science-fiction'){
    $genre = '71';
    $genre_exist = true;
}
// //////////
echo "<br/>==START QUERY==<br/>";
$additional_query = '';
if ($genre2_exist === true){
    $additional_query .= " OR FIND_IN_SET( LEFT( ".$genre2.", 10 ) , genre ) >0";
}
if ($genre3_exist === true){
    $additional_query .= " OR FIND_IN_SET( LEFT( ".$genre3.", 10 ) , genre ) >0";
}
if ($genre4_exist === true){
    $additional_query .= " OR FIND_IN_SET( LEFT( ".$genre4.", 10 ) , genre ) >0";
}
if ($genre5_exist === true){
    $additional_query .= " OR FIND_IN_SET( LEFT( ".$genre5.", 10 ) , genre ) >0";
}
if ($genre6_exist === true){
    $additional_query .= " OR FIND_IN_SET( LEFT( ".$genre6.", 10 ) , genre ) >0";
}
$sql = "SELECT * FROM videos WHERE FIND_IN_SET( LEFT( ".$genre.", 10 ) , genre ) >0". $additional_query ." AND is_tvseries = '0' LIMIT 50";
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