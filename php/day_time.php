<?php
	include("DBClass.php");
	$objDB = new DBClass();

	//$date = $_POST['date'];
	$GPSset = array();
	$sumGPS = 0;


	//$sql = "select sum(hour) as total from taxi_hour_time where carno='".$_GET[find_carno]."' and time >= '".$_GET[pre_time]."' and time < '".$_GET[now_time]."' order by recordid";
	$sql = "select carno, sum(hour) as total from taxi_hour_time where  time >= '".$_GET[pre_time]."'  group by carno order by total desc";
	//$sql = "select t.carno, t.total from (select carno, sum(hour) as total from taxi_hour_time where  time >= '".$_GET[pre_time]."'  group by carno) as t where  t.total > 0  order by t.total desc";
	$rs1 = $objDB->Recordset($sql);
	$row1 = $objDB->GetRows($rs1);
	$dataCount1 = $objDB->RecordCount($rs1);

	$sql = "select sum(hour) as total from taxi_hour_time where  time >= '".$_GET[pre_time]."'";
	$rs2 = $objDB->Recordset($sql);
	$row2 = $objDB->GetRows($rs2);
	$dataCount2 = $objDB->RecordCount($rs2);

	$sql = "select carno, sum(hour) as total from taxi_hour_time where  time >= '".$_GET[pre_time]."' group by carno ";
	$rs3 = $objDB->Recordset($sql);
	$row3 = $objDB->GetRows($rs3);
	$dataCount3 = $objDB->RecordCount($rs3);

	
	for($i=0; $i<$dataCount1; $i++)
	{
		if (strcmp($row1[$i]['carno'], $_GET[find_carno]) == 0)	{
			$GPSset[$sumGPS] = array($row1[$i]['total'], bcdiv($row2[0]['total'], $dataCount3, 2), $i+1);
			break;
		}
		if ($i == ($dataCount1 - 1))	{
			$GPSset[$sumGPS] = array(0, bcdiv($row2[0]['total'], $dataCount3, 2), $i+1);
		}
	}


	echo json_encode($GPSset);

?>


