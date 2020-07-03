<style type="text/css">
.totalpoll-buttons-vote:hover{ background-color: <?php echo $central['cor_hover_bg_bt'];?> !important; color: <?php echo $central['cor_hover_txt_bt'];?> !important }	
</style>


<center>
	<div class="totalpoll-buttons" id="recomp" style="display: none;">
<h1 style="font-weight: bolder;font-size: 25px;color: <?php echo $central['cor_titulo'];?>;">Obrigado por participar!!!</h1> <br><br>
<a href="<?php echo $central['recompensa']; ?>" target="_blank" style="text-decoration:none;background-color: <?php echo $central['cor_bg_bt'];?>; padding-top: 1em;  padding-right: 1em; padding-bottom: 1em; padding-left: 1em;; color: <?php echo $central['cor_txt_bt'];?>;border:none;<?php if ($central['recompensa'] == null) {echo "display: none";}?> "   class="totalpoll-button totalpoll-button-primary totalpoll-buttons-vote" >Baixar minha recompensa</a>
</div>
		
	<div style="width: 50%; " id="totalpoll" class="totalpoll-wrapper totalpoll-uid-6499a4033fea1b86c812012eac21cf19 is-ltr is-screen-vote"  totalpoll-uid="6499a4033fea1b86c812012eac21cf19" >
		<form  method="POST" id="ajax_form" >
 			<div class="totalpoll-questions">
 				<input type="hidden" name="id" value="<?php echo $central['id']; ?>">
				<div class="totalpoll-question" totalpoll-min-selection="1" totalpoll-max-selection="1" totalpoll-valid-selection="false">
					<div class="totalpoll-question-container"><?php foreach ($itens as $i): ?><br>
						<?php $as = $i['id'];
						  $alternativas  = DBRead('alt_enquete','*',"WHERE id_pergunta = '{$as}'");?>						
						<h1 style="display: flex;flex-direction: row;flex-wrap: wrap;font-weight: bolder;color: <?php echo $central['cor_titulo'];?>;"><?php echo ($i['pergunta']); ?>  </h1>

						<div style="" class="totalpoll-question-choices">
							<input placeholder="Escreva aqui sua resposta" required style="width: 100%;" type="text" name="respos[<?php echo $as;?>]">
							
						</div>
						<div style="width: 100%;padding: calc(1em/2);display: none;" id="prof_gf<?php echo $i['id'];?>" >
							<span id="plead"></span>
						</div>
						<?php endforeach;?>
					</div>
				</div> 
			</div>
			<div class="totalpoll-buttons">			
				<button style="background-color: <?php echo $central['cor_bg_bt'];?>; color: <?php echo $central['cor_txt_bt'];?>;border:none;" type="submit"  class="totalpoll-button totalpoll-button-primary totalpoll-buttons-vote" ><?php echo $central['txt_bt']	;?></button>
				
			</div>
			
		</form>

		
	
    </div></center>

<script type="text/javascript">
    jQuery(document).ready(function(){
    jQuery('#ajax_form').submit(function(){
        document.getElementById("ajax_form").style.visibility = "hidden";
      var dados = jQuery( this ).serialize();

      jQuery.ajax({
        type: "POST",
        url: "<?php echo ConfigPainel('base_url'); ?>/wa/enquete/3rd_controller.php",
        data: dados,
        });
		document.getElementById('recomp').style.display = 'block';    
      return false;
    });
  });
  </script>

