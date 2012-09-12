// Drop Bown Menu - Head Script
// copyright Stephen Chapman, 4th March 2005
// you may copy this menu provided that you retain the copyright notice

var bar = new menuBar();
bar.addMenu('t_index2.php',' หน้าแรก ');
bar.addItem('','');
bar.addMenu('',' ผลการสำรวจรูปแบบการเรียนรู้ ');
bar.addItem('res_person.php',' - รายบุคคล');
bar.addItem('res_all.php',' - ภาพรวม');
bar.addMenu('check_std.php',' ตรวจสอบรายชื่อผู้ที่ไม่ได้ทำแบบสำรวจ ');
bar.addItem('','');
bar.addMenu('explanation.php',' Help');
bar.addItem('','');
// do not change anything below this line

var  already_point= '';
var point= '';
var char_afterp= '#FB6767';
var char_before= '#cc3300';

var blc = already_point; var blh =char_afterp; var bla = point;var lc = char_afterp;var lh = '#000000';var la = char_before;

function menuBar() {this.jj = -1;this.kk = 0;this.mO = new Array();
	this.addMenu = addMenu;
	this.addItem = addItem;
	this.writeBar = writeBar;
	this.writeDrop = writeDrop; 
}
function addMenu(mlink,main) {
	this.mO[++this.jj] = new Object();
	this.mO[this.jj].mlink = mlink;  // alert(this.mO[this.jj].mlink);
	this.mO[this.jj].main = main;
	this.kk = 0;       
	this.mO[this.jj].link = new Array();  
	this.mO[this.jj].name = new Array();
	}
	
function addItem(link,name) {
		if(name!=null){
					this.mO[this.jj].link[this.kk] = link;
					this.mO[this.jj].name[this.kk++] = name;
				}
}
		
function writeBar() {
		for (var i=1;i <= this.mO.length; i++){ 
			if(this.mO[i-1].mlink =='')  document.write('<span id="navMenu'+i+'" class="bblack"> '+this.mO[i-1].main+' <\/span>');
			else document.write(' <a href="'+this.mO[i-1].mlink+'"><span id="navMenu'+i+'" class="bblack"> '+this.mO[i-1].main+' <\/span><\/a>');
		if(i != this.mO.length) document.write('<span  id="navMenu'+i+'" class="bblack">|<\/span>');
		
		}
	}

function writeDrop() {
	for (var i=1;i <= this.mO.length; i++){ 
		document.write('<div id="dropMenu'+i+'" class="mD">\r\n');
		for (var h=0;h < this.mO[i-1].link.length; h++){
			if(this.mO[i-1].link[h] !=''){
				document.write('<table width="120" height="20" border="0"  cellpadding="1" cellspacing="1" class="tdborder1" align="center">');
			 	document.write(' <tr bgcolor="#FFFFFF" ><td>');
				document.write('<a class="mL" href="'+this.mO[i-1].link[h]+'">'+this.mO[i-1].name[h]+'<\/a>\r\n'); 
				 document.write(' </td>');
				  document.write('</tr></table>');
				}
		 }
	document.write('<\/div>\r\n');     
	} 
}
			
//window.onscroll=sMenu;
window.onload=iMenu;var onm = null;var ponm = null;var podm = null;var ndm = bar.mO.length;
function posY() {return window.pageYOffset != null? window.pageYOffset: document.body.scrollTop != null? document.body.scrollTop:0;}
function sMenu() {document.getElementById('mB').style.top = posY() + 'px'; for (i=1; i<=ndm; i++) {menuName = 'dropMenu' + i;odm = document.getElementById(menuName); if (onm) {var yPos = onm.offsetParent.offsetTop + onm.offsetParent.offsetHeight;odm.style.top = yPos + 'px';}}}
function iMenu() {if (document.getElementById) {document.onclick = mHide; for (i=1; i<=ndm; i++) {menuName = 'dropMenu' + i; navName = 'navMenu' + i; odm = document.getElementById(menuName); onm = document.getElementById(navName); odm.style.visibility = 'hidden'; onm.onmouseover =  mHov; onm.onmouseout = mOut;} onm = null;} return;}
function  mHov(e) {document.onclick = null; honm = document.getElementById(this.id); if (honm != onm) {honm.style.color = lh; honm.style.backgroundColor = blh;} menuName = 'drop' + this.id.substring(3,this.id.length); odm = document.getElementById(menuName); if (podm == odm) {mHide(); return;} if (podm != null) mHide(); onm = document.getElementById(this.id); if ((ponm != onm ) || (podm == null)) {onm.style.color = la; onm.style.backgroundColor = bla;} if (odm) {xPos = onm.offsetParent.offsetLeft + onm.offsetLeft; yPos = onm.offsetParent.offsetTop + onm.offsetParent.offsetHeight; odm.style.left = xPos + 'px'; odm.style.top = yPos + 'px'; odm.style.visibility = 'visible'; podm = odm; ponm = onm;}}
function mOut(e) {document.onclick = mHide;oonm = document.getElementById(this.id); if (oonm != onm) {oonm.style.color = lc; oonm.style.backgroundColor = blc;}}
function mHide() {document.onclick = null; if (podm) {podm.style.visibility = 'hidden'; podm = null; ponm.style.color = lc; ponm.style.backgroundColor = blc;} onm = null;}
var ag = navigator.userAgent.toLowerCase();var isG = (ag.indexOf('gecko') != -1);var isR=0;if (isG) {t = ag.split('rv:'); isR = parseFloat(t[1]);}if ( isR) setInterval('sMenu()',50);