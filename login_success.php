<?php 

include_once('connect.php');

session_start();        
if(!isset($_SESSION['KNO'])) header("location:index.php");
error_reporting(E_ALL & ~E_NOTICE);

$banka=true;
$auzunluk=12;
$guzunluk=$auzunluk*12;//54 idi
$suzunluk=$guzunluk*5;
$duzunluk=$suzunluk;

if(isset($_GET['zaman'])){
	
$simdi=date("Y-m-d H:i:s");

$simdid=date("Y-m-d H:i:s", strtotime('+2 minute'));
$simdis=date("Y-m-d H:i:s", strtotime('+2 hour'));
$simdig=date("Y-m-d H:i:s", strtotime('+2 days'));

$temeldakikalar=array("00","05","10","15","20","25","30","35","40","45","50","55");
for ($j=0;$j<$duzunluk;$j++){
	$dakikalar[$j]= date("i",strtotime($simdi.' -'.$j.' minute'));
if(!in_array($dakikalar[$j],$temeldakikalar)) $dakikalar[$j]=' '; 
if ($dakikalar[$j]=='00'||$dakikalar[$j]=='30') $dakikalar[$j]= date("H:i", strtotime($simdi.' -'.$j.' minute'));
}
$dakikalar[0]=date("i",strtotime($simdi));
$dakikalar=array_reverse($dakikalar);
$guncelleme_dakikalar="'".implode("','",$dakikalar)."'";

$temelsaatler=array("00","04","08","12","16","20");
for ($j=0;$j<$suzunluk;$j++){
	$saatler[$j]= date("H",strtotime($simdi.' -'.$j.' hour'));
if(!in_array($saatler[$j],$temelsaatler)) $saatler[$j]=' '; 
if ($saatler[$j]=='00') $saatler[$j]= date("H d-m", strtotime($simdi.' -'.$j.' hour'));
}
$saatler[0]=date("H",strtotime($simdi));
$saatler=array_reverse($saatler);
$guncelleme_saatler="'".implode("','",$saatler)."'";

//echo $guncelleme;
for ($j=0;$j<$guzunluk;$j++){
	$gunler[$j]= date("d",strtotime($simdi.' -'.$j.' day'));
//if(!in_array($aylar[$j],$temelaylar)) $aylar[$j]=' '; 
if ($gunler[$j]=='01'||$gunler[$j]=='02') $gunler[$j]= date("m-d", strtotime($simdi.' -'.$j.' day'));
}


$gunler=array_reverse($gunler);
$guncelleme_gunler="'".implode("','",$gunler)."'";

$temelaylar=array("Ocak","Şubat","Mart","Nisan","Mayıs","Haziran","Temmuz","Ağustos","Eylül","Ekim","Kasım","Aralık");
for ($j=0;$j<54;$j++){
	$aylar[$j]= date("m",strtotime($simdi.' -'.$j.' month'));
//if(!in_array($aylar[$j],$temelaylar)) $aylar[$j]=' '; 
if ($aylar[$j]=='01') $aylar[$j]= date("Y-m", strtotime($simdi.' -'.$j.' month'));
}
$aylar=array_reverse($aylar);
$guncelleme_aylar="'".implode("','",$aylar)."'";


	if($_GET['zaman']=='D'){ $yenileme=30;$zaman_ing='minute';$grup=12;$guncelleme=$guncelleme_dakikalar;$uzunluk=$duzunluk+8;}
	if($_GET['zaman']=='S'){ $yenileme=60;$zaman_ing='hour';$grup=10;$guncelleme=$guncelleme_saatler;$uzunluk=$suzunluk+8;}
	if($_GET['zaman']=='G'){ $yenileme=1440;$zaman_ing='day';$grup=8;$guncelleme=$guncelleme_gunler;$uzunluk=$guzunluk+8;}
	if($_GET['zaman']=='A'){ $yenileme=43200;$zaman_ing='month';$grup=6;$guncelleme=$guncelleme_aylar;$uzunluk=$auzunluk+8;}	
}

echo '<head>  <meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="scroll.css">
 <script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
 <script type="text/javascript" src="jquery-3.4.1.min.js"></script>
 <script type="text/javascript" src="jquery.doubleScroll.js"></script>
		
 	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	
'.(isset($_GET['grafik'])||isset($_GET['siradisi'])?"
<meta http-equiv=refresh content=".($yenileme).";>
	<link rel=stylesheet type=text/css href=style.css>":"").'
 	<script src="Chart.js-2.8.0/dist/Chart.min.js"></script>
	<script src="Chart.js-2.8.0/dist/chartjs-plugin-datalabels.min.js"></script>
	<script src="utils.js"></script>
	<script src="analyser.js"></script>
	   
    <script type="text/javascript">

function baglantisec(deger){	
	window.location.href("?erisim=1&kullanici="+deger);
	header("location:login_success.php?erisim=1&kullanici="+deger);
}

</script>

    <script type="text/javascript">
	
function mypass(sayi) {
 
 var x = document.getElementById("sifre"+sayi);
  var y = document.getElementById("eye"+sayi);
 
  if (x.type === "password") {  
  
    x.type = "text";
    y.setAttribute("class","glyphicon glyphicon-eye-open");
 
  } else {
	  
    x.type = "password";
    y.setAttribute("class","glyphicon glyphicon-eye-close");
  }
}


</script>

<script type="text/javascript">
function yeni(){
	var e = document.getElementById("idsablon");
	
	if (e.value=="diger")	{
	document.getElementById("iddiger").type="text";} else {
	document.getElementById("iddiger").type="hidden";
	

var n = e.options[e.selectedIndex].value;

	document.getElementById("idveritabani").value=document.getElementById("idveritabani"+n).value;
	document.getElementById("idadres").value=document.getElementById("idadres"+n).value;
	document.getElementById("idsifre").value=document.getElementById("idsifre"+n).value;
	document.getElementById("idbaglanti").value=document.getElementById("idbaglanti_adresi"+n).value;
	document.getElementById("idveritabanlari").value=document.getElementById("idveritabanlari"+n).value;
	document.getElementById("idtablolar_sorgu").value=document.getElementById("idtablolar"+n).value;
	document.getElementById("idalanlar_sorgu").value=document.getElementById("idislem"+n).value;
	document.getElementById("idalanlar_getirme").value=document.getElementById("idalanlar_getirme"+n).value;
	document.getElementById("idveriler").value=document.getElementById("idveriler"+n).value;
	document.getElementById("idizleyici_olusturma").value=document.getElementById("idizleyici_olusturma"+n).value;
	document.getElementById("idizleyici_silme").value=document.getElementById("idizleyici_silme"+n).value;
	document.getElementById("idveriseti_sorgu").value=document.getElementById("idveriseti_sorgu"+n).value;
	document.getElementById("idveriseti_getirme").value=document.getElementById("idveriseti_getirme"+n).value;
	
	document.getElementById("idornek_veri").value=document.getElementById("idornek_veri"+n).value;	
	}
}

</script>
<script type="text/javascript">
	$(document).ready(function() {
	   $(".double-scroll").doubleScroll();
	   $("#sample2").doubleScroll({resetOnWindowResize: true});



	});
	
</script>

        <style>
            .double-scroll {
                width: 1000px;
            }
            #sample2{
                width: 100%;
            }
        </style>
		
		      <style id="compiled-css" type="text/css">

.chartWrapper {/* w w w. j a v  a2 s.co  m*/
   position: relative;
}
.chartWrapper > canvas {
   position: absolute;
   left: 0;
   top: 0;
   pointer-events:none;
}
.chartAreaWrapper {
   width: 600px;
   overflow-x: scroll;
}


      </style> 
	  
	  <script type="text/javascript">
    window.onload=function(){
        var ctx = document.getElementById("myChart").getContext("2d");
        var data = {
            labels: ["January", "February", "March", "April", "May", "June", "July"],
            datasets: [
                {
                    label: "My First dataset",
                    fillColor: "rgba(220,220,220,0.2)",
                    strokeColor: "rgba(220,220,220,1)",
                    pointColor: "rgba(220,220,220,1)",
                    pointStrokeColor: "#fff",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(220,220,220,1)",
                    data: [65, 59, 80, 81, 56, 55, 40]
                },
                {
                    label: "My Second dataset",
                    fillColor: "rgba(151,187,205,0.2)",
                    strokeColor: "rgba(151,187,205,1)",
                    pointColor: "rgba(151,187,205,1)",
                    pointStrokeColor: "#fff",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(151,187,205,1)",
                    data: [28, 48, 40, 19, 86, 27, 90]
                }
            ]
        };
        new Chart(ctx).Line(data, {
            onAnimationComplete: function () {
                var sourceCanvas = this.chart.ctx.canvas;
                var copyWidth = this.scale.xScalePaddingLeft - 5;
                var copyHeight = this.scale.endPoint + 5;
                var targetCtx = document.getElementById("myChartAxis").getContext("2d");
                targetCtx.canvas.width = copyWidth;
                targetCtx.drawImage(sourceCanvas, 0, 0, copyWidth, copyHeight, 0, 0, copyWidth, copyHeight);
            }
        });
    }

      </script> 

</head>';


	$navbar1='<tr><td class="navbar navbar-light" style="background-color: #e3f2fd;">
  <div class=container-fluid>
    <div class=navbar-header>
      <a class=navbar-brand href="#">';
	  $navbar2='
	  	  </a>
    </div>
    <ul class="nav navbar-nav navbar-right">
		<li><a href=?><span class="glyphicon glyphicon-home"></span>Anasayfa</a></li>
        <li><a href=index.php?cikis=1><span class="glyphicon glyphicon-log-out aria-hidden="true"></span>Oturumu Kapat</a></li>
    </ul>
  </div>
  
</td></tr>
<tr><td >
'.(isset($_GET['sistem'])?
"
 <div class='double-scroll'>



":"").'

<table class="table" border=0>';
//style="padding-left: '.(isset($_GET['sistem'])?110:150).'px; padding-top: 20px;"
//onsubmit="setTimeout(function(){window.location.reload();},10);
echo '<div class="container-fluid h-100">
  <div class="row h-100 align-items-center">
<form class="col-12" name="form2" method="post" action="" 
onsubmit="setTimeout(function(){window.location.reload();},10);"
enctype="multipart/form-data">
  <table class="form-group" height: 100%  align="center" width=600 border=0>
  <tr><td style="padding-top: '.(isset($_GET['sistem'])?50:0).'px;">';// bgcolor="#F7F7F7"


//$sayac=(isset($_POST['sayac'])?$_POST['sayac']:$_GET['sayac']);
    if(isset($_GET['sayac1'])) $sayac1=$_GET['sayac1'];
    if(isset($_GET['sayac2'])) $sayac2=$_GET['sayac2'];
    $pathimg='/OBS/resim/';

    if(isset($_POST['iptal'])){
$sayac=1;
        echo "<script>window.location.href('?modul=".$_GET['modul']."&sayac=1')</script>";
    }
	
 //if(isset($tabloadi)){   
    function tabloveri($conn,$tabloadi,$sayac) {
        $sql1="Select * from (select row_number() over (order by rowid) rno,o.* from vis.".$tabloadi." o) where rno=".$sayac;
       // if ($_GET['modul']=='dersler'){ global $yil;global $donem;
         //   $sql1.=" and yil=".$yil." and donem=".$donem;}
        $tabloadi=oci_parse($conn, $sql1);
        oci_execute($tabloadi);
        $veri=oci_fetch_assoc($tabloadi);
        //echo $sql1;
        return $veri;      
    }
	
    function tablobilgi($conn,$tabloadi,$nitelik) {       
        $sql2="Select count(*) toplam, max($nitelik)+1 yeni_no from vis.".$tabloadi;
       // if ($_GET['modul']=='dersler'){ global $yil;global $donem;
       // $sql2.=" where yil=".$yil." and donem=".$donem;}
        //ECHO $sql2;
        $tablo=oci_parse($conn, $sql2);
        oci_execute($tablo);
        $bilgi=oci_fetch_assoc($tablo);       
        return $bilgi;        
    }
 

    //KULLANICILAR
    $sql13="Select row_number() over (order by rowid) rno,b.* from vis.kullanicilar b";
    $kul=oci_parse($conn, $sql13);
    oci_execute($kul);
    

	
	//HTTPS sertifika hatası için
	
$arrContextOptions=array(
    "ssl"=>array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
    ),
); 

if (isset($_GET['duzeyler'])){
		
		$sql1b="Select * from vis.islem";
        $verib=oci_parse($conn, $sql1b);
        oci_execute($verib);
		
		$sayust=0;$sayorta=0;$sayalt=0;
        while (($row = oci_fetch_array($verib, OCI_BOTH)) != false){
			if($row['DUZEY']=='Üst') $ust[$sayust]=$row['ADI'];$sayust++;
			if($row['DUZEY']=='Orta') $orta[$sayorta]=$row['ADI'];$sayorta++;
			if($row['DUZEY']=='Alt') $alt[$sayalt]=$row['ADI'];$sayalt++;
		}
 
     if(isset($_POST['kaydet'])){
         for($i=1;$i<=$_POST['toplam'];$i++){
             $sqlupsistem= "update vis.duzey set adi='".$_POST['adi'.$i]."',gorevi='".$_POST['gorevi'.$i]."',kadi='".$_POST['kadi'.$i]."',sifre='".$_POST['sifre'.$i]."',tipi='".$_POST['tipi'.$i]."',eposta='".$_POST['eposta'.$i]."' where kno='".$_POST['kno'.$i]."'";
             $upsistem=oci_parse($conn, $sqlupsistem);
             oci_execute($upsistem);			 		 
		 }
       // header("location:login_success.php?duzeyler=1");
		
     }

if(isset($_POST['ekle'])){
         $sqlinsistem= "insert into vis.duzey values ('".$_POST['gorevi']."','".$_POST['tipi']."')";
         //echo $sqlinsistem;
		 $insistem=oci_parse($conn, $sqlinsistem);
         oci_execute($insistem);
        // header("location:login_success.php?duzeyler=1");
		 //echo "<script>window.location.href('?duzeyler=1')</script>";
     }
if(isset($_GET['sil'])){	

         $sqlsilsistem= "delete vis.duzey where gorev='".$_GET['sil']."'";
        // echo $sqlsilsistem;
		 $silsistem=oci_parse($conn, $sqlsilsistem);
         oci_execute($silsistem);
         //header("location:login_success.php?duzeyler=1");
		 //echo "<script>window.location.href('?duzeyler=1')</script>";

	}
	
  echo $navbar1.'Görev Tanımlama'.$navbar2.'
<tr><td></td><td><B>Görev</td><td><B>Düzey</td></tr>
<tr>
<td align=center><input type=submit name=ekle value=" Ekle "></input></td>
<td><input name="gorevi" type="text"size=10></td>
<td>
&nbsp;<input type=radio name=tipi value="Üst"></input> <u>Üst</u>&nbsp;&nbsp;&nbsp;
&nbsp;<input type=radio name=tipi value="Orta"></input> <u>Orta</u>&nbsp;&nbsp;&nbsp;
&nbsp;<input type=radio name=tipi value="Alt"></input> <u>Alt</u>
</td>
</tr>

<tr bgcolor=#DDDDDD><td colspan=7><center><h2>Mevcut Görevler ve Düzeyleri</h2></center></td></tr>
<tr><td><center><B>Üst</td><td><center><B>Orta</td><td><center><B>Alt</td></tr>';

		$sql1="Select * from (select row_number() over (order by rowid) rno,o.* from vis.duzey o)";
        //$sql1="select listagg(gorev,', ') within group(order by gorev) gorev, duzey from vis.duzey group by duzey";
		$veri=oci_parse($conn, $sql1);
        oci_execute($veri);
		$ust=array();$orta=array();$alt=array();
    while (($row = oci_fetch_array($veri, OCI_BOTH)) != false){
	if ($row['DUZEY']=='Üst') array_push($ust, $row['GOREV']);
	if ($row['DUZEY']=='Orta') array_push($orta, $row['GOREV']);
	if ($row['DUZEY']=='Alt') array_push($alt, $row['GOREV']);
	
//
	//echo "<input type=submit name=sil".$row["RNO"]." value=' Sil '></input>";
//echo '</center></td><td width="294">'.$row['GOREV'].'</td><td width="294">'.$row['DUZEY'].'</td></tr>';
	//$toplam=$row['RNO'];
	} 
	// print_r($ust);print_r($orta);print_r($alt);
	echo '<tr><td width=120>';
		foreach($ust as &$value) {echo "<a href='?duzeyler=1&sil=".$value."'><b>-</b></a>".$value."<br>";}   
		echo "</td><td  width=190>";	
		foreach($orta as &$value) {echo "<a href='?duzeyler=1&sil=".$value."'><b>-</b></a>".$value."<br>";}  
		echo "</td><td width=290>";	
		foreach($alt as &$value) {echo "<a href='?duzeyler=1&sil=".$value."'><b>-</b></a>".$value."<br>";}   
		
echo "</td></tr>";
               
echo "</table></td></tr>";
}/* modul sonu */ 

if (isset($_GET['kullanicilar'])){
    
        $sql2="Select count(*) toplam, max(kno)+1 yeni_no from vis.kullanicilar";
        $kullanicibilgi=oci_parse($conn, $sql2);
        oci_execute($kullanicibilgi);
		$bilgi=oci_fetch_assoc($kullanicibilgi);       
		
        $sql1="Select * from (select row_number() over (order by rowid) rno,o.* from vis.kullanicilar o)";
        $veri=oci_parse($conn, $sql1);
        oci_execute($veri);
		
		$sql1b="Select * from vis.islem";
        $verib=oci_parse($conn, $sql1b);
        oci_execute($verib);
		
		$sayust=0;$sayorta=0;$sayalt=0;
        while (($row = oci_fetch_array($verib, OCI_BOTH)) != false){
			if($row['DUZEY']=='Üst') $ust[$sayust]=$row['ADI'];$sayust++;
			if($row['DUZEY']=='Orta') $orta[$sayorta]=$row['ADI'];$sayorta++;
			if($row['DUZEY']=='Alt') $alt[$sayalt]=$row['ADI'];$sayalt++;
		}
 
     /*   if(isset($_POST['kaydet'])){            
            if(!$veri['KNO']){
                $sqlkullanicilar= "insert into vis.kullanicilar values (".$_POST['kno'].",'".$_POST['adi']."','".$_POST['gorevi']."','".$_POST['kadi']."','".$_POST['sifre']."','".$_POST['tipi']."')";
            } else {
                $sqlkullanicilar= "update vis.kullanicilar set kno=".$_POST['kno'].",adi='".$_POST['adi']."',gorevi='".$_POST['gorevi']."',kadi='".$_POST['kadi']."',sifre='".$_POST['sifre']."',tipi='".$_POST['tipi']."' where kno='".$veri['KNO']."'";
            }
            
            if (!$_POST['kno']||!$_POST['adi']||!$_POST['gorevi']||!$_POST['kadi']||!$_POST['tipi']) {
                echo "Lütfen tüm alanları doldurunuz";
            } else {
                //echo $sqlkullanicilar;
                $kullanicilar=oci_parse($conn, $sqlkullanicilar);
                oci_execute($kullanicilar);
                echo "<script>window.location.href('?modul=kullanicilar&sayac=".($sayac)."')</script>";
            }
         $veri['ADI']=$_POST['adi'];
		 $veri['GOREVI']=$_POST['gorevi'];
		 $veri['KADI']=$_POST['kadi'];
		 $veri['SIFRE']=$_POST['sifre'];
		 $veri['KNO']=$_POST['kno'];
		 $veri['TIPI']=$_POST['tipi'];
        }*/
		
     if(isset($_POST['kaydet'])){
         for($i=1;$i<=$_POST['toplam'];$i++){
             $sqlupsistem= "update vis.kullanicilar set adi='".$_POST['adi'.$i]."',gorevi='".$_POST['gorevi'.$i]."',kadi='".$_POST['kadi'.$i]."',sifre='".$_POST['sifre'.$i]."',eposta='".$_POST['eposta'.$i]."' where kno='".$_POST['kno'.$i]."' and kno<>'1002'";
           echo $sqlupsistem;
             $upsistem=oci_parse($conn, $sqlupsistem);
             oci_execute($upsistem);			 		 
		 }
	
       // header("location:login_success.php?kullanicilar=1");
		 //echo "<script>window.location('?kullanicilar=1')</script>";
            
     }

if(isset($_POST['ekle'])){
			$sql1b="select listagg(adi,', ') within group(order by adi) adi from vis.islem where duzey=(select duzey from vis.duzey where gorev='".$_POST['gorev']."')";
        $verib=oci_parse($conn, $sql1b);
        oci_execute($verib);
		$veriler=oci_fetch_assoc($verib);
				
         $sqlinsistem= "insert into vis.kullanicilar values ('".$bilgi['YENI_NO']."','".$_POST['adi']."','".$_POST['gorev']."','".$_POST['kadi']."','".$_POST['sifre']."','".$veriler['ADI']."','".$_POST['eposta']."')";
         echo $sql1b;
		 $insistem=oci_parse($conn, $sqlinsistem);
         oci_execute($insistem);
         //header("location:login_success.php?kullanicilar=1");
		 //echo "<script>window.location('?kullanicilar=1')</script>";
     }
	//echo $_POST['toplam'];
if(isset($_POST['toplam'])){	
  for($i=1;$i<=$_POST['toplam'];$i++){
	 if(isset($_POST['sil'.$i])){
         $sqlsilsistem= "delete vis.kullanicilar where kno='".$_POST['kno'.$i]."'";
         echo $sqlsilsistem;
		 $silsistem=oci_parse($conn, $sqlsilsistem);
         oci_execute($silsistem);
        //header("location:login_success.php?kullanicilar=1");
		 //echo "<script>window.location.href('?kullanicilar=1')</script>";
     }
	 }
	}

		$sql12="Select * from (select row_number() over (order by rowid) rno,o.* from vis.duzey o)";
		$veri2=oci_parse($conn, $sql12);
        oci_execute($veri2);
		
  echo $navbar1.'Kullanıcı Tanımlama'.$navbar2.'
<tr><td></td><td>Adı</td><td>Görevi</td><td>Kullanıcı Adı</td><td>Kullanıcı&nbsp;Şifresi</td><td>E-posta</td></tr>
<tr>
<td align=center><input type=submit name=ekle value=" Ekle "></input></td>
<td><input name="adi" type="text" </input></td>
<td><select name=gorev>
<option disabled=disabled selected=selected>Görev seçiniz</option>';
    while (($row = oci_fetch_array($veri2, OCI_BOTH)) != false){
echo '<option value="'.$row['GOREV'].'">'.$row['GOREV'].'</option>';	
	}

echo '</select>
</td>
<td><input name="kadi" type="text" size=10 autocomplete=false> </input></td>
<td><input name="sifre" type="password" id="sifre0" size=6></input>
<span class="glyphicon glyphicon-eye-close" id="eye0" onclick="mypass(0)"></span>
</td>
<td><input name="eposta" type="text" size=15></td>
</tr>

<tr bgcolor=#DDDDDD><td colspan=7><center><h2>Mevcut Kullanıcılar</h2></center></td></tr>
<tr><td></td><td>Adı</td><td>Görevi</td><td>Kullanıcı Adı</td><td>Kullanıcı Şifresi</td><td>E-posta</td></tr>';
    
    while (($row = oci_fetch_array($veri, OCI_BOTH)) != false){
echo '<tr><td><center>';
if($row["KADI"]=="sistem") {
$sistemvar=true;
	} else {
	echo "<input type=submit name=sil".$row["RNO"]." value=' Sil '></input>";
	}

echo '</center></td>
 <input type=hidden name=kno'.$row['RNO'].' value='.$row['KNO'].'></input>
<td><input name="adi'.$row['RNO'].'" type="text" value="'.$row['ADI'].'"</td>
<td width="294">';
if (isset($sistemvar)) {echo 'Sistem Kullanıcısı';$sistemvar=null;} else {
echo '<select name="gorevi'.$row['RNO'].'">';
	oci_execute($veri2);
    while (($rowa = oci_fetch_array($veri2, OCI_BOTH)) != false){
echo '<option value="'.$rowa['GOREV'].'" '.($rowa['GOREV']==$row['GOREVI']?'selected=selected':'').'>'.$rowa['GOREV'].'</option>';	
	}

echo '</select>';
}

echo '</td>
<td>'.($row["KADI"]=="sistem"?"sistem":'

<input name="kadi'.$row['RNO'].'" type="text"  size=10 value="'.($row['KADI']).'"').'</td>
<td><input name="sifre'.$row['RNO'].'" type="password" id="sifre'.$row['RNO'].'" size=6 value="'.($row['SIFRE']).'">
<span class="glyphicon glyphicon-eye-close" id="eye'.$row['RNO'].'" onclick="mypass('.$row['RNO'].')"></span>
</td>
<td width="294"><input name="eposta'.$row['RNO'].'" type="text"size=15 value="'.($row['EPOSTA']).'"></td>
</tr>';

//echo '<input type="hidden" '.($row["TIPI"]=="U"?'name="baslikust" value="'.implode("||",$ust).'"':($row["TIPI"]=="O"?implode("||",$orta):($row["TIPI"]=="A"?implode("||",$alt):''))).'"></input>';

	$toplam=$row['RNO'];
	}
        
    echo "<tr><td colspan=5 align=center>
	
    <input type=hidden name=toplam value=".$toplam."></input>
	<input type=submit name=kaydet value=' Kaydet '></input></td></tr>";
    
           
           
           
echo "</table></td></tr>";




}/* modul sonu */ 
    //$sql15="Select row_number() over (order by rowid) rno,s.* from (select * from vis.baglanti where adres <> 'https://www.albaraka.com.tr/forms/currencies.json') s";
    $sql15="Select row_number() over (order by rowid) rno,s.* from (select * from vis.baglanti) s order by veritabani desc";
	
	$sql15d="select distinct(VERITABANI) VERITABANI from vis.baglanti";
	
if (isset($_GET['sistem'])=='1') {
    $sayacrenksatir=0;

     if(isset($_POST['kaydet'])){
         for($i=1;$i<=$_POST['toplam'];$i++){
             $sqlupsistem= "update vis.baglanti set sifre='".$_POST['sifre'.$i]."', veritabanlari='".$_POST['veritabanlari'.$i]."' where adres='".$_POST['adres'.$i]."' and veritabani='".$_POST['veritabani'.$i]."' and sifre='".$_POST['eskisifre'.$i]."' and veritabanlari='".$_POST['eskiadi'.$i]."'";
//           echo $sqlupsistem;
             $upsistem=oci_parse($conn, $sqlupsistem);
             oci_execute($upsistem);			 		 
		 }
        //header("location:login_success.php?sistem=1");
     }

if(isset($_POST['ekle'])){
         $sqlinsistem= "insert into vis.baglanti values(
		 '".str_replace("'","''",$_POST['adres'] )."',
		 '".str_replace("'","''",$_POST['veritabani'] )."',
		 '".str_replace("'","''",$_POST['sifre'] )."',
		 '".str_replace("'","''",$_POST['adi'] )."',
		 '".str_replace("'","''",$_POST['veritabanlari'] )."', 
		 '".str_replace("'","''",$_POST['baglanti'] )."',
		 '".str_replace("'","''",$_POST['tablolar_sorgu'] )."',
		 '".str_replace("'","''",$_POST['kayit_getirme'] )."',
		 '".str_replace("'","''",$_POST['alanlar_sorgu'] )."',
		 '".str_replace("'","''",$_POST['izleyici_olusturma'] )."',
		 '".str_replace("'","''",$_POST['izleyici_silme'] )."',
		 '".str_replace("'","''",$_POST['alanlar_getirme'] )."',
		 '".str_replace("'","''",$_POST['veriseti_sorgu'] )."',
		 '".str_replace("'","''",$_POST['veriseti_getirme'] )."',
		 '".str_replace("'","''",$_POST['ornek_veri'] )."'
		 )";

		 $insistem=oci_parse($conn, $sqlinsistem);
         oci_execute($insistem);
		 //echo $sqlinsistem;
		 
        //header("location:login_success.php?sistem=1");
		//echo "<script>window.location.href('?sistem=1')</script>";
		
    }
	//echo $_POST['toplam'];
if(isset($_POST['toplam'])){	
  for($i=1;$i<=$_POST['toplam'];$i++){
	 if(isset($_POST['sil'.$i])){
         $sqlsilsistem= "delete vis.baglanti where adres='".$_POST['adres'.$i]."' and veritabani='".$_POST['veritabani'.$i]."' and adi='".$_POST['adi'.$i]."' ";
         //echo $sqlsilsistem;
		 $silsistem=oci_parse($conn, $sqlsilsistem);
         oci_execute($silsistem);
        // header("location:login_success.php?sistem=1");
		 //echo "<script>window.location.href('?sistem=1')</script>";
		 
     }
	 }
	}     
     echo $navbar1."Veri Tabanı Bağlantısı".$navbar2."


<tr style='font-weight:bold' align='center'><td></td>
<td>Yeni Bağlantı Adı</td>
<td>VTYS</td>
<td>IP/URL Adresi</td>
<td>Sistem&nbsp;Şifresi&nbsp;</td>
<td>Vtys Bağlantı Değişkeni</td>
<td>Veri Tabanlarını Listeleme Sorgusu</td>
<td>Veri Tabanı Tablolarını Listeleme Sorgusu</td>
<td>Tablo Alanlarını Listeleme Sorgusu</td>
<td>Tablo Alanlarını Getirme Döngüsü</td>
<td>Veri Tabanı Kayıtlarını Getirme Döngüsü</td>
<td>Veri İzleyici Oluşturma Komutu</td>
<td>Veri İzleyici Silme Komutu</td>
<td>Veriseti Sorgusu</td>
<td>Verisetini Getirme Döngüsü</td>
<td>Örnek Veri</td>
</tr>
<tr><td align='center'><input type=submit name=ekle value=' Ekle '></input></td>
<td align='center'>
<input name=adi type=text>
<select name=veritabani onchange=yeni() id=idsablon>".
(isset($_GET['veritabani'])?'':'<option disabled=disabled selected=selected>Şablon seçiniz</option>');
$donemliste=oci_parse($conn, $sql15);oci_execute($donemliste);
while (($row = oci_fetch_array($donemliste, OCI_BOTH)) != false){
echo "<option value=".$row['RNO'].">".$row['ADI']."</option>";
}
echo '<option value=diger>Diğer</option>
</select>
<br><input id="iddiger" type="hidden" name=diger size=12></input>
</td>
<td align="center"><input id=idveritabani name=veritabani type=text></td>
<td align="center"><input id=idadres name=adres type=text></td>
<td align="center"><input name="sifre" type="password" id="sifre0" size=6></input>
<span class="glyphicon glyphicon-eye-close" id="eye0" onclick="mypass(0)"></span></td>
<td align="center"><textarea id=idbaglanti name=baglanti rows=3 cols=30></textarea></td>
<td align="center"><textarea id=idveritabanlari name=veritabanlari rows=3 cols=30></textarea></td>
<td align="center"><textarea id=idtablolar_sorgu name=tablolar_sorgu rows=3 cols=30></textarea></td>
<td align="center"><textarea id=idalanlar_sorgu name=alanlar_sorgu rows=3 cols=30></textarea></td>
<td align="center"><textarea id=idalanlar_getirme name=alanlar_getirme rows=3 cols=30></textarea></td>
<td align="center"><textarea id=idveriler name=kayit_getirme rows=3 cols=30></textarea></td>
<td align="center"><textarea id=idizleyici_olusturma name=izleyici_olusturma rows=3 cols=30></textarea></td>
<td align="center"><textarea id=idizleyici_silme name=izleyici_silme rows=3 cols=30></textarea></td>
<td align="center"><textarea id=idveriseti_sorgu name=veriseti_sorgu rows=3 cols=30></textarea></td>
<td align="center"><textarea id=idveriseti_getirme name=veriseti_getirme rows=3 cols=30></textarea></td>
<td align="center"><textarea id=idornek_veri name=ornek_veri rows=3 cols=30></textarea></td>
</tr>

<tr bgcolor=#DDDDDD><td colspan=4><center><h2>Mevcut Bağlantılar</h2></center></td><td colspan=12></td></tr>   
<tr style="font-weight:bold" align="center">
<td></td>
<td>Bağlantı Adı</td>
<td>VTYS</td>
<td>IP/URL Adresi</td>
<td>Sistem Şifresi</td>
<td>Vtys Bağlantı Değişkeni</td>
<td>Veri Tabanlarını Listeleme Sorgusu</td>
<td>Veri Tabanı Tablolarını Listeleme Sorgusu</td>
<td>Tablo Alanlarını Listeleme Sorgusu</td>
<td>Tablo Alanlarını Getirme Döngüsü</td>
<td>Veri Tabanı Kayıtlarını Getirme Döngüsü</td>
<td>Veri İzleyici Oluşturma Komutu</td>
<td>Veri İzleyici Silme Komutu</td>
<td>Veriseti Sorgusu</td>
<td>Verisetini Getirme Döngüsü</td>
<td>Örnek Veri</td>
</tr>';

/*web-veritabanı alan karşılıkları
adi 			ADI
veritabani 		VERITABANI
adres			ADRES
sifre			SIFRE
baglanti		BAGLANTI ADRESI
veritabanlari	VERITABANLARI
tablolar_sorgu	TABLOLAR
alanlar_sorgu	ISLEM
alanlar_getirme	SUTUN_BILGILERI
kayit_getirme	VERILER
izleyici_olusturma	TETIKLEYICI_EKLE
izleyici_silme		TETIKLEYICI_SIL
veriseti_sorgu		ZAMANSAL_SORGU
veriseti_getirme	ZAMANSAL_BILGI

VERITABANI SIRALI
adres			ADRES
veritabani 		VERITABANI
sifre			SIFRE
adi 			ADI
veritabanlari	VERITABANLARI
baglanti		BAGLANTI ADRESI
tablolar_sorgu	TABLOLAR
kayit_getirme	VERILER
alanlar_sorgu	ISLEM
izleyici_olusturma	TETIKLEYICI_EKLE
izleyici_silme		TETIKLEYICI_SIL
alanlar_getirme	SUTUN_BILGILERI
veriseti_sorgu		ZAMANSAL_SORGU
veriseti_getirme	ZAMANSAL_BILGI
*/
    
	$donemliste=oci_parse($conn, $sql15);oci_execute($donemliste);
    while (($row = oci_fetch_array($donemliste, OCI_BOTH)) != false){
 	$yazdir[1]="<table>
		<tr><td colspan=2><h1>Deneme</h1></td></tr>
		
		</table>";
		
	$_SESSION['dizi'.$row['RNO']]=array(
	$row['ADI'],
	$row['VERITABANI'],
	$row['ADRES'],
	$row['SIFRE']);	

	$kesim=strpos($row['ADRES'],'/',8);

   $adresbr=substr($row['ADRES'],0,$kesim)."<br>".substr($row['ADRES'],$kesim);

$adresbr=str_replace('albaraka','********',$adresbr);
  echo '<tr bgcolor=#'.($row["RNO"] % 2 ?"FFFFFF":"F7F7F7" ).'>
<td><center><input type=submit name=sil'.$row["RNO"].' value=" Sil "></input></center></td>
<td><center><a href="?dizi='.$row["RNO"].'" target=_blank>'.$row["ADI"].'</a>
<input id=idadi'.$row["RNO"].' name=adi'.$row["RNO"].' type=hidden value="'.htmlspecialchars($row["ADI"], ENT_QUOTES).'"></input></center></td>
<td><center>'.$row["VERITABANI"].'</center><input type=hidden id=idveritabani'.$row["RNO"].' name=veritabani'.$row["RNO"].' value="'.$row["VERITABANI"].'"></input></td>
<td>'.$adresbr.'<input type=hidden id=idadres'.$row["RNO"].' name=adres'.$row["RNO"].' value="'.$row["ADRES"].'"></input></td>
<td><center><input name=sifre'.$row["RNO"].' type=password value="'.$row["SIFRE"].'" size=6 id="sifre'.$row["RNO"].'"></input>
<span class="glyphicon glyphicon-eye-close" id="eye'.$row["RNO"].'" 
onclick="mypass('.$row["RNO"].')"></span></center>
<input type=hidden name=eskisifre'.$row["RNO"].' value="'.$row["SIFRE"].'"></input></td>
<td><center><textarea id=idbaglanti_adresi'.$row["RNO"].' name=baglanti'.$row["RNO"].' 
rows=1 cols=30>'.htmlspecialchars($row["BAGLANTI_ADRESI"], ENT_QUOTES).'</textarea></center></td>

<td><center><textarea id=idveritabanlari'.$row["RNO"].' name=veritabanlari'.$row["RNO"].' 
rows=1 cols=30>'.htmlspecialchars($row["VERITABANLARI"], ENT_QUOTES).'</textarea></center><input type=hidden name=eskiadi'.$row["RNO"].' value="'.htmlspecialchars($row["VERITABANLARI"], ENT_QUOTES).'"></input></td>

<td><center><textarea id=idtablolar'.$row["RNO"].' name=tablolar_sorgu'.$row["RNO"].' 
rows=1 cols=30>'.htmlspecialchars($row["TABLOLAR"], ENT_QUOTES).'</textarea></center></td>
<td><center><textarea id=idislem'.$row["RNO"].' name=alanlar_sorgu'.$row["RNO"].' 
rows=1 cols=30>'.htmlspecialchars($row["ISLEM"], ENT_QUOTES).'</textarea></center></td>

<td><center><textarea id=idalanlar_getirme'.$row["RNO"].' name=alanlar_getirme'.$row["RNO"].' rows=1 cols=30>'.htmlspecialchars((isset($row["SUTUN_BILGILERI"])?$row["SUTUN_BILGILERI"]:""), ENT_QUOTES).'</textarea></center></td>

<td><center><textarea id=idveriler'.$row["RNO"].' name=kayit_getirme'.$row["RNO"].' 
rows=1 cols=30>'.htmlspecialchars($row["VERILER"], ENT_QUOTES).'</textarea></center></td>
<td><center><textarea id=idizleyici_olusturma'.$row["RNO"].' name=izleyici_olusturma'.$row["RNO"].' 
rows=1 cols=30>'.htmlspecialchars((isset($row["TETIKLEYICI_EKLE"])?$row["TETIKLEYICI_EKLE"]:""), ENT_QUOTES).'</textarea></center></td>
<td><center><textarea id=idizleyici_silme'.$row["RNO"].' name=izleyici_silme'.$row["RNO"].' rows=1 cols=30>'.htmlspecialchars((isset($row["TETIKLEYICI_SIL"])?$row["TETIKLEYICI_SIL"]:""), ENT_QUOTES).'</textarea></center></td>
<td><center><textarea id=idveriseti_sorgu'.$row["RNO"].' name=veriseti_sorgu'.$row["RNO"].' rows=1 cols=30>'.htmlspecialchars((isset($row["ZAMANSAL_SORGU"])?$row["ZAMANSAL_SORGU"]:""), ENT_QUOTES).'</textarea></center></td>
<td><center><textarea id=idveriseti_getirme'.$row["RNO"].' name=veriseti_getirme'.$row["RNO"].' rows=1 cols=30>'.htmlspecialchars((isset($row["ZAMANSAL_BILGI"])?$row["ZAMANSAL_BILGI"]:""), ENT_QUOTES).'</textarea></center></td>
<td><center><textarea id=idornek_veri'.$row["RNO"].' name=ornek_veri'.$row["RNO"].' rows=1 cols=30>'.htmlspecialchars((isset($row["ORNEK_VERI"])?$row["ORNEK_VERI"]:""), ENT_QUOTES).'</textarea></center></td>
</tr>';

        $toplam=$row['RNO'];
		
			
    }
        
    echo "</div><input type=hidden name=toplam value=".$toplam."></input>";

}


if (isset($_GET['dizi'])) {
	
	 $sql15="select * from (Select row_number() over (order by rowid) rno,s.* from (select * from vis.baglanti) s ) where rno=".$_GET['dizi'];

	$donemliste=oci_parse($conn, $sql15);oci_execute($donemliste);
    $row = oci_fetch_assoc($donemliste);

 $adresbr=str_replace('albaraka','********',$row['ADRES']);
 
  echo $navbar1.$row['ADI'].$navbar2."
<!--<tr><td colspan=2><h1><center>".$row['ADI']."</h1></td></tr>-->
<tr><td style='font-weight:bold'>VTYS</td>
<td><center>".$row['VERITABANI']."</center><input type=hidden id=idveritabani".$row['RNO']." name=veritabani".$row['RNO']." value='".$row['VERITABANI']."'></input></td></tr>
<tr><td style='font-weight:bold'>IP/URL Adresi</td>
<td><center>".$adresbr."</center><input type=hidden id=idadres".$row['RNO']." name=adres".$row['RNO']." value='".$row['ADRES']."'></input></td></tr>
<tr><td style='font-weight:bold'>Sistem Şifresi</td>
<td valign=center><center><input name=sifre".$row['RNO']." type=password value='".$row['SIFRE']."' size=6 id='sifre0'></input>
<span class='glyphicon glyphicon-eye-close' id='eye".$row['RNO']."' onclick='mypass(0)'></span></center>
<input type=hidden name=eskisifre".$row['RNO']." value='".$row['SIFRE']."'></input></td></tr>
<tr><td style='font-weight:bold'>Vtys Bağlantı Değişkeni</td>
<td valign=center><center><textarea id=idbaglanti_adresi".$row['RNO']." name=baglanti".$row['RNO']." rows=".(substr_count($row['BAGLANTI_ADRESI'], "\n"))." cols=60>".htmlspecialchars($row['BAGLANTI_ADRESI'], ENT_QUOTES)."</textarea></center></td></tr>
<tr><td style='font-weight:bold'>Veri Tabanlarını Listeleme Sorgusu</td>
<td valign=center><center><textarea id=idveritabanlari".$row['RNO']." name=veritabanlari".$row['RNO']." rows=".(substr_count($row['VERITABANLARI'], "\n"))." cols=60>".$row['VERITABANLARI']."</textarea></center><input type=hidden name=eskiadi".$row['RNO']." value='".$row['VERITABANLARI']."'></input></td></tr>
<tr><td style='font-weight:bold'>Veri Tabanı Tablolarını Listeleme Sorgusu</td>
<td valign=center><center><textarea id=idtablolar".$row['RNO']." name=tablolar_sorgu".$row['RNO']." rows=".(substr_count($row['TABLOLAR'], "\n"))." cols=60>".htmlspecialchars($row['TABLOLAR'], ENT_QUOTES)."</textarea></center></td></tr>
<tr><td style='font-weight:bold'>Tablo Alanlarını Listeleme Sorgusu</td>
<td valign=center><center><textarea id=idislem".$row['RNO']." name=alanlar_sorgu".$row['RNO']." rows=".(substr_count($row['ISLEM'], "\n"))." cols=60>".htmlspecialchars($row['ISLEM'], ENT_QUOTES)."</textarea></center></td></tr>
<tr><td style='font-weight:bold'>Tablo Alanlarını Getirme Döngüsü</td>
<td valign=center><center><textarea id=idalanlar_getirme".$row['RNO']." name=alanlar_getirme".$row['RNO']." rows=".(substr_count($row['SUTUN_BILGILERI'], "\n"))." cols=60>".htmlspecialchars((isset($row['SUTUN_BILGILERI'])?$row['SUTUN_BILGILERI']:''), ENT_QUOTES)."</textarea></center></td></tr>
<tr><td style='font-weight:bold'>Veri Tabanı Kayıtlarını Getirme Döngüsü</td>
<td valign=center><center><textarea id=idveriler".$row['RNO']." name=kayit_getirme".$row['RNO']." rows=".(substr_count($row['VERILER'], "\n"))." cols=60>".htmlspecialchars($row['VERILER'], ENT_QUOTES)."</textarea></center></td></tr>
<tr><td style='font-weight:bold'>Veri İzleyici Oluşturma Komutu</td>
<td valign=center><center><textarea id=idizleyici_olusturma".$row['RNO']." name=izleyici_olusturma".$row['RNO']." rows=".(substr_count($row['TETIKLEYICI_EKLE'], "\n"))." cols=60>".htmlspecialchars((isset($row['TETIKLEYICI_EKLE'])?$row['TETIKLEYICI_EKLE']:''), ENT_QUOTES)."</textarea></center></td></tr>
<tr><td style='font-weight:bold'>Veri İzleyici Silme Komutu</td>
<td valign=center><center><textarea id=idizleyici_silme".$row['RNO']." name=izleyici_silme".$row['RNO']." rows=".(substr_count($row['TETIKLEYICI_SIL'], "\n"))." cols=60>".htmlspecialchars((isset($row['TETIKLEYICI_SIL'])?$row['TETIKLEYICI_SIL']:''), ENT_QUOTES)."</textarea></center></td></tr>
<tr><td style='font-weight:bold'>Veriseti Sorgusu</td>
<td valign=center><center><textarea id=idveriseti_sorgu".$row['RNO']." name=veriseti_sorgu".$row['RNO']." rows=".(substr_count($row['ZAMANSAL_SORGU'], "\n"))." cols=60>".htmlspecialchars((isset($row['ZAMANSAL_SORGU'])?$row['ZAMANSAL_SORGU']:''), ENT_QUOTES)."</textarea></center></td></tr>
<tr><td style='font-weight:bold'>Verisetini Getirme Döngüsü</td>
<td valign=center><center><textarea id=idveriseti_getirme".$row['RNO']." name=veriseti_getirme".$row['RNO']." rows=".(substr_count($row['ZAMANSAL_BILGI'], "\n"))." cols=60 >".htmlspecialchars((isset($row['ZAMANSAL_BILGI'])?$row['ZAMANSAL_BILGI']:''), ENT_QUOTES)."</textarea></center></td></tr>
<tr><td style='font-weight:bold'>Örnek Veri</td>
<td valign=center><center><textarea id=idornek_veri".$row['RNO']." name=ornek_veri".$row['RNO']." rows=".(substr_count($row['ORNEK_VERI'], "\n"))." cols=60 >".htmlspecialchars((isset($row['ORNEK_VERI'])?$row['ORNEK_VERI']:''), ENT_QUOTES)."</textarea></center></td></tr>";


			

	
}
if (isset($_GET['erisim'])=='1') {
	if ($_GET['erisim']=='1') {
    $sayacrenksatir=0;

    $sql15e="Select row_number() over (order by rowid) rno,s.* from
(select * from vis.erisim ".($banka?"where ADRES<>'Banka bağlantı'":"").") s ";
   // echo $sql15e;
	$erisimliste=oci_parse($conn, $sql15e);
    oci_execute($erisimliste);
		
if (isset($_GET['veritabani'])) {
	
	$sqlbaglanti="select * from vis.baglanti where adi='".$_GET['baglanti']."'";
	//echo $sqlbaglanti;
	$baglanti=oci_parse($conn,$sqlbaglanti);
	oci_execute($baglanti);
	$bilgi_baglanti=oci_fetch_assoc($baglanti); 
	

//echo $bilgi_baglanti['VERILER'];	
	/*
if ($_GET['veritabani']=='Oracle') {
$baglantim=	str_replace('sorgu',$bilgi_baglanti['VERITABANLARI'],$bilgi_baglanti['BAGLANTI_ADRESI']);
$baglantim=	str_replace('$sonuc','$kullaniciliste',$baglantim);
echo "<br>".$baglantim."<br>";
	eval($baglantim);

$baglantim=	str_replace('sorgu',$bilgi_baglanti['TABLOLAR'],$bilgi_baglanti['BAGLANTI_ADRESI']);
$baglantim=	str_replace('$sonuc','$tabloliste',$baglantim);
echo "<br>".$baglantim."<br>";
	eval($baglantim);
	
  //  $sql17="SELECT table_name FROM all_tables where owner='".(isset($_GET['kullanici'])?$_GET['kullanici']:'')."'order by table_name";
	//$tabloliste=oci_parse($conn, $sql17);
 //   oci_execute($tabloliste); 
} 

if ($_GET['veritabani']=='MySQL') {	
$baglantim=	str_replace('sorgu',$bilgi_baglanti['VERITABANLARI'],$bilgi_baglanti['BAGLANTI_ADRESI']);
$baglantim=	str_replace('$sonuc','$kullaniciliste',$baglantim);
echo "<br>".$baglantim."<br>";
eval($baglantim);

	//$kullaniciliste = $conmy->query($bilgi_baglanti['VERITABANLARI']);
	
	$baglantim=	str_replace('sorgu',$bilgi_baglanti['TABLOLAR'],$bilgi_baglanti['BAGLANTI_ADRESI']);
$baglantim=	str_replace('$sonuc','$tabloliste',$baglantim);
echo "<br>".$baglantim."<br>";
	eval($baglantim);
	
//	$sql17="SELECT table_name FROM information_schema.tables where table_schema='".(isset($_GET['kullanici'])?$_GET['kullanici']:'')."'";
  //	$tabloliste = $conmy->query($sql17);
  }*/
}  
     if(isset($_POST['kaydet'])){
         for($i=1;$i<=$_POST['toplam'];$i++){
             $sqlupsistem= "update vis.erisim set adi='".$_POST['adi'.$i]."' where adres='".$_POST['adres'.$i]."' and veritabani='".$_POST['veritabani'.$i]."' and sifre='".$_POST['sifre'.$i]."' and ADI='".$_POST['eskiadi'.$i]."'";
    //       echo $sqlupsistem;
             $upsistem=oci_parse($conn, $sqlupsistem);
             oci_execute($upsistem);			 		 
		 }
        //header("location:login_success.php?erisim=1");
		//echo "<script>window.location.href('?erisim=1')</script>";
		
	 }

if(isset($_POST['ekle'])){
$tablo=(isset($_POST['tablo1'])?$_POST['tablo']."[".$_POST['tablo1']."]":$_POST['tablo']);
         $sqlinsistem= "insert into vis.erisim values('".$_GET['baglanti']."','".$_GET['username']."','".$tablo."','".$_POST['adi']."')";
        //echo $sqlinsistem;
		 $insistem=oci_parse($conn, $sqlinsistem);
         oci_execute($insistem);
         //header("location:login_success.php?erisim=1");
		// echo "<script>window.location.reload();</script>";
     }
	
if(isset($_POST['toplam'])){
  for($i=1;$i<=$_POST['toplam'];$i++){	
	 if(isset($_POST['sil'.$i])){	
         $sqlsilsistem= "delete vis.erisim where adres='".$_POST['adres'.$i]."' and veritabani='".$_POST['veritabani'.$i]."' and sifre='".$_POST['sifre'.$i]."' and adi='".$_POST['adi'.$i]."'";
         //echo $sqlsilsistem;
		 $silsistem=oci_parse($conn, $sqlsilsistem);
         oci_execute($silsistem);
         //header("location:login_success.php?erisim=1");
		// echo "<script>window.location.reload();</script>";
     }
	 }
	 }

     echo $navbar1.'Tablo Erişimi'.$navbar2.'

<tr style="font-weight:bold" align=center><td></td><td>Bağlantı Adı</td><td>Veri Tabanı</td><td>Tablo</td><td>Erişim Adı</td></tr>
<tr><td align=center><input type=submit name=ekle value=" Ekle "></input></td>
<td align=center><select name=baglanti
onChange="(window.location = this.options[this.selectedIndex].value);">

'.(isset($_GET['baglanti'])?'':'<option disabled=disabled selected=selected>Bağlantı seçiniz</option>');
    
	$donemliste=oci_parse($conn, $sql15);oci_execute($donemliste);
    while (($row = oci_fetch_array($donemliste, OCI_BOTH)) != false){
        echo "<option value='?erisim=1&baglanti=".$row['ADI']."&veritabani=".$row['VERITABANI']."' ".(isset($_GET['baglanti'])?($_GET['baglanti']==$row['ADI']?'selected=selected':''):'').">".$row['ADI']."</option>";        
    }
	
echo "</td>
<td><select name=kullanici
onChange='(window.location = this.options[this.selectedIndex].value);'>
".(isset($_GET['kullanici'])?"":"<option disabled=disabled selected=selected>Veri Tabanı seçiniz</option>");
if($bilgi_baglanti['VERITABANI']=='Oracle'){
	$bilgi_baglanti['VERITABANLARI']="select * from all_users where common='NO' and user_id not in(200,175,224,103) order by username";
	
}
$baglantim=	str_replace('sorgu',$bilgi_baglanti['VERITABANLARI'],$bilgi_baglanti['BAGLANTI_ADRESI']);
//$baglantim=	str_replace('$sonuc','$kullaniciliste',$baglantim);
//echo "<br>".$baglantim."<br>";
//$consql=sqlsrv_connect('FERHAT-PC',  array('Database'=>( isset($_GET['username'])?$_GET['username']:'deneme'), 'UID'=>'sa', 'PWD'=>'oracle'));
//$sonuc =sqlsrv_prepare( $consql, "SELECT name as username FROM master.sys.databases 
//where owner_sid<>0x01");
//sqlsrv_execute($sonuc);
//ECHO $baglantim;
	eval($baglantim);
	
	//$veriler=str_replace('$sonuc','$kullaniciliste',$bilgi_baglanti['VERILER']);
		$veriler=$bilgi_baglanti['VERILER'];
$secenek= "<option value='?erisim=1&baglanti=".$_GET['baglanti']."&column=degisken&veritabani=".$_GET['veritabani']."' secilen>degisken</option>";
$veriler=str_replace('secenek',$secenek,$veriler);
$veriler=str_replace('column','username',$veriler);
//echo "BU=".$veriler."=BU";
eval($veriler);


/*
while (($row=oci_fetch_array($sonuc, OCI_BOTH)) != false){ 
echo str_replace('secilen', ( isset($_GET['kullanici'])?($_GET['kullanici']==$row['column']?"selected=selected":""):""), str_replace("degisken",$row['column'],"secenek"))




/*
if ($_GET['veritabani']=='Oracle') {
	$baglantim=	str_replace('sorgu',$bilgi_baglanti['VERITABANLARI'],$bilgi_baglanti['BAGLANTI_ADRESI']);
$baglantim=	str_replace('$sonuc','$kullaniciliste',$baglantim);
//echo "<br>".$baglantim."<br>";
	eval($baglantim);
	
	$veriler=str_replace('$sonuc','$kullaniciliste',$bilgi_baglanti['VERILER']);
$secenek= "<option value='?erisim=1&baglanti=".$_GET['baglanti']."&kullanici=degisken&veritabani=".$_GET['veritabani']."' ".(isset($_GET['kullanici'])?($_GET['kullanici']=="degisken"?'selected=selected':''):'').">degisken</option>";
$veriler=str_replace('secenek',$secenek,$veriler);
$veriler=str_replace('column','USERNAME',$veriler);
eval($veriler);
	} 
	
	if ($_GET['veritabani']=='MySQL') 	{
	 while ($row = $kullaniciliste->fetch_assoc()){
        echo "<option value='?erisim=1&baglanti=".$_GET['baglanti']."&kullanici=".$row['USERNAME']."&veritabani=".$_GET['veritabani']."' ".(isset($_GET['kullanici'])?($_GET['kullanici']==$row['USERNAME']?'selected=selected':''):'
		').">".$row['USERNAME']."</option>";  }
	}
*/
//onChange='this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);'	
echo "</td>

<td align='center'><select name=tablo  id=idtablo>
".(isset($_GET['tablo'])?"":"<option disabled=disabled selected=selected>Tablo seçiniz</option>");
$icerik=file_get_contents( $bilgi_baglanti['ADRES'], false, stream_context_create($arrContextOptions));		
  
  $baglantim=	str_replace('sorgu',$bilgi_baglanti['TABLOLAR'],$bilgi_baglanti['BAGLANTI_ADRESI']);
//$baglantim=	str_replace('$sonuc','$tabloliste',$baglantim);
//echo "BU=".$baglantim."=BU";
eval($baglantim);

//$veriler=str_replace('$sonuc','$tabloliste',$bilgi_baglanti['VERILER']);
$veriler=($_GET['veritabani']=='Harici'?$bilgi_baglanti['ZAMANSAL_BILGI']:$bilgi_baglanti['VERILER']);//Harici verilerde çoklu dizileri açmak için verilerdeki kodlar tetikleyici sile taşındı
//$secenek= "<option value='?erisim=1&baglanti=".$_GET['baglanti']."&username=".$_GET['username']."&column=degisken&veritabani=".$_GET['veritabani']."' secilen>degisken</option>";
$secenek= "<option value='degisken' >degisken</option>";
$veriler=str_replace('secenek',$secenek,$veriler);
$veriler=str_replace('column','table_name',$veriler);

//$dizi=(isset($_GET['username'])?'sonuc['.$_GET['username'].']':'sonuc');
$dizi=(isset($_GET['username'])?'sonuc':'sonuc');
$veriler=str_replace('sonuc',$dizi,$veriler);
//echo "BU=".$veriler."=BU";
eval($veriler);
/*
print_r($sonuc);

foreach($sonuc as $key=>$val){
echo $val->{$_GET['username']};
}


foreach($sonuc as $key=>$val){
	echo str_replace('secilen',
	( isset($_GET['table_name'])?($_GET['table_name']==$key?"selected=selected":""):""),
	str_replace("degisken",
		$key->$_GET['table_name'],
		"<option value='?erisim=1&baglanti=Atauni avesis bağlantı&username=TopicName&table_name=degisken&veritabani=Harici' secilen>degisken</option>"));}


while ($row=oci_fetch_array($sonuc, OCI_BOTH)) { 

echo str_replace('secilen',
( isset($_GET['table_name'])?($_GET['table_name']==$row[strtoupper('table_name')]?"selected=selected":""):""),
str_replace("degisken",$row[strtoupper('table_name')],"<option value='?erisim=1&baglanti=Oracle bağlantı&username=TEST&table_name=degisken&veritabani=Oracle' secilen>degisken</option>"));


}

*/

  /*
  if ($_GET['veritabani']=='Oracle') {
	  $baglantim=	str_replace('sorgu',$bilgi_baglanti['TABLOLAR'],$bilgi_baglanti['BAGLANTI_ADRESI']);
$baglantim=	str_replace('$sonuc','$tabloliste',$baglantim);
//echo "<br>".$baglantim."<br>";
	eval($baglantim);
$veriler=str_replace('$sonuc','$tabloliste',$bilgi_baglanti['VERILER']);
$secenek= "<option value='?erisim=1&baglanti=".$_GET['baglanti']."&kullanici=".$_GET['kullanici']."&tablo=degisken&veritabani=".$_GET['veritabani']."' ".(isset($_GET['tablo'])?($_GET['tablo']=="degisken"?'selected=selected':''):'').">degisken</option>";
$veriler=str_replace('secenek',$secenek,$veriler);
$veriler=str_replace('column','TABLE_NAME',$veriler);
eval($veriler);
        
	}
	if ($_GET['veritabani']=='MySQL') {
	while ($row = $tabloliste->fetch_assoc()){
        echo "<option value='?erisim=1&baglanti=".$_GET['baglanti']."&kullanici=".$_GET['kullanici']."&tablo=".$row['TABLE_NAME']."&veritabani=".$_GET['veritabani']."' ".(isset($_GET['tablo'])?($_GET['tablo']==$row['TABLE_NAME']?'selected=selected':''):'
		').">".$row['TABLE_NAME']."</option>";}
	}*/
	
	
echo "</select>";
if(isset($_GET['veritabani'])) {
	if(($_GET['veritabani']=='Harici')&&($_GET['username']<>'ÖBS')){
		//onChange='this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);'
echo "<select name=tablo1 id=idtablo1>
".(isset($_GET['tablo'])?"":"<option disabled=disabled selected=selected>Alan seçiniz</option>");
  
  $baglantim=	str_replace('sorgu',$bilgi_baglanti['TABLOLAR'],$bilgi_baglanti['BAGLANTI_ADRESI']);
  eval($baglantim);

$veriler=$bilgi_baglanti['ZAMANSAL_BILGI'];//Harici verilerde çoklu dizileri açmak için verilerdeki kodlar tetikleyici sile taşındı
//$secenek= "<option value='?erisim=1&baglanti=".$_GET['baglanti']."&username=".$_GET['username']."&column=degisken&veritabani=".$_GET['veritabani']."' secilen>degisken</option>";
$secenek= "<option value='degisken' >degisken</option>";
$veriler=str_replace('secenek',$secenek,$veriler);
$veriler=str_replace('column','table_name',$veriler);

$dizi=(isset($_GET['username'])?'sonuc':'sonuc');
$veriler=str_replace('sonuc',$dizi,$veriler);
eval($veriler);
echo "</select>";
}
}

echo "</td><td align='center'><input name=adi type=text></td></tr>

<tr bgcolor=#DDDDDD><td colspan=5><center><h2>Mevcut Erişimler</h2></center></td></tr>
<tr style='font-weight:bold' align='center'><td></td><td>Bağlantı Adı</td><td>Veri Tabanı</td><td>Tablo</td><td>Erişim Adı</td></tr>";
    $donemliste=oci_parse($conn, $sql15);
    oci_execute($donemliste);    
    while (($row = oci_fetch_array($erisimliste, OCI_BOTH)) != false){
        
  echo "<tr bgcolor=#".($row['RNO'] % 2 ?'FFFFFF':'F7F7F7' ).">
<td><center><input type=submit name=sil".$row['RNO']." value=' Sil '></input></center></td>
<td><center>".$row['ADRES']."</center><input type=hidden name=adres".$row['RNO']." value='".$row['ADRES']."'></input></td>
<td><center>".$row['VERITABANI']."</center><input type=hidden name=veritabani".$row['RNO']." value='".$row['VERITABANI']."'></input></td>
<td><center>".$row['SIFRE']."<input type=hidden name=sifre".$row['RNO']." value='".$row['SIFRE']."'></input></td>
<td><center>".$row['ADI']."<input name=adi".$row['RNO']." type=hidden value='".$row['ADI']."'></input></center><input type=hidden name=eskiadi".$row['RNO']." value='".$row['ADI']."'></input></td></tr>";
        $toplam=$row['RNO'];
    }
        
    echo "<tr><td colspan=5 align=center><input type=hidden name=toplam value=".(isset($toplam)?$toplam:0)."></input></td></tr>";


	 
}
}

if (isset($_GET['islem'])=='1') {
	if ($_GET['islem']=='1') {
    $sayacrenksatir=0;
    $sql15="Select row_number() over (order by rowid) rno,s.* from
(select (select veritabani from vis.baglanti where adi=s.adres) veritaban,s.* from vis.erisim s WHERE ADI NOT IN('Usd alış erişim','Usd satış erişim')) s";
    $erisimliste=oci_parse($conn, $sql15);
    oci_execute($erisimliste);

$erisimsayi['SAYI']=null;
if (isset($_GET['erisim'])){
	$sql15t="select * from vis.erisim where adi='".$_GET['erisim']."'";
    $erisimtek=oci_parse($conn, $sql15t);
    oci_execute($erisimtek);
	$erisimbilgi=oci_fetch_assoc($erisimtek);	
$sql15s="select count(*) SAYI from ".$erisimbilgi['VERITABANI'].".".$erisimbilgi['SIFRE'];	
	//echo $sql15s;
	
	
/*	if (isset($_GET['veritabani'])) {
	
	$sqlbaglanti="select * from vis.baglanti where adi=
	(select adres from vis.erisim where adi='".$_GET['erisim']."')";
	//echo $sqlbaglanti;
	$baglanti=oci_parse($conn,$sqlbaglanti);
	oci_execute($baglanti);
	$bilgi_baglanti=oci_fetch_assoc($baglanti);
	//} else {
$icerik=file_get_contents( $bilgi_baglanti['ADRES'], false, stream_context_create($arrContextOptions));		
	}
if (isset($icerik)){	
	$baglantim=	str_replace('sorgu',$bilgi_baglanti['TABLOLAR'],$bilgi_baglanti['BAGLANTI_ADRESI']);
	$baglantim=	str_replace('$sonuc','$alanlar',$baglantim);
	//echo "BU=".$baglantim."BU=";
	//if($bilgi_baglanti['VERITABANI']<>'Harici') 
eval($baglantim);}
*/
	if (isset($_GET['veritabani'])) {
	
	$sqlbaglanti="select * from vis.baglanti where adi=
	(select adres from vis.erisim where adi='".$_GET['erisim']."')";
	//echo $sqlbaglanti;
	$baglanti=oci_parse($conn,$sqlbaglanti);
	oci_execute($baglanti);
	$bilgi_baglanti=oci_fetch_assoc($baglanti);
	
	if($bilgi_baglanti['VERITABANI']=='Harici')  {
$icerik=file_get_contents( $bilgi_baglanti['ADRES'], false, stream_context_create($arrContextOptions));		
	$baglantim=	str_replace('sorgu',$bilgi_baglanti['TABLOLAR'],$bilgi_baglanti['BAGLANTI_ADRESI']);
	//$baglantim=	str_replace('$sonuc','$alanlar',$baglantim);

//ECHO "BU0=".$baglantim."=BU0";
	eval($baglantim);
	}

	}

	/*
$dizi=array( 'Database'=>( isset($_GET['username'])?$_GET['username']:'master'), 'UID'=>'sa', 'PWD'=>'oracle');	
$consql=sqlsrv_connect( 'FERHAT-PC', $dizi); 
$sorgu="SELECT data_type, column_name = STUFF( (SELECT ',' + column_name FROM 
".(isset($_GET['username'])?$_GET['username']:'BEKLE').".INFORMATION_SCHEMA.COLUMNS t1 
WHERE table_name='".$erisimbilgi['SIFRE']."' 
and t1.data_type = t2.data_type FOR XML PATH ('')) , 1, 1, '') 
from ".(isset($_GET['username'])?$_GET['username']:'BEKLE').".INFORMATION_SCHEMA.COLUMNS t2 
where table_name='".$erisimbilgi['SIFRE']."' group by data_type;";
echo $dizi['Database'].$sorgu;
$alanlar =sqlsrv_prepare( $consql, $sorgu); 
sqlsrv_execute($alanlar);*/
	/*
	if ($_GET['veritabani']=='Oracle') {
	//$sqlalanlar="";
	
    $erisimsay=oci_parse($conn, $sql15s);
    oci_execute($erisimsay);
	$erisimsayi=oci_fetch_assoc($erisimsay);
  
   //$alanlar=oci_parse($conn, $sqlalanlar);
    //oci_execute($alanlar);
	////$alan=oci_fetch_assoc($alanlar);
	}

	
	if ($_GET['veritabani']=='MySQL') {		
	//$sqlalanlar="select data_type, GROUP_CONCAT(column_name SEPARATOR ', ') COLUMN_NAME
 //from information_schema.columns WHERE table_schema='".$erisimbilgi['VERITABANI']."' and table_name = '".$erisimbilgi['SIFRE']."' group by data_type";
	
	$result = mysqli_query($conmy, $sql15s);
	$erisimsayi = mysqli_fetch_assoc($result);
	//$erisimsayi = $conmy->query($sql15s)->fetch_object()->erisimsayi;		
	
	////$resultalanlar = mysqli_query($conmy, $sqlalanlar);
	////$alanlar = mysqli_fetch_assoc($resultalanlar);
	//$alanlar = $conmy->query($sqlalanlar);
	}
*/
	
	
	}
	

    $sql15e="Select row_number() over (order by rowid) rno,s.* from
(select i.*,(select sifre from vis.erisim e where e.adi=i.adres) tablo from vis.islem i where ADI NOT IN('Usd alış işlemi','Usd satış işlemi')) s order by veritabani";//
    $islemliste=oci_parse($conn, $sql15e);
    oci_execute($islemliste);
	
	    $sql15b="select nvl((max(veritabani)),0)+1 yeni_no from vis.islem";
    $islembilgi=oci_parse($conn, $sql15b);
    oci_execute($islembilgi);
		$islembilgi=oci_fetch_assoc($islembilgi);	
	
    $sql16="select username from all_users where common='NO' order by username";
    
	$kullaniciliste=oci_parse($conn, $sql16);
    oci_execute($kullaniciliste);

    $sql17="SELECT table_name FROM all_tables where owner='".(isset($_GET['kullanici'])?$_GET['kullanici']:'')."'order by table_name";
    $tabloliste=oci_parse($conn, $sql17);
    oci_execute($tabloliste); 
	
     if(isset($_POST['kaydet'])){
         for($i=1;$i<=$_POST['toplam'];$i++){
             $sqlupsistem= "update vis.islem set adi='".$_POST['adi'.$i]."' where adres='".$_POST['adres'.$i]."' and veritabani='".$_POST['veritabani'.$i]."' and sifre='".$_POST['sifre'.$i]."' and ADI='".$_POST['eskiadi'.$i]."'";
//           echo $sqlupsistem;
             $upsistem=oci_parse($conn, $sqlupsistem);
             oci_execute($upsistem);			 		 
		 }
	    // header("location:login_success.php?islem=1");
//		echo "<script>window.location.href('?islem=1')</script>";
     }

if(isset($_POST['ekle'])){
         		 
		////$query = str_replace(chr(13), ' ', $_POST['islemsql']);
		////$query = str_replace(chr(10),' ', $query); 
		////$query = trim(preg_replace('/\s+/', ' ',$query));


	$baglantim=	str_replace('sorgu',$bilgi_baglanti['TETIKLEYICI_EKLE'],$bilgi_baglanti['BAGLANTI_ADRESI']);
	$baglantim=	str_replace('$sonuc','$sonuctrigger',$baglantim);
	//echo $baglantim;	
	if($bilgi_baglanti['VERITABANI']<>'Harici') {eval($baglantim);} else
		{
			//$_SESSION['baglanti_adresi']=$bilgi_baglanti['BAGLANTI_ADRESI'];
			//$_SESSION['tablolar']=$bilgi_baglanti['TABLOLAR'];
			//$_SESSION['islem']=$bilgi_baglanti['ISLEM'];
			$link = "<script>
		window.open('?izleme=1&erisim=".$_GET['erisim']."&adi=".$_POST['adi']."&tablo=".$erisimbilgi['SIFRE']."','_blank','width=296,height=278,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=0,left=0,top=0');
		</script>";
	$sqlinsistem= "insert into vis.islem values('".$_GET['erisim']."','".$islembilgi['YENI_NO']."','".$_GET['veritabani']."@".$erisimbilgi['VERITABANI'].".VERI_TOPLA".$islembilgi['YENI_NO']."','".$_POST['adi']."','".$_POST['islemsql']."','".$_POST['tipi']."')";
         //echo $sqlinsistem;
		 $insistem=oci_parse($conn, $sqlinsistem);
         oci_execute($insistem);
echo $link;
}
	
	/*
	if ($_GET['veritabani']=='Oracle') {
			$sqltrigger="CREATE OR REPLACE TRIGGER ".$erisimbilgi['VERITABANI'].".VERI_TOPLA".$islembilgi['YENI_NO']." AFTER INSERT OR DELETE OR UPDATE ON  
".(isset($_GET['erisim'])?$erisimbilgi['VERITABANI'].".".$erisimbilgi['SIFRE']:'')." 
BEGIN 
INSERT INTO vis.VERI (KAYNAK,DEGER) VALUES('".(isset($_POST['adi'])?$_POST['adi']:'')."',(".$_POST['islemsql']."));   
END;";	

$instrigger=oci_parse($conn, $sqltrigger);
        $sonuctrigger=oci_execute($instrigger);
		////$instrigger=oci_parse($conn, "ALTER TRIGGER vis.VERI_TOPLA".$islembilgi['YENI_NO']." DISABLE");
        ////oci_execute($instrigger);
	}
	if ($_GET['veritabani']=='MySQL') {
		$sqltrigger="CREATE TRIGGER ".$erisimbilgi['VERITABANI'].".VERI_TOPLA".$islembilgi['YENI_NO']."_INS AFTER INSERT ON
".(isset($_GET['erisim'])?$erisimbilgi['VERITABANI'].".".$erisimbilgi['SIFRE']:'')." FOR EACH ROW 
INSERT INTO vis.VERI (KAYNAK,DEGER) VALUES('".(isset($_POST['adi'])?$_POST['adi']:'')."',(".$_POST['islemsql'].")); ";
		$sonuctrigger=mysqli_multi_query($conmy, $sqltrigger);       
		////$instrigger=mysqli_query($conmy, "ALTER TRIGGER vis.VERI_TOPLA".$islembilgi['YENI_NO']." DISABLE");
        
	}
	*/
	
	if(isset($sonuctrigger)){
	$sqlinsistem= "insert into vis.islem values('".$_GET['erisim']."','".$islembilgi['YENI_NO']."','".$_GET['veritabani']."@".$erisimbilgi['VERITABANI'].".VERI_TOPLA".$islembilgi['YENI_NO']."','".$_POST['adi']."','".$_POST['islemsql']."','".$_POST['tipi']."')";
         //echo $sqlinsistem;
		 $insistem=oci_parse($conn, $sqlinsistem);
         oci_execute($insistem);
		 //header("location:login_success.php?islem=1");
		 //echo "<script>window.location.href('?islem=1')</script>";
	}	 
 //echo $sqltrigger;	
/*
	$e = oci_error($instrigger);
	print "\n<pre>\n";
    print htmlentities($e['sqltext']);
    printf("\n%".($e['offset']+1)."s", "^");
    print  "\n</pre>\n";

	SELECT SCN_TO_TIMESTAMP(MAX(ora_rowscn)) FROM vis.ANKETGORUS
	
	*/
		 
	 		 		 
         //header("location:login_success.php?islem=1");
     }

if(isset($_POST['toplam'])){	
  for($i=1;$i<=$_POST['toplam'];$i++){	
	 if(isset($_POST['sil'.$i])){
		 $part=explode("@",$_POST['sifre'.$i]);
		 
	$sqlbaglanti="select * from vis.baglanti where veritabani='".$part[0]."'";
	$baglanti=oci_parse($conn,$sqlbaglanti);
	oci_execute($baglanti);
	$bilgi_baglanti=oci_fetch_assoc($baglanti);
	
		 	$baglantim=	str_replace('sorgu',$bilgi_baglanti['TETIKLEYICI_SIL'],$bilgi_baglanti['BAGLANTI_ADRESI']);
			$baglantim=	str_replace('$sonuc','$sonuctriggersil',$baglantim);
			//ECHO $baglantim;
			/*$sonuctriggersil =pg_query( pg_pconnect("host=localhost port=5432 dbname=".( isset($_GET['username'])?$_GET['username']:'DEMIRBAS')." user=postgres password=oracle"), "drop trigger ".explode('.',$part[1])[1]." on ".sprintf('"%s"',$_POST['tablo'.$i])."; drop function ".explode('.',$part[1])[1].";");
			
			$consql=sqlsrv_connect( 'FERHAT-PC', array( 'Database'=>( isset($_GET['username'])?$_GET['username']:'master'), 'UID'=>'sa', 'PWD'=>'oracle')); 
			$sorgu="DROP TRIGGER ".explode('.',$part[1])[1]." ON DATABASE";
			
			$sonuctriggersil =sqlsrv_prepare( $consql, $sorgu); 
			ECHO "BU".$sorgu;
			sqlsrv_execute($sonuctriggersil);
			    if( ($errors = sqlsrv_errors() ) != null) {
        foreach( $errors as $error ) {
            echo "SQLSTATE: ".$error[ 'SQLSTATE']."<br />";
            echo "code: ".$error[ 'code']."<br />";
            echo "message: ".$error[ 'message']."<br />";
        }
    }*/
			if($bilgi_baglanti['VERITABANI']<>'Harici') {eval($baglantim);} else
		{
		$sonuctriggersil=true;}
	
		/* 
		 $sqlsiltrigger="DROP TRIGGER ".$part[1];
		 
		 if ($part[0]=='Oracle') {
		 $siltrigger=oci_parse($conn, $sqlsiltrigger);
         $sonuctriggersil=oci_execute($siltrigger);
		 }
		 
		 if ($part[0]=='MySQL') {
		 $sqlsiltrigger.="_INS;";
		$sonuctriggersil=mysqli_query($conmy, $sqlsiltrigger);       		 		 
		 }	
		 */
	if($sonuctriggersil){
         $sqlsilsistem= "delete vis.islem where veritabani='".$_POST['veritabani'.$i]."' and adi='".$_POST['adi'.$i]."'";
         //echo $sqlsilsistem;
		 $silsistem=oci_parse($conn, $sqlsilsistem);
         oci_execute($silsistem);
         //header("location:login_success.php?islem=1");
	}
//echo $sqlsiltrigger;	
	 
	 }
	 }

	//ECHO $_POST['toplam'];
	}	

     echo $navbar1.'Veri Toplama İşlemi'.$navbar2.'

<tr style="font-weight:bold" align=center>
<tr><td>Erişim Adı</td><td align=center><select name=erisim
onChange="this.options[this.selectedIndex].value  && (window.location = this.options[this.selectedIndex].value);">

'.(isset($_GET['erisim'])?'':'<option disabled=disabled selected=selected>Erişim seçiniz</option>');
    
    while (($row = oci_fetch_array($erisimliste, OCI_BOTH)) != false){
        echo "<option value='?islem=1&erisim=".$row['ADI']."&veritabani=".$row['VERITABAN']."&username=".$row['VERITABANI']."' ".(isset($_GET['erisim'])?($_GET['erisim']==$row['ADI']?'selected=selected':''):'').">".$row['ADI']."</option>";        
    }
//if($bilgi_baglanti['VERITABANI']<>'Harici'){	
echo "</td>
<td rowspan=4>
<textarea rows=10 cols=50 name=islemsql>";
echo "SELECT COUNT(*) SAYI FROM ";
if(isset($bilgi_baglanti)&&$bilgi_baglanti['VERITABANI']<>'Harici') {echo (isset($_GET['erisim'])?$erisimbilgi['VERITABANI'].".".$erisimbilgi['SIFRE']:'');} 
echo"</textarea><br><br>
<input type=submit name=ekle value=' Ekle '></input>
</td>
</tr><tr><td>Alanlar</td>";
//}

echo "<td><table class=table>";

if (isset($_GET['erisim'])){
	/*
	$sqlbaglanti="select * from vis.baglanti where veritabani='".$_GET['veritabani']."'";
	$baglanti=oci_parse($conn,$sqlbaglanti);
	oci_execute($baglanti);
	$bilgi_baglanti=oci_fetch_assoc($baglanti);

	

//echo "<br>".$baglantim."<br>";
	eval($baglantim);
	*/
	
	


if($bilgi_baglanti['VERITABANI']<>'Harici') {
	
$baglantim=	str_replace('sorgu',$bilgi_baglanti['ISLEM'],$bilgi_baglanti['BAGLANTI_ADRESI']);
//$baglantim=	str_replace('$sonuc','$alanlar',$baglantim);	
eval($baglantim);
//echo "BU=".$baglantim."BU="; 	
//$veriler=	str_replace('sorgu',$bilgi_baglanti['SUTUN_BILGILERI'],$bilgi_baglanti['BAGLANTI_ADRESI']);
//$veriler=	str_replace('$sonuc','$alanlar',$baglantim);
//$veriler=   str_replace('column','USERNAME',$bilgi_baglanti['SUTUN_BILGILERI']);
$veriler=   $bilgi_baglanti['SUTUN_BILGILERI'];

} else {//Harici verilerde çoklu dizileri açmak için verilerdeki kodlar tetikleyici sile taşındı
//$veriler=str_replace('$sonuc','$alanlar',$bilgi_baglanti['ZAMANSAL_SORGU']);
$veriler=$bilgi_baglanti['ZAMANSAL_SORGU'];
$alan=explode("[",$erisimbilgi['SIFRE']);
@$alan[1]=substr($alan[1],0,-1);
}

// echo "BU=".$veriler."BU=";

eval($veriler);
	
	
	
/*	
if ($_GET['veritabani']=='Oracle') {
while (($row = oci_fetch_array($alanlar, OCI_BOTH)) != false){	 
	  echo "<tr><td>".$row['DATA_TYPE']."</td><td>".$row['COLUMN_NAME']."</td><tr>"; }
}

if ($_GET['veritabani']=='MySQL') {
while ($row = $alanlar->fetch_assoc()){	 
	  echo "<tr><td>".$row['DATA_TYPE']."</td><td>".$row['COLUMN_NAME']."</td><tr>"; }
	
}
*/

}
echo "</table></td></tr>
<tr><td>Kullanıcı Düzeyi</td>
<td align='center'>
&nbsp;<input type=radio name=tipi value=Üst></input> <u>Üst</u>&nbsp;&nbsp;&nbsp;
&nbsp;<input type=radio name=tipi value=Orta></input> <u>Orta</u>&nbsp;&nbsp;&nbsp;
&nbsp;<input type=radio name=tipi value=Alt></input> <u>Alt</u>
</td></tr>
<tr><td>İşlem Adı</td><td align='center'><input name=adi type=text></td></tr>

<tr><td colspan=5><center><h4><a href=?izleme=0 target=_blank>
Anlık Veri İzleme ve Kayıt Penceresi</a></h4></center></td></tr>
<tr bgcolor=#DDDDDD><td colspan=5><center><h2>Mevcut İşlemler</h2></center></td></tr>
<tr style='font-weight:bold' align='center'><td></td><td>İşlem Adı</td><td>İşlem Adresi</td></tr>";
    $islemliste=oci_parse($conn, $sql15e);
    oci_execute($islemliste); $toplam=0;   

    while (($row = oci_fetch_array($islemliste, OCI_BOTH)) != false){
  $link= "izleme.php?iadi=".utf8_encode($row['ADI'])."&deger=0";
  echo "<tr bgcolor=#".($row['RNO'] % 2 ?'FFFFFF':'F7F7F7' ).">
<td><center><input type=submit name=sil".$row['RNO']." value=' Sil '></input></center></td>
<td><center>
<a href=\"javascript:window.open('".$link."','_blank','width=296,height=278,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=0,left=0,top=0')\" >".$row['ADI']."</a></center>
<input type=hidden name=adi".$row['RNO']." value='".$row['ADI']."'></input></td>
<td><center>".$row['SIFRE']."</center><input type=hidden name=sifre".$row['RNO']." value='".$row['SIFRE']."'></input>
<input type=hidden name=veritabani".$row['RNO']." value='".$row['VERITABANI']."'></input>
<input type=hidden name=tablo".$row['RNO']." value='".$row['TABLO']."'></input></td>
</tr>";
        $toplam++;
    }
        
    echo "<tr><td colspan=3 align=center><input type=hidden name=toplam value=".(isset($toplam)?$toplam:0)."></input></td></tr>";


	 
}
}
if (isset($_GET['izleme'])) {
if ($_GET['izleme']=='0') {
		$sqlbaglanti="select  i.adi iadi, e.adi,e.sifre tablo,b.adres,b.tablolar,b.baglanti_adresi,b.islem 
		from vis.baglanti b, vis.erisim e, vis.islem i where b.adi=e.adres and e.adi=i.adres
		 --and b.veritabani='Harici'";
	$baglanti=oci_parse($conn,$sqlbaglanti);
	oci_execute($baglanti);$say=0;
echo "<table  class=table style='width:300'>
<tr style='font-weight:bold' align=center><td colspan=3>ANLIK VERİ İZLEME VE KAYIT</td></tr>
<tr style='font-weight:bold'>
<td >Veri".str_repeat('&nbsp;',20)."</td>
<td >Değer</td>
<td >Güncelleme<br>kalan saniye</td></tr>";
	 while (($row = oci_fetch_array($baglanti, OCI_BOTH)) != false){
			$say++;
	echo "<tr><td valign=center>".$row['IADI']."</td>
	<td valign=top colspan=2><iframe scrolling=no width=180 height=20 src='izleme.php?iadi=".utf8_encode($row['IADI'])."&deger=0' frameborder=0 scrolling=false></iframe></td>
	</tr>";	 	 
	 }
echo "</table>"; 
}}

/*
if (isset($_GET['izleme'])=='1') {
		$sqlbaglanti="select adres,tablolar,baglanti_adresi,islem,
		(select sorgu from vis.islem where adres='".$_GET['erisim']."') sorgu
		from vis.baglanti b where adi=
	(select adres from vis.erisim where adi='".$_GET['erisim']."')";
	$baglanti=oci_parse($conn,$sqlbaglanti);
	oci_execute($baglanti);
	$bilgi_baglanti=oci_fetch_assoc($baglanti);
$icerik=file_get_contents( $bilgi_baglanti['ADRES'], false, stream_context_create($arrContextOptions));		
if ($icerik){
$baglantim =str_replace('sorgu',$bilgi_baglanti['TABLOLAR'],$bilgi_baglanti['BAGLANTI_ADRESI']);
$baglantim .=$bilgi_baglanti['ISLEM'];
$baglantim =str_replace('veri',$_GET['tablo'],$baglantim);
eval($baglantim);
} else {echo "\n Sayfa 30 saniye sonra yeniden yüklenecek.<script>window.location.reload()</script>";sleep(2);}
$sql_tekrar_kontrol="SELECT deger FROM veri where kaynak='".$_GET['adi']."' order by guncelleme desc  fetch first 1 rows only";
$sql_ins="insert into vis.veri (kaynak,deger) values('".$_GET['adi']."',".$deger.")";
		 $insistem=oci_parse($conn, $sql_ins);
         oci_execute($insistem); 
echo "<meta http-equiv=refresh content='60;url=?izleme=1&erisim=".$_GET['erisim']."&adi=".$_GET['adi']."&tablo=".$_GET['tablo']."' />";	
}*/



if (isset($_GET['baslik'])=='1') {
    $sayacrenksatir=0;

    $sql15e="Select row_number() over (order by rowid) rno,s.* from
(select * from vis.erisim WHERE ADI NOT IN ('Usd alış erişim','Usd satış erişim')) s";
    $erisimliste=oci_parse($conn, $sql15e);
    oci_execute($erisimliste);

    $sql15b="select * from vis.baslik WHERE ADI NOT IN('Usd alış','Usd satış') order by sifre desc";
    $baslikliste=oci_parse($conn, $sql15b);
    oci_execute($baslikliste);
	
		
	if (isset($_GET['erisim'])){
    $sql15t="select * from vis.erisim where adi='".$_GET['erisim']."'";
    $erisimtek=oci_parse($conn, $sql15t);
    oci_execute($erisimtek);	
	}
	
	$sql15i="Select row_number() over (order by rowid) rno,s.* from
(select * from vis.islem where adres='".(isset($_GET['erisim'])?$_GET['erisim']:'')."') s";
    $islemliste=oci_parse($conn, $sql15i);
    oci_execute($islemliste);
	
     if(isset($_POST['kaydet'])){
         for($i=1;$i<=$_POST['toplam'];$i++){
             $sqlupsistem= "update vis.baslik set adi='".$_POST['adi'.$i]."' where adres='".$_POST['adres'.$i]."' and veritabani='".$_POST['veritabani'.$i]."' and sifre='".$_POST['sifre'.$i]."' and ADI='".$_POST['eskiadi'.$i]."'";
          //echo $sqlupsistem;
             $upsistem=oci_parse($conn, $sqlupsistem);
             oci_execute($upsistem);			 		 
		 }
       // header("location:login_success.php?baslik=1");
     }
	 
     if(isset($_GET['seviye'])){
		          $i=$_GET['baslik'];
		 	$sql15bb="Select * from vis.baslik where adi='".$i."'";
      //echo $sql15bb; 
	   $tablo=oci_parse($conn, $sql15bb);
        oci_execute($tablo);
        $bilgi=oci_fetch_assoc($tablo);



             $sqlupsistem= "update vis.baslik set sifre='".$_GET['seviye']."-".$_GET['szaman']."' where adres='".$bilgi['ADRES']."' and veritabani='".$bilgi['VERITABANI']."' and ADI='".$bilgi['ADI']."'";
		//	echo $sqlupsistem;
             $upsistem=oci_parse($conn, $sqlupsistem);
             oci_execute($upsistem);			 		 
       // header("location:login_success.php?baslik=1");
		//echo "<script>window.location.href('?baslik=1');</script>";
     }
	 
if(isset($_POST['ekle'])){
         $sqlinsistem= "insert into vis.baslik values('".$_GET['erisim']."','".$_GET['islem']."','".$_POST['durum']."','".$_POST['adi']."')";
    //     echo $sqlinsistem;
		 $insistem=oci_parse($conn, $sqlinsistem);
         oci_execute($insistem);
         //header("location:login_success.php?baslik=1");
		 
     }
	
if(isset($_POST['toplam'])){	
  for($i=1;$i<=$_POST['toplam'];$i++){	
	 if(isset($_POST['sil'.$i])){
         $sqlsilsistem= "delete vis.baslik where adres='".$_POST['adres'.$i]."' and veritabani='".$_POST['veritabani'.$i]."' and sifre='".$_POST['sifre'.$i]."' and adi='".$_POST['adi'.$i]."'";
      //echo $sqlsilsistem;
		 $silsistem=oci_parse($conn, $sqlsilsistem);
         oci_execute($silsistem);
        //header("location:login_success.php?baslik=1");
     }
	}
	}

     echo $navbar1.'Veri Yapılandırma Başlığı'.$navbar2.'
<tr><td>

<table class=table>

<tr style="font-weight:bold" align=center>
<td></td>
<td>Erişim Adı</td>
<td>İşlem Adı</td>
<td>Kullanıcı Düzeyi</td>
<td>Başlık Adı</td></tr>

<tr><td align=center><input type=submit name=ekle value=" Ekle "></input></td>
<td align=center><select name=baslik
onChange="this.options[this.selectedIndex].value  && (window.location = this.options[this.selectedIndex].value);">

'.(isset($_GET['erisim'])?'':'<option disabled=disabled selected=selected>Erişim seçiniz</option>');
    
    while (($row = oci_fetch_array($erisimliste, OCI_BOTH)) != false){
        echo "<option value='?baslik=1&erisim=".$row['ADI']."' ".(isset($_GET['erisim'])?($_GET['erisim']==$row['ADI']?'selected=selected':''):'').">".$row['ADI']."</option>";        
    }
	
echo '</td>
<td align=center><select name=islem
onChange="this.options[this.selectedIndex].value  && (window.location = this.options[this.selectedIndex].value);">

'.(isset($_GET['islem'])?'':'<option disabled=disabled selected=selected>İşlem seçiniz</option>');
    
    while (($row = oci_fetch_array($islemliste, OCI_BOTH)) != false){
        echo "<option value='?baslik=1&erisim=".$_GET['erisim']."&islem=".$row['ADI']."' ".(isset($_GET['islem'])?($_GET['islem']==$row['ADI']?'selected=selected':''):'').">".$row['ADI']."</option>";        
    }       
$say=0;$ust=0;$orta=0;$alt=0;$toplam=0;
while (($row = oci_fetch_array($baslikliste, OCI_BOTH)) != false){
	$szbilgi=explode('-',$row['SIFRE']);
        $say++;
		$toplam=$say;
	$baslik[$say]=$row['ADI'];
    $seviye[$say]=$szbilgi[0];
	$szaman[$say]=$szbilgi[1];
	
	if ($seviye[$say]=='Üst') $ust++;
	if ($seviye[$say]=='Orta') $orta++;
	if ($seviye[$say]=='Alt') $alt++;
	}

echo "</td>

<td>
<input type=radio name=durum value=Üst ".($toplam/5<$ust?"disabled=true":"").">Üst</input><br>
<input type=radio name=durum value=Orta ".($toplam/2<($orta+$ust)?"disabled=true":"").">Orta</input><br>
<input type=radio name=durum value=Alt checked=checked>Alt</input></td>
<td align='center'><input name=adi type=text></td></tr>

<tr bgcolor=#DDDDDD><td colspan=6><center><h2>Mevcut Başlıklar</h2></center></td></tr>
<tr style='font-weight:bold' align='center'><td></td>
<td>Erişim Adı</td>
<td>İşlem Adı</td>
<td>Kullanıcı Düzeyi</td>
<td>Başlık Adı</td></tr>";
    
	$baslikliste=oci_parse($conn, $sql15b);
    oci_execute($baslikliste);
	$say=0; 
    while (($row = oci_fetch_array($baslikliste, OCI_BOTH)) != false){    
$szbilgi=explode('-',$row['SIFRE']);
$szbilgi[0]=$row['SIFRE'];
$szbilgi[1]=null;
  echo "<tr bgcolor=#".($say++ % 2 ?'FFFFFF':'F7F7F7' )." style='vertical-align: middle'>
<td><center><input type=submit name=sil".$say." value=' Sil '></input></center></td>
<td><center>".$row['ADRES']."</center><input type=hidden name=adres".$say." value='".$row['ADRES']."'></input></td>
<td><center>".$row['VERITABANI']."</center><input type=hidden name=veritabani".$say." value='".$row['VERITABANI']."'></input></td>
<td><center>".$szbilgi[0]."<input type=hidden name=sifre".$say." value='".$szbilgi[0]."'></input></td>

<td style='vertical-align: middle'><center><input name=adi".$say." type=text value='".$row['ADI']."'></input></center><input type=hidden name=eskiadi".$say." value='".$row['ADI']."'></input></td></tr>";
        
	}
 //echo "toplam=".$orta;      
    echo "<tr><td colspan=5 align=center><input type=hidden name=toplam value=".(isset($toplam)?$toplam:0)."></input>
	<input type=submit name=kaydet value=' Kaydet '></input></td></tr>
</table>

</td>";
/*
echo str_repeat("<br>", 9+$say);
echo "<td><svg height=".(45*$toplam)." width=250 style='path{fill: none;stroke: #646464;stroke-width: 1px;stroke-dasharray: 2,2;}'>
  <polygon points='
  0,".(45*$toplam)." 
  0,".(0*$toplam)." 
  ".(5*$toplam).",".(0*$toplam)." 
  ".(5*$toplam).",".(30*$toplam)."' style='fill:lime;stroke:purple;stroke-width:1' />";
 
  for($i=0;$i<$toplam;$i++){ 
 echo "<a xlink:href='?baslik=".($baslik[$i+1])."&seviye=".($seviye[$i+1]=='Alt'&&($toplam/2>($orta+$ust))?'Orta':'Alt')."&szaman=".$szaman[$i+1]."'>
<circle cx=6 cy=".(23+$i*45)." r=5 stroke=black stroke-width=1 fill=red /> </a>";
  }
 
if ($toplam>0){
 echo "<polygon points='
  ".(5*$toplam).",".(30*$toplam)." 
  ".(5*$toplam).",".(0*$toplam)." 
  ".(10*$toplam).",".(0*$toplam)." 
  ".(10*$toplam).",".(15*$toplam)."' style='fill:lime;stroke:purple;stroke-width:1' />";
$egim=(5*$toplam)/(15*$toplam); 
 for($i=0;$i<$toplam;$i++){ 
 if($seviye[$i+1]<>'Alt'){
	 $negim=(2*$toplam)/((30*$toplam)-(23+$i*45));
	 
	if($negim<$egim){ 
echo "<a xlink:href='?baslik=".$baslik[$i+1]."&seviye=".($seviye[$i+1]=='Orta'&&($toplam/5>$ust)?'Üst':'Alt')."&szaman=".$szaman[$i+1]."'>
<circle cx=".(7*$toplam)." cy=".(23+$i*45)." r=5 stroke=black stroke-width=1 fill=red /></a>
<line x1=".(7*$toplam)." y1=".(23+$i*45)." x2=6 y2=".(23+$i*45)." style='stroke:rgb(255,0,0);stroke-width:2' />";
 } else {
	$sqlupsistem= "update vis.baslik set sifre='Alt-".$szaman[$i+1]."' where ADI='".$baslik[$i+1]."'";
			echo $sqlupsistem;
             $upsistem=oci_parse($conn, $sqlupsistem);
             oci_execute($upsistem);			 		 
		 }	//egim kontrolü 
	} 

 }

}

if ($toplam>0){
 echo "<polygon points='
  ".(10*$toplam).",".(15*$toplam)." 
  ".(10*$toplam).",".(0*$toplam)." 
  ".(15*$toplam).",".(0*$toplam)." 
  ".(15*$toplam).",".(0*$toplam)."' style='fill:lime;stroke:purple;stroke-width:1' />";
$egim=(5*$toplam)/(15*$toplam); 
 for($i=0;$i<$toplam;$i++){ 
 if($seviye[$i+1]=='Üst'){
$negim=(2*$toplam)/((15*$toplam)-(23+$i*45));
	if($negim<$egim){ 
echo "<a xlink:href='?baslik=".$baslik[$i+1]."&seviye=Orta&szaman=".$szaman[$i+1]."'>
<circle cx=".(12*$toplam)." cy=".(23+$i*45)." r=5 stroke=black stroke-width=1 fill=red /></a>
<line x1=".(12*$toplam)." y1=".(23+$i*45)." x2=".(7*$toplam)." y2=".(23+$i*45)." style='stroke:rgb(255,0,0);stroke-width:2' />";
	} else {
	$sqlupsistem= "update vis.baslik set sifre='Orta-".$szaman[$i+1]."' where ADI='".$baslik[$i+1]."'";
			echo $sqlupsistem;
             $upsistem=oci_parse($conn, $sqlupsistem);
             oci_execute($upsistem);			 		 
		 }	//egim kontrolü 
 } 

 }



}
echo "</svg></td>";
*/
echo "</tr>";	
}

function getConditionalProbabilty($A, $B, $Data) {
  $NumAB   = 0;
  $NumB    = 0;
  $NumData = count($Data);
  for ($i=0; $i < $NumData; $i++) {
    if (in_array($B, $Data[$i])) {
      $NumB++;
      if (in_array($A, $Data[$i])) {
        $NumAB++;
      }
    }
  }
  return $NumAB / $NumB;
}

function exponentialMovingAverage(array $numbers, int $n): array
{
    $numbers=array_reverse($numbers);
    $m   = count($numbers);
    $α   = 2 / ($n + 1);
    $EMA = [];

    // Start off by seeding with the first data point
    $EMA[] = $numbers[0];

    // Each day after: EMAtoday = α⋅xtoday + (1-α)EMAyesterday
    for ($i = 1; $i < $m; $i++) {
        $EMA[] = ($α * $numbers[$i]) + ((1 - $α) * $EMA[$i - 1]);
    }
    $EMA=array_reverse($EMA);
    return $EMA;
}

/*
INSERT INTO VERI
select KAYNAK, TO_DATE('2-4'||substr(to_char(guncelleme,'DD-MM-YYYY HH24:MI:SS'),6),'DD-MM-YYYY HH24:MI:SS'),DEGER from veri

select guncelleme, round(avg(deger),0) degers from ( SELECT substr( TO_CHAR(guncelleme, 'dHH24MMSS') , 0, 4) guncelleme,deger from vis.veri where guncelleme<trunc(sysdate)) dt group by guncelleme order by guncelleme

SELECT TO_CHAR(guncelleme, 'dHH24MMSS') FROM VERI order by guncelleme 

DELETE VERI WHERE GUNCELLEME>TO_DATE('5-4-2019','DD-MM-YYYY')

DELETE FROM veri
WHERE rowid NOT IN ( SELECT MAX(ROWID) FROM veri
                     GROUP BY guncelleme,deger );

$sqlzaman= "select trunc(guncelleme,'hh24') + (trunc(to_char(guncelleme,'mi')/".$zaman.")*".$zaman.")/24/60 guncelleme, round(avg(deger),0) degers
from veri
group by trunc(guncelleme,'hh24') + (trunc(to_char(guncelleme,'mi')/".$zaman.")*".$zaman.")/24/60";

	$sqlzaman= "select guncelleme, round(avg(deger),0) degers from (
	SELECT substr( TO_CHAR(guncelleme, 'YYYYMMDDHH24MMSS') , 0, ".$grup.") guncelleme,deger
			from vis.veri where TO_CHAR(GUNCELLEME, 'YYYYMMDDHH24MMSS')<TO_CHAR(SYSDATE, 'YYYYMMDDHH24MMSS')
 ) dt 
 group by guncelleme 
 order by guncelleme desc
 fetch first 20 rows only";
 
 
$toplam=0;$ortalama=0;
for($i=1;$i<=$say;$i++){
if ($dizi[$i]=='') $dizi[$i]=1;

if ($i<6){
$toplam=$toplam+$dizi[$i];
$ortalama=$toplam/$i;
$degerust =$degerust.','.($ortalama);
} else {
$toplam=$toplam+$dizi[$i]-$dizi[$i-6];
$ortalama=$toplam/5;
$degerust =$degerust.','.($ortalama);
}
}*/	
//echo phpinfo();

/*
for($i=(1+$kaydir);$i<($say-$kaydir);$i++){

if($i<(20+$kaydir)){
	if($i<1) $degera[$i]='';
$deger=str_replace('0',$degera[$i],$deger);

} else {
$deger=substr($deger,(strpos($deger,',')+1),strlen($deger));	
if($i>=$say) $degera[$i]='';
$deger .=','.$degera[$i];	
}

}

*/


if (isset($_GET['grafik'])=='1') {
	
$zaman=$_GET['zaman'];$kaydir=$_GET['kaydir'];

echo date("d-m-Y H:i:s")."<br>";
/*
$simdi=date("Y-m-d H:i:s", strtotime($kaydir.' hour'));
$simdi=strtotime($simdi);
$simdi=$simdi-($simdi%(60*$zaman));
$simdi=date("Y-m-d H:i:s",$simdi);
*/


//$j=1;
//echo date("Y-m-d",strtotime($simdi.' -'.$j.' month'));

//if ($zaman=='10') {$grup=11;}
//if ($zaman=='60') {$grup=10;}
//if ($zaman=='1440') {$grup=6;}

/*$saat[5]='';
for ($j=4;$j>=0;$j--){
$hesap=strtotime($simdi)-($j*4*60*$zaman);
$hesap=$hesap-($hesap%(60*$zaman));
$saat[$j] = date("H:i", $hesap);
$gun = date("d", $hesap);
$guncelleme .=',"","","","'.($j==4?$saat[$j]:($saat[$j]<$saat[$j+1]?$gun:$saat[$j])).'"';
}
$guncelleme=substr($guncelleme,1,strlen($guncelleme));
*/


$sqlkbaslik="select basliklar from vis.kullanicilar where kno=".$_SESSION['KNO'];
//echo $sqlkbaslik;
$kbaslik=oci_parse($conn, $sqlkbaslik);
oci_execute($kbaslik);
$kbilgi=oci_fetch_assoc($kbaslik);
$kbasliklar=str_replace(",","','",$kbilgi['BASLIKLAR']); 
//echo $kbilgi['BASLIKLAR'];
 $sql15b="Select row_number() over (order by rowid) rno,
 sifre veritaban,
 s.* from
(select * from vis.islem where adi in ('".$kbasliklar."')  AND ADI NOT IN('Usd alış','Usd satış') ) s";
//echo $sql15b; 
 $baslikliste=oci_parse($conn, $sql15b);
    oci_execute($baslikliste);

if($kbasliklar==''){$sql15bm=str_replace("and adi in ('')","",$sql15b);} else {
$sql15bm=str_replace("adi in","adi not in",$sql15b);}
 
$basliklistem=oci_parse($conn, $sql15bm);
    oci_execute($basliklistem);
//echo $sql15bm;	
$saya=0;
    while (($rowa = oci_fetch_array($baslikliste, OCI_BOTH)) != false){$saya++;
		if(isset($_GET['gbaslik'.$saya])) {
	$degeri='';$say=0;$deger='';$onceki=0;
	/*$szbilgi=explode('-',$rowa['SIFRE']);
	
	if ($szbilgi[1]=='Dakikalık') $guncelleme=$guncelleme_dakikalar;
	if ($szbilgi[1]=='Saatlik') $guncelleme=$guncelleme_saatler;
	if ($szbilgi[1]=='Günlük') $guncelleme=$guncelleme_gunler;
	if ($szbilgi[1]=='Aylık') $guncelleme=$guncelleme_aylar;
*/	
	$veritabani=explode('@',$rowa['SIFRE']);
	if($veritabani[0]=='Harici') $veritabani[0]='Oracle';
	
	$sqlbaglanti="select * from vis.baglanti where veritabani='".$veritabani[0]."'";
	$baglanti=oci_parse($conn,$sqlbaglanti);
	oci_execute($baglanti);
	$bilgi_baglanti=oci_fetch_assoc($baglanti);
	$baglantim=	str_replace('sorgu',$bilgi_baglanti['ZAMANSAL_SORGU'],$bilgi_baglanti['BAGLANTI_ADRESI']);
			
				//$baglantim=	str_replace('$sonuc','$zamana',$baglantim);
				//echo $baglantim;
			eval($baglantim); 
			/*
			$sorgu=
			"WITH mycte AS
( SELECT CAST(dateadd(".$zaman_ing.",(".$kaydir."),getdate()) as datetime) DateValue
  UNION ALL
  SELECT  dateadd(".$zaman_ing.", -1,DateValue) DateValue  FROM mycte)

select top 27  a.guncelleme, sum(a.degers) degers from 
(select dt.guncelleme, round(avg(dt.deger),3) degers from (
	SELECT substring(replace(replace(replace(convert(varchar, guncelleme, 20),'-',''),':',''),' ','') , 1, ".$grup.") guncelleme, deger
			from dbo.VERI v where v.GUNCELLEME < dateadd(".$zaman_ing.", +(".$kaydir."), getdate() )
			and v.guncelleme > dateadd(".$zaman_ing.", -(27+(".$kaydir.")), getdate() )
			 and v.kaynak='".$rowa['VERITABANI']."'
 ) as dt 
 group by guncelleme
 UNION ALL
SELECT top 27 substring(replace(replace(replace(convert(varchar, m.DateValue, 20),'-',''),':',''),' ','') , 1, ".$grup.") guncelleme, 0 degers FROM  mycte
 as m
)
 as a
group by a.guncelleme
 order by a.guncelleme
";
			$consql=sqlsrv_connect( 'FERHAT-PC', array( 'Database'=>( isset($_GET['username'])?$_GET['username']:'TEST'), 'UID'=>'sa', 'PWD'=>'oracle')); 
			$sonuc =sqlsrv_query( $consql, $sorgu); 
if( $sonuc === false ) {
    if( ($errors = sqlsrv_errors() ) != null) {
        foreach( $errors as $error ) {
            echo "SQLSTATE: ".$error[ 'SQLSTATE']."<br />";
            echo "code: ".$error[ 'code']."<br />";
            echo "message: ".$error[ 'message']."<br />";
        }
    }
}
			sqlsrv_execute($sonuc);
			
			echo $sorgu;
			*/
			//$veriler=str_replace('$sonuc','$zamana',$bilgi_baglanti['ZAMANSAL_BILGI']);
		eval($bilgi_baglanti['ZAMANSAL_BILGI']);
		
		

/*	
	if($veritabani[0]=='MySQL') { 
	$sqlzamanmy= "select a.guncelleme, sum(a.deger) DEGERS from 
((select guncelleme, round(avg(deger),0) deger from (
	SELECT substr( DATE_FORMAT(guncelleme, '%Y%m%d%H%i%s') , 1, ".$grup.") guncelleme,deger
			from vis.veri where DATE_FORMAT(GUNCELLEME, '%Y%m%d%H%i%s')<DATE_FORMAT(SYSDATE(), '%Y%m%d%H%i%s')
 and kaynak='".$rowa['ADI']."'
 order by guncelleme) dt 
 group by guncelleme
 limit 27) 
 union
(select substr( DATE_FORMAT((sysdate() - interval 1/2 hour), '%Y%m%d%H%i%s') , 1, ".$grup.") araliklar, 0 
  from dual) ) a
  
group by a.guncelleme
order by a.guncelleme";
//echo $sqlzamanmy;
		$zamana=$conmy->query($sqlzamanmy);   
		while ($row = $zamana->fetch_assoc()){	 $say++;
if($row['DEGERS']==0) $row['DEGERS']=$onceki;
$deger =$deger.','.$row['DEGERS'];
$onceki=$row['DEGERS'];		
		}
	}
	
	
if($veritabani[0]=='Oracle') {	
$sqlzaman= "select guncelleme, sum(degers) degers from 
((select guncelleme, round(avg(deger),0) degers from (
	SELECT substr( TO_CHAR(guncelleme, 'YYYYMMDDHH24MMSS') , 0, ".$grup.") guncelleme,deger
			from vis.veri where GUNCELLEME<SYSDATE +(".$kaydir.")/24
			and guncelleme > (sysdate-(27+(".$kaydir."))/24)
 and kaynak='".$rowa['ADI']."') dt 
 group by guncelleme) 
 union
(select substr( TO_CHAR((sysdate + (rownum-27+(".$kaydir."))/24), 'YYYYMMDDHH24MMSS') , 0, ".$grup.") araliklar, 0
  from all_objects where rownum<28) )
  
group by guncelleme
order by guncelleme 
fetch first 27 rows only";

$sqlzaman= "select guncelleme, sum(degers) degers from 
((select guncelleme, round(avg(deger),0) degers from (
	SELECT substr( TO_CHAR(guncelleme, 'YYYYMMDDHH24MMSS') , 0, 6) guncelleme,deger
			from vis.veri where GUNCELLEME<add_months(sysdate, +(".$kaydir."))
			and guncelleme > add_months(sysdate, -(27+(".$kaydir.")))
 and kaynak='".$rowa['ADI']."') dt 
 group by guncelleme) 
 union
(select substr( TO_CHAR(add_months(sysdate, + (rownum-27+(".$kaydir."))), 'YYYYMMDDHH24MMSS') , 0, 6) araliklar, 0
  from all_objects where rownum<28) )
  
group by guncelleme
order by guncelleme 
fetch first 27 rows only";
//echo $sqlzaman;
$zamana=oci_parse($conn, $sqlzaman);
 oci_execute($zamana);
 
while (($row = oci_fetch_array($zamana, OCI_BOTH)) != false){ $say++;
if($row['DEGERS']==0) {$row['DEGERS']=$onceki;}
$deger =$deger.','.$row['DEGERS'];
$onceki=$row['DEGERS'];
}

}//Oracle sonu*/
//.str_repeat(' ',750)
${"baslik" . $saya}	=$rowa['ADI'].str_repeat(' ',750)."-".$rowa['ADI'];
$dizi=substr($deger,1,strlen($deger));
$ilkdeger=strrpos($dizi,'0,')+2;
$ilkuzunluk=strpos($dizi,',',$ilkdeger);
$doldur= substr($dizi,$ilkdeger,$ilkuzunluk-$ilkdeger);

//echo "<br>".$ilkdeger;
//$dizi=str_replace(',0,',','.$doldur.',', $dizi);

$dizi=explode(",",$dizi);

$dizi= array_replace($dizi,
    array_fill_keys(
        array_keys($dizi, 0),
        $doldur
    )
);


$ondalik=strlen(round($dizi[100]));

$numara_en= 40;$ystep=100;
if($ondalik==1) {$numara_en= 15;	$ystep=0.1;}
if($ondalik==4) {$numara_en= 40; $ystep=250;}
if($ondalik==6) {$numara_en= 60;	$ystep=500;}
$dizib=trader_bbands( $dizi,
                        7,
                        1.5,
                        1.5,
                        TRADER_MA_TYPE_WMA
                       );
//echo $ondalik."*".$ystep."*"; 
if(strpos($dizib[1][100],".")){
	$ymax=max($dizib[0]);
	$ymin=min($dizib[2]);
} else {
$ymax=round(max($dizib[0]));
$ymin=round(min($dizib[2]));
}
$ondalik=4;$numara_en= 50;$ystep=$ymax/10;
if($rowa['ADI']=='Öğrenci Bina Giriş Sayısı') {	
if ($_GET['zaman']=='G') {$ondalik=4;$numara_en= 50;$ystep=3000;$ymax=30000;$ymin=0;}
if ($_GET['zaman']=='S') {$ondalik=4;$numara_en= 40;$ystep=300;$ymax=3000;$ymin=0;}	
if ($_GET['zaman']=='D') {$ondalik=4;$numara_en= 40;$ystep=400;$ymax=4000;$ymin=0;}	
	}

if($rowa['ADI']=='Öbs Toplam Kullanıcı Sayısı') {	
if ($_GET['zaman']=='G') {$ondalik=4;$numara_en= 40;$ystep=250;$ymax=2500;$ymin=0;}
if ($_GET['zaman']=='S') {$ondalik=4;$numara_en= 40;$ystep=300;$ymax=3000;$ymin=0;}	
if ($_GET['zaman']=='D') {$ondalik=4;$numara_en= 40;$ystep=250;$ymax=2500;$ymin=0;}	
	}
	
if($rowa['ADI']=='Toplam indexli yayımlar') {	
if ($_GET['zaman']=='G') {$ondalik=4;$numara_en= 40;$ystep=50;$ymax=5000;$ymin=4700;}
if ($_GET['zaman']=='S') {$ondalik=4;$numara_en= 40;$ystep=50;$ymax=5000;$ymin=4700;}
if ($_GET['zaman']=='D') {$ondalik=4;$numara_en= 40;$ystep=50;$ymax=5000;$ymin=4700;}
	}

if($rowa['ADI']=='Bütçe gelir-gider farkı') {	
if ($_GET['zaman']=='G') {$ondalik=6;$numara_en= 60;$ystep=50000;$ymax=180000;$ymin=-80000;}
if ($_GET['zaman']=='S') {$ondalik=6;$numara_en= 60;$ystep=50000;$ymax=180000;$ymin=-80000;}
if ($_GET['zaman']=='D') {$ondalik=6;$numara_en= 60;$ystep=50000;$ymax=180000;$ymin=-80000;}
	}	
	
if($rowa['ADI']=='Gelen Ziyaretçi Sayısı') {	
if ($_GET['zaman']=='G') {$ondalik=2;$numara_en= 30;$ystep=6;$ymax=60;$ymin=0;}
if ($_GET['zaman']=='S') {$ondalik=2;$numara_en= 30;$ystep=4;$ymax=40;$ymin=0;}	
if ($_GET['zaman']=='D') {$ondalik=2;$numara_en= 30;$ystep=4;$ymax=40;$ymin=0;}	
	}	

if($rowa['ADI']=='Usd Alış Kuru'||$rowa['ADI']=='Usd Satış Kuru') {	
if ($_GET['zaman']=='G') {$ondalik=3;$numara_en= 30;$ystep=0.2;$ymax=7.4;$ymin=5.4;}
if ($_GET['zaman']=='S') {$ondalik=4;$numara_en= 40;$ystep=0.05;$ymax=7.1;$ymin=6.5;}	
if ($_GET['zaman']=='D') {$ondalik=4;$numara_en= 40;$ystep=0.05;$ymax=7;$ymin=6.5;}	
$ondalikli=true;
	}

if($rowa['ADI']=='Gbp/Usd Alış Kuru') {
if ($_GET['zaman']=='G') {$ondalik=4;$numara_en= 30;$ystep=0.1;$ymax=1.35;$ymin=1.15;}
if ($_GET['zaman']=='S') {$ondalik=4;$numara_en= 40;$ystep=0.1;$ymax=1.28;$ymin=1.23;}	
if ($_GET['zaman']=='D') {$ondalik=4;$numara_en= 40;$ystep=0.1;$ymax=1.28;$ymin=1.23;}
$ondalikli=true;
}

	
	
$dizib[0][2]=$dizib[0][3]=$dizib[0][4]=$dizib[0][5]=$dizib[2][2]=$dizib[2][3]=$dizib[2][4]=$dizib[2][5]=0;	
$dizib[0][152]=$dizib[0][153]=$dizib[0][154]=$dizib[2][152]=$dizib[2][153]=$dizib[2][154]=null;
				
for($i=0;$i<$say;$i++){
		if(isset($dizib[0][$i+3])){
$dizib[0][$i]=$dizib[0][$i+3];
$dizib[2][$i]=$dizib[2][$i+3];
} else $dizib[0][$i]=$dizib[2][$i]=null;
}

//print_r($dizib); 
//echo "<br>say=".$say." dizi=".count($dizib[0])."<br>";
for($i=0;$i<$say-9;$i++){
$diziy[$i]=$dizi[$i+9];
//echo $i.".sayac, i+6=".($i+6).".deger=".$dizi[$i+6]."<br>";
//$dizib[0][$i]=$dizib[0][$i+7];
//$diziy[2][$i]=$dizib[0][$i+7];
//echo $i." ".$dizi[$i]."---".($i+7)." ".$dizi[$i+7]."<br>";
}
if(!empty($dizib)) {
$degeriust[$saya]=implode(",",$dizib[0]);
$degerialt[$saya]=implode(",",$dizib[2]);
$degerorta[$saya]=implode(",",$diziy);
}

//echo $degerorta[$saya]."<br>";
//print_r($diziy); 

//echo "say=".$say;
for ($k=0;$k<$say;$k++){
	$hesap=strtotime($simdi)-(($k-8)*60*$yenileme);
	$hesap=$hesap-($hesap%(60*$yenileme));
	$zamantam[$k]=date("Y-m-d H:i:s", $hesap);
	//$zamantam[$k]= date('Y-m-d H:i:s', strtotime($zamantam[$k].' -1 hour'));
}
$zamantam=array_reverse($zamantam);
//print_r($zamantam);
//$indexust=0;
	for ($i = 0; $i <$say-9 ; $i++) {
		$nokta[$i]="";
		$bust=$dizib[0][$i+6]-$diziy[$i];
		$balt=$diziy[$i]-$dizib[2][$i+6];
	if(($bust<0)||($balt<0)) {
		if($ondalikli){
			$uzaklik_deger=round(($bust<0?abs($bust):$balt),3)*1000;
			$borta=$diziy[$i]*1000;
			} else {
		$uzaklik_deger=round(($bust<0?abs($bust):$balt),0);
		$borta=$diziy[$i];
		}
		$sqluzaklasma="insert into vis.siradisi (baslik,tarih,uzaklik,zaman) values('".$rowa['ADI']."',to_date('".$zamantam[$i]."', 'yyyy-mm-dd hh24:mi:ss'),".$uzaklik_deger.",'".$_GET['zaman']."')";
		$sqluzak="select count(*) sayi from vis.siradisi where baslik='".$rowa['ADI']."' and tarih=to_date('".$zamantam[$i]."', 'yyyy-mm-dd hh24:mi:ss') and uzaklik=".$uzaklik_deger." and zaman='".$_GET['zaman']."'";
		//abs(round(($bust<0?$bust:$balt),0))
		$uzak=oci_parse($conn, $sqluzak);
       // if($_GET['zaman']<>'G'&&$_GET['zaman']<>'S') {
							oci_execute($uzak);
							$bilgi=oci_fetch_assoc($uzak);
		//echo $sqluzaklasma;
							if(($bilgi['SAYI']==0)&&($uzaklik_deger<>0)&&($uzaklik_deger<>$borta)) {
								$uzaklasma=oci_parse($conn,$sqluzaklasma);	
								@oci_execute($uzaklasma);
							}
							//echo "=".$uzaklik_deger."/".$borta;
						//} //kontrollü kayıt ekleme
	//	echo "ust=".$dizib[0][$i+6]." orta=".$diziy[$i]." alt=".$dizib[2][$i+6]."<br>";
	$nokta[$i]="'rgb(0, 0, 0)'";
	//$zamanust[$saya][$indexust]=$zamantam[$i];
	}
//	echo $i.". fark=".$dizib[0][$i+6].	"-".$diziy[$i]."=".	round(($dizib[0][$i+6]-	$diziy[$i]),0)." zaman=".($i).	$zamantam[$i]."<br>";
	//if(($diziy[$i]-$dizib[2][$i+6])<0)$uzaklasmaalt[$saya][$indexalt]=$zamantam[$i]."/".round(($diziy[$i]-$dizib[2][$i+6]),0);
//$indexust++;
	}
if(!empty($nokta)) {
$uzaknokta[$saya]=implode(",",$nokta);
//echo $uzaknokta[$saya];
}
		}//checked kontrolü
	}//baslikliste sonu
	
//echo $zamantam[0]."////".$zamantam[count($zamantam)-1]."////".count($zamantam)."<br>";	

//for ($i = 1; $i <=$saya ; $i++) {
//echo implode("<br>",$sqluzaklasma[1])."<br>";
//echo $degerorta[1];
//echo implode("<br>",$uzaklasmaalt[$i])."<br><br>";
//}

echo $navbar1.'Grafikler'.$navbar2."
<tr><td>
	<div class=content>
<div style='top:0;height:300'>
	<canvas id='chart-1' height=320 style='position: absolute; left: ".($numara_en+960)."; top: 95; z-index: 1;border:0px solid #000000;' ></canvas>
	<div class=toolbar>	

		<div style='position: relative;
		width: 900px;
  overflow-x: scroll;
  direction: rtl;'>
		<div class=wrapper style='position: relative; width: ".(($uzunluk*22))."'>
			<canvas id='chart-0' height=300 style='position: absolute; left: 0; top: 0; z-index: 0;' ></canvas>
		
		</div>	
		
		</div>



	</div>	
			
		<table class=table>
		
		<tr>
		
		<td colspan=5 align=center>		
		  ".($_GET['zaman']=='D'?"Dakikalık":"<a href=".str_replace("zaman=".$zaman,"zaman=D","$_SERVER[REQUEST_URI]").">Dakikalık</a>")."
		  ".($_GET['zaman']=='S'?"Saatlik":"<a href=".str_replace("zaman=".$zaman,"zaman=S","$_SERVER[REQUEST_URI]").">Saatlik</a>")."
		  ".($_GET['zaman']=='G'?"Günlük":"<a href=".str_replace("zaman=".$zaman,"zaman=G","$_SERVER[REQUEST_URI]").">Günlük</a>")."
						
		</td></tr>
		<tr style='font-weight:bold' align='center' bgcolor=#DDDDDD><td colspan=7><center>Seçilen Grafikler</center></td></tr>
<tr style='font-weight:bold' align='center'>
<td>Göster</td>
<td></td>
<td width=150>".str_repeat('&nbsp;', 5)."Grafik&nbsp;Adı".str_repeat('&nbsp;', 5)."</td>
<td>Kaynak</td>
<td>".str_repeat('&nbsp;', 30)."İşlem".str_repeat('&nbsp;', 30)."</td>
</tr>";
/* 
echo 	($kaydir==-19?"Önceki Veriler":"
		<a href=".str_replace("kaydir=".$kaydir,"kaydir=".($kaydir-1),"$_SERVER[REQUEST_URI]")."><span class='glyphicon glyphicon-step-backward'></span>Önceki Veriler</a>
		").str_repeat('&nbsp;', 70);
		
echo   str_repeat('&nbsp;', 50)."
		<a href=".str_replace("kaydir=".$kaydir,"kaydir=".($kaydir+1),"$_SERVER[REQUEST_URI]").">Sonraki Veriler<span class='glyphicon glyphicon-step-forward'></span></a>";
		
style='font-weight:bold'

*/				
 
	$baslikliste=oci_parse($conn, $sql15b);
    oci_execute($baslikliste);
	$say=0;  $degisim=array(",'","',");
    while (($row = oci_fetch_array($baslikliste, OCI_BOTH)) != false){    
  echo "<tr bgcolor=#".($say++ % 2 ?'FFFFFF':'F7F7F7' ).">
<td><center><input type=checkbox name=sec".$say." ".(isset($_GET['gbaslik'.$say])?'checked=checked':'')."
onchange='basliksec(".$say.")' id=idsec".$say."
value='&gbaslik".$say."=".$row['ADI']."&gislem".$say."=".$row['ADRES']."'></input></center></td>

<td><center><input type=submit name=sil".$say." value='  Sil  '></center>
<input type=hidden name=adres".$say." value='".$row['ADRES']."'></input>
<input type=hidden name=idbaslikust".$say." value='".$row['ADI']."'></input></td>

<td><center>".$row['ADI']."</center><input type=hidden name=eskiadi".$say." value='".$row['ADI']."'></input></td>

<td><center>".$row['SIFRE']."<input type=hidden name=sifre".$say." value='".$row['SIFRE']."'></input></td>

<td><center>".@$row['SORGU']."</center>
<input type=hidden name=sorgu".$say." value='".@$row['SORGU']."'></input></td>

</tr>";       
$sqlsil[$row['RNO']]="update vis.kullanicilar set basliklar='".str_replace($row['ADI'],"",$kbilgi['BASLIKLAR'])."' where kno=".$_SESSION['KNO'];            
$sqlsil[$row['RNO']]=str_replace($degisim,"'",$sqlsil[$row['RNO']]);
$sqlsil[$row['RNO']]=str_replace(",,",",",$sqlsil[$row['RNO']]);
//echo $sqlsil[$row['RNO']]."-".$kbilgi['BASLIKLAR'];
	}	
	//<div id='chart-analyser' class='analyser'></div>
		echo "<input type=hidden id=idtoplam value=".$say."></input>

<tr style='font-weight:bold' align='center' bgcolor=#DDDDDD>
<td colspan=7><center>Mevcut Grafikler</center></td></tr>
<tr style='font-weight:bold' align='center'>
<td></td>
<td></td>
<td  width=150>Grafik&nbsp;Adı</td>
<td>Kaynak</td>
<td>İşlem</td>
</tr>";    
	$basliklistem=oci_parse($conn, $sql15bm);
    oci_execute($basliklistem);  $saym=0;
    while (($row = oci_fetch_array($basliklistem, OCI_BOTH)) != false){    
  echo "<tr bgcolor=#".($saym++ % 2 ?'FFFFFF':'F7F7F7' ).">
<td><center> </td>
<td><center><input type=submit name=ekle".$saym." value='  Ekle  '></center></td>
<td><center>".$row['ADI']."</center></td>
<td><center>".$row['SIFRE']."</td>
<td><center>".@$row['SORGU']."</center></td>
</tr>";   
$sqlekle[$row['RNO']]="update vis.kullanicilar set basliklar='".$kbilgi['BASLIKLAR'].",".$row['ADI']."' where kno=".$_SESSION['KNO'];            
$sqlekle[$row['RNO']]=str_replace($degisim,"'",$sqlekle[$row['RNO']]);
	}

for ($i=1;$i<=(isset($saym)?$saym:0);$i++){
           if(isset($_POST['ekle'.$i])){
              // echo $sqlekle[$i];$sayac++;
               $sqlkayit=$sqlekle[$i];
               $ekle=oci_parse($conn, $sqlkayit);
               oci_execute($ekle);  
			  // $url="?modul=derskayit&sayac=".($sayac)."&sayac1=".($sayac1).(isset($sayac2)?"&sayac2=".$sayac2:"");
               echo '<script>document.location=window.location.href;</script>';
           }
       }
for ($i=1;$i<=(isset($say)?$say:0);$i++){
           if(isset($_POST['sil'.$i])){
               //echo $sqlsil[$i];
           $sqlkayit=$sqlsil[$i];
               $kayit=oci_parse($conn, $sqlkayit);
               oci_execute($kayit);  
               //$url="?modul=derskayit&sayac=".($sayac)."&sayac1=".($sayac1).(isset($sayac2)?"&sayac2=".$sayac2:"");
                echo '<script>document.location=window.location.href;</script>';
 
 }
       }
	   
echo"<script>
	window.onload = function() {
  var c = document.getElementById('chart-1');
  var ctx = c.getContext('2d');
  var img = document.getElementById('chart-0');
  ctx.drawImage(img, 0, 0, ".$numara_en.", 400, 0, 0, ".$numara_en.", 400);
}
	
	
	function basliksec(sec) { var adres='';
	var toplam=document.getElementById('idtoplam').value;
for (var i = 1; i <= toplam; i++) {
document.getElementById('idsec'+i).checked=false;
}	
document.getElementById('idsec'+sec).checked=true;	
	
for (var i = 1; i <= toplam; i++) {		
  if (document.getElementById('idsec'+i).checked) { 
  adres=adres+document.getElementById('idsec'+i).value;
} else {
	  adres=adres.replace(document.getElementById('idsec'+i).value,'');}
	  
}
adres='?grafik=1&zaman=G&kaydir=-1'+adres;
window.location=adres;
}


function getRandomColor() {
    var letters = '0123456789ABCDEF'.split('');
    var color = '#';
    for (var i = 0; i < 6; i++ ) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}
var renk= ['','rgb(255, 0, 0)','rgb(0, 163, 51)','rgb(255, 159, 64)','rgb(255, 205, 86)','rgb(0, 163, 51)','rgb(54, 162, 235)','rgb(153, 102, 255)','rgb(201, 203, 207)','rgb(0,0,255)'];
		var presets = window.chartColors;
		var utils = Samples.utils;
		var inputs = {
			min: 20,
			max: 80,
			count: 8,
			decimals: 2,
			continuity: 1
		};

		function generateData() {
			return utils.numbers(inputs);
		}

		function generateLabels() {
			return utils.months({count: inputs.count});
		}
		
		utils.srand(42);
		



		var data = {
			labels: [".$guncelleme."],
			datasets: []
		};
 ";

$aktif=-1;
 for ($i = 1; $i <=$saya ; $i++) {	 
if(isset($_GET['gbaslik'.$i])) {$aktif=$aktif+3;
echo " 

  data.datasets.push({backgroundColor: utils.transparentize(renk[".$i."]),
				borderColor: renk[".$i."],			
			    data: [".$degeriust[$i]."],
				hidden: ".(isset($_GET['gbaslik'.$i])?'false':'true').",
				label: 'ara',
				fill: ".($aktif).",
				borderWidth: 0,
				pointRadius: 1,
				pointHoverRadius: 1
				 
  },
  {backgroundColor: utils.transparentize(renk[".$i."]),
				borderColor: renk[".$i."],			
			    data: [".$degerorta[$i]."],
				hidden: ".(isset($_GET['gbaslik'.$i])?'false':'true').",
				label: ('".${"baslik" . $i}."'),
				fill: false,
				pointBackgroundColor: [".$uzaknokta[$i]."],
                pointBorderColor: [".$uzaknokta[$i]."],
				pointHoverBackgroundColor: [".$uzaknokta[$i]."],
				pointHoverBorderColor: [".$uzaknokta[$i]."]
				 
  },
  {backgroundColor: utils.transparentize(renk[".$i."]),
				borderColor: renk[".$i."],			
			    data: [".$degerialt[$i]."],
				hidden: ".(isset($_GET['gbaslik'.$i])?'false':'true').",
				label: 'ara',
				fill: false,
				borderWidth: 0,
				pointRadius: 1,
				pointHoverRadius: 1
				 
})

";}
 }

 echo "
var yAxesticks = [];
	  
		var options = {
			animation: {
						duration: 0
						},
			maintainAspectRatio: false,
			spanGaps: false,
			responsive: true,
			elements: {
				line: {
					tension: 0.00001
				}
			},
			scales: {
				yAxes: [{   
					display: true,
					position: 'left',
					stacked: false,
					
					ticks : {
							fontStyle: 'bold',
							fontSize: 14,
							min: ".$ymin.",
							max: ".$ymax.",
							stepSize: ".$ystep."
							//,userCallback: function(label, index, labels) {
							// when the floored value is the same as the value we have a whole number
									//	if (Math.floor(label) === label) {
										//	return label;
											//		}

										//}
                            }
					
					}],
				xAxes: [{   
					display: true,
					stacked: false,

					ticks: {
							fontStyle: 'bold',
							fontSize: 14,			
							stepSize: 0.5
							}
					}]
			},
			plugins: {
				filler: {
					propagate: false
						},
					'samples-filler-analyser': {
					target: 'chart-analyser'
						},				      
					datalabels: {
								display: false
							}
			},
        tooltips: {
                enabled: true
		},
			legend:{
                    labels: {
                filter: function(item, chart) {
                    // Logic to remove a particular legend item goes here
                    return !item.text.includes('ara');
                },
				fontColor: 'black'
				
            }  }
		};
		
var img = new Image();
img.onload = function() {
  var size = 48;

  Chart.types.Line.extend({
    name: 'LineAlt',
    draw: function() {
      Chart.types.Line.prototype.draw.apply(this, arguments);

      var scale = this.scale;
      [
        { x: 1.5, y: 50 }, 
        { x: 4, y: 10 }
      ].forEach(function(p) {
        ctx.drawImage(img, scale.calculateX(p.x) - size / 2, scale.calculateY(p.y) - size / 2, size, size);
      })
    }
  });
}

 		var chart = new Chart('chart-0', {
			type: 'line',
			data: data,
			options: options
		});
			

		

function addData() {
	setInterval(function(){ 

}, ".($yenileme*6000).");
	chart.update();
}

  var fillBetweenLinesPlugin = {
    afterDatasetsDraw: function (chart) {
        var ctx = chart.chart.ctx;
        var xaxis = chart.scales['x-axis-0'];
        var yaxis = chart.scales['y-axis-0'];
        var datasets = chart.data.datasets;
        ctx.save();

        for (var d = 0; d < datasets.length; d++) {
            var dataset = datasets[d];
            if (dataset.fillBetweenSet == undefined) {
                continue;
            }

            // get meta for both data sets
            var meta1 = chart.getDatasetMeta(d);
            var meta2 = chart.getDatasetMeta(dataset.fillBetweenSet);

            // do not draw fill if one of the datasets is hidden
            if (meta1.hidden || meta2.hidden) continue;

            // create fill areas in pairs
            for (var p = 0; p < meta1.data.length-1;p++) {
                // if null skip
              if (dataset.data[p] == null || dataset.data[p+1] == null) continue;

              ctx.beginPath();

              // trace line 1
              var curr = meta1.data[p];
              var next = meta1.data[p+1];
              ctx.moveTo(curr._view.x, curr._view.y);
              ctx.lineTo(curr._view.x, curr._view.y);
              if (curr._view.steppedLine === true) {
                ctx.lineTo(next._view.x, curr._view.y);
                ctx.lineTo(next._view.x, next._view.y);
              }
              else if (next._view.tension === 0) {
                ctx.lineTo(next._view.x, next._view.y);
              }
              else {
                  ctx.bezierCurveTo(
                    curr._view.controlPointNextX,
                    curr._view.controlPointNextY,
                    next._view.controlPointPreviousX,
                    next._view.controlPointPreviousY,
                    next._view.x,
                    next._view.y
                  );
                            }

              // connect dataset1 to dataset2
              var curr = meta2.data[p+1];
              var next = meta2.data[p];
              ctx.lineTo(curr._view.x, curr._view.y);

              // trace BACKWORDS set2 to complete the box
              if (curr._view.steppedLine === true) {
                ctx.lineTo(curr._view.x, next._view.y);
                ctx.lineTo(next._view.x, next._view.y);
              }
              else if (next._view.tension === 0) {
                ctx.lineTo(next._view.x, next._view.y);
              }
              else {
                // reverse bezier
                ctx.bezierCurveTo(
                  curr._view.controlPointPreviousX,
                  curr._view.controlPointPreviousY,
                  next._view.controlPointNextX,
                  next._view.controlPointNextY,
                  next._view.x,
                  next._view.y
                );
              }

                            // close the loop and fill with shading
              ctx.closePath();
              ctx.fillStyle = dataset.fillBetweenColor || 'rgba(255,255,0,0.1)';
              ctx.fill();
            } // end for p loop
        }
    } // end afterDatasetsDraw
}; // end fillBetweenLinesPlugin
Chart.pluginService.register(fillBetweenLinesPlugin);
//document.getElementById('iddeger').value=yAxesticks[0];
	</script>

</td>

</tr>";
/*
echo '<tr><td>

      <div class="chartWrapper"> 
         <div class="chartAreaWrapper"> 
            <canvas id="myChart" height="300" width="1200"></canvas> 
         </div> 
         <canvas id="myChartAxis" height="300" width="0"></canvas> 
      </div>  


</td></tr>';
*/
}

if (isset($_GET['siradisi'])=='1') {
	$zaman=$_GET['zaman'];
	$sqlkbaslik="select basliklar from vis.kullanicilar where kno=".$_SESSION['KNO'];
//echo $sqlkbaslik;
$kbaslik=oci_parse($conn, $sqlkbaslik);
oci_execute($kbaslik);
$kbilgi=oci_fetch_assoc($kbaslik);
$kbasliklar=str_replace(",","','",$kbilgi['BASLIKLAR']); 
//echo $kbilgi['BASLIKLAR'];
 $sql15b="Select row_number() over (order by rowid) rno,
 (select sifre from vis.islem where adres=s.adres and rownum=1) veritaban,
 s.* from
(select * from vis.islem where adi in ('".$kbasliklar."') AND ADI NOT IN('Usd alış','Usd satış')) s";
	//echo $sql15b; 
    $baslikliste=oci_parse($conn, $sql15b);
    oci_execute($baslikliste);
/*
<input type=range class=custom-range id=customRange1 
min=1
    max=4                 
    step=1
	data-slider-ticks=[1, 2, 3, 4]  data-slider-ticks-labels=['1', '2', '3', '4']>
</input>
*/
echo $navbar1.'Sıra Dışı Olay Analizi'.$navbar2."
<tr><td>
	<div class=content>
		
		<div class=wrapper>
			<canvas id='chart-0'></canvas>
		</div>
		
		
		</div>
		<table class=table>
		<tr><td colspan=5 align=right>
			<input
    type=range
    min=1                   // default 0
    max=4                  // default 100
    step=1                   // default 1
	value=".$_GET['val']."                 // default min + (max-min)/2
    data-orientation=vertical // default horizontal
	onchange=updateTextInput();
	id=idrange
	list=tickmarks
	style='
	-webkit-appearance: none;
	width:480;
	height:15px;
	border-radius: 5px;  
	background: '#d3d3d3';
	opacity: '0.7';
	cursor: pointer; 
	-webkit-transition: .2s;
  transition: opacity .2s;'
></input>
<datalist id=tickmarks>
  <option value=0></option>
  <option value=1></option>
  <option value=2></option>
  <option value=3></option>
</datalist>
<form class=range-field>
	
	</form>
<input type=hidden id=idval value=".$_GET['val']."></input>
		</td></tr>
		<tr>
		
		<td colspan=5 align=center>		
		".($_GET['zaman']=='D'?"Dakikalık":"<a href=".str_replace("zaman=".$zaman,"zaman=D","$_SERVER[REQUEST_URI]").">Dakikalık</a>")."
		  ".($_GET['zaman']=='S'?"Saatlik":"<a href=".str_replace("zaman=".$zaman,"zaman=S","$_SERVER[REQUEST_URI]").">Saatlik</a>")."
		  ".($_GET['zaman']=='G'?"Günlük":"<a href=".str_replace("zaman=".$zaman,"zaman=G","$_SERVER[REQUEST_URI]").">Günlük</a>")."
		<br>				
		</td></tr>
		<tr style='font-weight:bold' align='center' bgcolor=#DDDDDD><td colspan=7><center>Seçilen Grafikler</center></td></tr>
<tr style='font-weight:bold' align='center'><td></td>
<td>Grafik</td><td>Vtys</td><td>Veri Tabanı</td><td>Düzey</td></tr>";
		
			$say=0;  
    while (($row = oci_fetch_array($baslikliste, OCI_BOTH)) != false){   
$parcalar=explode('@',$row['SIFRE']);
$vtys=$parcalar[0];
$tablo=	explode('.',$parcalar[1])[0];
if($row['DUZEY']=='Üst') $ek_url="&val=3&renk3=00c600";
if($row['DUZEY']=='Orta') $ek_url="&val=2&renk2=00c600&renk3=00c600";
if($row['DUZEY']=='Alt') $ek_url="&val=1&renk1=00c600&renk2=00c600&renk3=00c600";
  echo "<tr bgcolor=#".($say++ % 2 ?'FFFFFF':'F7F7F7' ).">
<td><center><input type=radio name=sec ".($_GET['gbaslik']==$say?'checked=checked':'')."
onchange='sbasliksec(".$say.")' id=idsec".$say."
value='&gbaslik=".$say."&gbaslikadi=".$row['ADI'].$ek_url."'></input></center></td>
<td><center>".$row['ADI']."</center><input type=hidden name=adres".$say." value='".$row['ADI']."'></input></td>
<td><center>".$vtys."<input type=hidden name=sifre".$say." value='".$vtys."'></input></td>
<td><center>".$tablo."</center></td>
<td><center>".$row['DUZEY']."</center></td>
<input type=hidden id=idgbaslik".$say." value='".$row['ADI']."'></input>

</tr>";    
if($say==1) $ilkbas=$row['ADI'];



	}	
$sqlsiradisimax="select max(uzaklik) max from vis.siradisi  where zaman='".$_GET['zaman']."' and baslik='".(isset($_GET['gbaslikadi'])?$_GET['gbaslikadi']:$ilkbas)."'";
//echo $sqlsiradisimax;
$siradisimax=oci_parse($conn, $sqlsiradisimax);
oci_execute($siradisimax);
$bilgimax=oci_fetch_assoc($siradisimax);  
$katsayi=abs(floor($bilgimax['MAX']/9));
//if($katsayi==0) {$katsayi=1;}
$sqlsiradisi="select uzaklik, count(uzaklik) toplam from vis.siradisi  where zaman='".$_GET['zaman']."' and baslik='".(isset($_GET['gbaslikadi'])?$_GET['gbaslikadi']:$ilkbas)."' group by uzaklik order by uzaklik";
//echo $sqlsiradisi;
$siradisi=oci_parse($conn, $sqlsiradisi);
    oci_execute($siradisi);
	$etiket1=array();$etiket2=array();$etiket3=array();$say=0;
	$sayigrup=array($katsayi*5,$katsayi*6,$katsayi*8);$toplam=array(0,0,0);
	//print_r ($sayigrup);
	     while (($row = oci_fetch_array($siradisi, OCI_BOTH)) != false){   
		$mutlak_uzaklik=abs($row['UZAKLIK']);
		
		if($katsayi==0||$mutlak_uzaklik<$sayigrup[0])   {$toplam[0]=$toplam[0]+$row['TOPLAM'];		
		$etiket3[$say] = $row['UZAKLIK'];} else
		
		if($mutlak_uzaklik>$sayigrup[2])  {$toplam[2]=$toplam[2]+$row['TOPLAM'];
		$etiket1[$say] = $row['UZAKLIK'];} else 
		
		if($mutlak_uzaklik<=$sayigrup[2]&&$row['UZAKLIK']>=$sayigrup[0]) {
			$toplam[1]=$toplam[1]+$row['TOPLAM'];
		$etiket2[$say] = $row['UZAKLIK'];}
		
	 //echo "<input type=hidden id=iduzaklikgrup".$say." value=".$row['UZAKLIK'].">";
	 $say++;
		 }
		 $temel_etiket1=$etiket1;
		 $temel_etiket2=$etiket2;
		 $temel_etiket3=$etiket3;
	$sayigrubu=implode(",",$sayigrup);
	$toplamgrubu=implode(',',$toplam);	
	if($toplamgrubu=='0,0,0') {echo "<center><h4>
	Henüz ".($_GET['zaman']=='G'?"günlükte":($_GET['zaman']=='S'?"saatlikte":"dakikalıkta"))." sıra dışı veri tespit edilmemiştir.
	</h4></center>";}else if($katsayi==0) {
		echo "<center><h4>
	Henüz ".($_GET['zaman']=='G'?"günlükte":($_GET['zaman']=='S'?"saatlikte":"dakikalıkta"))." sınıflandırma için yeterli sayıda sıra dışı veri tespit edilmediğinden mevcut veriler Alt düzeyde gösterilmektedir.
	</h4></center>";}
	$sayigrubu="'Alt','Orta','Üst'";
	//$toplamgrubu="5,3,1";
	
	$etiket1=array_reverse($etiket1);
	$etiket2=array_reverse($etiket2);
	$etiket3=array_reverse($etiket3);
	
	$etiket10 = array_chunk($etiket1, 2);
	$etiket20 = array_chunk($etiket2, 2);
	$etiket30 = array_chunk($etiket3, 2);
	
	for($i=0;$i<(count($etiket10)>18?18:count($etiket10));$i++){
			if(strlen($etiket10[$i][0])==1) {$bosluk=',    ';} else
			if(strlen($etiket10[$i][0])==2) {$bosluk=',   ';} else
			{$bosluk=', ';}
			$etiket12[$i]="'".implode($bosluk,$etiket10[$i])."'";
	}
	
		for($i=0;$i<(count($etiket20)>18?18:count($etiket20));$i++){
			if(strlen($etiket20[$i][0])==1) {$bosluk=',    ';} else
			if(strlen($etiket20[$i][0])==2) {$bosluk=',   ';} else
			{$bosluk=', ';}
			$etiket22[$i]="'".implode($bosluk,$etiket20[$i])."'";
	}
	
		for($i=0;$i<(count($etiket30)>18?18:count($etiket30));$i++){
			if(strlen($etiket30[$i][0])==1) {$bosluk=',     ';} else
			if(strlen($etiket30[$i][0])==2) {$bosluk=',    ';} else
			if(strlen($etiket30[$i][0])==3) {$bosluk=',   ';} else {$bosluk=',  ';}
			$etiket32[$i]="'".implode($bosluk,$etiket30[$i])."'";
	}
	
	@$etiket1="[".implode(', ',$etiket12)."]";
	@$etiket2="[".implode(', ',$etiket22)."]";
	@$etiket3="[".implode(', ',$etiket32)."]";
//	['3, 5','2, 6']
	//$etiket1='';$etiket3='';
	
		
	if(!isset($_GET['renk1'])) $_GET['renk1']="99ff9980";
	if(!isset($_GET['renk2'])) $_GET['renk2']="99ff9980";
	if(!isset($_GET['renk3'])) $_GET['renk3']="99ff9980";//rgba(5, 5, 5, 0.2)	
	
	echo "<input type=hidden id=idtoplam value=".$say."></input>
	</table>
	
			<table class=table>
		<tr style='font-weight:bold' align='center' bgcolor=#DDDDDD><td colspan=7><center>Sıra Dışı Veriler</center></td></tr>
<tr style='font-weight:bold' align='center'>
<td> </td>
<td>Uzaklık</td>
<td>Tarih</td>
<td>Grafik Adı</td>
<td>Düzey</td></tr>";

if($_GET['val']==1) {$ouzaklik=0;} else 
if($_GET['val']==2) {$ouzaklik=$sayigrup[0];} else 
if($_GET['val']==3) {$ouzaklik=$sayigrup[2];} else 
if($_GET['val']==4) {$ouzaklik=$bilgimax['MAX'];}

$sqlsiradisiolay="select
(select veritabani from vis.baglanti where rownum=1 and adi=(select adres from vis.erisim where rownum=1 and veritabani=(select veritabani from vis.erisim where rownum=1 and adi=(select adres from vis.islem where rownum=1 and adi=s.baslik)))) veritabanis,
(select adres from vis.erisim where rownum=1 and veritabani=(select veritabani from vis.erisim where rownum=1 and adi=(select adres from vis.islem where rownum=1 and adi=s.baslik))) baglanti,
(select veritabani from vis.erisim where rownum=1 and adi=(select adres from vis.islem where rownum=1 and adi=s.baslik)) veritabanı,
(select sifre from vis.erisim where rownum=1 and adi=(select adres from vis.islem where rownum=1 and adi=s.baslik)) tablo,
(select adres from vis.islem where rownum=1 and adi=s.baslik) erisim,
(select adi from vis.islem where rownum=1 and adi=s.baslik) islem,
(select duzey from vis.islem where rownum=1 and adi=s.baslik) duzey,
decode(zaman,'G','Günlük',decode(zaman,'S','Saatlik','Dakikalık'))zaman,baslik,TO_CHAR(tarih, 'YYYY-MM-DD HH24:MI:SS') tarih, uzaklik from vis.siradisi s 
where zaman='".$_GET['zaman']."' and baslik='".(isset($_GET['gbaslikadi'])?$_GET['gbaslikadi']:$ilkbas)."' and abs(uzaklik)>".$ouzaklik." order by abs(uzaklik) desc
";
//$sqlsiradisiolay="select * from vis.siradisi ";
//echo $sqlsiradisiolay;
$siradisiolay=oci_parse($conn, $sqlsiradisiolay);
oci_execute($siradisiolay);

			$say=0;  
    while (($row = oci_fetch_array($siradisiolay, OCI_BOTH)) != false){
		if(in_array($row['UZAKLIK'],$temel_etiket1)) $row['DUZEY']='Üst';
		if(in_array($row['UZAKLIK'],$temel_etiket2)) $row['DUZEY']='Orta';
		if(in_array($row['UZAKLIK'],$temel_etiket3)) $row['DUZEY']='Alt';
  echo "<tr bgcolor=#".($say++ % 2 ?'FFFFFF':'F7F7F7' ).">
<td><center><input type=radio name=osec 
onchange='obasliksec(".$say.")' id=idosec".$say."
value='&gbaslik".$say."=".$row['BASLIK']."&gislem".$say."=".$row['BASLIK']."'></input></center></td>
<td><center>".$row['UZAKLIK']."<input type=hidden id=iduzaklik".$say." value='".$row['UZAKLIK']."'></input></td>
<td><center>".date("H:i:s d-m-Y",strtotime($row['TARIH']))."</center><input type=hidden id=idtarih".$say." value='".$row['TARIH']."'></input></td>
<td><center>".$row['BASLIK']."</center><input type=hidden id=idbaslik".$say." value='".$row['BASLIK']."'></input></td>
<td><center>".$row['DUZEY']."</center><input type=hidden id=idduzey".$say." value='".$row['DUZEY']."'></input></td>

<input type=hidden id=idaciklama".$say." 
value='".$row['DUZEY']." düzeyde tanımlı ".$row['BASLIK']." adlı ".$row['ZAMAN']." grafikte ".$row['TARIH']." tarihinde beklenti aralığından ".$row['UZAKLIK']." birimlik uzaklaşma sıra dışı olay olarak tesbit edilmiştir.'></input>

<input type=hidden id=idvts".$say." value='".$row['VERITABANIS']."'></input>
<input type=hidden id=idvta".$say." value='".$row['VERITABANI']."'></input>
<input type=hidden id=idvtt".$say." value='".$row['TABLO']."'></input>
<input type=hidden id=idvte".$say." value='".$row['ERISIM']."'></input>
<input type=hidden id=idvti".$say." value='".$row['ISLEM']."'></input>
<input type=hidden id=idvtb".$say." value='".$row['BAGLANTI']."'></input>
</tr>";
//if($say==1) {	$ilkbas=$row['BASLIK'];}

	
	}
//$etiket[1]=	array_diff($etiket[1],$etiket[2]);
//$etiket[2]=	array_diff($etiket[2],$etiket[3]);

	echo "	
	<tr><td colspan=5><br><b>Açıklama:</b>
	<textarea rows=3 cols=65 id=idaciklama></textarea> <br><br><b>Teknik Detay:</b> 
	<table class=table>
	<tr><td>Veri Tabanı Sistemi</td><td>:</td><td id=idvts></td></tr>
	<tr><td>Veri Tabanı Adı	  </td><td>:</td><td id=idvta></td></tr>
	<tr><td>Tablo Adı		  </td><td>:</td><td id=idvtt></td></tr>
	<tr><td>Tablo Erişim Adı  </td><td>:</td><td id=idvte></td></tr>
	<tr><td>Tablo İşlem Adı	  </td><td>:</td><td id=idvti></td></tr>
	<tr><td>Veri Tabanı Bağlantı Adı</td><td>:</td><td id=idvtb></td></tr>
	</table>
	</td></tr>
	</table>
 
	<script>
			var utils = Samples.utils;
					function sbasliksec(say) {
window.location='?siradisi=1&zaman=G'+document.getElementById('idsec'+say).value; 

}
			
					function obasliksec(say) {
if(say==1)document.getElementById('idosec1').checked=true;
document.getElementById('idaciklama').value=document.getElementById('idaciklama'+say).value; 
document.getElementById('idvts').innerHTML=document.getElementById('idvts'+say).value;
document.getElementById('idvta').innerHTML=document.getElementById('idvta'+say).value; 
document.getElementById('idvtt').innerHTML=document.getElementById('idvtt'+say).value; 
document.getElementById('idvte').innerHTML=document.getElementById('idvte'+say).value; 
document.getElementById('idvti').innerHTML=document.getElementById('idvti'+say).value; 
document.getElementById('idvtb').innerHTML=document.getElementById('idvtb'+say).value; 
}
window.onload=obasliksec(1);

	function updateTextInput() {
	var urlorigin=window.location.origin+window.location.pathname;
	urlpath=window.location.href.replace(urlorigin,'');
	urlpath=urlpath.replace('&renk3=00c600','');
	urlpath=urlpath.replace('&renk2=00c600','');
	urlpath=urlpath.replace('&renk1=00c600','');
	
	
	var yenipath='';	
		var val=document.getElementById('idrange').value;
	var yenival=0;
			if(val==4) {yenipath=urlpath;yenival=4;}
			if(val==3) {yenipath=urlpath+'&renk3=00c600';yenival=3;}
			if(val==2) {yenipath=urlpath+'&renk2=00c600&renk3=00c600';yenival=2;}
			if(val==1) {yenipath=urlpath+'&renk1=00c600&renk2=00c600&renk3=00c600';yenival=1;}
yenipath=yenipath.replace('val='+document.getElementById('idval').value,'val='+yenival);

window.location=urlorigin+yenipath;
 }
	
	
		function basliksec() { var adres='';
for (var i = 1; i <= document.getElementById('idtoplam').value; i++) {		
  if (document.getElementById('idsec'+i).checked) { 
  adres=adres+document.getElementById('idsec'+i).value;
} else {
	  adres=adres.replace(document.getElementById('idsec'+i).value,'');}
}
adres='?siradisi=1&zaman=".$_GET['zaman']."&val=3&renk3=".$_GET['renk3']."'+adres;
window.location=adres;
}


var data = {
			labels: [".$sayigrubu."],
			datasets: [{
				fill: true,
			    data: [".$toplamgrubu."],
				hidden: false,
				label: 'Yönetim Düzeyi',
				borderColor: ['#".$_GET['renk1']."','#".$_GET['renk2']."','#".$_GET['renk3']."'],
				backgroundColor: ['#".$_GET['renk1']."','#".$_GET['renk2']."','#".$_GET['renk3']."']		 
}]
		};
	

		var options = {
animation: {
	duration: 1,
  onComplete: function () {

        var ctx = this.chart.ctx;
        ctx.font = this.scale.font;
        ctx.fillStyle = this.scale.textColor
        ctx.textAlign = 'center';
        ctx.textBaseline = 'bottom';

        this.datasets.forEach(function (dataset) {
            dataset.bars.forEach(function (bar) {
                ctx.fillText(bar.value, bar.x, bar.y - 5);
            });
        })
    }
},
			maintainAspectRatio: false,
			spanGaps: false,
			elements: {
				line: {
					tension: 0.00001
				}
			},
			scales: {
				yAxes: [{
					stacked: true,
					scaleLabel: {
					display: true,
					labelString: 'Uzaklaşma Sayısı'	},
					ticks: {mirror: true}
				}],
			xAxes: [{
				stacked: true
				
				}]
			},
			plugins: {
				filler: {
					propagate: false
				},
				'samples-filler-analyser': {
					target: 'chart-analyser'
				},
				      datalabels: {
								formatter: function(value, context) {
									
								return context.dataIndex == 2 ? (".$etiket1.") : 
									   context.dataIndex == 1 ? (".$etiket2." ) : 
												 (".$etiket3." );
			

			},
								display: true,
								align: 'center',
								anchor: 'center',
								labels: {
									title: {
										font :{
											weight: 'bold'
											
										}
									},
								    value: {
										color: 'green'
										}
								}
							}
			},
        tooltips: {
				mode: 'label',
                enabled: true,
				callbacks: {
						label: function(tooltipItem, data) {
						return data.datasets[tooltipItem.datasetIndex].label + ': ' + numberWithCommas(tooltipItem.yLabel);
						}
				}
		}};
		
var img = new Image();
img.onload = function() {
  var size = 48;

  Chart.types.Line.extend({
    name: 'LineAlt',
    draw: function() {
      Chart.types.Line.prototype.draw.apply(this, arguments);

      var scale = this.scale;
      [
        { x: 1.5, y: 50 }, 
        { x: 4, y: 10 }
      ].forEach(function(p) {
        ctx.drawImage(img, scale.calculateX(p.x) - size / 2, scale.calculateY(p.y) - size / 2, size, size);
      })
    }
  });
}
 		var chart = new Chart('chart-0', {
			type: 'bar',
			data: data,
			options: options
		});	
		
		

	</script>
		
</td></tr>";
		
}

if (isset($_GET['talep'])=='1') {
    $sayacrenksatir=0;
    $sql15="Select row_number() over (order by rowid) rno,s.* from
(select * from vis.talepler) s";
    $talepliste=oci_parse($conn, $sql15);
    oci_execute($talepliste);

     if(isset($_POST['kaydet'])){
         for($i=1;$i<=$_POST['toplam'];$i++){
             $sqluptalep= "update vis.talepler set tanim='".$_POST['tanim'.$i]."', durum='".$_POST['durum'.$i]."' where id='".$_POST['id'.$i]."'";
//           echo $sqlupsistem;
             $uptalep=oci_parse($conn, $sqluptalep);
             oci_execute($uptalep);			 		 
		 }
        //header("location:login_success.php?talep=1");
     }

if(isset($_POST['ekle'])){
         $sqlintalep= "insert into vis.talepler values('".($_POST['toplam']+1)."','".$_POST['tanim']."','H','".$_SESSION['KNO']."')";
         echo $sqlinstalep;
		 $intalep=oci_parse($conn, $sqlintalep);
         oci_execute($intalep);
        // header("location:login_success.php?talep=1");
     }
	//echo $_POST['toplam'];
if(isset($_POST['toplam'])){	
  for($i=1;$i<=$_POST['toplam'];$i++){
	 if(isset($_POST['sil'.$i])){
         $sqlsiltalep= "delete vis.talepler where id='".$_POST['id'.$i]."'";
         //echo $sqlsilsistem;
		 $siltalep=oci_parse($conn, $sqlsiltalep);
         oci_execute($siltalep);
         //header("location:login_success.php?talep=1");
     }
	 }
	}     
     echo $navbar1."Yeni Grafik Talebi".$navbar2."

<tr style='font-weight:bold' align='center'><td></td><td>No</td><td colspan=3>Tanım</td></tr>
<tr>
<td align='center'><br><input type=submit name=ekle value=' Ekle '></input></td>
<td></td>

<td colspan=3>
<textarea rows=4 cols=60 name=tanim></textarea>
</td>

</tr>

<tr bgcolor=#DDDDDD><td colspan=5><center><h2>Mevcut Talepler</h2></center></td></tr>
<tr style='font-weight:bold' align='center'><td></td><td>No</td><td>Tanım</td><td>Durum</td><td>Kullanıcı No</td></tr>";

   $toplam=0; 
    while (($row = oci_fetch_array($talepliste, OCI_BOTH)) != false){
        
  echo "<tr bgcolor=#".($row['RNO'] % 2 ?'FFFFFF':'F7F7F7' ).">
<td><center>
".($row['KNO']==$_SESSION['KNO']?"<input type=submit name=sil".$row['RNO']." value=' Sil '></input>":"")."
</center></td>
<td><center>".$row['ID']."</center><input type=hidden name=id".$row['RNO']." value='".$row['ID']."'></input></td>
<td>".($row['DURUM']=='E'?$row['TANIM']:"<input name=tanim".$row['RNO']." size=40 type=text value='".$row['TANIM']."'></input>")."</td>
<td><center>
".($row['DURUM']=='E'?'<font color=black>Hazır</font>':'<font color=black>Beklemede</font>')."</center><input type=hidden name=durum".$row['RNO']." value='".$row['DURUM']."'></input></td>
<td><center>".$row['KNO']."</center><input type=hidden name=kno".$row['RNO']." value='".$row['KNO']."'></input></td>";

        $toplam=$row['RNO'];
    }
        
    echo "<tr><td colspan=5 align=center>
	
    <input type=hidden name=toplam value=".$toplam."></input>
	</td></tr>";


}


if( !isset($_GET['kullanicilar'])
	&&!isset($_GET['sistem'])
	&&!isset($_GET['erisim'])
	&&!isset($_GET['baslik'])
	&&!isset($_GET['islem'])
	&&!isset($_GET['grafik'])
	&&!isset($_GET['talep'])
	&&!isset($_GET['siradisi'])
	&&!isset($_GET['izleme'])
	&&!isset($_GET['dizi'])
	&&!isset($_GET['duzeyler'])	) {
    
         echo "
<tr><td colspan=2  style='style='border-top: 1px solid black;'>
<center>
<h1>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Veri İzleme Sistemi <br>
<span style='font-size:80x;' class='glyphicon glyphicon-grain' ></span>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hoşgeldiniz&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h1>

</center>
</td></tr>

<tr valign=center><td>

      <a><h2>";
	  
         if ($_SESSION["KADI"]=="sistem"){
echo "<span style='font-size:23px;' class='glyphicon glyphicon-grain' ></span>Yönetici Paneli</h2></a></td>
        <td align=right><a href=index.php?cikis=1><span class='glyphicon glyphicon-log-out'></span>Oturumu Kapat</a>
		<br><font size=2>".$_SESSION['ADI']."</font>&nbsp</td>
		</tr>


<tr valign=center><td colspan=2>
<div class='list-group list-group-flush' align=center>
<a href=?duzeyler=1 role=button class='btn btn-primary btn-block'><h4>Görev Tanımlama</h4></a>
<a href=?kullanicilar=1 role=button class='btn btn-primary btn-block'><h4>Kullanıcı Tanımlama</h4></a>
<a href=?sistem=1 role=button class='btn btn-primary btn-block'><h4>Veri Tabanı Bağlantısı</h4></a>
<a href=?erisim=1 role=button class='btn btn-primary btn-block'><h4>Tablo Erişimi</h4></a>
<a href=?islem=1 role=button class='btn btn-primary btn-block'><h4>Veri Toplama İşlemi</h4></a>";
//<a href=?baslik=1 role=button class='btn btn-primary btn-block'><h4>Veri Yapılandırma Başlığı</h4></a>
         } else {//echo $_SESSION['TIPI'];
echo "<span style='font-size:23px;' class='glyphicon glyphicon-grain'></span>Kullanıcı Paneli</h2></a></td>    
        <td align=right><a href=index.php?cikis=1><span class='glyphicon glyphicon-log-out'></span>Oturumu Kapat</a>
		<br><font size=2>".$_SESSION['ADI']."</font>&nbsp</td>		
		</tr>

<tr valign=center><td colspan=2>
<div class='list-group list-group-flush' align=center'>
<a href=?talep=1 role=button class='btn btn-primary btn-block'><h4>Yeni Grafik Talebi</h4></a>
<a href=?grafik=1&zaman=G&kaydir=-1&gbaslik1=1 role=button class='btn btn-primary btn-block'><h4>Grafikler</h4></a>
<a href=?siradisi=1&zaman=G&gbaslik=1&val=3&renk3=00c600 role=button class='btn btn-primary btn-block'><h4>Sıra Dışı Olay Analizi</h4></a>";      
         }
echo "</div></td></tr>";
    
}
echo "</table></td></tr>

</table></form></div>
</div>";//scrolls

?>



