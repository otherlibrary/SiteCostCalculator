<?php
    include("Image/Graph.php");
    $Graph =& new Image_Graph(400, 300);
    $PlotArea =& $Graph->add(new Image_Graph_Plotarea());

    $DataSet =& new Image_Graph_Dataset_Trivial();    // create the dataset
    $DataSet->addPoint(1, 1);
    $DataSet->addPoint(1, 2);

    $Plot =& $PlotArea->addPlot(new Image_Graph_Plot_Bar_Horizontal($DataSet));

    $Plot->setLineColor(IMAGE_GRAPH_GRAY);

    $GREEN =& $Graph->newColor(IMAGE_GRAPH_GREEN, 100);

    $Plot->setFillStyle($GREEN);

    $Arial =& $Graph->addFont(new Image_Graph_Font_TTF("arial.ttf"));

    $Arial->setSize(11);

    $Graph->add(new Image_Graph_Title("Last calculated ratio", $Arial));

    $AxisX =& $PlotArea->getAxis(IMAGE_GRAPH_AXIS_X); 

    $AxisX->forceMinimum(0);

    $Graph->done();
?>
