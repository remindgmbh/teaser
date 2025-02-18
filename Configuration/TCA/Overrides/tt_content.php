<?php

declare(strict_types=1);

use Remind\Extbase\Utility\Dto\PluginType;
use Remind\Extbase\Utility\PluginUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') || die;

(function (): void {
    $selectionListSignature = ExtensionUtility::registerPlugin(
        'Teaser',
        'SelectionList',
        'LLL:EXT:rmnd_teaser/Resources/Private/Language/locallang_tca.xlf:selectionList',
        '',
    );

    PluginUtility::addTcaType(
        $selectionListSignature,
        PluginType::SELECTION_LIST,
        'tx_teaser_domain_model_teaser'
    );
})();
