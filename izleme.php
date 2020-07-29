<?php
include_once 'connect.php';


echo '
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="bootstrap-3.3.7-dist/css/custom.css">
<script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
</head>

<script type="text/javascript">

(function () {
    var timeLeft = 60,
        cinterval;

    var timeDec = function (){
        timeLeft--;
        document.getElementById("countdown").innerHTML = timeLeft;
        if(timeLeft === 0){
            clearInterval(cinterval);
        }
    };

    cinterval = setInterval(timeDec, 1000);
})();
	var randomScalingFactor = function() {
		return Math.ceil(Math.random() * 10.0) * Math.pow(10, Math.ceil(Math.random() * 5));
	};
</script>
';

function myUrlEncode($string) {
    $entities = array('%20','%C4%B1','%C5%9F', '%C3%B6','%C3%96','%C3%BC','%C3%A7','%C4%B0');
    $replacements = array(' ','ı','ş', 'ö','Ö','ü','ç','İ');
    return str_replace($entities, $replacements, $string);
}


//session_start();
//$iadi=$_GET['iadi'];
//$deger=$_SESSION['deger'];
//else {$iadi=explode('?',$_SERVER['REQUEST_URI']);}

//$iadi=myUrlEncode($iadi);
$iadi=utf8_decode($_GET['iadi']);
//echo "bumu".$iadi;

$sqlbaglanti="select i.sorgu,e.adi,e.sifre tablo,b.adres,b.tablolar,b.baglanti_adresi,b.islem, b.zamansal_sorgu, b.zamansal_bilgi, ornek_veri, b.veritabani
		from vis.baglanti b, vis.erisim e, vis.islem i where b.adi=e.adres and e.adi=i.adres 
		and i.adi='".$iadi."'";
//echo $sqlbaglanti;
	$baglanti=oci_parse($conn,$sqlbaglanti);
	oci_execute($baglanti);
	$row=oci_fetch_assoc($baglanti);
	 
				
	if ($row['VERITABANI']<>'Harici') {
		
		$sql_ins="select round(deger/length('".$iadi."')) deger from vis.veri 
		where kaynak='Avesis Toplam Yayınlar'
		and guncelleme<(sysdate - numtodsinterval((length('".$iadi."')*3), 'day'))
		order by guncelleme desc
		fetch first 1 rows only";
		
		if ($row['VERITABANI']=='MySQL') {
		$sql_ins="select 
		(deger-(length('".$iadi."')*20))*100 deger 
		from vis.veri where kaynak='Öbs Toplam Kullanıcı Sayısı'
		and guncelleme<(sysdate - numtodsinterval((length('".$iadi."')*3), 'day'))
		order by guncelleme desc
		fetch first 1 rows only";
		}
		
		if ($row['VERITABANI']=='SQLServer') {
		$sql_ins="select 
decode(sign(substr(substr(deger*1000,2,2)*2,2,2)-length('".$iadi."')*2),-1,0,substr(substr(deger*1000,2,2)*2,2,2)-length('".$iadi."')*2) deger
from vis.veri where kaynak='Usd Alış Kuru'
	order by guncelleme desc
		fetch first 1 rows only";
		}
		
		if ($row['VERITABANI']=='PostgreSQL') {
		$sql_ins="select 
round(power(deger/power(decode(to_char(v.guncelleme, 'HH24'),'00',1,to_char(v.guncelleme, 'HH24')),2)*decode(sign(substr(substr(deger*1000,2,2)*2,2,2)-length('".$iadi."')*2),-1,0,substr(substr(deger*1000,2,2)*2,2,2)-length('".$iadi."')*2),2)*1000) deger
from vis.veri v where kaynak='Usd Alış Kuru'
	order by v.guncelleme desc
		fetch first 1 rows only";
		}
		
		$insistem=oci_parse($conn, $sql_ins);
        oci_execute($insistem); 
		$ornek_veri=oci_fetch_assoc($insistem);
		
		$baglantim =str_replace('sorgu',$row['ORNEK_VERI'],$row['BAGLANTI_ADRESI']);	
		eval($baglantim);
	  // echo $ornek_veri['DEGER'];
		
		$uzunluk=1;$zaman_ing='minute';$grup=12;$kaydir=0;$rowa['ADI']=$iadi;
		$baglantim =str_replace('sorgu',$row['ZAMANSAL_SORGU'],$row['BAGLANTI_ADRESI']);
				
		eval($baglantim);
		$say=0;$onceki=0;$deger=null;

		eval($row['ZAMANSAL_BILGI']);

		
		$deger=substr($deger, 1, strlen($deger));
		
		if($deger==0){echo "\n <font color=red>Bekleniyor.</font><script>window.location.reload()</script>";sleep(30);
} else {
			
		echo "<table><tr><td width=120><font color=green>".$deger."</font></td>
						<td><span id='countdown'>60</span></td></tr></table>";
}
		
		} else {
			$icerik=@file_get_contents( $row['ADRES'], false, stream_context_create($arrContextOptions));
			if($icerik){
			$baglantim =str_replace('sorgu',$row['TABLOLAR'],$row['BAGLANTI_ADRESI']);
			$baglantim .=$row['ISLEM'];
			$baglantim =str_replace('veri',$row['TABLO'],$baglantim);
			//echo $baglantim;
			
			
			eval($baglantim);
			}
			
		if(isset($deger)){
		$sql_ins="insert into vis.veri (kaynak,deger) values('".$iadi."',".$deger.")";
//echo $sql_ins;
		 $insistem=oci_parse($conn, $sql_ins);
         oci_execute($insistem);
		}//değer varsa sonu
		
		}	
			
//echo "BU=".$baglantim."=BU";
		
 if(!isset($deger)){echo "\n <font color=red>Bağlantı kesildi.</font><script>window.location.reload()</script>";sleep(3);
} //icerik sonu


echo "<br><br><a href=login_success.php?izleme=0 target=_blank>Anlık Veri İzleme ve Kayıt Penceresi</a>";
echo "<meta http-equiv=refresh content='60;url=?iadi=".utf8_encode($iadi)."' />";	

//$max=10;
		//$min=1;
		//$sayi=ceil(rand(0,10) * 10.0) *pow(10, ceil(rand(1,10)*5));
		//$sayi=(rand() > 0.5 ? 1.0 : -1.0) * rand() * 100;
		//$sayi=rand(0,5);
		//$sayi=($sayi* 9301 + 49297) % 233280;
		//$sayi= $sayi/ 233280;
		//$sayi=ceil($min + $sayi * ($max - $min))+$deger;
		//$sayi=$sayi+$deger;	
		//$random_0_1=(float) mt_rand() / (float) mt_getrandmax() ;
		//echo floor($random_0_1 * ($maxRand)) + $LowValue ;
		//echo $sayi;
		
		/*if($iadi=='Öğrenci Bina Giriş Sayısı') $deger=6578;
		if($iadi=='Bütçe gelir-gider farkı') $deger=115250;
		if($iadi=='Öğrenci Bina Giriş Sayısı') $deger=6578;
		if($iadi=='Toplam indexli yayımlar') $deger=5748;	*/	
		
		//echo "<font color=green>".$deger."</font>".str_repeat('&nbsp;',22-strlen($deger))." <span id='countdown'>60</span>";
		
?>

