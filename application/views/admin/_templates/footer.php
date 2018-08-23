<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>

            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    <b><?php echo lang('footer_version'); ?></b> 1.3.0
                </div>
                <strong><?php echo lang('footer_copyright'); ?> &copy; 2014-<?php echo date('Y'); ?> <a href="http://almsaeedstudio.com" target="_blank">Almsaeed Studio</a> &amp; <a href="http://domprojects.com" target="_blank">domProjects</a>.</strong> <?php echo lang('footer_all_rights_reserved'); ?>.
            </footer>
        </div>

        <script src="<?php echo base_url($frameworks_dir . '/jquery/jquery.min.js'); ?>"></script>
        <script src="<?php echo base_url($frameworks_dir . '/bootstrap/js/bootstrap.min.js'); ?>"></script>
        <script src="<?php echo base_url($plugins_dir . '/slimscroll/slimscroll.min.js'); ?>"></script>
<?php if ($mobile == TRUE): ?>
        <script src="<?php echo base_url($plugins_dir . '/fastclick/fastclick.min.js'); ?>"></script>
<?php endif; ?>
<?php if ($admin_prefs['transition_page'] == TRUE): ?>
        <script src="<?php echo base_url($plugins_dir . '/animsition/animsition.min.js'); ?>"></script>
<?php endif; ?>
<?php if ($this->router->fetch_class() == 'users' && ($this->router->fetch_method() == 'create' OR $this->router->fetch_method() == 'edit')): ?>
        <script src="<?php echo base_url($plugins_dir . '/pwstrength/pwstrength.min.js'); ?>"></script>
<?php endif; ?>
<?php if ($this->router->fetch_class() == 'groups' && ($this->router->fetch_method() == 'create' OR $this->router->fetch_method() == 'edit')): ?>
        <script src="<?php echo base_url($plugins_dir . '/tinycolor/tinycolor.min.js'); ?>"></script>
        <script src="<?php echo base_url($plugins_dir . '/colorpickersliders/colorpickersliders.min.js'); ?>"></script>
<?php endif; ?>
        <script src="<?php echo base_url($frameworks_dir . '/adminlte/js/adminlte.min.js'); ?>"></script>
        <script src="<?php echo base_url($frameworks_dir . '/domprojects/js/dp.min.js'); ?>"></script>

        <script src="<?php echo base_url($frameworks_dir . '/jquery/dashboard.js'); ?>"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.bundle.js"></script>
        <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var prazo = $('#prz').val();
        var list = [];

        for (var i = 1; i <= prazo; i++) {
            list.push(i);
        }
        
        var premio = $('#premio').val();
        var premio_parts = premio.split(";");
        var result_premio = premio_parts.map(function (x) { 
            return parseFloat(x, 10); 
        });

        var valor_calc = $('#valor_calc').val();
        var valor_parts = valor_calc.split(";");
        var result_valor = valor_parts.map(function (x) { 
            return parseFloat(x, 10); 
        });

        var myChart = new Chart(ctx, {
          type: 'line',
          data: {
            labels: list,
            datasets: [
                {
                  label: 'Valor de Resgate',
                  data: result_valor,
                  backgroundColor: "rgba(16, 0, 255,0.4)"
                },
                {
                  label: 'Premio Pago',
                  data: result_premio,
                  backgroundColor: "rgba(249, 47, 47,0.4)"
                }
            ]
          }
        });
        </script>
    </body>
</html>