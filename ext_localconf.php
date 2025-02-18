<?php

declare(strict_types=1);

use Remind\Teaser\Controller\TeaserController;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') || die('Access denied.');

(function (): void {
    ExtensionUtility::configurePlugin(
        'Teaser',
        'SelectionList',
        [TeaserController::class => 'selectionList'],
        [],
        ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
    );
})();
