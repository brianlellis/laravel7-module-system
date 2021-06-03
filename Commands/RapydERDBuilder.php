<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Rapyd\Erd\DocumentorGraph;

use Rapyd\ERD\Model as GraphModel;
use Rapyd\ERD\ModelFinder;
use Rapyd\ERD\RelationFinder;
use Rapyd\ERD\GraphBuilder;
use phpDocumentor\GraphViz\Node;

use ReflectionClass;

// Requirements
// This package requires the graphviz tool.

// You can install Graphviz on MacOS via homebrew:

// brew install graphviz
// Or, if you are using Homestead:

// sudo apt-get install graphviz

class RapydERDBuilder extends Command
{
    const FORMAT_TEXT = 'text';

    const DEFAULT_FILENAME = 'graph';

    /**
     * The console command name.
     *
     * @var string
     */
    // --scope = policies | 
    protected $signature = 'rapyd:erd {--format=png} {--type=full} {--scope=false} {--engine=dot} {--legend=false} {filename?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate ER diagram.';

    /** @var ModelFinder */
    protected $modelFinder;

    /** @var RelationFinder */
    protected $relationFinder;

    /** @var Graph */
    protected $graph;

    /** @var GraphBuilder */
    protected $graphBuilder;

    public function __construct(ModelFinder $modelFinder, RelationFinder $relationFinder, GraphBuilder $graphBuilder)
    {
        parent::__construct();

        $this->relationFinder = $relationFinder;
        $this->modelFinder = $modelFinder;
        $this->graphBuilder = $graphBuilder;
    }

    /**
     * @throws \phpDocumentor\GraphViz\Exception
     */
    public function handle()
    {
        if ($this->option('scope') == 'full') {
            $scopes_arr = [
                'false',
                'bondlibrary',
                'cms',
                'policies',
                'system',
                'user',
            ];
            $type_arr = ['full', 'slim'];

            foreach ($scopes_arr as $scope) {
                foreach ($type_arr as $type) {
                    self::graph_initiator($scope, $type);
                }
            }
        } else {
            self::graph_initiator($this->option('scope'), $this->option('type'));
        }
    }

    protected function graph_initiator($passed_scope, $passed_type)
    {
        $models = $this->getModelsThatShouldBeInspected($passed_scope);

        $this->info("Found {$models->count()} models.");
        $this->info("Inspecting model relations.");

        $bar = $this->output->createProgressBar($models->count());

        $models->transform(function ($model) use ($bar) {
            $bar->advance();

            $this->info($model); // DUMPING

            return new GraphModel(
                $model,
                (new ReflectionClass($model))->getShortName(),
                $this->relationFinder->getModelRelations($model)
            );
        });

        $graph = $this->graphBuilder->buildGraph($models, $passed_type,$passed_scope);

        if ($this->option('format') === self::FORMAT_TEXT) {
            $this->info($graph->__toString());
            return;
        }

        // CREATE FILEPATH
        $scopename = $passed_scope == 'false' ? 'AllTables' : ucfirst($passed_scope);
        $filename = './ERD_MAPS/'.$scopename.'_'.$passed_type.'.'.$this->option('format');

        // ADD GRAPH LEGEND
        if ($this->option('legend') == 'true') {
            $legend_node = Node::create('graph_legend');
            $nodetext = '<<table>'.PHP_EOL.'<tr><td><font>WHAT</font></td></tr>'.PHP_EOL.'</table>>';


            $legend_node->setlabel($nodetext);
            $legend_node->setpos("0,0!");
            $legend_node->setshape('rectangle');
            $legend_node->setfontname('Helvetica Neue');
            $graph->setNode($legend_node);
        }

        $graph->export(
            $this->option('format'), 
            $filename,
            $this->option('engine')
        );

        $this->info(PHP_EOL);
        $this->info('Wrote diagram to ' . $filename);
    }

    protected function getOutputFileName($filename): string
    {
        return $filename ?:
            static::DEFAULT_FILENAME . '.' . $this->option('format');
    }

    protected function getModelsThatShouldBeInspected($model_scope): Collection
    {
        $directories = config('erd-generator.directories');

        $modelsFromDirectories = $this->getAllModelsFromEachDirectory($directories, $model_scope);

        return $modelsFromDirectories;
    }

    protected function getAllModelsFromEachDirectory(array $directories, $model_scope): Collection
    {
        return collect($directories)
            ->map(function ($directory) use ($model_scope) {
                return $this->modelFinder->getModelsInDirectory($directory, $model_scope)->all();
            })
            ->flatten();
    }
}
