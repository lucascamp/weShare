<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();

        /* Load :: Common */
        $this->load->helper('number');
        $this->load->model('admin/dashboard_model');
    }

	public function index()
	{
        if ( ! $this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin())
        {
            redirect('auth/login', 'refresh');
        }
        else
        {
            /* Title Page */
            $this->page_title->push(lang('menu_dashboard'));
            $this->data['pagetitle'] = $this->page_title->show();

            /* Breadcrumbs */
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            /* Data */
            $this->data['count_users']       = $this->dashboard_model->get_count_record('users');
            $this->data['count_groups']      = $this->dashboard_model->get_count_record('groups');
            $this->data['disk_totalspace']   = $this->dashboard_model->disk_totalspace(DIRECTORY_SEPARATOR);
            $this->data['disk_freespace']    = $this->dashboard_model->disk_freespace(DIRECTORY_SEPARATOR);
            $this->data['disk_usespace']     = $this->data['disk_totalspace'] - $this->data['disk_freespace'];
            $this->data['disk_usepercent']   = $this->dashboard_model->disk_usepercent(DIRECTORY_SEPARATOR, FALSE);
            $this->data['memory_usage']      = $this->dashboard_model->memory_usage();
            $this->data['memory_peak_usage'] = $this->dashboard_model->memory_peak_usage(TRUE);
            $this->data['memory_usepercent'] = $this->dashboard_model->memory_usepercent(TRUE, FALSE);


            /* TEST */
            $this->data['url_exist']    = is_url_exist('http://www.domprojects.com');


            /* Load Template */
            $this->template->admin_render('admin/dashboard/index', $this->data);
        }
	}

    public function table()
    {
        if ( ! $this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin())
        {
            redirect('auth/login', 'refresh');
        }
        else
        {
            /* Title Page */
            $this->page_title->push(lang('menu_dashboard'));
            $this->data['pagetitle'] = $this->page_title->show();

            /* Breadcrumbs */
            $this->data['breadcrumb'] = $this->breadcrumbs->show();

            /* Data */
            $this->data['count_users']       = $this->dashboard_model->get_count_record('users');
            $this->data['count_groups']      = $this->dashboard_model->get_count_record('groups');


            /* TEST */
            $this->data['url_exist']    = is_url_exist('http://www.domprojects.com');

            $array_diferimento = ['wl10'=>38.995, 'wl20'=>46.204, 'wl30'=>57.716];

            $capital = $this->input->post()['capital'];
            
            $this->data['diferimento'] = round(($array_diferimento[$this->input->post()['prazo']] / 100) * floatval($capital),2);

            $percents = $this->db->select('porcentagem')->get_where('tabela_wl', array('sexo' => $this->input->post()['sexo'], 'prazo' => $this->input->post()['prazo']))->result();

            $calcs = array();

            $idade = intval($this->input->post()['idade'])+1;

            foreach ($percents as $value) 
            {
                $calcs[$idade] = round((floatval($value->porcentagem) / 100) * $this->data['diferimento'], 2);
                $idade++;
            }

            $this->data['valor_seguro'] = $calcs[$idade-1];

            $uniquetb = $this->db->select('porcentagem')->get_where('tabela_unica', array('sexo' => $this->input->post()['sexo'], 'idade >' => $idade-1))->result();

            foreach ($uniquetb as $value) 
            {
                $calcs[$idade] = round(floatval($capital) * ((floatval($value->porcentagem) / 100)), 2);
                $idade++;
            }

            $this->data['valor_seguro'] = $this->db->select('valor')->get_where('valor_seguro', array('sexo' => $this->input->post()['sexo'], 'idade' => $this->input->post()['idade'],
                'prazo' => $this->input->post()['prazo']))->row();

            $this->data['calculos'] = $calcs;

            $this->data['inputs'] = $this->input->post();

            /* Load Template */
            $this->template->admin_render('admin/dashboard/table', $this->data);
        }
    }

    public function pdf()
    {
        $array_diferimento = ['wl10'=>36.157, 'wl20'=>46.204, 'wl30'=>57.716];

        $capital = $this->input->post()['capital'];

        $this->data['diferimento'] = round(($array_diferimento[$this->input->post()['prazo']] / 100) * floatval($capital),2);

        $percents = $this->db->select('porcentagem')->get_where('tabela_wl', array('sexo' => $this->input->post()['sexo'], 'prazo' => $this->input->post()['prazo']))->result();

        $calcs = array();

        $idade = $this->input->post()['idade']+1;

        foreach ($percents as $value) 
        {
            $calcs[$idade] = round((floatval($value->porcentagem) / 100) * $this->data['diferimento'], 2);
            $idade++;
        }

        $valor_seguro = $calcs[$idade-1];

        $uniquetb = $this->db->select('porcentagem')->get_where('tabela_unica', array('sexo' => $this->input->post()['sexo'], 'idade >' => $idade-1))->result();

        foreach ($uniquetb as $value) 
        {
            $calcs[$idade] = round(floatval($capital) * ((floatval($value->porcentagem) / 100)), 2);
            $idade++;
        }

        $valor_seguro = $this->db->select('valor')->get_where('valor_seguro', array('sexo' => $this->input->post()['sexo'], 'idade' => $this->input->post()['idade'],
            'prazo' => $this->input->post()['prazo']))->row();

        $html = '<html>
                <head>
                    
                    <style>
                        table.paleBlueRows {
                          font-family: Verdana, Geneva, sans-serif;
                          border: 0px solid #FFFFFF;
                          background-color: #EEEEEE;
                          width: 100%;
                          height: 100%;
                          text-align: center;
                      }
                      table.paleBlueRows td, table.paleBlueRows th {
                          border: 0px solid #FFFFFF;
                          padding: 3px 2px;
                      }
                      table.paleBlueRows tbody td {
                          font-size: 12px;
                      }
                      table.paleBlueRows tr:nth-child(even) {
                          background: #68ff81;
                      }
                      
                      .tablehead {
                          font-size: 20px;
                          font-weight: bold;
                          color: #FFFFFF;
                          text-align: center;
                          background: #3ed154;
                      }

                      table.dados {
                          font-family: Verdana, Geneva, sans-serif;
                          border-bottom: 1px solid #FFFFFF;
                          background-color: #3ed154;
                          width: 100%;
                          height: 100px;
                          text-align: center;
                          border-collapse: collapse;
                      }
                      table.dados td, table.dados th {
                          border: 1px solid #FFFFFF;
                      }
                      table.dados tbody td {
                          font-size: 13px;
                          color: #000000;
                      }
                      table.dados td:nth-child(even) {
                          background: #EEEEEE;
                      }
                      table.dados tfoot td {
                          font-size: 14px;
                      }
                      
                  </style>

                </head>
                <body>
                <table class="dados">
                    <tr>
                        <td style="width:25%">Nome</td>
                        <td style="width:25%">'.$this->input->post()['nome'].'</td>
                        <td style="width:25%">Plano</td>
                        <td style="width:25%">'.$this->input->post()['prazo'].'</td>
                    </tr>
                    <tr>
                        <td>Idade</td>
                        <td>'.$this->input->post()['idade'].'</td>
                        <td>Capital Segurado:</td>
                        <td>R$ '.$capital.'</td>
                    </tr>
                    <tr>
                        <td>Sexo:</td>
                        <td>'.$this->input->post()['sexo'].'</td>
                    </tr>
                </table><br>';

                $i = 1;
                $total_premio = [];
                $total_valor =[];
                $prazo = (int)substr($this->input->post()['prazo'],2,2);
                $prazo_total = (int)substr($this->input->post()['prazo'],2,2);

        $html .= '<table class="paleBlueRows">
                    <thead class="tablehead">
                            <tr>
                              <td>Prazo</td>
                              <td>Idade</td>
                              <td>Valor do Seguro</td>
                              <td>Valor Resgate</td>
                              <td>Diferença</td>
                            </tr>
                    </thead>
                    <tbody>';

                    
                    foreach ($calcs as $key => $value) 
                    {
                        $class = ($i % 2 == 0) ? 'red' : 'black';

                        $html .='
                            <tr>
                                <td style="width:20%">'.$i.' Anos</td>
                                <td style="width:20%">'.$key.' Anos</td>';

                            if($i <= $prazo_total) 
                              { 
                                $html .='<td style="width:20%">R$ '.number_format($valor_seguro->valor * $i,2,',','.').'</td>';
                              } else { 
                                $html .='<td style="width:20%">-</td>';
                              }     

                              $html .='<td style="width:20%">R$ '.number_format($value,2,',','.').'</td>';

                              if($i > $prazo_total) {
                                  $total = $value - ($valor_seguro->valor * $prazo_total);

                                } else {  
                                  $total = $value - floatval($valor_seguro->valor * $i);
                                }
                                $class = $total < 0 ? 'red' : 'black';

                              $html .='<td style="width:20%; color:'.$class.'">R$'. number_format($total,2,',','.').'</td>';
                                
                              $html .='</tr>';

                        $i++;
                        $prazo--;
                    }

            $html .='</tbody>
                     </table>';
                          
        $html .= '</body></html>';  

        // $this->template->admin_render('admin/dashboard/table', $this->data);
        $this->load->library('m_pdf');
        $this->m_pdf->pdf->WriteHTML($html);
        $this->m_pdf->pdf->Output(time()."_seguro.pdf", 'D');
    }
}
