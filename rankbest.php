<?php
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
    $t=0;$p=0;
    $fives[][] = array();

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
?>
    <!doctype html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Rank Best Charts</title>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="/resources/demos/style.css">
        <style>
            #sortable {
                list-style-type: none;
                margin: 0;
                padding: 0;
                width: 1030px;
            }

            #sortable li {
                margin: 3px 3px 3px 0;
                padding: 5px;
                float: left;
                width: 225px;
                height: 225px;
                font-size: 4em;
                text-align: center;
            }
        </style>
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script>
            $(function () {
                $("#sortable").sortable({
                    placeholder: "ui-state-highlight",
                    update: function (event, ui) {
                        var sorted = $("#sortable").sortable("serialize", {
                            key: "sort"
                        });

                        btn_save.on('click', function (e) {
                            e.preventDefault();
                            var sortable_data = ul_sortable.sortable('serialize');

                            $.ajax({
                                data: sorted, //able_data,
                                type: 'POST',
                                url: 'rankbestprocess.php', // save.php - file with database update
                            });
                        });
                    }
                });
                $("#sortable").disableSelection();
            });
        </script>
    </head>

    <body>
        <button class="save">See Results</button>
        <ul id="sortable">

            <?php

            $x = (sizeof($fives))-1;

            while($x >= 0){
                $id = $fives[$x][0];
                $imgsrc = $fives[$x][0] . "_1440.gif-cropped.png?" . time();
                //echo $imgsrc."<br>";
                echo "<li class='ui-state-default' id='$id'>
                <img src='$imgsrc' style='width:100%;height:100%;'></img>
                </li><br>";
                $x--;
            }

              // echo "<br><br>"; print_r($fives);

            ?>

        </ul>


    </body>

    </html>
