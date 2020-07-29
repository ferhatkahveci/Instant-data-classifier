<?php

putenv("NLS_LANG=TURKISH_TURKEY.AL32UTF8");
//set_time_limit(300);
$conn= oci_connect('system', 'oracle', ' (DESCRIPTION =
    (ADDRESS_LIST =
      (ADDRESS = (PROTOCOL = TCP)(HOST = localhost)(PORT = 1521))
    )
    (CONNECT_DATA =
      (SERVICE_NAME = orcl)
    )
  )')
  or die(oci_error());


/*
$conor= oci_connect('test', 'oracle', ' (DESCRIPTION =
    (ADDRESS_LIST =
      (ADDRESS = (PROTOCOL = TCP)(HOST = localhost)(PORT = 1521))
    )
    (CONNECT_DATA =
      (SERVICE_NAME = orcl)
    )
  )')
  or die(oci_error());


$consql=sqlsrv_connect( "ORACLE-PC\SQLEXPRESS",  array( "Database"=>"master", "UID"=>"sa", "PWD"=>"oracle"));
if($consql) echo "tamam";

$sonuc =sqlsrv_query( 
$consql, 

'SELECT name as USERNAME FROM master.sys.databases where owner_sid<>0x01');

sqlsrv_execute($sonuc);

ECHO "BUMU=".$sonuc;

while ($row=sqlsrv_fetch_array($sonuc, SQLSRV_FETCH_ASSOC)){ 


echo $row['USERNAME'];

}


$sorgu="SELECT table_name as table_name FROM information_schema.tables";
$sonuc=(new mysqli('localhost:3306', 'root', 'oracle', 'Mysql'))->query($sorgu);
while ($row = $sonuc->fetch_assoc()){

echo $row['table_name']."<br>";

}


$sonuc =pg_query( pg_pconnect("host=localhost port=5432 dbname=PGDENEME user=postgres password=oracle"), 
"SELECT column_name FROM information_schema.columns where table_name='PGTABLE'");
ECHO "BUMU=".$sonuc;
while (
 $row=pg_fetch_assoc($sonuc)
 ) {
echo $row['column_name']."<br>";
}

//$url = 'https://obs.atauni.edu.tr/online/online2.txt'; // path to your JSON file
$url = 'https://www.albaraka.com.tr/forms/currencies.json';
$data = file_get_contents($url); // put the contents of the file into a variable
$decode = json_decode($data); // decode the JSON feed
echo $decode[0]->Alis;
/*
ECHO $decode[0]->Alis;
foreach($decode as $key=>$val){
  foreach($val as $k=>$v){
    echo $k."=".$v."<br>";
  }
}

foreach($decode[0] as $key=>$val){
    echo $key."=".$val."<br>"; 
}

*/

$arrContextOptions=array(
    "ssl"=>array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
		
    ),
    "http" => array(
        "timeout" => 900
        )
);

//		"protocol_version"=>"1.1"
/*
$url = 'https://avesis.atauni.edu.tr/home/getpublicationcountsbyresearchareas';
$data = file_get_contents($url, false, stream_context_create($arrContextOptions)); // put the contents of the file into a variable
//$decode = json_decode($data); // decode the JSON feed

$pos1=strpos($data,'[');
$data= substr($data,$pos1,strlen($data)-$pos1-1);

//echo $data;

$decode = json_decode($data); // decode the JSON feed
//echo $decode[0]->PublicationCount;

 foreach($decode as $key=>$val){
	 
      foreach($val as $keykey=>$valval){
		echo $keykey."=".$valval."<br>";
  }
  }

//print_r($decode);
$alan=array("","Sosyal Bilimler (SOC)","Temel Bilimler (SCI)");$deger=0;
 foreach($decode as $key=>$val){
	 	if( array_search($val->TopicName,$alan)) {$deger= $deger+ $val->PublicationCount ;
		echo $val->TopicName."=".$val->PublicationCount;		
		}

  }

echo $deger;
 //echo phpinfo();

ini_set("SMTP", "localhost");
ini_set("sendmail_from", "skypie67@hotmail.com");

ini_set("smtp_port", "587");

 $to = "ferhatkahveci@gmail.com";
$subject = "My subject";
$txt = "Hello world!";
$headers = "From: ahmet@postaci.com" . "\r\n";

mail($to,$subject,$txt,$headers);
*/ 
  ?>