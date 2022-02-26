<?php

namespace Imanghafoori\LaravelMicroscope\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Imanghafoori\LaravelMicroscope\BladeFiles;
use Imanghafoori\LaravelMicroscope\CheckClassReferencesAreValid;
use Imanghafoori\LaravelMicroscope\Checks\CheckClassReferences;
use Imanghafoori\LaravelMicroscope\Checks\FacadeDocblocks;
use Imanghafoori\LaravelMicroscope\ErrorReporters\ErrorPrinter;
use Imanghafoori\LaravelMicroscope\FileReaders\Paths;
use Imanghafoori\LaravelMicroscope\ForPsr4LoadedClasses;
use Imanghafoori\LaravelMicroscope\LaravelPaths\LaravelPaths;
use Imanghafoori\LaravelMicroscope\SpyClasses\RoutePaths;
use Imanghafoori\LaravelMicroscope\Traits\LogsErrors;

class CheckFacadeDocblocks extends Command
{
    use LogsErrors;

    protected $signature = 'check:facades';

    protected $description = 'Checks facade doc-blocks';

    public function handle(ErrorPrinter $errorPrinter)
    {
        event('microscope.start.command');
        $this->info('Checking Facades...');

        $errorPrinter->printer = $this->output;

        ForPsr4LoadedClasses::check([
            FacadeDocblocks::class
        ]);

        $this->finishCommand($errorPrinter);
        $this->getOutput()->writeln(' - ');

        $errorPrinter->printTime();

        return $errorPrinter->hasErrors() ? 1 : 0;
    }
}
