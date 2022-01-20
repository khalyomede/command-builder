# command-builder

A PHP class to build executable with using fluent API.

## Summary

- [About](#about)
- [Features](#featues)
- [Installation](#installation)
- [Examples](#examples)
- [Compatibility table](#compatibility-table)
- [Tests](#tests)

## About

I need to have a fluent way to call my executable. I did not found any other command builder providing such interface that was updated recently or provide a large test coverage.

## Features

- Use a fluent API to construct the string to be executed
- Class-based
- Support arguments, long/short options and flags
- Preserves order of elements
- Does **not** handle executing the command

## Installation

Install the package using Composer:

```bash
composer require khalyomede/command-builder
```

## Examples

- [1. Create a simple command](#1-create-a-simple-command)
- [2. Add an argument](#2-add-an-argument)
- [3. Add a flag](#3-add-a-flag)
- [4. Add an option](#4-add-an-option)
- [5. Configure the standard](#5-configure-the-standard)
- [6. Get the number of arguments](#6-get-the-number-of-arguments)
- [7. Get the number of flags](#7-get-the-number-of-flags)
- [8. Get the number of options](#8-get-the-number-of-options)
- [9. Check if a flag has been added](#9-check-if-a-flag-has-been-added)
- [10. Check if an option has been added](#10-check-if-an-option-has-been-added)

### 1. Create a simple command

In this example, we will just pass a command name, without arguments/options/flags.

```php
use Khalyomede\CommandBuilder\Command;

$command = new Command("composer");

echo $command; // composer
```

### 2. Add an argument

In this example, we will add an argument to our command.

```php
use Khalyomede\CommandBuilder\Command;

$command = new Command("composer");

$command->argument("require");

echo $command; // composer require
```

### 3. Add a flag

In this example, we will add a "long" flag to the command.

```php
use Khalyomede\CommandBuilder\Command;

$command = new Command("composer");

$command->argument("require")
  ->longFlag("ignore-platform-reqs");

echo $command; // composer require --ignore-platform-reqs
```

And this is how to add a "short" flag.

```php
use Khalyomede\CommandBuilder\Command;

$command = new Command("composer");

$command->argument("require")
  ->flag("i");

echo $command; // composer require -i
```

### 4. Add an option

You can add options to your command.

```php
use Khalyomede\CommandBuilder\Command;

$command = new Command("composer");

$command->argument("require")
  ->longOption("prefer-install", "source");

echo $command; // composer require --prefer-install=source
```

If your option contains spaces, it will automatically be escaped using double quotes.

```php
use Khalyomede\CommandBuilder\Command;

$command = new Command("composer");

$command->argument("require")
  ->longOption("prefer-install", "auto source");

echo $command; // composer require --prefer-install="auto source"
```

And if your option contains spaces and doubles quotes, they will also be escaped.

```php
use Khalyomede\CommandBuilder\Command;

$command = new Command("composer");

$command->argument("require")
  ->longOption("prefer-install", 'auto "source"');

echo $command; // composer require --prefer-install="auto \"source\""
```

You can also use "short" option.

```php
use Khalyomede\CommandBuilder\Command;

$command = new Command("composer");

$command->argument("require")
  ->option("p", 'source');

echo $command; // composer require -p=source
```

### 5. Configure the standard

You can specify the standard used for the option. By default, it is set to "GNU".

```php
use Khalyomede\CommandBuilder\Command;

$command = new Command("composer", "POSIX");

$command->argument("require")
  ->option("p", 'source');

echo $command; // composer require -p source

$command = new Command("composer")

$command->argument("require")
  ->option("p", 'source');

echo $command; // composer require -p=source
```

You can also use constants if you prefer

```php
use Khalyomede\CommandBuilder\Command;
use Khalyomede\CommandBuilder\Standard;

$command = new Command("composer", Standard::POSIX);
```

### 6. Get the number of arguments

You can know how many arguments were added to the command.

```php
use Khalyomede\CommandBuilder\Command;

$command = new Command("composer");

$command->argument("create-project")
  ->argument("laravel/laravel");

echo $command->argumentCount(); // 2
```

### 7. Get the number of flags

You can know the number of flags added to your command.

```php
use Khalyomede\CommandBuilder\Command;

$command = new Command("composer");

$command->flag("i")
  ->longFlag("prefer-dist");

echo $command->flagCount(); // 2
```

### 8. Get the number of options

You can know the number of options added to your command.

```php
use Khalyomede\CommandBuilder\Command;

$command = new Command("composer");

$command->option("a", "source")
  ->longFlag("apcu-autoloader-prefix", "app");

echo $command->optionCount(); // 2
```

### 9. Check if a flag has been added

You can know if a flag has been added already.

```php
use Khalyomede\CommandBuilder\Command;

$command = new Command("composer");

$command->longFlag("dev");

var_dump( $command->hasFlag("d", "dev") ); // bool(true)
var_dump( $command->hasFlag("o", "optimize-autoloader") ); // bool(false)
```

### 10. Check if an option has been added

You can know if an option has been added or not.

```php
use Khalyomede\CommandBuilder\Command;
use Khalyomede\CommandBuilder\Style;

$command = new Command("composer");

$command->longOption("prefer-install", "source");

var_dump( $command->hasOption("p", "prefer-install") ); // bool(true)
var_dump( $command->hasOption("i", "ignore-platform-req") ); // bool(false)
```

## Compatibility table

This is the compatibility for this version only. To check the compatibility with other version of this package, please browse the version of your choice.

| PHP Version | Compatibility |
|-------------|---------------|
| 8.1.*       | ✔️             |
| 8.0.*       | ✔️             |
| 7.4.*       | ✔️             |

## Tests

```bash
composer run test
composer run mutate
composer run analyse
composer run lint
composer run install-security-checker
composer run check-security
composer run check-updates
```
