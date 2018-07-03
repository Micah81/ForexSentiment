<?php
if(isset($_POST['choices[]'])){
    echo $_POST['choices[]'];
}

//$choices = array("NZDCHF","USDHUF");
$choices =  $_POST['choices[]'];
$choices = substr($choices, 0, -32);

$servername = "localhost";
$username = "root";
$password = "";
$db = 'forexml';

// Create connection
$conn = new mysqli($servername, $username, $password, $db);

foreach($choices as $pair){

    // Only pull those with today's date
    $today = date("Y-m-d");
    echo "Today: " . $today . "<br>";

    // loop to get NewDate
    $datesql = "
    SELECT * FROM mysentiment
    WHERE Pair='$pair'
    ORDER BY DateTime DESC
    LIMIT 1
    ";

    if ($result = $conn->query($datesql)) {
        /* fetch associative array */
        while ($row = $result->fetch_assoc()) {
            $NewDate = date('Y-m-d',strtotime($row['DateTime']));
            echo "NewDate: " . $today . "<br>";
        }

        if($NewDate==$today){
            $sql = "
            UPDATE mysentiment
            SET SortRank='100'
            WHERE Pair='$pair'
            ";

            if ($conn->query($sql) === TRUE) {
                echo "";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
            }
        }
        else {
            echo $NewDate . " != " . $today . "<br>";
        }
    }
    else {
        echo "Error: " . $datesql . "<br>" . $conn->error . "<br>";
    }
}

    $conn->close();
?>
