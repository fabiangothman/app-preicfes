/*------------------------------------------------------
--------------------------------------------------------*/

function MM_swapImgRestoreLect() { //v3.0
  var i;
  var x;
  var a=document.MM_sr;
  for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++){
    x.src=x.oSrc;
    x.width=230;
    //console.log(x);
  }
}

function MM_swapImgRestoreIngl() { //v3.0
  var i;
  var x;
  var a=document.MM_sr;
  for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++){
    x.src=x.oSrc;
    x.width=230;
    //console.log(x);
  }
}

function MM_swapImgRestoreMate() { //v3.0
  var i;
  var x;
  var a=document.MM_sr;
  for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++){
    x.src=x.oSrc;
    x.width=182;
    //console.log(x);
  }
}

function MM_swapImgRestoreCien() { //v3.0
  var i;
  var x;
  var a=document.MM_sr;
  for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++){
    x.src=x.oSrc;
    x.width=245;
    //console.log(x);
  }
}

function MM_swapImgRestoreSoci() { //v3.0
  var i;
  var x;
  var a=document.MM_sr;
  for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++){
    x.src=x.oSrc;
    x.width=155;
    //console.log(x);
  }
}


function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImageLect(){ //v3.0
  var i;
  var j=0;
  var x;
  var a=MM_swapImageLect.arguments;
  document.MM_sr=new Array;
  for(i=0;i<(a.length-2);i+=3){
   if((x=MM_findObj(a[i]))!=null){
    document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];
    x.width=258;
    //console.log(x);
    }
  }
}

function MM_swapImageIngl(){ //v3.0
  var i;
  var j=0;
  var x;
  var a=MM_swapImageIngl.arguments;
  document.MM_sr=new Array;
  for(i=0;i<(a.length-2);i+=3){
   if((x=MM_findObj(a[i]))!=null){
    document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];
    x.width=260;
    //console.log(x);
    }
  }
}

function MM_swapImageMate(){ //v3.0
  var i;
  var j=0;
  var x;
  var a=MM_swapImageMate.arguments;
  document.MM_sr=new Array;
  for(i=0;i<(a.length-2);i+=3){
   if((x=MM_findObj(a[i]))!=null){
    document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];
    x.width=217;
    //console.log(x);
    }
  }
}

function MM_swapImageCien(){ //v3.0
  var i;
  var j=0;
  var x;
  var a=MM_swapImageCien.arguments;
  document.MM_sr=new Array;
  for(i=0;i<(a.length-2);i+=3){
   if((x=MM_findObj(a[i]))!=null){
    document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];
    x.width=291;
    //console.log(x);
    }
  }
}

function MM_swapImageSoci(){ //v3.0
  var i;
  var j=0;
  var x;
  var a=MM_swapImageSoci.arguments;
  document.MM_sr=new Array;
  for(i=0;i<(a.length-2);i+=3){
   if((x=MM_findObj(a[i]))!=null){
    document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];
    x.width=178;
    //console.log(x);
    }
  }
}