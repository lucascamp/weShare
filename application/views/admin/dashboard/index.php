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
                        <form name ="userinput" action="table" method="post">
                            <div class="col-md-3">
                              <label>Nome</label>
                              <input type="text" name='nome' id='nome' class="form-control" >
                          </div>
                          <div class="col-md-1">
                              <label>Idade</label>
                              <input type="text" name='idade' id='idade' class="form-control" >
                          </div>
                          <div class="col-md-2">
                              <label>Sexo</label>
                              <select class="form-control" name='sexo' id='sexo'>
                                <option value='m'>Masculino</option>
                                <option value='f'>Feminino</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                          <label>Prazo</label>
                          <select class="form-control" name='prazo' id='prazo'>
                            <option value='wl10'>WL 10 Anos</option>
                            <option value='wl20'>WL 20 Anos</option>
                            <option value='wl30'>WL 30 Anos</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                      <label>Capital Segurado</label>
                      <input type="text" class="form-control" name='capital' id='capital' >
                    </div>
                    <div class="col-md-2">
                      <br>
                      <input type="submit" class="btn btn-primary" value="Calcular">
                    </div>
                    </form>
                    </div>
            </div>
        </div>
    </div>
</div>
</div>
</section>

</div>
