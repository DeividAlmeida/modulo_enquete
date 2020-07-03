<?php
	header('Access-Control-Allow-Origin: *');
	require_once('../../includes/funcoes.php');
	require_once('../../database/config.database.php');
	require_once('../../database/config.php');

	$id 	= get('id');

	if (ModoManutencao()) { header("Location: ../manutencao.php"); }
	
	$itens = DBRead('out_enquete','resposta',"WHERE id_pergunta = '{$id}'");

	foreach ($itens as $key => $value) {
		$dft= implode($value);
		$sft = $key+1;
		 echo $sft." - ".$dft."<br>";
	}
           

?>
 








