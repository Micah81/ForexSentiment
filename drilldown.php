<?php

// pull all the 5's generated today
// put them into array with score 0.  array[1][0]
// scramble the array
// show chart for array[0] and array[1]. I select one.
// The selected chart is updated as: array[1][n+1] to indicate it won, and in what order
// That ends a round.
// In the next round, compare them again, but don't use the one that was selected.
// Eventually there will be only one without a win. Give it a win as [n+1] so that it's ranked last.
// Display the list of all the 5's generated today, now listed in their new order.

//              ----- updated order of tasks

// pull all the 5's generated today

// put them into array with score 0.  array[1][0]

// scramble the array

// If there is more than one var array[][] without a win,

    // Right here, it needs to gor through a round of multiple matches.
        // For each one that is not a win, compare each to a particular one: t++; // each instance is a "match"
        // After doing all of them for that [t++], go to the next via t++; // each instance is a "round"

    // The selected chart is updated as: array[1][n+1] to indicate it won, and in what order

// Else

    // Eventually there will be only one without a win. Give it a win as [n+1] so that it's ranked last.

    // Display the list of all the 5's generated today, now listed in their new order.
// -------------------------------------------------- CODING BEGINS ---------------------------
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
//var_dump($fives);
$nextChart2=0;
// scramble the array
shuffle($fives);
$max = sizeof($fives);
}






else { // not the first run of the game... has variables to review

    $fives = $_POST['fives2'];
    $max = sizeof($fives);
    // increase its score
    $pair2 = substr($_POST['radio'], 0, -21);
    $key = array_search($pair2, array_column($fives, 0));
    $fives[$key][1] = $fives[$key][1] + 1;

    //

    // show two different charts
    $nextChart2 = $_POST['nextChart']; // index of next chart in array


}





// RUNS THIS EVERY TIME ...






    // If there is more than one var array[][] without a win,
$no_wins = 0;
for ($row = 0; $row < $max; $row++) {
    if($fives[$row][1]==0) {
         $no_wins++;
        //echo $fives[$row][0] . '   ';
         //echo $fives[$row][1] . '<br />';
    }
}

if($no_wins == 0){
        // Display the list of all the 5's generated today, now listed in their new order.
        echo "test";
    }

if ($no_wins == 1){}

$l=0;
if ($no_wins >= 2){
    while($l <= 1 && $nextChart2 <= ($max-1)  )
            {

            // display the charts with a form
            $ChartName1 = $fives[$nextChart2][0] . "_1440.gif-cropped.png";
            $ChartScore1 = $fives[$nextChart2][1];
            $l++;
            $nextChart2++;

        if ($nextChart2 <= ($max-1)){
            $ChartName2 = $fives[$nextChart2][0] . "_1440.gif-cropped.png";
            $ChartScore2 = $fives[$nextChart2][1];

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

            $pair3 = substr($ChartName2, 0, -21);
            $num = array_search($pair3, array_column($fives, 0));
            $num++;
            echo "<input type='hidden' name='nextChart' value='$num'>";

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

            $l++;
        }

        else {
             echo "find the two that don't have a score, and compare them.";
        }

        }
    }


    elseif($nextChart2 > ($max-1)){
            echo "what is this?";
    }


    else
        {
        // Eventually there will be only one without a win. Give it a win as [n+1] so that it's ranked last.

        // how many nowins are there there? if 2 ...
        if ($no_wins == 2){
            echo "There are 2 without wins, so compare those two.";

        }

    }




?>
