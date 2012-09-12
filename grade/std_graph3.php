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

// Grade A
$text_a='A';
ImageString($im,2,40,440, $text_a, $pink);
ImageFilledRectangle($im,30,440,50,440,$pink);
//ImageString($im,2,40,440, $text_a, $col_8);
//ImageFilledRectangle($im,30,440,50,440,$col_8);

// Grade B
$text_bb='B';
ImageString($im,2,120,440, $text_bb, $blue_sea);
ImageFilledRectangle($im,110,440,130,440,$blue_sea);
//ImageString($im,2,120,440, $text_bb, $col_6);
//ImageFilledRectangle($im,110,440,130,440,$col_6);

// Grade C
$text_cc='C';
ImageString($im,2,200,440, $text_cc, $violate);
ImageFilledRectangle($im,190,440,210,440,$violate);
//ImageString($im,2,200,440, $text_cc, $col_4);
//ImageFilledRectangle($im,190,440,210,440,$col_4);

// Grade D
$text_dd='D';
ImageString($im,2,280,440, $text_dd, $green);
ImageFilledRectangle($im,270,440,290,440,$green);
//ImageString($im,2,280,440, $text_dd, $col_2);
//ImageFilledRectangle($im,270,440,290,440,$col_2);

// Grade F
$text_ff='F';
ImageString($im,2,320,440, $text_ff, $red);
ImageFilledRectangle($im,310,440,330,440,$red);
//ImageString($im,2,320,440, $text_ff, $col_1);
//ImageFilledRectangle($im,310,440,330,440,$col_1);

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
ImageFilledRectangle($im,30,$pos_y,50,440,$pink);
//ImageFilledRectangle($im,30,$pos_y,50,440,$col_8);

$x_aa	=	30;
$y_aa = $pos_y;
												}
									} 
/*
if ($num_ba <> 0) {
if ($num_ba == $in_num ) {
ImageFilledRectangle($im,70,$pos_y,90,440,$jade);
//ImageFilledRectangle($im,70,$pos_y,90,440,$col_7);
$x_ba	=	70;
$y_ba = $pos_y;


												}
									} 
*/									
if ($num_bb <> 0) {
if ($num_bb == $in_num ) {
ImageFilledRectangle($im,110,$pos_y,130,440,$blue_sea);
//ImageFilledRectangle($im,110,$pos_y,130,440,$col_6);

$x_bb	=	110;
$y_bb = $pos_y;
												}
									} 
/*									
if ($num_ca <> 0) {
if ($num_ca == $in_num ) {
ImageFilledRectangle($im,150,$pos_y,170,440,$yellow);
//ImageFilledRectangle($im,150,$pos_y,170,440,$col_5);

$x_ca	=	150;
$y_ca = $pos_y;

												}
									} 									
*/									
if ($num_cc <> 0) {
if ($num_cc == $in_num ) {
ImageFilledRectangle($im,190,$pos_y,210,440,$violate);
//ImageFilledRectangle($im,190,$pos_y,210,440,$col_4);
$x_cc	=	190;
$y_cc = $pos_y;
												}
									}
/*									
if ($num_da <> 0) {
if ($num_da == $in_num ) {
ImageFilledRectangle($im,230,$pos_y,250,440,$blue);
//ImageFilledRectangle($im,230,$pos_y,250,440,$col_3);
$x_da	=	230;
$y_da = $pos_y;
												}
									} 																											
*/									
if ($num_dd <> 0) {
if ($num_dd == $in_num ) {
ImageFilledRectangle($im,270,$pos_y,290,440,$green);
//ImageFilledRectangle($im,270,$pos_y,290,440,$col_2);
$x_dd	=	270;
$y_dd = $pos_y;
												}
									} 																																				
if ($num_ff <> 0) {
if ($num_ff == $in_num ) {
ImageFilledRectangle($im,310,$pos_y,330,440,$red);
//ImageFilledRectangle($im,310,$pos_y,330,440,$col_1);

												}
									} 																																													 																		
}






ImagePNG($im);
ImageDestroy($im);  
?>
