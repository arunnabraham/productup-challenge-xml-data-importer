<?php

declare(strict_types=1);

namespace Arunnabraham\XmlDataImporter\Service\Metadata;

interface WriteMetaInterface {
    public function writeRowDataToStream($fileStream): bool;
    public function setRowData(): void;
    public function getRowMeta(): string;
}