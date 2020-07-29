<?php
$_POST['kullanici']="test";
include_once 'connect.php';
session_start();

if(isset($_SESSION['KNO'])) header("location:login_success.php");

    if (isset($_GET['cikis'])) {
	
   unset($_SESSION['KNO']);
   unset($_SESSION['ADI"']);
	unset($_SESSION['KADI']);   
  
     header("location:index.php");
	//	echo "<script>window.location('index.php')</script>";
   
    }
	
echo '
<head>
<link rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="bootstrap-3.3.7-dist/css/custom.css">
<script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
</head>

    <script type="text/javascript">
function mypass() {
  var x = document.getElementById("sifre");
  var y = document.getElementById("eye");
  if (x.type === "password") {
    x.type = "text";
    y.setAttribute("class","glyphicon glyphicon-eye-open");
  
  } else {
    x.type = "password";
    y.setAttribute("class","glyphicon glyphicon-eye-close");
  }
}

</script>

<div class="container h-100">
  <div class="row h-100 justify-content-center align-items-center">

<form class="col-12" name="form1" method="post" >

<table class="form-group" height: 100% width="300" border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#F7F7F7">

<tr>
<td colspan="3" align=center>
<br><br>
<span style="font-size:60px;" class="glyphicon glyphicon-grain" ></span><br><b><h2>Veri İzleme Sistemi<br>(V I S)</h2></b></td>
</tr>';

if(isset($_POST['kullanici'])&&isset($_POST['sifre'])){
   
    $myusername=$_POST['kullanici'];
    $mypassword=$_POST['sifre'];
    
    $myusername = stripslashes($myusername);
    $mypassword = stripslashes($mypassword);
    
    $sqlkullanici="select * from vis.kullanicilar where kadi='".$myusername."' and sifre='".$mypassword."'";
    $tablo=oci_parse($conn, $sqlkullanici);
    oci_execute($tablo);
    $bilgi=oci_fetch_assoc($tablo);
    
    
    
    if ($bilgi['KNO']){
    session_start();    
        // Register $myusername, $mypassword and redirect to file "login_success.php"
        $_SESSION['KNO']=$bilgi['KNO'];
        $_SESSION['ADI']=$bilgi['ADI'];
        $_SESSION['KADI']=$bilgi['KADI'];
        echo $_SESSION['KADI'];
        header("location:login_success.php");
		//echo "<script>window.location('login_success.php')</script>";
		} else {
            
            echo "Girdiğiniz kullanıcı adı veya şifre yanlıştır. <a href=index.php>Lütfen tekrar deneyiniz.</a>";
            //die(oci_error());
            
        }
}

if(isset($_POST['admin'])||isset($_POST['kullanici'])){
    echo (isset($_POST['admin'])?'
<tr><td colspan=3><input name="kullanici" type="hidden" id="kullanici" value="sistem"></td></tr>':
        
'<tr>
<td colspan=2 align=right><b>Kullanıcı : </b></td><td align=left><input name="kullanici" size=10 type="text" id="kullanici"></td>
</tr><tr><td colspan=3><br></td></tr>').'

<tr><td colspan=2 align=right><b>Şifre : </b></td><td align=left>
<input name="sifre" type="password" id="sifre" size=10>
<span class="glyphicon glyphicon-eye-close" id="eye" onclick="mypass()"></span>
</td></tr>       
<tr><td colspan=2></td><td><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input class="btn btn-info my-2 my-sm-0" size=20 type="submit" name="giris" value="Giriş"></td></tr>
'.(isset($_POST['kullanici'])?'
<tr><td colspan="3"><br><br><center>Kullanıcı: test</center></td><tr>
<tr><td colspan="3"><center>&nbsp;&nbsp;&nbsp;Şifre: test</center></td><tr>
':'<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><td colspan="2"><br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Şifre: test</td><tr>').'

';
    
} else if(!isset($_POST['kullanici'])&&!isset($_POST['admin'])){
	$sqlbilgi="select count(*) sayi from vis.veri";
    $bilgi=oci_parse($conn, $sqlbilgi);
    oci_execute($bilgi);
    $veri=oci_fetch_assoc($bilgi);

echo '
<tr>
<td colspan="3"><center><b>Lütfen, kullanıcı tipini seçiniz. </b><center></td>
</tr>

<tr><td colspan="3"><br><center><b><input class="btn btn-danger my-2 my-sm-1" size=10 type="submit" name="admin" value="Yönetici">
<input class="btn btn-success my-2 my-sm-0" size=10 type="submit" name="kullanici" value="Kullanıcı"></b><center></td>
<tr>

<tr><td colspan="3" align=center><br><br><h4>Yazılım Bilgileri:<h4></td> 


<tr><td colspan="2">Gerçek veri sayısı:</td> 
<td>'.$veri["SAYI"].'</td></tr>

<tr><td colspan="2">Prototip veri sayısı:</td> 
<td>'.round($veri["SAYI"]*4/5).'</td></tr>

<tr><td colspan="2">İlk veri kayıt tarihi:</td> 
<td>22 Temmuz 2019</td></tr>

<tr><td colspan="2"></td> 
<td></td></tr>

';
}
    
echo '</table>

</form>
   </div>
</div>';

//<tr><td colspan="2">Kaynak kod dosyası:</td> 
//<td><a href=vis.txt target=_blank>vis.php</a></td></tr>
?>