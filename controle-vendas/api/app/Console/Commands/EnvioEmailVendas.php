<?php

namespace App\Console\Commands;

use App\LogEnvioEmail;
use App\Mail\TemplateEmailGeral;
use App\Mail\TemplateEmailVendasDiarias;
use App\Venda;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class EnvioEmailVendas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'service:email_vendas {email?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Serviço responsável por enviar as vendas diárias';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $vendas_do_dia = Venda::vendas_do_dia();
        $email_para_enviar = $this->argument('email');
        $otal_vendas = count($vendas_do_dia);
        $data_atual = Carbon::now()->format('d/m/Y');

        if ($otal_vendas > 0 and isset($email_para_enviar) and !empty($email_para_enviar)) {
            $this->info("Gerando relatório das vendas de " . $data_atual);
            $this->verificarExistenciaDiretorio();
            $caminho_relatorio = $this->gerar_relatorio($vendas_do_dia);

            $mail = [];
            $mail['email'] = $email_para_enviar;
            $mail['assunto'] = "Gestão de Vendas | Relação diária ({$data_atual})";
            $mail['relatorio'] = $caminho_relatorio;
            Mail::to($mail['email'])->send(new TemplateEmailGeral($mail));

            $mensagem_log = "Relatório enviado para {$email_para_enviar} em " . $data_atual . " às " . Carbon::now()->format('H:i:s');
            LogEnvioEmail::create([
                "tipo" => 'RELATORIO_GERAL',
                "descricao" => $mensagem_log
            ]);
        } else {
            if ($otal_vendas == 0)
                $this->error("Sem vendas para enviar em " . $data_atual);
            else if (isset($email_para_enviar) or empty($email_para_enviar))
                $this->error("E-mail não informado");
        }
    }

    private function gerar_relatorio($vendas_do_dia)
    {
        $soma_vendas = $this->formatar_moeda(Venda::somar_vendas_do_dia());
        $soma_comissao_vendas = $this->formatar_moeda(Venda::somar_comissao_vendas_do_dia());

        $mpdf = new \Mpdf\Mpdf();
        $mpdf->AddPage('L');
        $mpdf->SetDisplayMode('fullpage');
        $titulo = "Relação diária de Vendas";
        $subtitulo = "Segue abaixo todas as suas vendas referentes ao dia " . Carbon::now()->format('d/m/Y') . ", ótimas vendas !";
        $caminho_logo = public_path("\\img\\tray_logo.jpg");

        $cabecalho = "<div class='form-group col-sm-12 cabecalho_relatorio_2'><span><img width='200' height='100' class='logo pull-left' src='{$caminho_logo}'></span><span class='titulo'>{$titulo}</span><br><span style='margin-top: 20px'>{$subtitulo}</span></div>";


        $tabela_clientes = "<table class='table' style='margin-top: 10px'>";
        $tabela_clientes .= "<thead style='background-color: #EFEFEF;padding: 10px' class='cabecalho_padrao_tabela'><tr>";
        $tabela_clientes .= "<th width='8%'>Hora</th>";
        $tabela_clientes .= "<th>Vendedor</th>";
        $tabela_clientes .= "<th class='text-left'>Comissão gerada para o vendedor</th>";
        $tabela_clientes .= "<th class='text-right'>Valor</th>";
        $tabela_clientes .= "</tr></thead>";
        $tabela_clientes .= "<tbody>";
        // Iterando
        foreach ($vendas_do_dia as $venda) {
            $vendedor = $venda->nome . " ({$venda->email})";
            $comissao_venda = $this->formatar_moeda($venda->comissao_venda);
            $valor = $this->formatar_moeda($venda->valor);
            $hora = date('H:i:s', strtotime($venda->data));

            $tabela_clientes .= "<tr>";
            $tabela_clientes .= "<td>{$hora}</td>";
            $tabela_clientes .= "<td>{$vendedor}</td>";
            $tabela_clientes .= "<td class='text-left'>{$comissao_venda}</td>";
            $tabela_clientes .= "<td class='text-right'>{$valor}</td>";

            $tabela_clientes .= "</tr>";
        }
        $tabela_clientes .= "</tbody>";
        $tabela_clientes .= "</table>";

        $footer_texto_info = " venda(s) encontradas(s) que totalizam <b style='font-weight: bold'>{$soma_vendas}</b> e <b style='font-weight: bold'>{$soma_comissao_vendas}</b> de comissão aos vendedores.";
        $footer_texto_quantidade = count($vendas_do_dia);
        $footer = "";
        $footer .= "<div class='footer_relatorio'>";
        $footer .= "<div><b style='font-weight: bold'>{$footer_texto_quantidade}</b><span>{$footer_texto_info}</span></div>";
        $footer .= "</div>";


        $mpdf->WriteHTML(file_get_contents(public_path("\\css\\bootstrap.min.css")), 1);
        $mpdf->WriteHTML(file_get_contents(public_path("\\css\\vendors.min.css")), 1);
        $mpdf->WriteHTML(file_get_contents(public_path("\\css\\custom.css")), 1);

        $mpdf->WriteHTML($cabecalho);
        $mpdf->WriteHTML($tabela_clientes);
        $mpdf->WriteHTML($footer);

        // Gravando relatorio
        $data_atual = Carbon::now()->format('Y_m_d');
        $nome_relatorio = "Vendas_Diarias_" . $data_atual . '.pdf';
        $caminho_output = public_path('\\reports\\') . $nome_relatorio;

        $mpdf->Output($caminho_output);

        return $caminho_output;
    }

    private function formatar_moeda($valor)
    {
        return "R$ " . number_format($valor, "2", ",", ".");
    }

    private function verificarExistenciaDiretorio()
    {
        $caminho_verificacao = public_path('\\reports');
        if (!(\File::isDirectory($caminho_verificacao)))
            mkdir($caminho_verificacao, 0777, true);
    }
}
