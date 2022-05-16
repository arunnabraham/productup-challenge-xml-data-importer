<?php

declare(strict_types=1);

namespace Arunnabraham\XmlDataImporter\Service\Formats;

interface ExportCoreFormatInterface {
    public function coreFormatAndWrite($sourceResource, $destinationResource = null, $destinatonPath = ''): void;
}