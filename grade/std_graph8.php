<?php
header("Content-type: image/png");
$img = ImageCreate(460, 460);           
ImageColorAllocate($img, 255, 255, 255); 

$degrees = array();      
$diameter = 300;         
$radius = $diameter / 2; 
$sum= $num_aa + $num_bb;
for ($i=1; $i<=2; $i++) {
  if ($i=1) {
  $degrees[$i] = $num_aa / $sum * 360 ;
  }
  if ($i=2) {
  $degrees[$i] = $num_bb / $sum * 360 ;
  }
} 


$bg=ImageColorAllocate($img,214,235,255);
$pink=ImageColorAllocate($img,255,0,128);
$red = ImageColorAllocate($img, 255, 0, 0);
$blue = ImageColorAllocate($img, 0, 0, 255);
$green = ImageColorAllocate($img, 0, 255, 0);
$yellow = ImageColorAllocate($img, 255, 255, 0);
//$black = ImageColorAllocate($img, 166, 174, 198);
$black = ImageColorAllocate($img, 0, 0, 0);
$bluelight = ImageColorAllocate($img, 0, 255, 255);
$violet = ImageColorAllocate($img, 255, 0, 255);
$darkgreen = ImageColorAllocate($img,0, 51, 51);
$orange = ImageColorAllocate($img,255, 163, 0);
$cyan=ImageColorAllocate($img, 0, 255, 255);
$white=ImageColorAllocate($img,255,255,255);
$jade=ImageColorAllocate($img,55,187,157);
$blue_sea=ImageColorAllocate($img,125,128,64);

$col_1=ImageColorAllocate($img,0,165,244);
$col_2=ImageColorAllocate($img,0,147,244);
$col_3=ImageColorAllocate($img,0,130,191);
$col_4=ImageColorAllocate($img,0,115,170);
$col_5=ImageColorAllocate($img,0,98,145);
$col_6=ImageColorAllocate($img,0,81,119);
$col_7=ImageColorAllocate($img,0,63,94);
$col_8=ImageColorAllocate($img,0,48,70);

$arrColor = array($blue, $red, $black);
//$arrColor = array($col_1, $col_2, $col_3,$col_4,$col_5,$col_6,$col_7,$col_8,$black);

$last_angle = 0;      

for ($i=1; $i<=2; $i++) {
  ImageArc($img, 150, 150, $diameter, $diameter, $last_angle,
    ($last_angle + $degrees[$i]), $red);
  $last_angle += $degrees[$i];
  $end_x = round(150 + ($radius * cos($last_angle * pi() / 180)));
  $end_y = round(150 + ($radius * sin($last_angle * pi() / 180)));
  ImageLine($img, 150, 150, $end_x, $end_y, $red);
}

$prev_angle = 0;
$pointer = 0;
for ($i=1; $i<=2; $i++) {
  $pointer = $prev_angle + $degrees[$i];
  $this_angle = ($prev_angle + $pointer) / 2;
  $prev_angle = $pointer; 
  $end_x = round(150 + ($radius * cos($this_angle * pi() / 180)));
  $end_y = round(150 + ($radius * sin($this_angle * pi() / 180))); 
  $mid_x = round((150 + ($end_x)) / 2);
  $mid_y = round((150 + ($end_y)) / 2); 

  ImageFill($img, $mid_x, $mid_y, $arrColor[$i - 1]);
  
  if ($i==1) {
  	if ($num_aa!=0) {
  		ImageString($img,2,$mid_x-10,$mid_y, 'S : '. $num_aa, $black);
  	}
  }
  
  if ($i==2) {
  	if ($num_bb!=0) {
  		ImageString($img,2,$mid_x-10,$mid_y, 'U : '. $num_bb, $black);
  	}
  }
}
ImageFill($img, 0, 0, $white);
ImageFill($img, 0, 400, $white);
ImagePNG($img);
ImageDestroy($img);
?>
