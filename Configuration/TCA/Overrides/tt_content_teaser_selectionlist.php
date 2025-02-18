<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') || die;

ExtensionManagementUtility::addTcaSelectItem(
    'tt_content',
    'CType',
    [
        'LLL:EXT:rmnd_teaser/Resources/Private/Language/locallang_tca.xlf:selectionList',
        'teaser_selectionlist',
        'content-card-group',
    ],
);

$GLOBALS['TCA']['tt_content']['types']['teaser_selectionlist'] = [
    'columnsOverrides' => [
        'pages' => [
            'onChange' => 'reload',
        ],
    ],
    'showitem' => '
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
            --palette--;;general,
            --palette--;;headers,
            pages,
            pi_flexform;LLL:EXT:rmnd_teaser/Resources/Private/Language/locallang_tca.xlf:teaser,
        --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance,
            --palette--;;frames,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
            --palette--;;language,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
            --palette--;;hidden,
            --palette--;;access,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:categories,
            categories,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:notes,
            rowDescription,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:extended,
    ',
];

ExtensionManagementUtility::addPiFlexFormValue(
    '*',
    'FILE:EXT:rmnd_teaser/Configuration/FlexForms/ListSelection.xml',
    'teaser_selectionlist'
);
