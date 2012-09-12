<?php 
header( "Content-type: image/png" );
$im=ImageCreate(460,460);
ImageColorAllocate($im, 0, 0, 0);
$graph=ImageColorAllocate($im,8,36,91);
$bg=ImageColorAllocate($im,214,235,255);
$red=ImageColorAllocate($im, 255, 0, 0);
$green=ImageColorAllocate($im, 0, 255, 0);
$blue=ImageColorAllocate($im, 0, 0, 255);
$yellow=ImageColorAllocate($im, 255, 255, 0);
$cyan=ImageColorAllocate($im, 0, 255, 255);
$white=ImageColorAllocate($im,255,255,255);
$jade=ImageColorAllocate($im,55,187,157);
$pink=ImageColorAllocate($im,255,0,128);
$blue_sea=ImageColorAllocate($im,125,128,64);
$col_1=ImageColorAllocate($im,0,165,244);
$col_2=ImageColorAllocate($im,0,147,244);
$col_3=ImageColorAllocate($im,0,130,191);
$col_4=ImageColorAllocate($im,0,115,170);
$col_5=ImageColorAllocate($im,0,98,145);
$col_6=ImageColorAllocate($im,0,81,119);
$col_7=ImageColorAllocate($im,0,63,94);
//$col_8=ImageColorAllocate($im,128,128,192);
$col_8=ImageColorAllocate($im,0,48,70);

$violate=ImageColorAllocate($im,255,102,225);
ImageFill($im, 0, 0, $white);
ImageLine($im,11,30,11,451,$red);

// Grade S
$text_a='S';
ImageString($im,2,40,440, $text_a, $blue);
ImageFilledRectangle($im,30,440,50,440,$blue);
//ImageString($im,2,40,440, $text_a, $col_8);
//ImageFilledRectangle($im,30,440,50,440,$col_8);

// Grade U
$text_bb='U';
ImageString($im,2,120,440, $text_bb, $red);
ImageFilledRectangle($im,110,440,130,440,$red);
//ImageString($im,2,120,440, $text_bb, $col_6);
//ImageFilledRectangle($im,110,440,130,440,$col_6);



ImageLine($im,0,440,390,440,$red);

$text_x='Grade';
ImageString($im,2,391,440, $text_x, $red);
$text_y='Student';
ImageString($im,2,0,0, $text_y, $red);
$text_0='0';
ImageString($im,2,1,438, $text_0, $red);

$rec_num = $max_num;
$percen=400 / $rec_num;
while ($in_num<$rec_num) {
$in_rec_num=$in_rec_num + 1;
$pos_y = 0;
$in_num = $in_num+1;
$pos_y   = ($in_num * $percen);
$pos_y = 450 - $pos_y;
ImageString($im,1,1,$pos_y, $in_num, $red);
ImageLine($im,10,$pos_y,15,$pos_y,$red);
if ($num_aa <> 0) {
if ($num_aa == $in_num ) {
ImageFilledRectangle($im,30,$pos_y,50,440,$blue);
//ImageFilledRectangle($im,30,$pos_y,50,440,$col_8);

$x_aa	=	30;
$y_aa = $pos_y;
}
} 
if ($num_bb <> 0) {
if ($num_bb == $in_num ) {
ImageFilledRectangle($im,110,$pos_y,130,440,$red);
//ImageFilledRectangle($im,110,$pos_y,130,440,$col_6);
$x_bb	=	110;
$y_bb = $pos_y;
}
} 
}


ImagePNG($im);
ImageDestroy($im);  
?>
