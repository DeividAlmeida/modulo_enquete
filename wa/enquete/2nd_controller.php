<?php
error_reporting(0);
	header('Access-Control-Allow-Origin: *');
	require_once('../../includes/funcoes.php');
	require_once('../../database/config.database.php');
	require_once('../../database/config.php');


$idbr = post('id');
$zico = DBRead('c_enquete','*',"WHERE id = '{$idbr}'")[0];
$Jr = $zico['votos'];
$gabigol = $Jr + 1;

$Arao = array(
'votos' => $gabigol  		
);
DBUpdate('c_enquete',$Arao,"id = '{$idbr}'")[0];  

foreach ($_POST['outros'] as $ky => $vl) {
if ($vl == null) {
}else{
$cosk = array(
'resposta' => $vl,
'id_pergunta' => $ky  		
);
 DBCreate('out_enquete', $cosk);
}}

unset($_POST['outros']);
unset($_POST['id']);
foreach ($_POST as $i => $v) {
$id = $v;
$itens = DBRead('alt_enquete','*',"WHERE id = '{$id}'"); 
foreach ($itens as $key => $e) {
	$d = $e['zero']+1;
$cors = array(
  'zero' => $d,  		
);
 DBUpdate('alt_enquete',$cors,"id = '{$id}'");  
}};



  



