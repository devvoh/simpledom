# SimpleDom

[![Build Status](https://travis-ci.org/devvoh/simpledom.svg?branch=master)](https://travis-ci.org/devvoh/simpledom)
[![Latest Stable Version](https://poser.pugx.org/devvoh/simpledom/v/stable)](https://packagist.org/packages/devvoh/simpledom)
[![Latest Unstable Version](https://poser.pugx.org/devvoh/simpledom/v/unstable)](https://packagist.org/packages/devvoh/simpledom)
[![License](https://poser.pugx.org/devvoh/simpledom/license)](https://packagist.org/packages/devvoh/simpledom)

SimpleDom adds simple class manipulation to DOMDocuments and DOMElements.

## Requirements

- PHP 5.6+
- Composer

## Installation

SimpleDom can be installed by using [Composer](http://getcomposer.org/). Simply run:

`composer require devvoh/simpledom`

## Usage

SimpleDom can be considered an facade adapter for the built-in `DOMDocument` and `DOMElement` classes. As such, you can use them anywhere you currently use those.

Creating a new instance is done with an extra step, however:

```php
$domDocument = new \DOMDocument();
$domDocument->loadHTML($htmlString);

$document = \SimpleDom\Document::fromDOMDocument($domDocument);
```

To then get all elements with the class "header":

```php
$elements = $document->getElementsByClassName("header");
```

And you'll get an array of `\SimpleDom\Element` items. SimpleDom also overwrites the following `DOMDocument` methods: `getElementsByTagName()`, `getElementById()` and `createElement()`.

Normally the `getElement` methods would return a `DOMNodeList` but SimpleDom returns an array of elements instead.

It's also possible to get elements which have multiple classes.

```php
$elements = $document->getElementsByClassNames(["header", "sub"]);
```

Which will only return items that have both the "header" and "sub" class. The order of which is not important.

SimpleDom `Element` instances have some added features as well.

```php
$element = $document->createElement("span", "this is a span!");
$element->addClass("blue");
```

The above code will result in the following html: `<span class="blue">this is a span!</span>`

The following methods are available to work with classes and Elements:
- `getClasses(): array`
- `setClasses(array): Element`
- `hasClass(string): bool`
- `hasClasses(array): bool`
- `addClass(string): Element`
- `addClasses(array): Element`
- `removeClass(string): Element`
- `removeClasses(array): Element`
- `toggleClass(string): Element`
- `toggleClasses(array): Element`
- `clearClasses(): Element`

## Contact

All questions can be asked through github. Just create an issue and I'll get back with an answer as soon as possible.

## License

Devvoh SimpleDom is open-sourced software licensed under the MIT license.