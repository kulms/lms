<?php
include ("../lib/jpgraph/jpgraph.php");
include ("../lib/jpgraph/jpgraph_pie.php");
include ("../lib/jpgraph/jpgraph_pie3d.php");


$notdo = $all-$do;

$data = array($notdo,$do);
$legend = array(Dropout,Completion);

$graph = new PieGraph(450,150,"auto");
//$graph->SetShadow();

//$graph->title->Set("A simple Pie plot");
$graph->title->SetFont(FF_FONT1,FS_BOLD);

$p1 = new PiePlot3D($data);
$p1->SetSize(0.5);
$p1->SetCenter(0.40);

// Label format 
// Option 1 'percentage' 
//$p1->value->SetFormat("%01.1f%%"); 
//$p1->SetLegends(array("May (%1.1f%%)","June (%1.1f%%)","July (%1.1f%%)","Aug (%1.1f%%)","Sep (%1.1f%%)","Oct (%1.1f%%)")); 

// Option 2 
// If you need the absolute values then uncomment the following lines 
$p1->SetLabelType(PIE_VALUE_ABS); 
$p1->value->SetFormat("%d persons"); 
//$p1->SetLegends(array("May ($%d)","June ($%d)","July ($%d)","Aug ($%d)","Sep ($%d)","Oct ($%d)")); 


$p1->SetLegends($legend);
$p1->SetSliceColors(array('#C2DFFF','blue','#FBB917','#59E817','#C2DFFF'));    //#C2DFFF


//$graph->legend->SetColor('blue');
$graph->legend->Pos(0.03,0.35); 

$graph->Add($p1);
$graph->Stroke();




?>


