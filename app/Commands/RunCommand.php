<?php


namespace App\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;


class RunCommand extends Command
{
    protected $signature =  'run {args}';

    public function handle(): int
    {
        $options = $this->arguments();
        array_shift($options);
        $process = new Process(array_values($options));
        $process->setTty(true);

        $process->mustRun(function($type, $buffer) {
            $this->getOutput()->write($buffer);
        });

        return self::SUCCESS;
    }
}
