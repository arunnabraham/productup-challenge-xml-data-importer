<?php

declare(strict_types=1);

namespace Arunnabraham\XmlDataImporter\Service\Storage\Drivers;

interface StorageDriverInterface
{
    public function outputLocation(mixed $data, string $path='.'):string;
    public function storeData(): bool;
}
