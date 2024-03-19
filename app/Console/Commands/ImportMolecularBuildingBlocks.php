<?php

namespace App\Console\Commands;

use App\Enums\ElementEnum;
use App\Enums\MetaProperties\Abbr;
use App\Enums\MetaProperties\Symbol;
use App\Enums\MolecularTypeEnum;
use App\Models\MolecularBuildingBlock;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImportMolecularBuildingBlocks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-molecular-building-blocks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $files = Storage::disk('local')->files('pfgp/bbs');

        $this->info('Importing Molecular Building Blocks...');

        collect($files)
            ->each(function ($path) {
                $typeAbbr = Str::of($path)->after('pfgp/bbs/')->substr(0, 1)->toString();
                $typeEnum = match ($typeAbbr) {
                    'N'      => MolecularTypeEnum::from('node'),
                    'E', 'L' => MolecularTypeEnum::from('linker'),
                    default  => throw new \Exception("Provided Molecular Type: '{$typeAbbr}', is not valid." , 1),
                };

                $name = Str::of($path)->afterLast('/')->before('.')->toString();

                $fullPath = Storage::disk('local')->path($path);

                $elements = [];

                $handle = fopen($fullPath, "r");

                // Check if the file is successfully opened
                if ($handle) {
                    // Read the file line by line
                    while (($line = fgets($handle)) !== false) {
                        // Trim the line to remove whitespace
                        $line = trim($line);
                        // Check if the line starts with a letter
                        if (preg_match('/^[A-Za-z]+ /', $line)) {
                            // Get the first letter of the line
                            $firstLetter = Str::before($line, ' ');

                            // Increment the count for this letter
                            if (!isset($elements[$firstLetter])) {
                                $elements[$firstLetter] = 1;
                            } else {
                                $elements[$firstLetter]++;
                            }
                        }
                    }

                    // Close the file handle
                    fclose($handle);
                } else {
                    // Error opening the file
                    throw new \Exception("Error opening the file.", 1);
                }

                MolecularBuildingBlock::create([
                    'code'     => $name,
                    'elements' => collect($elements)
                        ->map(fn ($count, $symbol) => [
                            'element' => ElementEnum::from($symbol),
                            'count'   => $count
                        ])
                        ->values(),
                    'type'     => $typeEnum,
                ]);
            });

        $this->info('Import successful!');
    }
}
