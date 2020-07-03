<style type="text/css">
.totalpoll-buttons-vote:hover{ background-color: <?php echo $central['cor_hover_bg_bt'];?> !important; color: <?php echo $central['cor_hover_txt_bt'];?> !important }	
</style>


<center>
	<div style="width: 50%; " id="totalpoll" class="totalpoll-wrapper totalpoll-uid-6499a4033fea1b86c812012eac21cf19 is-ltr is-screen-vote"  totalpoll-uid="6499a4033fea1b86c812012eac21cf19" >
		<form  method="POST" id="ajax_form" action="<?php echo ConfigPainel('base_url'); ?>/wa/enquete/2nd_controller.php">
 			<div class="totalpoll-questions">
 				<input type="hidden" name="id" value="<?php echo $central['id']; ?>">
				<div class="totalpoll-question" totalpoll-min-selection="1" totalpoll-max-selection="1" totalpoll-valid-selection="false">
					<div class="totalpoll-question-container"><?php foreach ($itens as $i): ?><br>
						<?php $as = $i['id'];
						  $alternativas  = DBRead('alt_enquete','*',"WHERE id_pergunta = '{$as}'");?>						
						<h1 style="display: flex;flex-direction: row;flex-wrap: wrap;font-weight: bolder;color: <?php echo $central['cor_titulo'];?>;"><?php echo ($i['pergunta']); ?>  </h1><?php foreach($alternativas as $key => $s): ?>
							<?php $ass = $s['id']; ?>
						<div style="" class="totalpoll-question-choices">
							<label for="<?php echo $s['alternativa']; ?><?php echo $i['id'];?>" tabindex="0" class="totalpoll-question-choices-item totalpoll-question-choices-item-type-text">
								<div style="padding-top: 10px; padding-bottom: 10px;cursor: pointer;border-color: <?php echo $central['cor_da_borda']?>; background-color: <?php echo $central['cor_fundo'];?>;"   class="totalpoll-question-choices-item-control">
									<input required <?php if ($s['alternativa'] == 'Outros'){ echo "onclick='opentudo".$i['id']."()'";}else{echo "onclick='hidetudo".$i['id']."()'";}?> 
									style="margin-left: 10px;margin-right: 10px;cursor: pointer;" type="radio" id="<?php echo $s['alternativa']; ?><?php echo $i['id'];?>" name="<?php echo $i['id'];?>" value="<?php echo $ass;?>" class="<?php echo $s['alternativa']; ?><?php echo $i['id'];?>">
									<span style="color: <?php echo $central['cor_conteudo'];?>"><?php echo $s['alternativa']; ?>										
									</span>									
								</div>
							</label>
							<script>
								function opentudo<?php echo $i['id'];?>() {
								  var text = document.getElementById("prof_gf<?php echo $i['id'];?>");
								    text.style.display = "block";
								    document.getElementById("prof_gf<?php echo $i['id'];?>").innerHTML = "<input type='text' required class='form-control' name='outros[<?php echo $i['id'];?>]' >"};
								function hidetudo<?php echo $i['id'];?>() {
								  var text = document.getElementById("prof_gf<?php echo $i['id'];?>");
								    text.style.display = "none";
								    document.getElementById("prof_gf<?php echo $i['id'];?>").innerHTML = "";
								}

							</script>
						</div><?php endforeach;?>
						<div style="width: 100%;padding: calc(1em/2);display: none;" id="prof_gf<?php echo $i['id'];?>" >
							<span id="plead"></span>
						</div>
						<?php endforeach;?>
					</div>
				</div> 
			</div>
			<div class="totalpoll-buttons">
				<a onclick="crossfit()" style="  text-decoration: none; background-color: <?php echo $central['cor_fundo'];?>;color: <?php echo $central['cor_conteudo'];?>;border-color: <?php echo $central['cor_da_borda']; if ($central['resultado'] == '2') {echo ";display:none";}?>; " type="submit" class="totalpoll-button totalpoll-buttons-results">Resultado</a>
				<button style="background-color: <?php echo $central['cor_bg_bt'];?>; color: <?php echo $central['cor_txt_bt'];?>;border:none;" type="submit"  class="totalpoll-button totalpoll-button-primary totalpoll-buttons-vote" ><?php echo $central['txt_bt']	;?></button>
			</div>
		</form>

	<div class="totalpoll-form"  >   
		<div class="totalpoll-question">
	<span id="blablaaward" ></span>	

	<div class="totalpoll-buttons" style="display: none;" >
  
 </div>

 
    </div></center>

	<script type="text/javascript">
	
		
	function crossfit(){
	$("#blablaaward").load('<?php echo ConfigPainel('base_url'); ?>/wa/enquete/graf2.php?id=<?php echo $central['id'];?>');	
	document.getElementById("ajax_form").style.display = "none";
	document.getElementById("blablavoltar").style.display = "block";
	document.getElementById("recomp").style.display = "none";	
		
	
			
		
	}
	function blablavoltar(){
		document.getElementById("ajax_form").style.display = "block";
		document.getElementById("totalpoll-form").style.display = "none";
		document.getElementById("blablavoltar").style.display = "none";
	}

	  jQuery(document).ready(function(){
    	jQuery('#ajax_form').submit(function(){    
      		var dados = jQuery( this ).serialize();
		    jQuery.ajax({
		       type: "POST",
		       url: "<?php echo ConfigPainel('base_url'); ?>/wa/enquete/2nd_controller.php",
		       data: dados,
		       }); setTimeout(function(){$("#blablaaward").load('<?php echo ConfigPainel('base_url'); ?>/wa/enquete/graf.php?id=<?php echo $central['id'];?>');<?php if($central['recompensa'] == null){}
		       else{ echo "document.getElementById('recomp').style.display = 'block';";}?>;document.getElementById("recomp").style.display = "block";}, 1000); 
		    	
		         
      			return false;
			    });
			  });

</script>


