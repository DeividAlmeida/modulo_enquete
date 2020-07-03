<?php
	header('Access-Control-Allow-Origin: *');
	require_once('../../includes/funcoes.php');
	require_once('../../database/config.database.php');
	require_once('../../database/config.php');

	$id 	= get('id');

	if (ModoManutencao()) { header("Location: ../manutencao.php"); }
	$central 		= DBRead('c_enquete','*',"WHERE id = '{$id}'")[0];
	$itens 			= DBRead('enquete','*',"WHERE id_categoria = '{$id}'");
    require_once('includes/jaiminho.php');        

?>
 


<link rel="stylesheet" href="<?php echo RemoveHttpS(ConfigPainel('base_url')); ?>/wa/enquete/includes/chiquinha.css">





