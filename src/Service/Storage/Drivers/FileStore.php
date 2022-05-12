<?php

declare(strict_types=1);

namespace Arunnabraham\XmlDataImporter\Service\Storage\Drivers;

class FileStore implements StorageDriverInterface
{
    private mixed $data;
    private string $fileStore;

    public function outputLocation(mixed $data, string $path='.'): string
    {
        $this->data = $data;
        
        return $this->storeData() ? $this->fileStore : null;
    }

    public function storeData(): bool
    {
        // save sql;
        return true;
    }
}