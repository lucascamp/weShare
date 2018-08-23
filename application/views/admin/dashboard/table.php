<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
<div class="content-wrapper">
    <section class="content-header">
        <?php echo $pagetitle; ?>
        <?php echo $breadcrumb; ?>
    </section>

    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Tabela</h3>
                    </div>
                    <div class="box-body">
                    <div class="row">
                            <div class="col-md-2">
                              <label>Nome</label>
                              <input type="text" class="form-control" disabled value="<?= $inputs['nome'];?>" >
                          </div>
                          <div class="col-md-1">
                              <label>Idade</label>
                              <input type="text" class="form-control" disabled value="<?= $inputs['idade'];?>">
                          </div>
                          <div class="col-md-2">
                              <label>Sexo</label>
                              <select class="form-control" disabled>
                                <option <?php if($inputs['sexo'] == 'm') echo 'selected' ?> >Masculino</option>
                                <option <?php if($inputs['sexo'] == 'f') echo 'selected' ?> >Feminino</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                          <label>Prazo</label>
                          <select class="form-control" disabled>
                            <option <?php if($inputs['prazo'] == 'wl10') echo 'selected' ?> >WL 10 Anos</option>
                            <option <?php if($inputs['prazo'] == 'wl20') echo 'selected' ?> >WL 20 Anos</option>
                            <option <?php if($inputs['prazo'] == 'wl30') echo 'selected' ?> >WL 30 Anos</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                      <label>Capital Segurado</label>
                      <input type="text" class="form-control" disabled value="<?= $inputs['capital'];?>">
                    </div>
                      <div class="col-md-3">
                        <form name ="form" action="pdf" method="post">
                          <input type="hidden" name="nome" value="<?= $inputs['nome'];  ?>" >
                          <input type="hidden" name="idade" value="<?= $inputs['idade']; ?>">
                          <input type="hidden" name="sexo" value="<?= $inputs['sexo'];  ?>">
                          <input type="hidden" name="prazo" value="<?= $inputs['prazo']; ?>">
                          <input type="hidden" name="capital" value="<?= $inputs['capital'];?>">
                          <br>
                          <input type="submit" class="btn btn-primary" value="PDF">&nbsp;
                          <button type="button" class="btn btn-primary btn" data-toggle="modal" data-target="#myModal">
  Nova  Simulação
</button>
                        </form>
                      </div>
                    </div>

                    <br><br>

                    <div class="row">
                        <div class="col-md-12 text-center">
                        <table class="table table-bordered table-hover">
                          <thead>
                            <tr>
                              <td>Prazo</td>
                              <td>Idade</td>
                              <td>Valor Seguro</td>
                              <td>Valor Resgate</td>
                              <td>Diferença</td>
                            </tr>
                          </thead>
                          <tbody>
                          <?php 
                          $i = 1;
                          $total_premio = [];
                          $total_valor =[];
                          $prazo = (int)substr($inputs['prazo'],2,2);
                          $prazo_total = (int)substr($inputs['prazo'],2,2);
                          foreach ($calculos as $key => $value) 
                          {
                            // echo "<pre>"; var_dump($calculos); die();
                          ?>
                            <tr>
                              <td><?= ($i == 1) ? $i.' Ano' : $i.' Anos'?></td>
                              <td><?= $key ?> Anos</td>
                              
                              <?php 
                              if($i <= $prazo_total) { 
                                array_push($total_premio, $valor_seguro->valor * $i);
                                ?>
                                <td>R$ <?= number_format($valor_seguro->valor * $i,2,',','.') ?></td>
                                
                              <?php } else { 
                                array_push($total_premio, $valor_seguro->valor * $prazo_total);
                                ?>
                                <td>-</td>
                              <?php } ?>

                              <td>R$ <?= number_format($value,2,',','.'); ?></td>
                              <?php array_push($total_valor, $value); ?>

                              <?php if($i > $prazo_total) {
                                  $total = $value - ($valor_seguro->valor * $prazo_total);

                                } else {  
                                  $total = $value - floatval($valor_seguro->valor * $i);
                                }
                                $class = $total < 0 ? 'red' : 'black';
                                ?>
                              <td style="color:<?= $class ?>">R$ <?= number_format($total,2,',','.');  ?></td>

                            </tr>
                         <?php 
                         $i++;
                         $prazo--;
                         }  ?>
                          </tbody>
                        </table>
                        </div>
                    </div>

                    <input type="hidden" name="prz" id="prz" value="<?= $i ?>">
                    <input type="hidden" name="premio" id="premio" value="<?= implode(';', $total_premio) ?>">
                    <input type="hidden" name="valor_calc" id="valor_calc" value="<?= implode(';', $total_valor) ?>">

                    <div class="row">
                      <div style="width:100%; height:400px;">
                          <canvas id="myChart" width="1000" height="400"></canvas>
                      </div>
                    </div>
            </div>
        </div>
    </div>
</div>
</div>

</section>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Nova simulação</h4>
      </div>
      <div class="modal-body">
      <form name ="userinput" action="table" method="post">
                            <div class="col-md-6">
                              <label>Nome</label>
                              <input type="text" name='nome' id='nome' class="form-control" >
                          </div>
                          <div class="col-md-6">
                              <label>Idade</label>
                              <input type="text" name='idade' id='idade' class="form-control" >
                          </div>
                          <div class="col-md-6">
                              <label>Sexo</label>
                              <select class="form-control" name='sexo' id='sexo'>
                                <option value='m'>Masculino</option>
                                <option value='f'>Feminino</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                          <label>Prazo</label>
                          <select class="form-control" name='prazo' id='prazo'>
                            <option value='wl10'>WL 10 Anos</option>
                            <option value='wl20'>WL 20 Anos</option>
                            <option value='wl30'>WL 30 Anos</option>
                        </select>
                    </div>
                    <div class="col-md-12">
                      <label>Capital Segurado</label>
                      <input type="text" class="form-control" name='capital' id='capital' >
                    </div>
                    <div class="col-md-12">
                      <br><br>
                    <input type="submit" class="btn btn-primary" value="Calcular">
                    </form>
                     </div>
                    
      </div>
      <div class="modal-footer" style='padding-top:20px'>
      
      </div>
    </div>
  </div>
</div>