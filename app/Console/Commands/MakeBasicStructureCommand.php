<?php

namespace App\Console\Commands;

use DB;
use Illuminate\Console\Command;
use Illuminate\Support\Pluralizer;
use Illuminate\Filesystem\Filesystem;

class MakeBasicStructureCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:basic-structure {model} {module} {--parent_module=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command create basic solid API & service structure';

    /**
     * Filesystem instance
     * @var Filesystem
     */
    protected $files;

    /**
     * Create a new command instance.
     * @param Filesystem $files
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $actionArray = [
            'Create',
            'Update',
            'Show',
            'List',
            'Delete'
        ];

        // Create Controller File
        foreach ($actionArray as $action_name) {
            $path = $this->getSourceControllerFilePath($action_name);

            $this->makeDirectory(dirname($path));

            $contents = $this->getSourceFile($this->getControllerStubPath($action_name));

            if (!$this->files->exists($path)) {
                $this->files->put($path, $contents);
                $this->info("File : {$path} created");
            } else {
                $this->info("File : {$path} already exits");
            }
        }

        // Create Data Transfer Object File
        $path = $this->getSourceDataTransferObjectFilePath();

        $this->makeDirectory(dirname($path));

        $contents = $this->getSourceFile($this->getDataTransferObjectStubPath());

        $contents = $this->getStubContentTableColumns($this->getSourceModelFilePath(), $contents);

        if (!$this->files->exists($path)) {
            $this->files->put($path, $contents);
            $this->info("File : {$path} created");
        } else {
            $this->info("File : {$path} already exits");
        }

        // Create Logic File
        foreach ($actionArray as $action_name) {
            $path = $this->getSourceLogicFilePath($action_name);

            $this->makeDirectory(dirname($path));

            $contents = $this->getSourceFile($this->getLogicStubPath($action_name));

            if (!$this->files->exists($path)) {
                $this->files->put($path, $contents);
                $this->info("File : {$path} created");
            } else {
                $this->info("File : {$path} already exits");
            }
        }

        // Create Processor File
        $actionArray = [
            'Store',
            'Show',
            'Delete',
            'Search',
        ];

        foreach ($actionArray as $action_name) {
            $path = $this->getSourceProcessorFilePath($action_name);

            $this->makeDirectory(dirname($path));

            $contents = $this->getSourceFile($this->getProcessorStubPath($action_name));

            if (!$this->files->exists($path)) {
                $this->files->put($path, $contents);
                $this->info("File : {$path} created");
            } else {
                $this->info("File : {$path} already exits");
            }
        }

        // Create Request File
        $path = $this->getSourceRequestFilePath();

        $this->makeDirectory(dirname($path));

        $contents = $this->getSourceFile($this->getRequestStubPath());

        if (!$this->files->exists($path)) {
            $this->files->put($path, $contents);
            $this->info("File : {$path} created");
        } else {
            $this->info("File : {$path} already exits");
        }
    }

    /**
     * Build the directory for the class if necessary.
     *
     * @param  string  $path
     * @return string
     */
    protected function makeDirectory($path)
    {
        if (!$this->files->isDirectory($path)) {
            $this->files->makeDirectory($path, 0777, true, true);
        }

        return $path;
    }

    /**
     * Get the full path of generate controller class
     *
     * @return string
     */
    public function getSourceControllerFilePath($action_name)
    {
        return base_path('App/Http/Controllers/Api') . '/' . strtoupper($this->argument('module')) . '/' . $this->getControllerPath($this->argument('model'), $this->option('parent_module')) . '/' . $this->argument('model') . $action_name . 'Controller.php';
    }

    /**
     * Get the full path of generate data transfer object class
     *
     * @return string
     */
    public function getSourceDataTransferObjectFilePath()
    {
        return base_path('App/Services/Modules') . '/' . strtoupper($this->argument('module')) . '/' . $this->getServiceModulePath($this->argument('model'), $this->option('parent_module')) . '/' . 'DataTransferObjects' . '/' . $this->argument('model') . 'RequestObject.php';
    }

    /**
     * Get the full path of model class
     *
     * @return string
     */
    public function getSourceModelFilePath()
    {
        return base_path('App/Models') . '/' . $this->argument('module') . '/' . $this->argument('model') . '.php';
    }

    /**
     * Get the full path of generate logic class
     *
     * @return string
     */
    public function getSourceLogicFilePath($action_name)
    {
        return base_path('App/Services/Modules') . '/' . strtoupper($this->argument('module')) . '/' . $this->getServiceModulePath($this->argument('model'), $this->option('parent_module')) . '/' . 'Logics' . '/' . $this->argument('model') . $action_name . 'Logic.php';
    }

    /**
     * Get the full path of generate processor class
     *
     * @return string
     */
    public function getSourceProcessorFilePath($action_name)
    {
        return base_path('App/Services/Modules') . '/' . strtoupper($this->argument('module')) . '/' . $this->getServiceModulePath($this->argument('model'), $this->option('parent_module')) . '/' . 'Processors' . '/' . $this->argument('model') . $action_name . 'Processor.php';
    }

    /**
     * Get the full path of generate request class
     *
     * @return string
     */
    public function getSourceRequestFilePath()
    {
        return base_path('App/Services/Modules') . '/' . strtoupper($this->argument('module')) . '/' . $this->getServiceModulePath($this->argument('model'), $this->option('parent_module')) . '/' . 'Requests' . '/' . $this->argument('model') . 'StoreRequest.php';
    }

    /**
     * Get the stub path and the stub variables
     *
     * @return bool|mixed|string
     *
     */
    public function getSourceFile($stub)
    {
        return $this->getStubContents($stub, $this->getStubVariables());
    }

    /**
     * Replace the stub variables(key) with the desire value
     *
     * @param $stub
     * @param array $stubVariables
     * @return bool|mixed|string
     */
    public function getStubContents($stub, $stubVariables = [])
    {
        $contents = file_get_contents($stub);

        foreach ($stubVariables as $search => $replace) {
            $contents = str_replace('$' . $search . '$', $replace, $contents);
        }

        return $contents;
    }

    /**
     * Replace the stub $COLUMN_NAMES$ with table's column name
     *
     * @param $modelPath
     * @param $stubContents
     * @return bool|mixed|string
     */
    public function getStubContentTableColumns($modelPath, $stubContents)
    {
        if ($this->files->exists($modelPath)) {
            $this->info("File : {$modelPath} exits");
            $modelFile = "App\\Models\\" . $this->argument('module') . "\\" . $this->argument('model');

            $model = new $modelFile;

            $table = $model->getTable();

            $columns = DB::getSchemaBuilder()->getColumnListing($table);

            foreach ($columns as $replace) {
                if (!in_array($replace, ['created_at', 'updated_at', 'deleted_at'])) {
                    $stubContents = str_replace('$COLUMN_NAMES$', 'public $' . $replace . ';
    $COLUMN_NAMES$', $stubContents);
                }
            }
        }
        $stubContents = str_replace('$COLUMN_NAMES$', '', $stubContents);

        return $stubContents;
    }

    /**
     * Return the controller stub file path
     * @return string
     *
     */
    public function getControllerStubPath($action_name)
    {
        return __DIR__ . '/../../Services/Stubs/Controllers/' . $action_name . 'Controller.stub';
    }

    /**
     * Return the data transfer object stub file path
     * @return string
     *
     */
    public function getDataTransferObjectStubPath()
    {
        return __DIR__ . '/../../Services/Stubs/Services/DataTransferObjects/RequestObject.stub';
    }

    /**
     * Return the logic stub file path
     * @return string
     *
     */
    public function getLogicStubPath($action_name)
    {
        return __DIR__ . '/../../Services/Stubs/Services/Logics/' . $action_name . 'Logic.stub';
    }

    /**
     * Return the logic stub file path
     * @return string
     *
     */
    public function getProcessorStubPath($action_name)
    {
        return __DIR__ . '/../../Services/Stubs/Services/Processors/' . $action_name . 'Processor.stub';
    }

    /**
     * Return the data transfer object stub file path
     * @return string
     *
     */
    public function getRequestStubPath()
    {
        return __DIR__ . '/../../Services/Stubs/Services/Requests/StoreRequest.stub';
    }

    /**
     **
     * Map the stub variables present in stub to its value
     *
     * @return array
     *
     */
    public function getStubVariables()
    {
        return [
            'MODEL' => $this->argument('model'),
            'MODEL_SERVICE_CLASS' => $this->getModelServiceClassName($this->argument('model'), $this->option('parent_module')),
            'MODULE' => $this->argument('module'),
            'CONTROLLER_NAMESPACE' => $this->getControllerNamespace($this->argument('model'), $this->option('parent_module')),
            'SERVICE_MODULE_NAMESPACE' => $this->getServiceModuleNamespace($this->argument('model'), $this->option('parent_module')),
            'MODEL_LOWERCASE' => lcfirst($this->argument('model')),
        ];
    }

    /**
     * Return the Controller Path
     * @param $name
     * @return string
     */
    public function getControllerPath($model, $parent_module = '')
    {
        if ($parent_module) {
            return $parent_module . "/" . ucwords(Pluralizer::plural($model));
        }
        return ucwords(Pluralizer::plural($model));
    }

    /**
     * Return the Controller Namespace
     * @param $name
     * @return string
     */
    public function getControllerNamespace($model, $parent_module = '')
    {
        if ($parent_module) {
            return $parent_module . "\\" . ucwords(Pluralizer::plural($model));
        }
        return ucwords(Pluralizer::plural($model));
    }

    /**
     * Return the Service Module Path
     * @param $name
     * @return string
     */
    public function getServiceModulePath($model, $parent_module = '')
    {
        if ($parent_module) {
            return $parent_module . "/" . "SubModules" . "/" . ucwords(Pluralizer::plural($model));
        }
        return ucwords(Pluralizer::plural($model));
    }

    /**
     * Return the Service Module Namespace
     * @param $name
     * @return string
     */
    public function getServiceModuleNamespace($model, $parent_module = '')
    {
        if ($parent_module) {
            return $parent_module . "\\SubModules\\" . ucwords(Pluralizer::plural($model));
        }
        return ucwords(Pluralizer::plural($model));
    }

    /**
     * Return the Model Service Class Name
     * @param $name
     * @return string
     */
    public function getModelServiceClassName($model, $parent_module = '')
    {
        if ($parent_module) {
            return ucwords(Pluralizer::singular($parent_module)) . ucwords(Pluralizer::singular($model));
        }
        return ucwords(Pluralizer::singular($model));
    }
}
