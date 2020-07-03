<?php
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
DBUpdate('c_enquete',$Arao,"id = '{$idbr}'");  

foreach ($_POST['respos'] as $key => $value) {
$mitero = array(
'id_categoria' => $idbr,
'id_pergunta' => $key,
'resposta' => $value
);
 DBCreate('res_enquete', $mitero);
}
  



