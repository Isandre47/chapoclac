<?php

namespace App\Command;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class LoadFixturesDevCommand extends Command
{
    private $objectManager;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('app:load-fixtures-dev')
            ->setDescription('Load database and fixtures')
            ->setHelp('This command allows you to load database and fixtures...')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $command = $this->getApplication()->find('doctrine:database:drop');

        $arguments = array(
            '--force'  => true,
        );

        $greetInput = new ArrayInput($arguments);
        $command->run($greetInput, $output);

        $command = $this->getApplication()->find('doctrine:database:create');
        $command->run($input, $output);

        $command = $this->getApplication()->find('doctrine:schema:update');

        $arguments = array(
            '--force'  => true,
        );

        $greetInput = new ArrayInput($arguments);
        $command->run($greetInput, $output);

        $filenames = [
            'data/chapoclac.sql',
        ];

        foreach($filenames as $filename){
            $sql = file_get_contents($filename);
            $this->objectManager->getConnection()->exec($sql);
        }

        $this->objectManager->flush();
    }

}