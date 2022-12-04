<?php

namespace App\Command;

use App\Message\FetchNewsMessage;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class ScrapNewsCommand extends Command{

    private $bus;
    protected static $defaultName="app:scrap-news";

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus=$bus;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription("starts news source scrapping");
    }

   public function execute(InputInterface $input, OutputInterface $output): int
   {
        $this->bus->dispatch(new FetchNewsMessage("https://highload.today/uk/category/novyny/"));
        
        $output->writeln("[*] Congrates 👏 ! News scrap request is queued successfully.");
        return Command::SUCCESS;
   } 
}