
<html>
<head>
<!-- Meta -->
<meta name="author" content="ar3t4">
<meta name="generator" content="Macromedia DreamWeaver 8">
<meta name="description" content="locked was hare">
<meta name="keywords" content="The Art of Indonesian">
<!-- End Meta -->

<!-- Link -->
<link rel="shortcut icon" href="https://lh6.googleusercontent.com/-6R-amQCOkNM/UVkSlbq3UQI/AAAAAAAAAD8/bPA3KPfbYiM/s18/emoticon_cry.gif" type="image/x-icon">
<!-- End Link -->
</head>
<!-- Title -->
<title>[Locked-golou]</title>
<!-- End Title -->
<style
  type="text/css">body { background-image: 
url(); 
background-color:transparent; }</style>
<script>
TypingText = function(element, interval, cursor, finishedCallback) {
  if((typeof document.getElementById == "undefined") || (typeof element.innerHTML == "undefined")) {
    this.running = true;	// Never run.
    return;
  }
  this.element = element;
  this.finishedCallback = (finishedCallback ? finishedCallback : function() { return; });
  this.interval = (typeof interval == "undefined" ? 100 : interval);
  this.origText = this.element.innerHTML;
  this.unparsedOrigText = this.origText;
  this.cursor = (cursor ? cursor : "");
  this.currentText = "";
  this.currentChar = 0;
  this.element.typingText = this;
  if(this.element.id == "") this.element.id = "typingtext" + TypingText.currentIndex++;
  TypingText.all.push(this);
  this.running = false;
  this.inTag = false;
  this.tagBuffer = "";
  this.inHTMLEntity = false;
  this.HTMLEntityBuffer = "";
}
TypingText.all = new Array();
TypingText.currentIndex = 0;
TypingText.runAll = function() {
  for(var i = 0; i < TypingText.all.length; i++) TypingText.all[i].run();
}
TypingText.prototype.run = function() {
  if(this.running) return;
  if(typeof this.origText == "undefined") {
    setTimeout("document.getElementById('" + this.element.id + "').typingText.run()", this.interval);	// We haven't finished loading yet.  Have patience.
    return;
  }
  if(this.currentText == "") this.element.innerHTML = "";
//  this.origText = this.origText.replace(/<([^<])*>/, "");     // Strip HTML from text.
  if(this.currentChar < this.origText.length) {
    if(this.origText.charAt(this.currentChar) == "<" && !this.inTag) {
      this.tagBuffer = "<";
      this.inTag = true;
      this.currentChar++;
      this.run();
      return;
    } else if(this.origText.charAt(this.currentChar) == ">" && this.inTag) {
      this.tagBuffer += ">";
      this.inTag = false;
      this.currentText += this.tagBuffer;
      this.currentChar++;
      this.run();
      return;
    } else if(this.inTag) {
      this.tagBuffer += this.origText.charAt(this.currentChar);
      this.currentChar++;
      this.run();
      return;
    } else if(this.origText.charAt(this.currentChar) == "&" && !this.inHTMLEntity) {
      this.HTMLEntityBuffer = "&";
      this.inHTMLEntity = true;
      this.currentChar++;
      this.run();
      return;
    } else if(this.origText.charAt(this.currentChar) == ";" && this.inHTMLEntity) {
      this.HTMLEntityBuffer += ";";
      this.inHTMLEntity = false;
      this.currentText += this.HTMLEntityBuffer;
      this.currentChar++;
      this.run();
      return;
    } else if(this.inHTMLEntity) {
      this.HTMLEntityBuffer += this.origText.charAt(this.currentChar);
      this.currentChar++;
      this.run();
      return;
    } else {
      this.currentText += this.origText.charAt(this.currentChar);
    }
    this.element.innerHTML = this.currentText;
    this.element.innerHTML += (this.currentChar < this.origText.length - 1 ? (typeof this.cursor == "function" ? this.cursor(this.currentText) : this.cursor) : "");
    this.currentChar++;
    setTimeout("document.getElementById('" + this.element.id + "').typingText.run()", this.interval);
  } else {
	this.currentText = "";
	this.currentChar = 0;
        this.running = false;
        this.finishedCallback();
  }
}
</script>
<br>
<center>
<div id="example1"></div>
<pre style="color: red">
 +-+ +-+ +-+ +-+ +-+ +-+ +-+ +-+ +-+ +-+ +-+ +-+ +-+ +-+ +-+   +-+ +-+ +-+ +-+ +-+
 |L| |a| |n| |g| |k| |a| |h| |-| |L| |a| |n| |g| |k| |a| |h|   |K| |e| |c| |i| |l|
 +-+ +-+ +-+ +-+ +-+ +-+ +-+ +-+ +-+ +-+ +-+ +-+ +-+ +-+ +-+   +-+ +-+ +-+ +-+ +-+
<center><center>                                                                         
</center>
<pre>
<p id="example2">
Langkah-langkah kecil menjejak 
Berjinjit jinjit diatas telapak
Meniti ruang dan waktu seraya berharap
Di tempat putih ini kucoba menatap
<br>
Kamu...
<br>
Tersirat pemandangan hujan
Namun bukan disini tapi di tempat lain
Aku pindah begitu cepat
Sesuatu yang pasti kurindukan
<br>
Kalian....
<br>
Entah benar entah salah
Layaknya sudah jatuh talaq 
Jalan itu lurus tak bersimpangan
Tak sedikitpun ada keraguan didalam
<br>
Diriku.....
<br>
Mencari tempat disetiap hati
Mencari ruang disetiap sudut
Dengan pena kutulis kutulis KUGORES
Kutoreh dan takkan ku hapus
<br>
Kenangan......
<br>
Tersimpan dilangkah-langkah kecil
Terukir cerita yang selalu berkilau
Dimulai dengan langkah-langkah kecil
Ku berjalan ke muara hidupku....
<br>
                                                                                                         
                                       ##        ##                                                      
 #                                      #   #   # #                                                      
     #                                  #       #                       #                                
##  ###   ##          #### ##   ## ##   #  ##  ###   ##   ####    ###  ###   ## ##  ###  ## ##  ## #  ## 
 #   #   #             #  #  #   # #    #   #   #   #  #   #  #  #   #  #     # #  #   #  #  #   ##  #   
 #   #    #   #####    #  #  #   # #    #   #   #   ####   #  #  #   #  #     # #  #   #  #  #   #    #  
 #   #     #           #  #  #    #     #   #   #   #      #  #  #   #  #      #   #   #  #  #   #     # 
###   ## ##           ### ## ##   #    ### ### ###   ###  ### ##  ###    ##    #    ###    #### ###  ##  
                                # #                                          # #                         
                                ##                                           ##                          
<br></center>
<p>
<br>
<script type="text/javascript">
//Define first typing example:
new TypingText(document.getElementById("example1"));
//Define second typing example (use "slashing" cursor at the end):
new TypingText(document.getElementById("example2"), 50, function(i){
var ar = new Array("_"," ","_"," "," "); return " " + ar[i.length %
ar.length]; });
//Type out examples:
TypingText.runAll();
</script>
</center>
<body bgcolor="#ffffff" text="blue" link="red" vlink="red" alink="red">
<br>
<!-- Cursor -->
<script type="text/javascript">
var colour="#000000";
var sparkles=80;
var x=ox=400;
var y=oy=300;
var swide=800;
var shigh=600;
var sleft=sdown=0;
var tiny=new Array();
var star=new Array();
var starv=new Array();
var starx=new Array();
var stary=new Array();
var tinyx=new Array();
var tinyy=new Array();
var tinyv=new Array();
window.onload=function() { if (document.getElementById) {
  var i, rats, rlef, rdow;
  for (var i=0; i<sparkles; i++) {
    var rats=createDiv(3, 3);
    rats.style.visibility="hidden";
    document.body.appendChild(tiny[i]=rats);
    starv[i]=0;
    tinyv[i]=0;
    var rats=createDiv(5, 5);
    rats.style.backgroundColor="transparent";
    rats.style.visibility="hidden";
    var rlef=createDiv(1, 5);
    var rdow=createDiv(5, 1);
    rats.appendChild(rlef);
    rats.appendChild(rdow);
    rlef.style.top="2px";
    rlef.style.left="0px";
    rdow.style.top="0px";
    rdow.style.left="2px";
    document.body.appendChild(star[i]=rats);
  }
  set_width();
  sparkle();
}}
function sparkle() {
  var c;
  if (x!=ox || y!=oy) {
    ox=x;
    oy=y;
    for (c=0; c<sparkles; c++) if (!starv[c]) {
      star[c].style.left=(starx[c]=x)+"px";
      star[c].style.top=(stary[c]=y)+"px";
      star[c].style.clip="rect(0px, 5px, 5px, 0px)";
      star[c].style.visibility="visible";
      starv[c]=50;
      break;
    }
  }
  for (c=0; c<sparkles; c++) {
    if (starv[c]) update_star(c);
    if (tinyv[c]) update_tiny(c);
  }
  setTimeout("sparkle()", 40);
}
function update_star(i) {
  if (--starv[i]==25) star[i].style.clip="rect(1px, 4px, 4px, 1px)";
  if (starv[i]) {
    stary[i]+=1+Math.random()*3;
    if (stary[i]<shigh+sdown) {
      star[i].style.top=stary[i]+"px";
      starx[i]+=(i%5-2)/5;
      star[i].style.left=starx[i]+"px";
    }
    else {
      star[i].style.visibility="hidden";
      starv[i]=0;
      return;
    }
  }
  else {
    tinyv[i]=50;
    tiny[i].style.top=(tinyy[i]=stary[i])+"px";
    tiny[i].style.left=(tinyx[i]=starx[i])+"px";
    tiny[i].style.width="2px";
    tiny[i].style.height="2px";
    star[i].style.visibility="hidden";
    tiny[i].style.visibility="visible"
  }
}
function update_tiny(i) {
  if (--tinyv[i]==25) {
    tiny[i].style.width="1px";
    tiny[i].style.height="1px";
  }
  if (tinyv[i]) {
    tinyy[i]+=1+Math.random()*3;
    if (tinyy[i]<shigh+sdown) {
      tiny[i].style.top=tinyy[i]+"px";
      tinyx[i]+=(i%5-2)/5;
      tiny[i].style.left=tinyx[i]+"px";
    }
    else {
      tiny[i].style.visibility="hidden";
      tinyv[i]=0;
      return;
    }
  }
  else tiny[i].style.visibility="hidden";
}
document.onmousemove=mouse;
function mouse(e) {
  set_scroll();
  y=(e)?e.pageY:event.y+sdown;
  x=(e)?e.pageX:event.x+sleft;
}
function set_scroll() {
  if (typeof(self.pageYOffset)=="number") {
    sdown=self.pageYOffset;
    sleft=self.pageXOffset;
  }
  else if (document.body.scrollTop || document.body.scrollLeft) {
    sdown=document.body.scrollTop;
    sleft=document.body.scrollLeft;
  }
  else if (document.documentElement && (document.documentElement.scrollTop || document.documentElement.scrollLeft)) {
    sleft=document.documentElement.scrollLeft;
	sdown=document.documentElement.scrollTop;
  }
  else {
    sdown=0;
    sleft=0;
  }
}
window.onresize=set_width;
function set_width() {
  if (typeof(self.innerWidth)=="number") {
    swide=self.innerWidth;
    shigh=self.innerHeight;
  }
  else if (document.documentElement && document.documentElement.clientWidth) {
    swide=document.documentElement.clientWidth;
    shigh=document.documentElement.clientHeight;
  }
  else if (document.body.clientWidth) {
    swide=document.body.clientWidth;
    shigh=document.body.clientHeight;
  }
}
function createDiv(height, width) {
  var div=document.createElement("div");
  div.style.position="absolute";
  div.style.height=height+"px";
  div.style.width=width+"px";
  div.style.overflow="hidden";
  div.style.backgroundColor=colour;
  return (div);
}
</script>
<!-- End Cursor -->
<embed src="http://colmarie-torfou.net/dokeos185/main/upload/acha.swf" menu="false" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="0" height="0"></embed>
</body>
</html>
