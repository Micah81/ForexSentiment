<?php
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

$sql="SELECT * FROM `mysentiment` ORDER BY `Pair` ASC LIMIT 100";
$result=mysqli_query($con,$sql);
$row_cnt = $result->num_rows;
$row_cnt = $row_cnt-1;

$data[0] = array('Pair','Vote');//('DateTime','Pair','Vote');
$i=1;
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
  {
    // convert DateTime to just the date
    //$old_date_timestamp = strtotime($row['DateTime']);
    //$row['DateTime'] = date('m-d-Y', $old_date_timestamp);

    // edit Vote to be a number
    if($row['Vote']=='Unsure'){$row['Vote']=0;}
    else if ($row['Vote']=='Up1'){$row['Vote']=1;}
    else if ($row['Vote']=='Up2'){$row['Vote']=2;}
    else if ($row['Vote']=='Up3'){$row['Vote']=3;}
    else if ($row['Vote']=='Up4'){$row['Vote']=4;}
    else if ($row['Vote']=='Up5'){$row['Vote']=5;}
    else if ($row['Vote']=='Dn1'){$row['Vote']=-1;}
    else if ($row['Vote']=='Dn2'){$row['Vote']=-2;}
    else if ($row['Vote']=='Dn3'){$row['Vote']=-3;}
    else if ($row['Vote']=='Dn4'){$row['Vote']=-4;}
    else if ($row['Vote']=='Dn5'){$row['Vote']=-5;}

    //$data[$i] = array($row['DateTime'],$row['Pair'],$row['Vote']);
    $data[$i] = array($row['Pair'],$row['Vote']);
    $i++;
  }

echo json_encode($data);

// Free result set
mysqli_free_result($result);

mysqli_close($con);
?>
