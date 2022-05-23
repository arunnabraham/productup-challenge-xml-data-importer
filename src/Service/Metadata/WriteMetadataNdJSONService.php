<?php

declare(strict_types=1);

namespace Arunnabraham\XmlDataImporter\Service\Metadata;

class WriteMetadataNdJSONService implements WriteMetaInterface
{
    private string $rowMeta = '';
    private int $rowIndex;
    private array $rowData;
    public function __construct(int $rowIndex, array $rowData)
    {
        $this->rowIndex = $rowIndex;
        $this->rowData = $rowData;
    }
    public function writeRowDataToStream($fileStream): bool
    {
        $this->setRowData();
        $writeData = fwrite($fileStream, $this->getRowMeta());
        return !is_bool($writeData);
    }

    public function setRowData(): void
    {
        $delimiter = $this->rowIndex > 0 ? PHP_EOL : '';
        $this->rowMeta = $delimiter . json_encode($this->rowData);
    }

    public function getRowMeta(): string
    {
        return $this->rowMeta;
    }
}
