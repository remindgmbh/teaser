[![REMIND](https://img.shields.io/badge/REMIND-black.svg)](https://www.remind.de/) 
[![HEADLESS](https://img.shields.io/badge/HEADLESS-blue.svg)](https://github.com/remindgmbh/headless) 
[![TYPO3 13](https://img.shields.io/badge/TYPO3-13-orange.svg)](https://get.typo3.org/version/13) 

# REMIND - Teaser Extension

A headless TYPO3 extension for teaser selections as a content element.

## Keypoints

- Adds one content element: `teaser_selectionlist` (label: Teaser selection).
- Uses its own domain table: `tx_teaser_domain_model_teaser`.
- Returns frontend JSON via Extbase (`TeaserController->selectionListAction`).
- Designed for REMIND headless setups (`remind/headless`, `remind/extbase`).
- Supports categories and one image reference per teaser.

## Requirements

- TYPO3 `^13.4`
- PHP version compatible with TYPO3 v13 requirements
- Dependencies:
  - `remind/extbase`
  - `remind/headless`

## Installation

1. Install the extension via Composer.
2. Run database updates (adds table `tx_teaser_domain_model_teaser`).
3. Include static TypoScript `REMIND - Teaser Extension` in your site template.

## Available Content

### Teaser Record

Table: `tx_teaser_domain_model_teaser`

Main fields:

- `title`
- `subtitle`
- `bodytext` (RTE)
- `image` (single file)
- `link` (TYPO3 link field)
- `categories`

### Content Element: Teaser Selection

`CType`: `teaser_selectionlist`

Content element configuration:

- `pages`: limits teaser selection to records on selected pages
- FlexForm `records`: selected teaser records
- FlexForm `enableLink`: available, currently not used in controller logic

## Output (Headless JSON)

The content element renders JSON with a list of selected teasers.

Typical fields per item:

- `uid`
- `pid`
- `title`
- `subtitle`
- `bodytext` (processed with `lib.parseFunc_links`)
- `link` (decoded, including `href`)
- `image` (if available)
- `categories` (if available)

## Development

Useful Composer scripts:

- `composer phpcs`
- `composer phpstan`
- `composer phpunit`
- `composer static-analysis`
