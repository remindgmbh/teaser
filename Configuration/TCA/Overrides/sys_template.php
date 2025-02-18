<?php

declare(strict_types=1);

defined('TYPO3') || die;

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

(function (): void {
    ExtensionManagementUtility::addStaticFile(
        'rmnd_teaser',
        'Configuration/TypoScript',
        'REMIND - Teaser Extension'
    );
})();
