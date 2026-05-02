<?php

namespace Database\Seeders;

use App\Services\MedicamentoImportService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class MedicamentoBaseSeeder extends Seeder
{
    public function __construct(
        protected MedicamentoImportService $importService
    ) {}

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $directory = database_path('seeders/data');
        
        // Procura por arquivos .xlsx ou .csv na pasta de dados
        $files = File::files($directory);
        
        $targetFile = null;
        foreach ($files as $file) {
            if (in_array($file->getExtension(), ['xlsx', 'xls', 'csv'])) {
                $targetFile = $file;
                break;
            }
        }

        if (!$targetFile) {
            $this->command->warn("Nenhum arquivo de base de dados encontrado em database/seeders/data/");
            $this->command->info("Por favor, coloque o arquivo 'medicamentos_base.xlsx' ou '.csv' nesta pasta.");
            return;
        }

        $this->command->info("Importando base de dados real do arquivo: " . $targetFile->getFilename());

        $result = $this->importService->import(
            $targetFile->getRealPath(), 
            $targetFile->getExtension()
        );

        $this->command->info("Sucesso! {$result['success']} medicamentos foram importados para a base principal.");
        
        if (count($result['errors']) > 0) {
            $this->command->error("Houve erros em algumas linhas:");
            foreach (array_slice($result['errors'], 0, 5) as $error) {
                $this->command->warn("- " . $error);
            }
        }
    }
}
