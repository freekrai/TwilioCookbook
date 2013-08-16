<?php
include("config.php");
include("pdo.class.php");

include("Services/Highchart.php");

$chart = new Highchart();

$qid = $_GET['qid'];

$_SESSION['survey'] = $qid;	// we store the survey in session so we can retrieve it later

$pdo = Db::singleton();

$res = $pdo->query("SELECT * FROM survey WHERE ID='{$qid}'");
while( $row = $res->fetch() ){
	$answers = array();
	$ares = $pdo->query("SELECT * FROM responses WHERE question_id='{$row['id']}' and answer != ''");
	$total = $ares->rowCount();
	while( $ar = $ares->fetch() ){
		$k = $row[ 'answer'.$ar['answer'] ];
		$answers[ $k ]++;
	}
}
$qs = array();
$add = array();
foreach($answers as $k=>$c){
	$qs[] = $k;
	$add[] = $c;
}

$chart = new Highchart();
$chart->chart->renderTo = "container";
$chart->chart->type = "bar";
$chart->title->text = $row['question'];
$chart->subtitle->text = "";
$chart->xAxis->categories = $qs;
$chart->xAxis->title->text = null;
$chart->yAxis->min = 0;
$chart->yAxis->title->text = "Votes";
$chart->yAxis->title->align = "high";

$chart->tooltip->formatter = new HighchartJsExpr("function() {
    return '' + this.series.name +': '+ this.y;}");

$chart->plotOptions->bar->dataLabels->enabled = 1;
$chart->legend->enabled = false;
$chart->credits->enabled = false;

$chart->series[] = array('name' => "Votes",'data' => $add);
?>
<html>
	<head>
		<title><?=$row['question']?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
		foreach ($chart->getScripts() as $script) {
			echo '<script type="text/javascript" src="' . $script . '"></script>';
		}
?>
	</head>
	<body>
		<a href="survey-builder.php">Return to home</a> or <a href="survey-builder.php?action=build">Add new survey</a><hr />
		<div id="container"></div>
		<script type="text/javascript">
		<?php 	echo $chart->render("chart1");	?>
		</script>
	</body>
</html>