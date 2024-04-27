<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DeleteExpiredTokens extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tokens:delete-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes all expired tokens from the database.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        // Delete all expired tokens from the database
        try {
            DB::transaction(function () {
                $deleted = DB::table('tokens')
                    ->where('expires_at', '<', now())
                    ->delete();

                $this->info("Deleted {$deleted} expired tokens.");
            });
        } catch (\Throwable $t) {
            $this->error("Error deleting expired tokens: {$t->getMessage()}.");
        }
    }
}