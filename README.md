# Title

[![Latest Stable Version](https://img.shields.io/packagist/v/horstoeko/docugen.svg?style=plastic)](https://packagist.org/packages/horstoeko/docugen)
[![PHP version](https://img.shields.io/packagist/php-v/horstoeko/docugen.svg?style=plastic)](https://packagist.org/packages/horstoeko/docugen)
[![License](https://img.shields.io/packagist/l/horstoeko/docugen.svg?style=plastic)](https://packagist.org/packages/horstoeko/docugen)

[![Build Status](https://github.com/horstoeko/docugen/actions/workflows/build.ci.yml/badge.svg)](https://github.com/horstoeko/docugen/actions/workflows/build.ci.yml)
[![Release Status](https://github.com/horstoeko/docugen/actions/workflows/build.release.yml/badge.svg)](https://github.com/horstoeko/docugen/actions/workflows/build.release.yml)

## Table of Contents

- [License](#license)
- [Overview](#overview)
- [Dependencies](#dependencies)
- [Installation](#installation)

## License

The code in this project is provided under the [MIT](https://opensource.org/licenses/MIT) license.

## Overview

Create simple documentation in Markdown, HTML or PDF format or generate sample code. The documentation is defined via a JSON file. Repeating elements, repeating text, etc. can be stored and assembled into complete documentation

## Dependencies

This package makes use of

* [league/commonmark](https://github.com/thephpleague/commonmark)
* [mpdf/mpdf](https://github.com/mpdf/mpdf)
* [swaggest/json-schema](https://github.com/swaggest/php-json-schema)
* [symfony/console](https://github.com/symfony/console)
* [symfony/expression-language](https://github.com/symfony/expression-language)
* [horstoeko/stringmanagement](https://github.com/horstoeko/stringmanagement)

## Installation

There is one recommended way to install `horstoeko/docugen` via [Composer](https://getcomposer.org/):

```bash
composer require horstoeko/docugen
```

## Usage

For detailed eplanation you may have a look in the [examples](https://github.com/horstoeko/docugen/tree/master/examples) of this package and the documentation attached to every release.
