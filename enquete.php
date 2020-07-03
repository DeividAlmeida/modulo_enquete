<?php
	require_once('includes/funcoes.php');
	require_once('includes/header.php');
?>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="css_js/jquery-ui.css">
<link rel="stylesheet" href="assets/plugins/iconpicker/bootstrap-iconpicker.min.css"/>
<link rel="stylesheet" href="wa/enquete/includes/chiquinha.css">

<?php
	require_once('includes/menu.php');
	require_once('controller/enquete.php');
	$TitlePage = 'Enquete';
	$UrlPage   = 'enquete.php';
?>

<div class="has-sidebar-left">
	<header class="blue accent-3 relative nav-sticky">
		<div class="container-fluid text-white">
			<div class="row p-t-b-10 ">
				<div class="col">
					<h4><i class="icon-pencil-square-o"></i> <?php echo $TitlePage; ?></h4>
				</div>
			</div>
		</div>
	</header>

	<div class="container-fluid animatedParent animateOnce my-3">
		<p>
			<?php if (DadosSession('nivel') == 1) { ?>
  			<a class="btn btn-sm btn-primary" href="<?php echo $UrlPage; ?>">Categorias cadastradas</a>
			  <?php if (checkPermission($PERMISSION, $_SERVER['SCRIPT_NAME'], 'categoria', 'adicionar')) { ?>
  			<a class="btn btn-sm btn-primary" href="?AdicionarCategoria">Cadastrar categoria</a>
<?php } ?>
				<?php if(isset($_GET['VisualizarCategoria'])){ ?>
					<?php if (checkPermission($PERMISSION, $_SERVER['SCRIPT_NAME'], 'item', 'adicionar')) { ?>
					<a class="btn btn-sm btn-primary" href="?AdicionarItem=<?php echo get('VisualizarCategoria'); ?>&radar=<?php echo get('radar')?>">Adicionar pergunta</a>
<?php } ?>
				<?php } ?>
  			<button class="btn btn-sm behance text-white" data-toggle="modal" data-target="#Ajuda"><i class="icon-question-circle"></i></button>
			<?php } ?>
		</p>

		<!-- LISTAR ITENS -->
		<?php if(isset($_GET['VisualizarCategoria'])){ ?>
			<?php $id = get('VisualizarCategoria'); $c_query = DBRead('c_enquete','*',"WHERE id = '{$id}'"); $categoria = $c_query['0']; ?>

			<div class="card">
				<div class="card-header white">
					<strong>#<?php echo $categoria['id']; ?> <?php echo $categoria['nome']; ?> > Enquete</strong>
				</div>

				<?php $Query = DBRead('enquete','*',"WHERE id_categoria = ".$id); if (is_array($Query)) {  ?>

					<div class="card-body p-0">
						<div>
							<div>
								<table id="DataTable" class="table m-0 table-striped">
									<tr>
										<th>ID</th>										
										<th>Pergunta</th>										
										<?php if (DadosSession('nivel') == 1) { ?>
										<th width="53px">Ações</th>
										<?php } ?>
									</tr>

									<?php foreach ($Query as $key => $dados) { ?>
										<tr>
											<td><?php echo $key + 1; ?></td>
											
											<td><?php echo $dados['pergunta']; ?></td>
											
											<?php if (DadosSession('nivel') == 1) { ?>
												<td>
													<div class="dropdown">
														<a class="" href="#" data-toggle="dropdown">
															<i class="icon-apps blue lighten-2 avatar"></i>
														</a>

														<div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end">
<?php if (checkPermission($PERMISSION, $_SERVER['SCRIPT_NAME'], 'item', 'editar')) { ?>
															<a class="dropdown-item" href="?EditarItem=<?php echo $dados['id']; ?>&radar=<?php echo get('radar')?>"><i class="text-primary icon icon-pencil"></i> Editar</a>
<?php } ?>
															<?php if ($dados['id'] != 0) { ?>
																<?php if (checkPermission($PERMISSION, $_SERVER['SCRIPT_NAME'], 'item', 'deletar')) { ?>
																<a class="dropdown-item" onclick="DeletarItem(<?php echo $dados['id']; ?>, 'DeletarItem');" href="#!"><i class="text-danger icon icon-remove"></i> Excluir</a>
<?php } ?>
															<?php } ?>
														</div>
													</div>
												</td>
											<?php } ?>
										</tr>
									<?php } ?>
								</table>
							</div>
						</div>
					</div>

<?php } else { ?>
					<div class="card-body">
					<?php if (checkPermission($PERMISSION, $_SERVER['SCRIPT_NAME'], 'item', 'adicionar')) { ?>
						<div class="alert alert-info">Nenhuma pergunta adicionada até o momento, <a href="?AdicionarItem=<?php echo $_GET['VisualizarCategoria']; ?>">clique aqui</a> para adicionar.
						<?php } ?>
					</div>
<?php } ?>
			</div>

		<!--  Adicionar Item -->
<?php } elseif(isset($_GET['AdicionarItem'])){ if(!checkPermission($PERMISSION, $_SERVER['SCRIPT_NAME'], 'item', 'adicionar')){ Redireciona('./index.php'); }; $radar = get('radar');$c_query = DBRead('c_enquete','*',"WHERE id = '{$radar}'")[0]; ?>
				<form method="post" action="?AddItem=<?php echo $_GET['AdicionarItem'];?>" enctype="multipart/form-data">
					<div class="card">
						<div class="card-header white">
							<strong>Adcionar Itens</strong>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-md-12">
									<input name="id_categoria" type="hidden" value="<?php echo $_GET['AdicionarItem'];?>">

									<div class="form-group">
										<label>Pergunta: </label>
										<input class="form-control" name="pergunta" required>
									</div>
									<span <?php if($c_query['tipo'] == 2 ){ echo "style='display:none'";}?>>
									<div class="form-group">
					                    <label>Alternativas <small>Disponível apenas na enquete de múltipla escolhas</small></label>
					                    <div id="input_group">
					                      <div class="row">
					                        <div class="col-md-12"><button type="button" class="btn btn-primary btnAdd" style="margin-bottom: 15px;"><i class="fas fa-plus"></i></button></div>
					                      </div>
					                      <div class="row groupItens">					                        
					                        <div class="col-md-10" style="margin-top: 6px;">
					                          <input  class="form-control" type="text" name="link[]" placeholder="Alternativa">
					                        </div>
					                        <div class="col-md-1 pull-right">
					                          <button type="button" class="btn btn-danger btnRemove"><i class="fas fa-trash"></i></button>
					                        </div>
					                      </div>
					                    </div>
					                </div>
									<label  for="chkPassport">Outros <small>Disponível apenas na enquete de múltipla escolhas</small><br><input name="pergunta_outros" type="checkbox"  value="Outros" />								    
								</label></span>											
							</div>			
						</div><br>
					<button class="btn btn-primary float-right" type="submit">Adicionar</button>	
				</div>
			</div>
		</form>
		<!--  Editar Item -->
		<?php } elseif(isset($_GET['EditarItem'])){ if(!checkPermission($PERMISSION, $_SERVER['SCRIPT_NAME'], 'item', 'editar')){ Redireciona('./index.php'); } ?>
			<?php $id = get('EditarItem'); $radar = get('radar'); $Query = DBRead('enquete','*',"WHERE id = '{$id}'");$c_query = DBRead('c_enquete','*',"WHERE id = '{$radar}'")[0]; if (is_array($Query)) { foreach ($Query as $dados) { ?>

				<form method="post" action="?AtualizarItem=<?php echo $id; ?>" enctype="multipart/form-data">
					<div class="card">
						<div class="card-header  white">
							<strong>Editar Pergunta</strong>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-md-12">
									
								<div class="col-md-12">
									<input name="id_categoria" type="hidden" value="<?php echo $_GET['radar'];?>">

									<div class="form-group">
										<label>Pergunta: </label>
										<input class="form-control" name="pergunta" value="<?php echo $dados['pergunta'];?>" required>
									</div>
									<span <?php if($c_query['tipo'] == 2 ){ echo "style='display:none'";}?>>	
									<div class="form-group">
					                  <label>Alternativas <small>Disponível apenas na enquete de múltipla escolhas</small> </label>
					                    <div id="input_group">
					                      <div class="row">
					                        <div class="col-md-12">
					                        	<button type="button" onclick="add()" class="btn btn-primary btnAdd" style="margin-bottom: 15px;">
					                        		<i class="fas fa-plus">					                        		</i>
					                        	</button>
					                        </div>
					                      </div>
											
										<?php $Query3 = DBRead('alt_enquete','*',"WHERE id_pergunta = '{$id}'"); foreach ($Query3 as $data3): ?>										
					                      <div class="row groupItens" style="<?php if($data3['alternativa'] === "Outros"){echo 'display: none';}?>">
					                        <div class="col-md-10" style="margin-top: 6px;">
					                          
					                        </div>
					                        <div class="col-md-10">
					                          <input class="form-control"  type="text" name="link[]" value="<?php  echo $data3['alternativa']?>" placeholder="Texto Conteúdo">
					                          <input class="form-control"  type="hidden" name="zero[]" value="<?php  echo $data3['zero']?>" placeholder="Texto Conteúdo">
					                        </div>
					                        <div class="col-md-1 pull-right">
					                          <button type="button" class="btn btn-danger btnRemove"><i class="fas fa-trash"></i></button>
					                        </div>
					                      </div>
					                  <?php endforeach; ?>

					                    </div>
					                </div>
								<label  for="chkPassport">Outros <small>Disponível apenas na enquete de múltipla escolhas</small> <br><input name="pergunta_outros" type="checkbox"  value="Outros" <?php if ($dados['pergunta_outros'] === 'Outros'){echo "checked";?>/>	
								<input type="hidden" name="xsa" value="<?php  echo $data3['zero']?>">	<?php ;}else{}?>						    
								</label></span>											
							</div>
									<button class="btnSubmit btn btn-primary float-right" type="submit">Editar</button>
								
							</div>
						</div>
					</div>
				</form>
			<?php }}?>
		<!--  VIZUALIZAR GRÁFICO -->
		<?php } elseif(isset($_GET['VisualizarGrafico'])){ if(!checkPermission($PERMISSION, $_SERVER['SCRIPT_NAME'], 'relatorio', 'acessar')){ Redireciona('./index.php'); }$id = get('VisualizarGrafico');  $central = DBRead('c_enquete','*',"WHERE id = '{$id}'")[0]; $itens = DBRead('enquete','*',"WHERE id_categoria = '{$id}'");error_reporting(0);if($central['tipo'] == '1'){?>
			<div  id="totalpoll" class="totalpoll-wrapper totalpoll-uid-6499a4033fea1b86c812012eac21cf19 is-ltr is-screen-vote"  totalpoll-uid="6499a4033fea1b86c812012eac21cf19" >
				<div class="totalpoll-form" id="totalpoll-form"  >   
					<div class="totalpoll-question">
    					<div class="totalpoll-question-container">
        					<div class="totalpoll-question-content">
								<?php foreach ($itens as $i): ?><br>

									<?php $as = $i['id'];$alternativas  = DBRead('alt_enquete','*',"WHERE id_pergunta = '{$as}'");?>						  						
									<center><h1 style=";font-weight: bolder;color: #86939e;position: relative; "><?php echo ($i['pergunta']); ?>  </h1></center>									
        					</div>
							<div class="totalpoll-question-choices-item totalpoll-question-choices-item-results totalpoll-question-choices-item-type-text" >
								<?php foreach($alternativas as $key => $s): ?>
									<?php $ass = $s['id']; ?>    
		        						<div class="totalpoll-question-choices-item-label" style=" background-color: #ffc500;?>;">
            								<span style="color: #fff"><?php echo $s['alternativa'] ?></span>											
            								<div class="totalpoll-question-choices-item-votes" >
            									<?php  $agas  = DBRead('alt_enquete','sum(zero)',"WHERE id_pergunta = '{$as}'"); $total = implode($agas[0]);if($total < 1){$shw = "0%";$parte = "0";}else{$parte = $s['zero']; $mi7 = $parte / $total; $porce = round($mi7*100); $shw = $porce."%";}?> 
                								<div  class="totalpoll-question-choices-item-votes-bar" style="width: <?php echo $shw;?>; background: #fff"></div>
                								<div class="totalpoll-question-choices-item-votes-text "style="font-size: 12px;color: #fff"><?php echo $shw." (".$parte." votos)";?></div>
            								</div>
        								</div><br>
    								<?php endforeach;?>
    								<button id="myAnchor<?php echo $i['id']; ?>"  style="<?php if ($i['pergunta_outros'] == null){echo "display: none";} ?> ;padding: .35rem .6rem;" class="btn btn-sm btn-primary"  href="#" onclick="showDetails<?php echo $i['id']; ?>(this)" data-toggle="modal" data-target="#Modal" data-num=" Respostas a pergunta: <?php echo $i['pergunta'];?>"> Outros Respostas</button> <script>function showDetails<?php echo $i['id']; ?>(z) {  $("#main").load('<?php echo ConfigPainel('base_url'); ?>/wa/enquete/modal.php?id=<?php echo $i['id']; ?>'); var x = document.getElementById("myAnchor<?php echo $i['id']; ?>").getAttribute("data-num");document.getElementById("demo").innerHTML = x;}</script>
    						</div>
    						<?php endforeach;?>
						</div>
 					</div>
 				</div>
    		</div><?php }else{ ?>
			<div class="card">
				<div class="card-header  white">					
				<?php $resposta = DBRead('res_enquete', '*', "WHERE id_categoria = '{$id}'");?>
				<style type="text/css">.fixed-table-loading{display: none;}</style>
				<div class="card-body p-0">
						<div>
							<table id="BootstrapTable" data-toggle="table" data-pagination="true" data-locale="pt-BR" data-cache="false" data-search="true" data-show-export="true" data-export-data-type="all" data-export-types="['csv', 'excel', 'pdf']" data-mobile-responsive="true" data-click-to-select="true" data-toolbar="#toolbar" data-show-columns="true" class="table m-0 table-striped">
								<thead>
									<tr class="first-line">	
										<th class="text-center">ID</th>									
										<th class="text-center">Pergunta</th>
										<th class="text-center">Resposta</th>										
										<th>Ação</th>
									</tr>
								</thead>
								<tbody>	<?php foreach($resposta as $vhs => $mima):?>							
									<tr>
										<td class="text-center"><?php echo $vhs+1;?>
										</td>
										<?php $per= $mima['id_pergunta'];?>
										<?php $pergunta = DBRead('enquete', '*', "WHERE id = '{$per}'");?>
										<?php foreach($pergunta as $mo):?>
										<td class="text-center">
											<?php echo $mo['pergunta']?>
										</td><?php endforeach ?>									
										<td class="text-center">
											<?php echo $mima['resposta']?>
										</td>
										<td>
											<div class="dropdown">
												<a class="" href="#" data-toggle="dropdown">
													<i class="icon-apps blue lighten-2 avatar"></i>
												</a>
												<div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end">
													<?php if (checkPermission($PERMISSION, $_SERVER['SCRIPT_NAME'], 'item', 'deletar')) { ?>
													<a class="dropdown-item" onclick="DeletarItem(<?php echo $mima['id']; ?>, 'DeletarLead');" href="#!"><i class="text-danger icon icon-remove"></i> Excluir</a>
													<?php } ?>
												</div>
											</div>
										</td>
									</tr>
								<?php endforeach ?>									
								</tbody>
							</table data-toggle="table">
						</div>
					</div>				
			</div>
		<!--  ADD CATEGORIA -->
		<?php }} elseif(isset($_GET['AdicionarCategoria'])){ if(!checkPermission($PERMISSION, $_SERVER['SCRIPT_NAME'], 'categoria', 'adicionar')){ Redireciona('./index.php'); } ?>

			<form method="post" action="?AddCategoria" enctype="multipart/form-data">
				<div class="card">
					<div class="card-header  white">
						<strong>Adicionar Categoria</strong>
					</div>

					<div class="card-body">
						<div class="row">
							<div class="col-md-6">

								<div class="form-group">
									<label>Nome da Categoria:</label>
									<input class="form-control" name="nome" required>
								</div>

								<div class="form-group">
									<label>Tipo de Enquete:</label>
									<select class="form-control" name="tipo">
										<option value="1" selected>Multipla Escolhas</option>
										<option value="2">Discursiva</option>									
									</select>
								</div>

								<div class="form-group">
									<label>Mostrar Resultado:</label>
									<select class="form-control custom-select" name="resultado">
										<option value="1" selected>Durante a Enquete</option>
										<option value="2">No Fim da Enquete</option>
									</select>
								</div>

								<div class="form-group">
									<label>Texto do Botão:</label>
									<input class="form-control" name="txt_bt" required>
								</div>

								<div class="form-group">
									<label>Recompensa:</label>
									<select class="form-control custom-select" id="select">
										<option value="1">Sim</option>
										<option value="2" selected>Não</option>
									</select>
								</div>

								<div style="display: none;" class="form-group" id="recom_link">
									<label class="tooltips" data-tooltip="Cole o link">Link: 
										<i class="icon icon-question-circle" ></i>				
									</label>
									<input style="display: none;" placeholder="Coloque aqui o link de sua recompensa." id="recom_link2"  class="form-control" type="url" name="recompensa" >
								</div>				
						    
						    	<div class="form-group">
									<label>Cor do Título:</label>
									<div class="color-picker input-group colorpicker-element focused">
				          				<input class="form-control" name="cor_titulo" value="#242424">
										<span class="input-group-append">
											<span class="input-group-text add-on white">
												<i class="circle"></i>
											</span>
										</span>
					        		</div>
						    	</div>
						    	<div class="form-group">
									<label>Cor do Conteúdo:</label>
									<div class="color-picker input-group colorpicker-element focused">
				          				<input class="form-control" name="cor_conteudo" value="#242424">
										<span class="input-group-append">
											<span class="input-group-text add-on white">
												<i class="circle"></i>
											</span>
										</span>
					        		</div>
						    	</div>
						   </div>
						    <div class="col-md-6">
						    	<div class="form-group">
									<label>Cor do Fundo:</label>
									<div class="color-picker input-group colorpicker-element focused">
				          				<input class="form-control" name="cor_fundo" value="#242424">
										<span class="input-group-append">
											<span class="input-group-text add-on white">
												<i class="circle"></i>
											</span>
										</span>
					        		</div>
						    	</div>
						    	<div class="form-group">
									<label>Cor da Borda:</label>
									<div class="color-picker input-group colorpicker-element focused">
				          				<input class="form-control" name="cor_da_borda" value="#242424">
										<span class="input-group-append">
											<span class="input-group-text add-on white">
												<i class="circle"></i>
											</span>
										</span>
					        		</div>
						    	</div>
						    	<div class="form-group">
									<label>Cor do Texto do Botão:</label>
									<div class="color-picker input-group colorpicker-element focused">
				          				<input class="form-control" name="cor_txt_bt" value="#242424">
										<span class="input-group-append">
											<span class="input-group-text add-on white">
												<i class="circle"></i>
											</span>
										</span>
					        		</div>
						    	</div>
						    	<div class="form-group">
									<label>Cor do Fundo do Botão:</label>
									<div class="color-picker input-group colorpicker-element focused">
				          				<input class="form-control" name="cor_bg_bt" value="#242424">
										<span class="input-group-append">
											<span class="input-group-text add-on white">
												<i class="circle"></i>
											</span>
										</span>
					        		</div>
						    	</div>
						    	<div class="form-group">
									<label>Cor do Texto Hover do Botão:</label>
									<div class="color-picker input-group colorpicker-element focused">
				          				<input class="form-control" name="cor_hover_txt_bt" value="#242424">
										<span class="input-group-append">
											<span class="input-group-text add-on white">
												<i class="circle"></i>
											</span>
										</span>
					        		</div>
						    	</div>
						    	<div class="form-group">
									<label>Cor do Fundo Hover do Botão:</label>
									<div class="color-picker input-group colorpicker-element focused">
				          				<input class="form-control" name="cor_hover_bg_bt" value="#242424">
										<span class="input-group-append">
											<span class="input-group-text add-on white">
												<i class="circle"></i>
											</span>
										</span>
					        		</div>
						    	</div>						    	
							</div>
						</div>
					</div>

					<div class="card-footer white">
						<button class="btn btn-primary float-right" type="submit">Cadastrar</button>
					</div>
				</div>
  		</form>

		<!--  EDITAR CATEGORIA -->
		<?php } elseif(isset($_GET['EditarCategoria'])){ if(!checkPermission($PERMISSION, $_SERVER['SCRIPT_NAME'], 'categoria', 'editar')){ Redireciona('./index.php'); } ?>
			<?php $id = get('EditarCategoria'); $Query = DBRead('c_enquete','*',"WHERE id = '{$id}'"); if (is_array($Query)) { foreach ($Query as $dados) { ?>
				<form method="post" action="?AtualizarCategoria=<?php echo $id; ?>" enctype="multipart/form-data">
					<div class="card">
						<div class="card-header  white">
							<strong>Editar Categorial</strong>
						</div>
						<div class="card-body">
							<div class="row">								
								<div class="col-md-6">
									<div class="form-group">
										<label>Nome da Categoria:</label>
										<input class="form-control" name="nome" value="<?php echo $dados['nome']; ?>" required>
									</div>
									<div class="form-group">
										<label>Tipo de Enquete:</label>
										<select class="form-control" name="tipo">
											<option value="1" <?php selected($dados['tipo'], '1'); ?>>Multipla Escolhas</option>
											<option value="2" <?php selected($dados['tipo'], '2'); ?>>Discursiva</option>									
										</select>
									</div>
									<div class="form-group">
										<label>Mostrar Resultado:</label>
										<select class="form-control custom-select" name="resultado">
											<option value="1" <?php selected($dados['resultado'], '1'); ?>>Durante a Enquete</option>
											<option value="2" <?php selected($dados['resultado'], '2'); ?>>No Fim da Enquete</option>
										</select>
									</div>
									<div class="form-group">
										<label>Texto do Botão:</label>
										<input class="form-control" name="txt_bt" value="<?php echo $dados['txt_bt']; ?>" required>
									</div>
									<div class="form-group">
									<label>Recompensa:</label>
									<select class="form-control custom-select" id="select">
										<option value="1">Sim</option>
										<option value="" <?php selected($dados['recompensa'], ''); ?>>Não</option>
									</select>
								</div>

								<div <?php if ($dados['recompensa'] == null) {echo "style='display: none;'";}?>  class="form-group" id="recom_link">
									<label class="tooltips" data-tooltip="Cole o link" >Link: 
										<i class="icon icon-question-circle" ></i>				
									</label>
									<input placeholder="Coloque aqui o link de sua recompensa."  style="display: block;"  id="recom_link2"  class="form-control" type="url" name="recompensa" value="<?php echo $dados['recompensa']; ?>">
								</div>
									<div class="form-group">
										<label>Cor do Título:</label>
										<div class="color-picker input-group colorpicker-element focused">
							          		<input class="form-control" name="cor_titulo" value="<?php echo $dados['cor_titulo']; ?>">
												<span class="input-group-append">
													<span class="input-group-text add-on white">
															<i class="circle"></i>
													</span>
												</span>
								        </div>
									</div>									
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Cor do Conteúdo:</label>
											<div class="color-picker input-group colorpicker-element focused">
							          			<input class="form-control" name="cor_conteudo" value="<?php echo $dados['cor_conteudo']; ?>">
													<span class="input-group-append">
														<span class="input-group-text add-on white">
															<i class="circle"></i>
														</span>
													</span>
								        	</div>
									</div>
									<div class="form-group">
										<label>Cor do Fundo:</label>
										<div class="color-picker input-group colorpicker-element focused">
							          		<input class="form-control" name="cor_fundo" value="<?php echo $dados['cor_fundo']; ?>">
											<span class="input-group-append">
												<span class="input-group-text add-on white">
													<i class="circle"></i>
												</span>
											</span>
								       	</div>
									</div>
									<div class="form-group">
										<label>Cor da Borda:</label>
										<div class="color-picker input-group colorpicker-element focused">
							          		<input class="form-control" name="cor_da_borda" value="<?php echo $dados['cor_da_borda']; ?>">
											<span class="input-group-append">
												<span class="input-group-text add-on white">
													<i class="circle"></i>
												</span>
											</span>
								        </div>
									</div>
									<div class="form-group">
										<label>Cor do Texto do Botão:</label>
										<div class="color-picker input-group colorpicker-element focused">
							          		<input class="form-control" name="cor_txt_bt" value="<?php echo $dados['cor_txt_bt']; ?>">
												<span class="input-group-append">
													<span class="input-group-text add-on white">
														<i class="circle"></i>
													</span>
												</span>
								        </div>
									</div>
							    	<div class="form-group">
										<label>Cor do Fundo do Botão:</label>
										<div class="color-picker input-group colorpicker-element focused">
					          				<input class="form-control" name="cor_bg_bt" value="<?php echo $dados['cor_bg_bt']; ?>">
											<span class="input-group-append">
												<span class="input-group-text add-on white">
													<i class="circle"></i>
												</span>
											</span>
						        		</div>
							    	</div>
							    	<div class="form-group">
										<label>Cor do Texto Hover do Botão:</label>
										<div class="color-picker input-group colorpicker-element focused">
					          				<input class="form-control" name="cor_hover_txt_bt" value="<?php echo $dados['cor_hover_txt_bt']; ?>">
											<span class="input-group-append">
												<span class="input-group-text add-on white">
													<i class="circle"></i>
												</span>
											</span>
						        		</div>
							    	</div>
							    	<div class="form-group">
										<label>Cor do Fundo Hover do Botão:</label>
										<div class="color-picker input-group colorpicker-element focused">
					          				<input class="form-control" name="cor_hover_bg_bt" value="<?php echo $dados['cor_hover_bg_bt']; ?>">
											<span class="input-group-append">
												<span class="input-group-text add-on white">
													<i class="circle"></i>
												</span>
											</span>
						        		</div>
							    	</div>						    	
								</div>								
							</div>
						<div class="card-footer white">
							<button class="btn btn-primary float-right" type="submit">Atualizar</button>
						</div>
					</div>
				</form>
			<?php } } ?>

		<!--  LISTAR CATEGORIAS -->
		<?php } else { ?>

			<div class="card">
				<div class="card-header white">
					<strong>Categorias</strong>
				</div>

				<?php $Query = DBRead('c_enquete','*'); if (is_array($Query)) {  ?>
					<div class="card-body p-0">
						<div>
							<div>
								<table id="DataTable" class="table m-0 table-striped">
									<tr>
										<th>ID</th>
										<th>Nome</th>
										<th><center>Item</center></th>
										<th></th>
										<?php if (DadosSession('nivel') == 1) { ?>
										<th>Implementação</th>
										<th width="53px">Ações</th>
										<?php } ?>
									</tr>

									<?php
										foreach ($Query as $key => $dados) { 							
											
											$CodSite  = '<div id="Enquete'.$dados['id'].'" data-painel="'.RemoveHttpS(ConfigPainel('base_url')).'"></div>'."\n";
											$CodSite .= '<script type="text/javascript">Enquete('.$dados['id'].',1);</script>';
									?>
									<tr>
										<td><?php echo $key + 1; ?></td>
										<td><?php echo LimitarTexto($dados['nome'],'80','...'); ?></td>
										<td><center>
										<?php if (checkPermission($PERMISSION, $_SERVER['SCRIPT_NAME'], 'item', 'adicionar')) { ?>
											<a class="tooltips" data-tooltip="Adicionar" href="?AdicionarItem=<?php echo $dados['id']; ?>&radar=<?php echo $dados['id'] ;?>">
												<i class="icon-plus blue lighten-2 avatar"></i>
											</a>
<?php } ?>

											<a class="tooltips" data-tooltip="Visualizar" href="?VisualizarCategoria=<?php echo $dados['id']; ?>&radar=<?php echo $dados['id'] ;?>">
												<i class="icon-eye blue lighten-2 avatar"></i>
											</a>


											<?php if (checkPermission($PERMISSION, $_SERVER['SCRIPT_NAME'], 'relatorio', 'acessar')) { ?>
													<?php if($dados['tipo'] == '1'){echo "<a  class='tooltips' data-tooltip='Gráfico'  href='?VisualizarGrafico=".$dados['id']."&radar=".$dados['id']."'> <i class='icon icon-bar-chart blue lighten-2 avatar' aria-hidden='true'></i></a>";}else{echo "<a  class='tooltips' data-tooltip='Relatório'  href='?VisualizarGrafico=".$dados['id']."&radar=".$dados['id']."'> <i class='icon icon-wpforms blue lighten-2 avatar' aria-hidden='true'></i></a>";}
													?>
											<?php } ?></center>
										</td>
										<td><i class="icon icon-signal" aria-hidden="true"></i> <?php if ($dados['votos'] == null){echo "0 Votos";
										}else{ echo $dados['votos']." Votos";}?></td>										
										<?php if (DadosSession('nivel') == 1) { ?>
											<td>
											<?php if (checkPermission($PERMISSION, $_SERVER['SCRIPT_NAME'], 'codigo', 'acessar')) { ?>
												<button
												id="btnCopiarCodSite<?php echo $dados['id']; ?>"
												class="btn btn-primary btn-xs"
												onclick="CopiadoCodSite(<?php echo $dados['id']; ?>)"
												data-clipboard-text='<?php echo $CodSite; ?>'>
													<i class="icon icon-code"></i> Copiar Cód. do Site
												</button>
<?php } ?>
											</td>
											<td>
												<div class="dropdown">
													<a class="" href="#" data-toggle="dropdown">
														<i class="icon-apps blue lighten-2 avatar"></i>
													</a>

													<div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end">
													<?php if (checkPermission($PERMISSION, $_SERVER['SCRIPT_NAME'], 'categoria', 'editar')) { ?>
														<a class="dropdown-item" href="?EditarCategoria=<?php echo $dados['id']; ?>"><i class="text-primary icon icon-pencil"></i> Editar</a>
<?php } ?>
														<?php if ($dados['id'] != 0) { ?>
															<?php if (checkPermission($PERMISSION, $_SERVER['SCRIPT_NAME'], 'categoria', 'deletar')) { ?>
															<a class="dropdown-item" href="#" onclick="DeletarItem(<?php echo $dados['id']; ?>, 'DeletarCategoria');"><i class="text-danger icon icon-remove"></i> Excluir</a>

															<a class="dropdown-item" href="#" onclick="ResetarCategoria(<?php echo $dados['id']; ?>, 'ResetarCategoria');"><i class="text-green icon icon-repeat"></i> Resetar</a>
<?php } ?>
														<?php } ?>
													</div>
												</div>
											</td>
										<?php } ?>
									</tr>
									<?php } ?>
								</table>
							</div>
						</div>
					</div>
				<?php } else { ?>
					<div class="card-body">
						<div class="alert alert-info">Nenhuma enquete adicionada até o momento, <a href="?AdicionarCategoria">clique aqui</a> para adicionar.
					</div>
				<?php } ?>

			</div>

    <?php } ?>
	</div>

<?php require_once('includes/footer.php'); ?>
<div class="modal fade" id="Ajuda" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content b-0">
			<div class="modal-header r-0 bg-primary">
				<h6 class="modal-title text-white" id="exampleModalLabel">Informações de Sobre o Módulo</h6>
				<a href="#" data-dismiss="modal" aria-label="Close" class="paper-nav-toggle paper-nav-white active"><i></i></a>
			</div>

			<div class="modal-body">
				<p>
						Atenção: Duas enquetes não funcionam em uma mesma página, se deseja colocar mais de uma
					enquete em seu site precisa ser em páginas diferentes.

				</p>
			</div>

			<div class="modal-footer">
				<center>
					<em>Obs.: As informações acima, não são BUGS e sim limitações que todo e qualquer sistema possui, portanto não será necessário reporta-los.</em>
				</center>
			</div>
		</div>
	</div>
</div>
<div class="modal fade"  id="Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div  class="modal-dialog" role="document">
    <div style="width:730px" class="modal-content">
    	<p id="demo" style=" width: 100%; font-weight: bolder; font-size: 30px; position: fixed; margin-top: 10px; margin-left: 150px" ></p><br>
    	<div id="main"  style="width:730px; height:auto; margin:50px;font-weight: bolder; font-size: 15px;"></div>
    </div>
  </div>
</div>


<script src="css_js/jquery.multifield.min.js"></script>
<script type="text/javascript" src="assets/plugins/iconpicker/bootstrap-iconpicker.bundle.min.js"></script>

<script type="text/javascript">
	$(function () {
		$('[data-toggle="tooltip"]').tooltip();
		$('.target').iconpicker();
	});

	$('#input_group').multifield({
	    section: '.groupItens',
	    btnAdd:'.btnAdd',
	    btnRemove:'.btnRemove',
	    locale:{
	      "multiField": {
	        "messages": {
	          "removeConfirmation": "Deseja realmente remover estes campos?"
	        }
	      }
	    }
	  });

  $('.btnAdd').on( "click", function(e) {
    setTimeout(function(){
      $('.target').iconpicker(); 
    }, 0);
  });

var selectElem = document.getElementById('select')
selectElem.addEventListener('change', function() {
 var index = selectElem.selectedIndex;
  if (index === 0) {
  document.getElementById('recom_link').style.display = "block";
  document.getElementById('recom_link2').style.display = "block";}
  else{
  document.getElementById('recom_link').style.display = "none";
  document.getElementById('recom_link2').style.display = "none";
  document.getElementById('recom_link2').value = "";
  }
});


function ResetarCategoria(id, get){
			swal({   
				title: "Você tem certeza?",   
				text: "Deseja realmente resetar a enquete?",   
				type: "warning",
				buttons: {
					cancel: "Não",
					confirm: {text: "Sim", className: "btn-primary",},
				},
				closeOnCancel: false
			}).then(function(isConfirm) {  
				if (isConfirm) {  
					window.location = '?'+get+'='+id;   
				} else {     
					swal("Cancelado", "O procedimento foi cancelado :)", "error");   
				} 
			});
		}
</script>

<script src="https://unpkg.com/bootstrap-table@1.16.0/dist/bootstrap-table.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.16.0/dist/locale/bootstrap-table-pt-BR.min.js"></script>
<script src="css_js/plugins/tableExport.jquery.plugin/libs/FileSaver/FileSaver.min.js"></script>
<script src="css_js/plugins/tableExport.jquery.plugin/libs/js-xlsx/xlsx.core.min.js"></script>
<script src="css_js/plugins/tableExport.jquery.plugin/libs/jsPDF/jspdf.min.js"></script>
<script src="css_js/plugins/tableExport.jquery.plugin/libs/jsPDF-AutoTable/jspdf.plugin.autotable.js"></script>
<script src="css_js/plugins/tableExport.jquery.plugin/tableExport.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.16.0/dist/extensions/export/bootstrap-table-export.min.js"></script>