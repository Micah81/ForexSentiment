<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="en">
<!--<![endif]-->

<head>

    <!-- Basic Page Needs
  ================================================== -->
    <meta charset="utf-8">
    <title>Chart Rank</title>

    <!-- Mobile Specific Metas
  ================================================== -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- PT Sans -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,300,600&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>

    <!-- CSS
  ================================================== -->
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/skeleton.css">


    <!-- JS
  ================================================== -->
    <script src="js/jquery.min.js" type="text/javascript"></script>
    <script src="js/jquery.ui.js" type="text/javascript"></script>

    <!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

</head>

<body>

    <section>
        <div class="container">

            <button class="save">Update Charts Rank</button>
            <div id="response"></div>

            <ul class="sortable">
                <?php

				/*
				* Connect to Your database
				*/
				include( 'db_connection.php' );

                $date = date("Y-m-d");

                $select = "
                SELECT * FROM $db_table
                WHERE
                Date = '$date' AND
                (Vote = 'Up5' OR Vote = 'Dn5')
                ";

				echo mysqli_error($connection);
				$perform = mysqli_query($connection, $select ); //perform selection query
				echo mysqli_error($connection);

				 while( $array = @mysqli_fetch_array( $perform ) ){ //download every row into array
                    $id = $array['id']; $time = time();
                    $photo_name = $array['Pair'] . "_1440.gif-cropped.png"  . "?" . time();
                    ?>

                    <li id='item-<?php echo $id ?>'><img src="<?php echo $photo_name ?>" alt=""></li>

                    <?php
                  }

				?>

            </ul>

        </div>
    </section>

    <script type="text/javascript">
        var ul_sortable = $('.sortable'); //setup one variable for sortable holder that will be used in few places


        /*
         * jQuery UI Sortable setup
         */
        ul_sortable.sortable({
            revert: 100,
            placeholder: 'placeholder'
        });
        ul_sortable.disableSelection();



        /*
         * Saving and displaying serialized data
         */
        var btn_save = $('button.save'), // select save button
            div_response = $('#response'); // response div



        btn_save.on('click', function (e) { // trigger function on save button click
            e.preventDefault();

            var sortable_data = ul_sortable.sortable('serialize'); // serialize data from ul#sortable

            div_response.text('Saving... please wait'); //setup response information


            $.ajax({ //aja
                data: sortable_data,
                type: 'POST',
                url: 'save.php', // save.php - file with database update
                success: function (result) {
                    div_response.text('Chart Rank Updated');
                }
            });

        });
    </script>
    <br>
    <br>
    <a href='http://flexmail.me/dailyarrows/mysentiment/chartrankresults.php'>View Results<l</a>
</body>

</html>
