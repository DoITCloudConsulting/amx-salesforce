<?php

namespace Amx\Salesforce\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SyncSalesforceObject extends Command
{
    protected static $defaultName = 'amx-salesforce:sync';
    protected static $defaultDescription = 'Synchronize Salesforce object fields (Standard or Custom) and update its trait.';

    public function __construct()
    {
        parent::__construct('amx-salesforce:sync-object');
    }

    protected function configure()
    {
        $this
            ->addArgument('object', InputArgument::REQUIRED, 'Salesforce object name (e.g. Account or Translations)')
            ->addOption('mode', null, InputOption::VALUE_OPTIONAL, 'Synchronization mode (api or ui)', 'api');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $objectName = ucfirst($input->getArgument('object'));
        $mode = $input->getOption('mode');

        $standardClass = "Amx\\Salesforce\\Objects\\Standard\\SF{$objectName}";
        $customClass = "Amx\\Salesforce\\Objects\\Custom\\SF{$objectName}";

        if (class_exists($standardClass)) {
            $class = $standardClass;
        } elseif (class_exists($customClass)) {
            $class = $customClass;
        } else {
            $output->writeln("<error>❌ Class not found: {$standardClass} or {$customClass}</error>");
            return Command::FAILURE;
        }

        $output->writeln("<info>🔄 Syncing Salesforce object: {$objectName}...</info>");

        try {
            $instance = new $class();
            $fields = $instance->sync($mode);
            $count = count($fields);
            $output->writeln("<info>✅ {$objectName} synchronized successfully ({$count} fields updated).</info>");
        } catch (\Throwable $e) {
            $output->writeln("<error>❌ Error: {$e->getMessage()}</error>");
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}