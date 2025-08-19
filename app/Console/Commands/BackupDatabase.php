<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class BackupDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'database:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup the database to a gzipped file';

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
     * @return int
     */
    public function handle()
    {
        $date = Carbon::now('Asia/Jakarta')->format('Y-m-d_H-i');
        $fileName = "db-backup-{$date}.sql.gz";
        
        $backupPath = '/home/smb-imx-ebill/backups/databases/db-backup/' . $date;

        if (!is_dir($backupPath)) {
            mkdir($backupPath, 0755, true);
        }

        $dbHost = env('DB_HOST');
        $dbName = env('DB_DATABASE');
        $dbUser = env('DB_USERNAME');
        $dbPass = env('DB_PASSWORD');

        // Command mysqldump dengan output gzip
        $command = "mysqldump -h $dbHost -u $dbUser -p$dbPass $dbName | gzip > $backupPath/$fileName";

        // Eksekusi command
        $result = null;
        system($command, $result);

        if ($result === 0) {
            $this->info('Backup berhasil disimpan di: ' . $backupPath . '/' . $fileName);
        } else {
            $this->error('Backup gagal.');
        }

        return 0;
    }
}
