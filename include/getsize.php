<?php
function GetSize ($sizeb) {
		  $sizekb = $sizeb / 1024;
		  $sizemb = $sizekb / 1024;
		  $sizegb = $sizemb / 1024;
		  $sizetb = $sizegb / 1024;
		  $sizepb = $sizetb / 1024;
		  if ($sizeb > 1) {$size = round($sizeb,2) . " B";}
		  if ($sizekb > 1) {$size = round($sizekb,2) . " KB";}
		  if ($sizemb > 1) {$size = round($sizemb,2) . " MB";}
		  if ($sizegb > 1) {$size = round($sizegb,2) . " GB";}
		  if ($sizetb > 1) {$size = round($sizetb,2) . " TB";}
		  if ($sizepb > 1) {$size = round($sizepb,2) . " PB";}
		  return $size;
}	 
?>
