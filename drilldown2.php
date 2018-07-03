<?php
if(!isset($_POST['radio'])){ // first run of the game
    // pull all the 5's generated today
    $dbhost="localhost";
    $dblogin="root";
    $dbpwd="";
    $dbname="forexml";

    $con=mysqli_connect($dbhost,$dblogin,$dbpwd,$dbname);
    // Check connection
    if (mysqli_connect_errno())
      {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
      }

    $sql=   "SELECT * FROM mysentiment
            WHERE (Vote = 'Up5')
            OR (Vote = 'Dn5')
            ORDER BY `Pair` ASC";

    $result=mysqli_query($con,$sql);
    $t=0;$p=0;$fives[][] = array();
    $HaveScore[][] = array();
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
    {
        // put them into array with score 0.  array[1][0]
        $today = date("Y-m-d"); //echo $today . " .....  ";
        $DT = date('Y-m-d',strtotime($row['DateTime'])); //echo $DT . "<br>";

        if ($DT == $today)
            {
            $fives[$t][$p] = $row['Pair'];
            $p++;
            $fives[$t][$p] = 0;
            $t++; $p=0;
        }
    }

    shuffle($fives);
    $max = sizeof($fives);
    $nextChart2=0;
    $match=1;
}

else { // not the first run of the game
    $fives = $_POST['fives2'];
    $max = sizeof($fives);

    // increase its score
    $pair2 = substr($_POST['radio'], 0, -32); //echo "pair2: " . $pair2 . "<br>";
    $key = array_search($pair2, array_column($fives, 0)); //echo "<br>1-key: " . $key . "<br>"; echo "2-fives[key][1] : " . $fives[$key][1] . "<br>";
    $fives[$key][1] = $fives[$key][1] + 1; //echo "fives[key][1] : " . $fives[$key][1] . "<br>";
    //print_r($fives);

    // show two different charts
    $nextChart2 = $_POST['nextChart']; // index of next chart in array
}
$Match1Part1Over = 0;

// compare them like 0,1,2,3

if($max % 2 == 0){
    //its divisible by 2
    $matches = $max/2;
}
else {
    // not div by 2
    $matches = (($max-1) / 2)+1;
}


    // display the charts with a form
    if($nextChart2<$max-1){
    $ChartName1 = $fives[$nextChart2][0] . "_1440.gif-cropped.png?" . time();
    $ChartScore1 = $fives[$nextChart2][1];
        echo "ChartName1: " . $ChartName1 . "; ChartScore1: " . $ChartScore1 . "<br>";
    }
    else {
        echo "Match1 Part1 Over!<br><br>";
        $Match1Part1Over = 1;

        // Display the results
        print_r($fives);

        // Begin Match 1, Part 2

        // for each element in $fives, if they have a score of 1, push them into $HaveScore
        $w4 = (sizeof($fives))-1; $x=0;
        while($w4 >= 0){
            if($fives[$w4][1]==1){
                //array_push($HaveScore[$w][0], $fives[$w][0]);
                $HaveScore[$x][0] = $fives[$w4][0];
                $HaveScore[$x][1] = 0;
                $x++;
            }
            $w4--;
        }
        echo "<br><br>HaveScore= "; print_r($HaveScore);

        // if they all have a score of 0,
        $e = (sizeof($HaveScore))-1; $Not0=0;
        while($e >= 0){
            if ($HaveScore[$e][1] != 0){
                 $Not0++;
            }
            $e--;
        }

        // compare the first 2.
        if($Not0==0){

        }

        // else, compare the one with the highest score to one that has the min score
        else {

        }

        // until they have each been compared once.

    }

    if($nextChart2<$max-1){
        $nextChart2++;
        $ChartName2 = $fives[$nextChart2][0] . "_1440.gif-cropped.png?" . time();
        $ChartScore2 = $fives[$nextChart2][1];
        echo "ChartName2: " . $ChartName2 . "; ChartScore2: " . $ChartScore2 . "<br>";
    }
    else {
        // Randomly select a chart that has a score of 0
        $zeros = array();
        $nmax = sizeof($fives);
        $m=0;

        while($m < ($nmax-1)){
            if ($fives[$m][1]==0){
                array_push($zeros, $fives[$m][0]);
            }
            $m++;
        }
        shuffle($zeros);
        $ChartName2 = $zeros[0] . "_1440.gif-cropped.png?" . time();
    }

if($Match1Part1Over==0){
    echo "
    <table style='width:100%'>
    <tr>
    <td align='center'>
    <img src='$ChartName1' style='width:80%;height:80%;'></img>
    </td>
    <td align='center'>
    <img src='$ChartName2' style='width:80%;height:80%;'></img>
    </td>
    </tr>
    <tr>
    <form action='' method='post'>";

    $r=0;
    while($r<=($max-1)){
        $var1 = $fives[$r][0];
        $var2 = $fives[$r][1];
        echo "<input type='hidden' name='fives2[$r][0]' value='$var1'>";
        echo "<input type='hidden' name='fives2[$r][1]' value='$var2'>";
        $r++;
    }

    $nextChart2++;
    echo "<input type='hidden' name='nextChart' value='$nextChart2'>";

    echo "<center>
    <h3>Which chart looks like the easier trade?</h3>
    Left Chart
    <input type='radio' name='radio' value='$ChartName1'>
    &nbsp;&nbsp;
    Right Chart
    <input type='radio' name='radio' value='$ChartName2'>
    &nbsp;&nbsp;&nbsp;
    <input type='submit' name='submit' value='Next' /></center><br>
    </form>";

    echo "
    </tr></table>";
}


?>
