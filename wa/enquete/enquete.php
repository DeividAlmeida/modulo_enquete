<?php
	header('Access-Control-Allow-Origin: *');
	require_once('../../includes/funcoes.php');
	require_once('../../database/config.database.php');
	require_once('../../database/config.php');

	$id 	= get('id');

	if (ModoManutencao()) { header("Location: ../manutencao.php"); }
	$central 		= DBRead('c_enquete','*',"WHERE id = '{$id}'")[0];


	$itens 			= DBRead('enquete','*',"WHERE id_categoria = '{$id}'");



switch ($central['tipo']) {
    case 1:
      require_once('includes/sr_madruga.php');
    break;
    case 2:
      require_once('includes/sr_barriga.php');
    break;  

};


?>
 


<?php if (isset($_GET['nada'])) { 
	echo "string";
    
	 } ?>

<link rel="stylesheet" href="<?php echo RemoveHttpS(ConfigPainel('base_url')); ?>/wa/enquete/includes/chiquinha.css">





