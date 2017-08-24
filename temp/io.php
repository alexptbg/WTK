 <?php
$CARD = $_GET['CARD'];
$servername = "127.0.0.1";
$username = "root";
$password = "a11543395";
$dbname = "raspi";
$data = array();
$errors = array();

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
/* change character set to utf8 */
if (!mysqli_set_charset($conn,"utf8")) {
    printf("Error loading character set utf8: %s\n", mysqli_error($link));
    exit();
}

$sql = "SELECT * FROM `cards_active` WHERE `card`='".$CARD."' ORDER BY `id` DESC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows === 1) {
    while($row = $result->fetch_assoc()) {
        $data = $row;
    }
    //continue
    if(!empty($data)) {
        //init
        //do nothing
    } else {
        $errors = array(
            "name" => "Err",
            "Error" => $CARD." - Empty data"
        );
    }
} else {
    $errors = array(
        "name" => "Err",
        "Error" => $CARD." - RFID not valid."
    );
}
if(empty($errors)) {
    header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
} else {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($errors);
}
$conn->close();
?> 