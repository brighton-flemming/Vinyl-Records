<?php

namespace App\Command;

use App\Entity\Vinyl;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:assign-record-sequences')]
class AssignRecordSequenceCommand extends Command
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('app:assign-record-sequence')
            ->setDescription('Assigns record_sequence values to existing records.')
            ->setHelp('This command allows you to assign record_sequence values to existing records...');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $repository = $this->entityManager->getRepository(Vinyl::class);
        $records = $repository->findBy([], ['id' => 'ASC']);

        $sequence = 1;
        foreach ($records as $record) {
            $record->setRecordSequence($sequence++);
            $this->entityManager->persist($record);
        }

        $this->entityManager->flush();

        $output->writeln('Record sequence values have been assigned.');

        return Command::SUCCESS;
    }
}
