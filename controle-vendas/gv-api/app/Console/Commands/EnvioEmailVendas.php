<?php

namespace App\Console\Commands;

use App\Mail\TemplateEmail;
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
    protected $signature = 'servico:email_vendas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        if (count($vendas_do_dia) > 0) {
            $this->info("Gerando relatório das vendas de " . Carbon::now()->format('d/m/Y'));
            $this->gerar_relatorio($vendas_do_dia);
//        $mail = ['email' => "roger.nizoli@gmail.com"];
//        Mail::to($mail['email'])->send(new TemplateEmail($mail));
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

        $mpdf->Output(public_path() . '\\teste.pdf', 'F');
    }

    private function formatar_moeda($valor)
    {
        return "R$ " . number_format($valor, "2", ",", ".");
    }
}
