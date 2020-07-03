<?php
require_once 'database/upload.class.php';

if(!$_SESSION['node']['id']){ die(); exit(); }

if (!checkPermission($PERMISSION, $_SERVER['SCRIPT_NAME'])) { Redireciona('./index.php'); }

// Pasta para upload dos arquivos enviados
$upload_folder = 'wa/tabela_de_precos/uploads/';

//
// Adicionar Item
//
if(isset($_GET['AddItem'])){
  if(!checkPermission($PERMISSION, $_SERVER['SCRIPT_NAME'], 'item', 'adicionar')){ Redireciona('./index.php'); }

    $data = array(
      'id_categoria'    => post('id_categoria'),
      'pergunta'        => post('pergunta'),
      'pergunta_outros' => post('pergunta_outros'),
);

 $query = DBCreate('enquete', $data, true);

foreach ($_POST['link'] as $key => $value) {

  $zap = $query.$key;
 $cors = array(
  'id_categoria'    => post('id_categoria'),
  'alternativa' => $value,
  'id_pergunta'    => $query,
  'tag' => $zap,
);   
 DBCreate('alt_enquete', $cors);
}

if ( post('pergunta_outros') === 'Outros') {

$pz = $query.post('pergunta_outros');

  $cors2 = array(
  'alternativa' => post('pergunta_outros'),
  'id_pergunta'    => $query,
   'id_categoria'    => post('id_categoria'),
   'tag'    => $pz,
);

$zas = array( 'zero' => post('xsa'));
  DBCreate('alt_enquete', $cors2);
  DBUpdate('alt_enquete', $zas, "tag = '{$pz}'");
}
    if ($query != 0) {
      Redireciona('?sucesso');
    } else {
      Redireciona('?erro');
    }
  
}

// Atualizar Item
if (isset($_GET['AtualizarItem'])) {
  if(!checkPermission($PERMISSION, $_SERVER['SCRIPT_NAME'], 'item', 'editar')){ Redireciona('./index.php'); }

  $id = get('AtualizarItem');

  $data = array(
      'id_categoria'    => post('id_categoria'),
      'pergunta'        => post('pergunta'),
      'pergunta_outros' => post('pergunta_outros'),);

  
$query = DBUpdate('enquete', $data, "id = '{$id}'");

DBDelete('alt_enquete',"id_pergunta = '{$id}'"); 


  
foreach ($_POST['link'] as $key => $value) {


  if ($value === 'Outros') {}else{
$zap = $id.$key;
 $cors = array(
 'id_categoria'    => post('id_categoria'),
  'alternativa'     => $value,
  'id_pergunta'    => $id,
  'tag' => $zap,


);

 DBCreate('alt_enquete', $cors);
}}

foreach ($_POST['zero'] as $ky => $vl) {

  $zp = $id.$ky;
  $cors6 = array(
   'zero'    => $vl,

);
    $q = DBUpdate('alt_enquete', $cors6, "tag = '{$zp}'");
} 

if ( post('pergunta_outros') === 'Outros') {

$pz = $id.post('pergunta_outros');

  $cors2 = array(
  'alternativa' => post('pergunta_outros'),
  'id_pergunta'    => $id,
   'id_categoria'    => post('id_categoria'),
   'tag'    => $pz,
   'zero' => post('xsa')
);


  DBCreate('alt_enquete', $cors2);
  
}

  if ($query != 0) {
    Redireciona('?sucesso&VisualizarCategoria='.post('id_categoria').'&radar='.post('id_categoria'));
  } else {
    Redireciona('?erro&VisualizarCategoria='.post('id_categoria').'&radar='.post('id_categoria'));
  }
}

// Excluir Item
if (isset($_GET['DeletarItem'])) {
  if(!checkPermission($PERMISSION, $_SERVER['SCRIPT_NAME'], 'item', 'deletar')){ Redireciona('./index.php'); }

  $id         = get('DeletarItem');
  $i_query    = DBRead('enquete','*',"WHERE id = '{$id}'");
	$item        = $i_query[0];

  $query = DBDelete('enquete',"id = '{$id}'");
  if ($query != 0) {
    Redireciona('?sucesso&VisualizarCategoria='.$item['id_categoria']);
  } else {
    Redireciona('?erro&VisualizarCategoria='.$item['id_categoria']);
  }
}

// Excluir Resposta
if (isset($_GET['DeletarLead'])) {
  if(!checkPermission($PERMISSION, $_SERVER['SCRIPT_NAME'], 'item', 'deletar')){ Redireciona('./index.php'); }

  $id         = get('DeletarLead');
  $i_query    = DBRead('res_enquete','*',"WHERE id = '{$id}'");
  $item        = $i_query[0];

  $query = DBDelete('res_enquete',"id = '{$id}'");
  if ($query != 0) {
    Redireciona('?sucesso&VisualizarGrafico='.$item['id_categoria']);
  } else {
    Redireciona('?erro&VisualizarGrafico='.$item['id_categoria']);
  }
}


//
// CATEGORIA
//

// Adicionar Categoria
if (isset($_GET['AddCategoria'])) {
  if(!checkPermission($PERMISSION, $_SERVER['SCRIPT_NAME'], 'categoria', 'adicionar')){ Redireciona('./index.php'); }

  $data = array(
    'nome'              => post('nome'),
    'tipo'              => post('tipo'),
    'resultado'         => post('resultado'),
    'txt_bt'            => post('txt_bt'),
    'recompensa'        => post('recompensa'),
    'cor_titulo'        => post('cor_titulo'),
    'cor_conteudo'      => post('cor_conteudo'),
    'cor_fundo'         => post('cor_fundo'),
    'cor_da_borda'      => post('cor_da_borda'),
    'cor_txt_bt'        => post('cor_txt_bt'),
    'cor_bg_bt'         => post('cor_bg_bt'),
    'cor_hover_txt_bt'  => post('cor_hover_txt_bt'),
    'cor_hover_bg_bt'   => post('cor_hover_bg_bt'),
    'cor_hover_bg_bt'   => post('cor_hover_bg_bt'),    
  );

  $query = DBCreate('c_enquete', $data);

  if ($query != 0) {
    Redireciona('?Implementacao&sucesso');
  } else {
    Redireciona('?Implementacao&erro');
  }
}

// Atualizar Categoria
if (isset($_GET['AtualizarCategoria'])) {
  if(!checkPermission($PERMISSION, $_SERVER['SCRIPT_NAME'], 'categoria', 'editar')){ Redireciona('./index.php'); }

  $id = get('AtualizarCategoria');
  $data = array(
    'nome'              => post('nome'),
    'tipo'              => post('tipo'),
    'resultado'         => post('resultado'),
    'txt_bt'            => post('txt_bt'),
    'recompensa'        => post('recompensa'),
    'cor_titulo'        => post('cor_titulo'),
    'cor_conteudo'      => post('cor_conteudo'),
    'cor_fundo'         => post('cor_fundo'),
    'cor_da_borda'      => post('cor_da_borda'),
    'cor_txt_bt'        => post('cor_txt_bt'),
    'cor_bg_bt'         => post('cor_bg_bt'),
    'cor_hover_txt_bt'  => post('cor_hover_txt_bt'),
    'cor_hover_bg_bt'   => post('cor_hover_bg_bt')

  );

  $query = DBUpdate('c_enquete', $data, "id = '{$id}'");
  if ($query != 0) {
    Redireciona('?Implementacao&sucesso');
  } else {
    Redireciona('?Implementacao&erro');
  }
}

// Excluir Categoria
if (isset($_GET['DeletarCategoria'])) {
  if(!checkPermission($PERMISSION, $_SERVER['SCRIPT_NAME'], 'categoria', 'deletar')){ Redireciona('./index.php'); }

  $id = get('DeletarCategoria');
  $query = DBDelete('c_enquete',"id = '{$id}'");
  $query2 = DBDelete('enquete',"id_categoria = '{$id}'");
  if ($query != 0) {
    Redireciona('?Implementacao&sucesso');
  } else {
    Redireciona('?Implementacao&erro');
  }
}
// Resetar Categoria
if (isset($_GET['ResetarCategoria'])) {
  if(!checkPermission($PERMISSION, $_SERVER['SCRIPT_NAME'], 'categoria', 'deletar')){ Redireciona('./index.php'); }

  $id = get('ResetarCategoria');
  $reset = "";

$data = array(        
    'votos'             => $reset,    
  );
$data3 = array(        
    'zero'             => $reset,    
  );

  $i_query    = DBRead('enquete','id',"WHERE id_categoria = '{$id}'")[0];
  foreach ($i_query as  $value) {
  $query2 = DBDelete('out_enquete',"id_pergunta = '{$value}'");
  }

  $query = DBUpdate('c_enquete', $data, "id = '{$id}'");
  $query3 = DBUpdate('alt_enquete', $data3, "id_categoria = '{$id}'");

 
  $query4 = DBDelete('res_enquete',"id_categoria = '{$id}'");  
  if ($query != 0) {
    Redireciona('?Implementacao&sucesso');
  } else {
    Redireciona('?Implementacao&erro');
  }
}
