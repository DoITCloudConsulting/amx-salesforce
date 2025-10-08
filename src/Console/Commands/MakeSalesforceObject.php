<?php

namespace Amx\Salesforce\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class MakeSalesforceObject extends Command
{
    protected static $defaultName = 'salesforce:make-object';
    protected static $defaultDescription = 'Create a new Salesforce object class (Standard or Custom) with its corresponding trait.';

    public function __construct()
    {
        parent::__construct('amx-salesforce:make-object');
    }

    protected function configure()
    {
        $this
            ->addArgument('object', InputArgument::REQUIRED, 'Salesforce object name (e.g. Account or Translations)')
            ->addOption('standard', null, InputOption::VALUE_NONE, 'Create a Standard object (default is Custom)');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $isStandard = $input->getOption('standard');
        $objectBaseName = ucfirst($input->getArgument('object'));

        if ($isStandard) {
            $objectName = $objectBaseName;
            $folder = 'Standard';
        } else {
            $objectName = $objectBaseName . '__c';
            $folder = 'Custom';
        }

        $basePath = dirname(__DIR__, 2);

        $objectDir = "{$basePath}/Objects/{$folder}";
        $traitDir = "{$basePath}/Traits/{$folder}";

        if (!is_dir($objectDir)) mkdir($objectDir, 0777, true);
        if (!is_dir($traitDir)) mkdir($traitDir, 0777, true);

        $objectClass = "SF{$objectBaseName}";
        $traitClass = "SF{$objectBaseName}Fields";

        $objectPath = "{$objectDir}/{$objectClass}.php";
        $traitPath = "{$traitDir}/{$traitClass}.php";

        if (file_exists($objectPath) || file_exists($traitPath)) {
            $output->writeln("<comment>⚠️ Object with class {$objectClass} or trait {$traitClass} already exists. Aborting.</comment>");
            return Command::SUCCESS;
        }

        $traitContent = <<<PHP
        <?php
        
        namespace Amx\\Salesforce\\Traits\\{$folder};
        
        trait {$traitClass}
        {
            public function getFields(): array
            {
                return [];
            }
        }
        PHP;

        $objectContent = <<<PHP
        <?php
        
        namespace Amx\\Salesforce\\Objects\\{$folder};
        
        use Amx\\Salesforce\\Traits\\{$folder}\\{$traitClass};
        use Amx\\Salesforce\\Objects\\SFBaseObject;
        
        class {$objectClass} extends SFBaseObject
        {
            use {$traitClass};
        
            protected string \$sObject = '{$objectName}';
        
            public function allFields(): array
            {
                return array_merge(\$this->getBaseFields(), \$this->get{$objectBaseName}Fields());
            }
        }
        PHP;

        file_put_contents($traitPath, $traitContent);
        file_put_contents($objectPath, $objectContent);

        $output->writeln("<info>✅ Salesforce PHP object and trait created successfully!</info>");
        $output->writeln("🧩 Class: {$objectPath}");
        $output->writeln("🔧 Trait: {$traitPath}");

        return Command::SUCCESS;
    }
}