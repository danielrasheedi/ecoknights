<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;


class GenerateDocumentation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'doc:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generated documentation for EcoKnights website';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Generating laravel project documentation..');
        $this->generateRoutes();
        $this->generateControllers();
        $this->generateModels();
        $this->combineDocs();

        $this->info('Documentation generated successfully');
        //
    }

    protected function generateRoutes()
    {
    $routes = Route::getRoutes();
    $doc = "# API Routes\n\n";

    foreach ($routes as $route) {
        $doc .= "### " . $route->uri() . "\n";
        $doc .= "- Method: " . implode('|', $route->methods()) . "\n";
        $doc .= "- Action: " . $route->getActionName() . "\n";

        // Add parameters if they exist
        $parameters = $route->parameterNames();
        if (count($parameters) > 0) {
            $doc .= "- Parameters: " . implode(', ', $parameters) . "\n";
        }

        $doc .= "\n";
    }

    file_put_contents(base_path('docs/routes.md'), $doc);
    }


    protected function generateControllers()
    {
    $controllerPath = app_path('Http/Controllers');
    $doc = "# Controllers\n\n";

    $rii = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($controllerPath));
    foreach ($rii as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            $contents = file_get_contents($file->getPathname());

            // Very basic class and method detection
            preg_match('/class\s+(\w+)/', $contents, $classMatch);
            if ($classMatch) {
                $className = $classMatch[1];
                $doc .= "## $className\n";

                preg_match_all('/public function (\w+)\(/', $contents, $methodMatches);
                foreach ($methodMatches[1] as $method) {
                    $doc .= "- $method()\n";
                }

                $doc .= "\n";
            }
        }
    }

    file_put_contents(base_path('docs/controllers.md'), $doc);
    }

    protected function generateModels()
    {
    $modelPath = app_path('Models');
    $doc = "# Models\n\n";

    if (!is_dir($modelPath)) return;

    $rii = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($modelPath));
    foreach ($rii as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            $contents = file_get_contents($file->getPathname());

            preg_match('/class\s+(\w+)/', $contents, $classMatch);
            if ($classMatch) {
                $className = $classMatch[1];
                $doc .= "## $className\n";

                // Optional: parse fillable or guarded
                preg_match('/\$fillable\s+=\s+\[(.*?)\];/s', $contents, $fillableMatch);
                if (!empty($fillableMatch[1])) {
                    $fillable = array_map('trim', explode(',', strip_tags($fillableMatch[1])));
                    $doc .= "- Fillable: " . implode(', ', $fillable) . "\n";
                }

                $doc .= "\n";
            }
        }
    }

    file_put_contents(base_path('docs/models.md'), $doc);
    }

    protected function combineDocs()
    {
    $output = "# Project Documentation\n\n";

    $parts = ['routes.md', 'controllers.md', 'models.md'];

    foreach ($parts as $file) {
        $path = base_path("docs/{$file}");
        if (file_exists($path)) {
            $output .= file_get_contents($path) . "\n\n";
        }
    }

    file_put_contents(base_path('docs/README.md'), $output);
    }

}
