<?
if (isset($_GET['show']))
	{
	// ���������� ����������
	include ('jpgraph/jpgraph.php');
	include ('jpgraph/jpgraph_line.php' );
	// ������� ������ �������� 460�180
	$graph  = new Graph(460, 180,"auto");
	// ������������� ��� ��� ��������� ��� ��� ������� �������� ����� URL
	if (isset($_GET['bgcolor'])) $color_bg = $_GET['bgcolor']; else $color_bg = '#FFF5C3';
	// ������������� ��������� ������� ���������� �������
	// ����
	$graph->SetMarginColor($color_bg);
	// ��� �������
	$graph->SetScale("textlin");
	// ���� �����
	$graph->SetFrameBevel(0,false,$color_bg);
	// ������� � �����
	$graph->SetMargin(45,10,20,42);
	// �������� ������ �� ���� ������
	// �������: id,date,dollar,euro

	$pilot = $dollars = $euros = array();
	$dollars[] = {1,2,3,4,5,10};
	$euros[] = {2,3,4,5};
	// ���. ��������� ����
	$graph->yaxis->HideZeroLabel();
	$graph->ygrid->SetFill(true,'#EFEFEF@0.5','#BBCCFF@0.5');
	$graph->xgrid->Show();
	//USD - ������� ������ ��� �������
	// �������������� ������
	$dollars = array_reverse($dollars);
	// ������� ������
	$lineplot =new LinePlot($dollars);
	//����
	$lineplot ->SetColor("blue");
	// ������ �����
	$lineplot ->SetWeight(2);
	// ������������� �������
	$lineplot->SetLegend('USD');
	//EURO -  ������� ������ ��� ���� ��� �� �������� � ��������
	$euros = array_reverse($euros);
	$lineplot2 =new LinePlot($euros);
	$lineplot2 ->SetColor("red");
	$lineplot2 ->SetWeight(2);
	$lineplot2->SetLegend('EUR');
	// ��������� �� ���� ������� ��� ��� "������� �����"
	$graph->Add( $lineplot);
	$graph->Add( $lineplot2);
	// ������������� ��������� ������� (������� � ����)
	// ��� ������� ����, �������� �����, � ������������� 90% � ������� 1
	$graph->legend->SetShadow('red@0.9',1);
	// ������������� (���������� �� 0 �� 1)
	$graph->legend->SetPos(0.091,0.031,'left','top');
	// ��� �������������� ������ ����� �� ��� �
	$pilot = array_reverse($pilot);
	// ����������� ������ � ������������ �� 90 �������� ������
	$graph->xaxis->SetTickLabels($pilot);
	$graph->xaxis->SetLabelAngle(90);
	// �� ��� Y ���������� ������ ������ ����� 35.00
	$graph->yaxis->SetLabelFormat('%0.2f');
	// ������ �� �����
	$graph->Stroke();
	exit;
	}
echo '<img src="graph.php?show"  border=0 align=center width=460 height=180>';
?>