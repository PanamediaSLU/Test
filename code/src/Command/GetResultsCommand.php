<?php

namespace App\Command;

use App\UseCases\GetDrawUseCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GetResultsCommand extends Command
{
    private $getDrawUseCase;

    public function __construct(GetDrawUseCase $getDrawUseCase)
    {
        $this->getDrawUseCase = $getDrawUseCase;

        parent::__construct();
    }
    protected function configure()
    {
        $this
            ->setName('app:get-results')
            ->setDescription('Retrieves results from api.')
            ->setHelp('This command gets results from api and saves them to the db.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $draw = $this->getDrawUseCase->execute();

            $drawDataArray = $draw->toArray();

            foreach ($drawDataArray as $key => $val) {
                $output->writeln($key . ": " . $val);
            }
            return 0;
        } catch (\Exception $exception) {
            $output->write($exception->getMessage());
            return 1;
        }
    }
}