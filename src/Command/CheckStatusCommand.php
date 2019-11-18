<?php

namespace App\Command;


use App\Controller\WebsiteController;
use App\Repository\WebsiteRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CheckStatusCommand extends Command
{
    protected static $defaultName = 'CheckStatus';
    private $website;

    public function __construct(WebsiteController $website, WebsiteRepository $repo, ObjectManager $manager) {
        parent::__construct();
        $this->website = $website;
        $this->repo = $repo;
        $this->manager = $manager;
    }

    protected function configure()
    {
        $this
            ->setDescription('Checl current status of allwebsites registered.')
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');

        if ($arg1) {
            $io->note(sprintf('You passed an argument: %s', $arg1));
        }

        if ($input->getOption('option1')) {
            // ...
        }

        $this->website->analyze($this->repo, $this->manager);
        $io->success('This command will check current status for all websites. Enter: php bin/console checkStatus --help for some help');

        return 0;
    }
}
