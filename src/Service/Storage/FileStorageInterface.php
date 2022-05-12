<?php

declare(strict_types=1);

namespace Arunnabraham\XmlDataImporter\Service\ExportIO;

interface FileStorageInterface
{
    public function createFile(string $data): bool;
    public function location(StorageDriverInterface $storageDriver, string $path=''): string;
}
