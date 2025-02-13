<?php

declare(strict_types=1);

defined('TYPO3') || die;

return [
    'ctrl' => [
        'title' => 'LLL:EXT:rmnd_teaser/Resources/Private/Language/locallang_tca.xlf:teaser',
        'label' => 'title',
        'label_alt' => 'subtitle',
        'label_alt_force' => true,
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'versioningWS' => true,
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'languageField' => 'sys_language_uid',
        'translationSource' => 'l10n_source',
        'origUid' => 't3_origuid',
        'delete' => 'deleted',
        'sortby' => 'sorting',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'iconfile' => 'EXT:rmnd_teaser/ext_icon.svg',
    ],
    'columns' => [
        'title' => [
            'label' => 'LLL:EXT:rmnd_teaser/Resources/Private/Language/locallang_tca.xlf:title',
            'config' => [
                'type' => 'input',
                'size' => 10,
                'eval' => 'trim',
                'max' => 256,
            ],
        ],
        'subtitle' => [
            'label' => 'LLL:EXT:rmnd_teaser/Resources/Private/Language/locallang_tca.xlf:subtitle',
            'config' => [
                'type' => 'input',
                'size' => 50,
                'eval' => 'trim',
                'max' => 256,
            ],
        ],
        'image' => [
            'label' => 'LLL:EXT:rmnd_teaser/Resources/Private/Language/locallang_tca.xlf:image',
            'config' => [
                'type' => 'file',
                'allowed' => 'common-image-types',
                'maxitems' => 1,
            ],
        ],
        'link' => [
            'config' => [
                'size' => 50,
                'type' => 'link',
            ],
            'label' => 'LLL:EXT:rmnd_teaser/Resources/Private/Language/locallang_tca.xlf:link',
        ],
        'bodytext' => [
            'config' => [
                'cols' => 80,
                'enableRichtext' => true,
                'rows' => 10,
                'type' => 'text',
            ],
            'l10n_mode' => 'prefixLangTitle',
            'label' => 'LLL:EXT:rmnd_teaser/Resources/Private/Language/locallang_tca.xlf:bodytext',
        ],
         'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'language',
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    [
                        '',
                        0,
                    ],
                ],
                'foreign_table' => 'tx_teaser_domain_model_teaser',
                'foreign_table_where' =>
                    'AND {#tx_teaser_domain_model_teaser}.{#pid}=###CURRENT_PID###'
                    . ' AND {#tx_teaser_domain_model_teaser}.{#sys_language_uid} IN (-1,0)',
                'default' => 0,
            ],
        ],
        'l10n_source' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
                'default' => '',
            ],
        ],
        't3ver_label' => [
            'displayCond' => 'FIELD:t3ver_label:REQ:true',
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.versionLabel',
            'config' => [
                'type' => 'none',
            ],
        ],
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.enabled',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [
                        0 => '',
                        1 => '',
                        'invertStateDisplay' => true,
                    ],
                ],
            ],
        ],
    ],
    'palettes' => [
        'teaser' => [
            'label' => 'LLL:EXT:rmnd_teaser/Resources/Private/Language/locallang_tca.xlf:teaser',
            'showitem' => '
                title,
                --linebreak--,
                subtitle,
                --linebreak--,
                bodytext,
                --linebreak--,
                link,
                --linebreak--,
                image,
            ',
        ],
    ],
    'types' => [
        0 => [
            'showitem' => '
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
                    --palette--;;teaser,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
                    sys_language_uid,
                    l10n_parent,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
                    hidden,
                --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:extended,
            ',
        ],
    ],
];
