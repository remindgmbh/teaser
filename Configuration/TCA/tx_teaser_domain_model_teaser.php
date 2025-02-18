<?php

declare(strict_types=1);

defined('TYPO3') || die;

return [
    'columns' => [
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
        'hidden' => [
            'config' => [
                'items' => [
                    [
                        'invertStateDisplay' => true,
                        0 => '',
                        1 => '',
                    ],
                ],
                'renderType' => 'checkboxToggle',
                'type' => 'check',
            ],
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.enabled',
        ],
        'image' => [
            'config' => [
                'allowed' => 'common-image-types',
                'maxitems' => 1,
                'type' => 'file',
            ],
            'label' => 'LLL:EXT:rmnd_teaser/Resources/Private/Language/locallang_tca.xlf:image',
        ],
        'l10n_diffsource' => [
            'config' => [
                'default' => '',
                'type' => 'passthrough',
            ],
        ],
        'l10n_parent' => [
            'config' => [
                'default' => 0,
                'foreign_table' => 'tx_teaser_domain_model_teaser',
                'foreign_table_where' =>
                    'AND {#tx_teaser_domain_model_teaser}.{#pid}=###CURRENT_PID###'
                    . ' AND {#tx_teaser_domain_model_teaser}.{#sys_language_uid} IN (-1,0)',
                'items' => [
                    [
                        '',
                        0,
                    ],
                ],
                'renderType' => 'selectSingle',
                'type' => 'select',
            ],
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
        ],
        'l10n_source' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'link' => [
            'config' => [
                'size' => 50,
                'type' => 'link',
            ],
            'label' => 'LLL:EXT:rmnd_teaser/Resources/Private/Language/locallang_tca.xlf:link',
        ],
        'subtitle' => [
            'config' => [
                'eval' => 'trim',
                'max' => 256,
                'size' => 50,
                'type' => 'input',
            ],
            'label' => 'LLL:EXT:rmnd_teaser/Resources/Private/Language/locallang_tca.xlf:subtitle',
        ],
        'sys_language_uid' => [
            'config' => [
                'type' => 'language',
            ],
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
        ],
        't3ver_label' => [
            'config' => [
                'type' => 'none',
            ],
            'displayCond' => 'FIELD:t3ver_label:REQ:true',
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.versionLabel',
        ],
        'title' => [
            'config' => [
                'eval' => 'trim',
                'max' => 256,
                'size' => 50,
                'type' => 'input',
            ],
            'label' => 'LLL:EXT:rmnd_teaser/Resources/Private/Language/locallang_tca.xlf:title',
        ],
    ],
    'ctrl' => [
        'crdate' => 'crdate',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'iconfile' => 'EXT:rmnd_teaser/Resources/Public/Icons/Extension.svg',
        'label' => 'title',
        'label_alt' => 'subtitle',
        'label_alt_force' => true,
        'languageField' => 'sys_language_uid',
        'origUid' => 't3_origuid',
        'sortby' => 'sorting',
        'title' => 'LLL:EXT:rmnd_teaser/Resources/Private/Language/locallang_tca.xlf:teaser',
        'translationSource' => 'l10n_source',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'transOrigPointerField' => 'l10n_parent',
        'tstamp' => 'tstamp',
        'versioningWS' => true,
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
                    pi_flexform,
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
