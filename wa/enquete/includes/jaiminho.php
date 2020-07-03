<?php header('Access-Control-Allow-Origin: *');?>




<center>
  <div style="width: 100%; " id="totalpoll" class="totalpoll-wrapper totalpoll-uid-6499a4033fea1b86c812012eac21cf19 is-ltr is-screen-vote"  totalpoll-uid="6499a4033fea1b86c812012eac21cf19" >
    <form  method="POST" id="ajax_form" action="<?php echo ConfigPainel('base_url'); ?>/wa/enquete/2nd_controller.php">
      <div class="totalpoll-questions">
        <input type="hidden" name="id" value="<?php echo $central['id']; ?>">
        <div class="totalpoll-question" totalpoll-min-selection="1" totalpoll-max-selection="1" totalpoll-valid-selection="false">
          <div class="totalpoll-question-container"><?php foreach ($itens as $i): ?><br>
            <?php $as = $i['id'];
              $alternativas  = DBRead('alt_enquete','*',"WHERE id_pergunta = '{$as}'");?>           
            <?php foreach($alternativas as $key => $s): ?>
              <?php $ass = $s['id']; ?>
            <div style="" class="totalpoll-question-choices">
              <label for="<?php echo $s['alternativa']; ?><?php echo $i['id'];?>" tabindex="0" class="totalpoll-question-choices-item totalpoll-question-choices-item-type-text">
                
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
      
    </form>

  <div class="totalpoll-form" id="totalpoll-form"  >   
    <div class="totalpoll-question">
    <div class="totalpoll-question-container">
        <div class="totalpoll-question-content">
      <?php foreach ($itens as $i): ?><br>
            <?php $as = $i['id'];
              $alternativas  = DBRead('alt_enquete','*',"WHERE id_pergunta = '{$as}'");?>           
            <h1 style="display: flex;flex-direction: row;flex-wrap: wrap;font-weight: bolder;color: <?php echo $central['cor_titulo'];?>; padding: calc(1em/2); "><?php echo ($i['pergunta']); ?>  </h1>
        </div>
<div class="totalpoll-question-choices-item totalpoll-question-choices-item-results totalpoll-question-choices-item-type-text" >


    <?php foreach($alternativas as $key => $s): ?>
              <?php $ass = $s['id']; ?>
    
            <div class="totalpoll-question-choices-item-label" style="border-color: <?php echo $central['cor_da_borda']?>; background: <?php echo $central['cor_fundo'];?>;">
            <span style="color: <?php echo $central['cor_conteudo'];?>"><?php echo $s['alternativa'] ?></span>                      
            <div class="totalpoll-question-choices-item-votes" >
              <?php  $agas  = DBRead('alt_enquete','sum(zero)',"WHERE id_pergunta = '{$as}'"); $total = implode($agas[0]);if($total < 1){$shw = "0%"; $parte = "0";}else{$parte = $s['zero']; $mi7 = $parte / $total; $porce = round($mi7*100); $shw = $porce."%";}?> 

                <div  class="totalpoll-question-choices-item-votes-bar" style="height:6px;width: <?php echo $shw ; ?>; background: <?php echo $central['cor_conteudo'];?>"></div>
                <div class="totalpoll-question-choices-item-votes-text "style="font-size: 12px;color: <?php echo $central['cor_conteudo'];?>"><?php echo $shw." (".$parte." votos)";?></div>  
            </div>
        </div><br><?php endforeach;?>

    </div><?php endforeach;?>

  </div></div>
  <div class="totalpoll-buttons" >
    <a id="recomp"  href="<?php echo $central['recompensa']; ?>" target="_blank" style=" text-decoration:none;background-color: <?php echo $central['cor_bg_bt'];?>; color: <?php echo $central['cor_txt_bt'];?>;border:none; <?php if ($central['recompensa'] == null) {echo "display: none";}?> "   class="totalpoll-button totalpoll-button-primary totalpoll-buttons-vote" >Baixar minha recompensa</a>
 </div>
</div>
 </div></div>
    </div></center>

  <script type="text/javascript">


  document.getElementById("ajax_form").style.display = "none";
  
         
</script>


