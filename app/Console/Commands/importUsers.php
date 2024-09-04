<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class importUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Путь к файлу по умолчанию
        $filePath = storage_path('app/users.csv');

        // Проверяем наличие файла
        if (!file_exists($filePath)) {
            $this->error("File not found: $filePath");
            return;
        }

        // Открываем файл и начинаем чтение
        if (($handle = fopen($filePath, 'r')) !== FALSE) {
            // Пропускаем заголовки (если они есть)
            $headers = fgetcsv($handle);

            while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                // Ожидаем, что файл содержит строки вида: name, email, password
                $name = $data[0];
                $email = $data[1];
                $password = $data[2];

                User::updateOrInsert(
                    ['email' => $email],
                    [
                        'name' => $name,
                        'password' => Hash::make($password),
                    ]);

                $this->info("Imported: $name ($email)");
            }

            fclose($handle);
        }

        $this->info('Import completed successfully.');
    }
}
