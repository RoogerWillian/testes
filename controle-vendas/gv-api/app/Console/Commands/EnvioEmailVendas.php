<?php

namespace App\Console\Commands;

use App\Mail\TemplateEmail;
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
        $this->info("Gerando relatório das vendas de " . Carbon::now()->format('d/m/Y'));
        $this->gerar_relatorio();
//        $mail = ['email' => "roger.nizoli@gmail.com"];
//        Mail::to($mail['email'])->send(new TemplateEmail($mail));
    }

    private function gerar_relatorio()
    {
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->AddPage('L');
        $mpdf->SetDisplayMode('fullpage');
        $titulo = "Relação diária de Vendas";
        $subtitulo = "Segue abaixo todas as suas vendas referentes ao dia " . Carbon::now()->format('d/m/Y') . ", ótimas vendas !";
        $caminho_logo = public_path("\\img\\tray_logo.jpg");

        $cabecalho = "<div class='form-group col-sm-12 cabecalho_relatorio_2'><span><img width='200' height='100' class='logo pull-left' src='{$caminho_logo}'></span><span class='titulo'>{$titulo}</span><br><span style='margin-top: 20px'>{$subtitulo}</span></div>";


        $tabela_clientes = "<table class='table' style='margin-top: 10px'>";
        $tabela_clientes .= "<thead style='background-color: #EFEFEF;padding: 10px' class='cabecalho_padrao_tabela'><tr>";
        $tabela_clientes .= "<th>Cliente</th>";
        $tabela_clientes .= "<th>Regime</th>";
        $tabela_clientes .= "<th>Folha</th>";
        $tabela_clientes .= "</tr></thead>";
        $tabela_clientes .= "<tbody>";
        $tabela_clientes .= "</tbody>";
        $tabela_clientes .= "</table>";

        $mpdf->WriteHTML(file_get_contents(public_path("\\css\\bootstrap.min.css")), 1);
        $mpdf->WriteHTML(file_get_contents(public_path("\\css\\vendors.min.css")), 1);
        $mpdf->WriteHTML(file_get_contents(public_path("\\css\\custom.css")), 1);

        $mpdf->WriteHTML($cabecalho);
        $mpdf->WriteHTML($tabela_clientes);

        $mpdf->Output(public_path() . '\\teste.pdf', 'F');

    }
}
