<?php
namespace Csgt\Login\Console;

use Illuminate\Console\Command;
use Illuminate\Console\DetectsApplicationNamespace;

class MakeAuthCommand extends Command
{
    use DetectsApplicationNamespace;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:csgtauth
                    {--views : Only scaffold the authentication views}
                    {--force : Overwrite existing views by default}';

    protected $views = [
        'auth/login.stub'            => 'auth/login.blade.php',
        'auth/register.stub'         => 'auth/register.blade.php',
        'auth/verify.stub'           => 'auth/verify.blade.php',
        'auth/profile.stub'          => 'auth/profile.blade.php',
        'auth/passwords/email.stub'  => 'auth/passwords/email.blade.php',
        'auth/passwords/reset.stub'  => 'auth/passwords/reset.blade.php',
        'auth/passwords/update.stub' => 'auth/passwords/update.blade.php',
        'layouts/login.stub'         => 'layouts/login.blade.php',
    ];

    protected $langs = [
        'es/auth.stub'       => 'es/auth.php',
        'es/pagination.stub' => 'es/pagination.php',
        'es/passwords.stub'  => 'es/passwords.php',
        'es/validation.stub' => 'es/validation.php',
        'es/login.stub'      => 'es/login.php',
        'en/login.stub'      => 'en/login.php',
    ];

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->createDirectories();

        $this->exportViews();
        $this->exportLangs();

        file_put_contents(
            base_path('routes/web.php'),
            file_get_contents(__DIR__ . '/stubs/make/routes.stub'),
            FILE_APPEND
        );

        if (file_exists(app_path('User.php'))) {
            unlink(app_path('User.php'));
        }

        $this->info('Authentication scaffolding generated successfully.');
    }

    /**
     * Create the directories for the files.
     *
     * @return void
     */
    protected function createDirectories()
    {
        if (!is_dir($directory = resource_path('lang/es'))) {
            mkdir($directory, 0755, true);
        }

        if (!is_dir($directory = resource_path('views/layouts'))) {
            mkdir($directory, 0755, true);
        }

        if (!is_dir($directory = resource_path('views/auth/passwords'))) {
            mkdir($directory, 0755, true);
        }
    }

    /**
     * Export the authentication views.
     *
     * @return void
     */
    protected function exportViews()
    {
        foreach ($this->views as $key => $value) {
            if (file_exists($view = resource_path('views/' . $value)) && !$this->option('force')) {
                if (!$this->confirm("The [{$value}] view already exists. Do you want to replace it?")) {
                    continue;
                }
            }

            copy(
                __DIR__ . '/stubs/make/views/' . $key,
                $view
            );
        }
    }

    /**
     * Export the authentication langs.
     *
     * @return void
     */
    protected function exportLangs()
    {
        foreach ($this->langs as $key => $value) {
            if (file_exists($view = resource_path('lang/' . $value)) && !$this->option('force')) {
                if (!$this->confirm("The [{$value}] lang already exists. Do you want to replace it?")) {
                    continue;
                }
            }

            copy(
                __DIR__ . '/stubs/make/lang/' . $key,
                $view
            );
        }
    }
}
