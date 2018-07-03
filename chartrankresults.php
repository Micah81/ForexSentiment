<html>

<head>

    <title>Chart Rank Results</title>

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

   $date = date("Y-m-d");

    $select = "
    SELECT * FROM $table
    WHERE
    Date = '$date' AND
    (Vote = 'Up5' OR Vote = 'Dn5')
    ORDER BY SortRank ASC
    ";

    $perform = mysqli_query($conn, $select );

    echo "
    <table style='width:100%'>

    ";

foreach($perform as $row){

    $vote = $row['Vote'];
    $currency = $row['Pair']; $time = time();
    $imgsrc = $row['Pair'] . "_1440.gif-cropped.png"  . "?" . time();
    $SortRank = $row['SortRank'];

    echo "
    <tr>
    <td>
    <img src='$imgsrc'></img><br>
     </td>
     ";

    echo "
    <td>
    Rank: $SortRank <br>
    Pair: $currency <br>
    Vote: $vote
    </td>
    </tr>
    ";

}
    echo "

    </table>";

?>

</body>

</html>
