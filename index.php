<html>

<head>

    <title>Monthly Trend Check</title>

    <!-- Mobile Specific Metas
  ================================================== -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- PT Sans -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,300,600&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>

    <!-- CSS
  ================================================== -->

    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/skeleton.css">

</head>

<body>
    <?php 
    include( 'dbconn.php' );
/////////////////////

if(!isset($_POST['radio'])){ // first run of the game
    $num = 0;

    $images = array ( glob("*_1440.gif") );

    $n = sizeof($images[0]);
    $n = $n-1;
    $randoms = array();
    while($n>=0)
    {
        $im = imagecreatefromgif($images[0][$n]);

        $size = min(imagesx($im), imagesy($im));
        $im2 = imagecrop($im, ['x' => 0, 'y' => 22, 'width' => 640, 'height' => 458]); // 640 x 480
        if ($im2 !== FALSE) {
            imagepng($im2, $images[0][$n] . '-cropped.png');
        }

        array_push($randoms,$n);

        $n--;
    }

    $images2 = array ( glob("*_1440.gif-cropped.png") );
    $nsize = sizeof($images2[0]);
    $nnsize = $nsize-1;
    $numbers = range(0, $nnsize);
    shuffle($numbers);
}
else {   // If this is not the first run
    $num = $_POST['nextChart']; // indexes to use inside ...
    $numbers = $_POST['randomArray']; // ... this array of indexes
    $images2 = array ( glob("*_1440.gif-cropped.png") );
    $nsize = sizeof($images2[0]);
    $Pair = $_POST['pair'];
    $num++;
     }


    $done = $num-1;
    $rem = $nsize-$num+1;
//if($done<=69){

    $done2 = $done+1;
if($done2<70){

    $im2 = $images2[0][$numbers[$num]];
    $im2 = $im2 . "?" . time();

    echo "
    <table style='width:100%'>
    <tr>
    <td>
    <img src='$im2'></img>
    </td>
    <td>
    <form action='' method='post'>";

    foreach ($numbers as $number)
        {
        echo "'<input type='hidden' name='randomArray[]' value='$number'>'";
        }



    echo "<input type='hidden' name='nextChart' value='$num'>";

        echo "<input type='hidden' name='pair' value='$im2'>";

        echo "
        <h3>What's the Trend?</h3>
        <br><br>
        <input type='radio' name='radio' value='TrendUp'>Up
        <br><br>
        <input type='radio' name='radio' value='TrendDn'>Down
        <br><br>
        <input type='radio' name='radio' value='TrendSideways'>Sideways
        <br><br>
        <input type='radio' name='radio' value='TrendUnsure' checked='checked'>Unsure
        <br><br>
        <input type='submit' name='submit' value='Next' />
        </form>";
}

///// Everything below is done every time it's run

        if (isset($_POST['submit'])) {
        if(isset($_POST['radio']))
            {
            //echo "You have selected :".$_POST['radio'];  //  Displaying Selected Value

            // on insert, put todays date like 01/01/17 YYYY-MM-DD
            $date = date("Y-m-d");

            if($done2<70){

                $sql = "INSERT INTO $table (Date, Pair, Vote)
                VALUES ( '$date', '$Pair', '$_POST[radio]')";

                if ($conn->query($sql) === TRUE) {
                    echo "Vote recorded. "; $num++;
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
                }

                $conn->close();
                     $rem2 = $rem-1;
                echo $done2 . ' done and ' . $rem2 . ' to go.';
            }
            else {
                $sql = "INSERT INTO $table (Date, Pair, Vote)
                VALUES ('$date', '$Pair', '$_POST[radio]')";

                if ($conn->query($sql) === TRUE) {
                    echo "Vote recorded. ";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
                }

                $conn->close();
                echo "Top charts selected. Now <a href='chartrank.php'>Rank the Best Charts</a>";
            }
            }  }

        echo "
        </td>
        </tr></table>";

?>

</body>

</html>
