<?
if (isset($_GET['show']))
	{
	// подключаем библиотеку
	include ('jpgraph/jpgraph.php');
	include ('jpgraph/jpgraph_line.php' );
	// Создаем график размером 460х180
	$graph  = new Graph(460, 180,"auto");
	// устанавливаем фон или дефолтный или тот который передали через URL
	if (isset($_GET['bgcolor'])) $color_bg = $_GET['bgcolor']; else $color_bg = '#FFF5C3';
	// Устанавливаем параметры области прорисовки графика
	// цвет
	$graph->SetMarginColor($color_bg);
	// тип графика
	$graph->SetScale("textlin");
	// цвет рамки
	$graph->SetFrameBevel(0,false,$color_bg);
	// отступы с краев
	$graph->SetMargin(45,10,20,42);
	// получаем данные из базы данных
	// таблица: id,date,dollar,euro

	$pilot = $dollars = $euros = array();
	$dollars[] = {1,2,3,4,5,10};
	$euros[] = {2,3,4,5};
	// доп. настройки осей
	$graph->yaxis->HideZeroLabel();
	$graph->ygrid->SetFill(true,'#EFEFEF@0.5','#BBCCFF@0.5');
	$graph->xgrid->Show();
	//USD - создаем график для доллара
	// подготавливаем данные
	$dollars = array_reverse($dollars);
	// создаем график
	$lineplot =new LinePlot($dollars);
	//цвет
	$lineplot ->SetColor("blue");
	// ширина линии
	$lineplot ->SetWeight(2);
	// устанавливаем легенду
	$lineplot->SetLegend('USD');
	//EURO -  создаем график для евро все по аналогии с долларом
	$euros = array_reverse($euros);
	$lineplot2 =new LinePlot($euros);
	$lineplot2 ->SetColor("red");
	$lineplot2 ->SetWeight(2);
	$lineplot2->SetLegend('EUR');
	// добавляем на поле графика эти две "ломаные линии"
	$graph->Add( $lineplot);
	$graph->Add( $lineplot2);
	// устанавливаем параметры легенды (позиции и цвет)
	// тут создаем тень, красного цвета, с прозрачностью 90% и шириной 1
	$graph->legend->SetShadow('red@0.9',1);
	// позиционируем (координаты от 0 до 1)
	$graph->legend->SetPos(0.091,0.031,'left','top');
	// тут подготавливаем данные меток по оси Х
	$pilot = array_reverse($pilot);
	// настраиваем данные и поворачиваем на 90 градусов тексты
	$graph->xaxis->SetTickLabels($pilot);
	$graph->xaxis->SetLabelAngle(90);
	// по оси Y выставляем формат вывода чисел 35.00
	$graph->yaxis->SetLabelFormat('%0.2f');
	// график на вывод
	$graph->Stroke();
	exit;
	}
echo '<img src="graph.php?show"  border=0 align=center width=460 height=180>';
?>