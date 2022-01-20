<?php

use CommandBuilder\Command;
use CommandBuilder\Standard;

test("can output simple command", function (): void {
    expect((string) new Command("composer"))->toEqual("composer");
});

// argument
test("can output command with an argument", function (): void {
    expect((string) (new Command("composer"))->argument("require"))->toEqual("composer require");
});

test("can output command with arguments", function (): void {
    expect((string) (new Command("composer"))->argument("require")->argument("laravel/laravel"))->toEqual("composer require laravel/laravel");
});

// flag
test("can output command with a flag", function (): void {
    expect((string) (new Command("composer"))->flag("i"))->toEqual("composer -i");
});

test("can output command with flags", function (): void {
    expect((string) (new Command("composer"))->flag("i")->flag("p"))->toEqual("composer -i -p");
});

// long flag
test("can output command with a long flag", function (): void {
    expect((string) (new Command("composer"))->longFlag("dev"))->toEqual("composer --dev");
});

test("can output command with long flags", function (): void {
    expect((string) (new Command("composer"))->longFlag("dev")->longFlag("classmap-authoritative"))->toEqual("composer --dev --classmap-authoritative");
});

// option
test("can output command with an option in GNU style", function (): void {
    expect((string) (new Command("composer"))->option("i", "hhvm"))->toEqual("composer -i=hhvm");
});

test("can output command with an option containing spaces in GNU style", function (): void {
    expect((string) (new Command("composer"))->option("i", "php hhvm"))->toEqual('composer -i="php hhvm"');
});

test("can output command with an option containing double quotes in GNU style", function (): void {
    expect((string) (new Command("composer"))->option("i", '"hhvm"'))->toEqual('composer -i="\"hhvm\""');
});

test("can output command with an option containing spaces and double quotes in GNU style", function (): void {
    expect((string) (new Command("composer"))->option("i", '"php" "hhvm"'))->toEqual('composer -i="\"php\" \"hhvm\""');
});

test("can output command with an option in POSIX style", function (): void {
    expect((string) (new Command("composer", Standard::POSIX))->option("i", "hhvm"))->toEqual("composer -i hhvm");
});

test("can output command with an option containing spaces in POSIX style", function (): void {
    expect((string) (new Command("composer", Standard::POSIX))->option("i", "php hhvm"))->toEqual('composer -i "php hhvm"');
});

test("can output command with options in GNU style", function (): void {
    expect((string) (new Command("composer"))->option("i", "hhvm")->option("a", "app"))->toEqual("composer -i=hhvm -a=app");
});

test("can output command with options in POSIX style", function (): void {
    expect((string) (new Command("composer", Standard::POSIX))->option("i", "hhvm")->option("a", "app"))->toEqual("composer -i hhvm -a app");
});

// long option
test("can output command with a long option in GNU style", function (): void {
    expect((string) (new Command("composer"))->longOption("ignore-platform-req", "hhvm"))->toEqual("composer --ignore-platform-req=hhvm");
});

test("can output command with a long option containing spaces in GNU style", function (): void {
    expect((string) (new Command("composer"))->longOption("ignore-platform-req", "php hhvm"))->toEqual('composer --ignore-platform-req="php hhvm"');
});

test("can output command with a long option containing double quotes in GNU style", function (): void {
    expect((string) (new Command("composer"))->longOption("ignore-platform-req", '"hhvm"'))->toEqual('composer --ignore-platform-req="\"hhvm\""');
});

test("can output command with a long option containing spaces and double quotes in GNU style", function (): void {
    expect((string) (new Command("composer"))->longOption("ignore-platform-req", '"php" "hhvm"'))->toEqual('composer --ignore-platform-req="\"php\" \"hhvm\""');
});

test("can output command with a long option in POSIX style", function (): void {
    expect((string) (new Command("composer", Standard::POSIX))->longOption("ignore-platform-req", "hhvm"))->toEqual("composer --ignore-platform-req hhvm");
});

test("can output command with a long option containing spaces in POSIX style", function (): void {
    expect((string) (new Command("composer", Standard::POSIX))->longOption("ignore-platform-req", "php hhvm"))->toEqual('composer --ignore-platform-req "php hhvm"');
});

test("can output command with long options in GNU style", function (): void {
    expect((string) (new Command("composer"))->longOption("ignore-platform-req", "hhvm")->longOption("apcu-prefix", "app"))->toEqual("composer --ignore-platform-req=hhvm --apcu-prefix=app");
});

test("can output command with long options in POSIX style", function (): void {
    expect((string) (new Command("composer", Standard::POSIX))->longOption("ignore-platform-req", "hhvm")->longOption("apcu-prefix", "app"))->toEqual("composer --ignore-platform-req hhvm --apcu-prefix app");
});

// has flag
test("returns true if long flag is present", function (): void {
    $command = new Command("composer");

    $command->longFlag("dev")
        ->option("i", "source");

    expect($command->hasFlag("d", "dev"))->toBeTrue();
});

test("returns true if short flag is present", function (): void {
    $command = new Command("composer");

    $command->flag("d")
        ->option("i", "source");

    expect($command->hasFlag("d", "dev"))->toBeTrue();
});

test("returns false if flag is missing", function (): void {
    $command = new Command("composer");

    $command->option("d", "source");

    expect($command->hasFlag("d", "dev"))->toBeFalse();
});

// has option
test("returns true if long option is present", function (): void {
    $command = new Command("composer");

    $command->longOption("apcu-prefix", "app")
        ->flag("d");

    expect($command->hasOption("a", "apcu-prefix"))->toBeTrue();
});

test("returns true if short option is present", function (): void {
    $command = new Command("composer");

    $command->longOption("a", "app")
        ->flag("d");

    expect($command->hasOption("a", "apcu-prefix"))->toBeTrue();
});

test("returns false if option is missing", function (): void {
    $command = new Command("composer");

    $command->flag("a");

    expect($command->hasOption("a", "apcu-prefix"))->toBeFalse();
});

test("returns number of arguments", function (): void {
    $command = new Command("composer");

    $command
        ->argument("require")
        ->argument("laravel/laravel")
        ->longFlag("dev");

    expect($command->argumentCount())->toEqual(2);
});

test("returns number of flags", function (): void {
    $command = new Command("composer");

    $command
        ->argument("require")
        ->argument("laravel/laravel")
        ->longFlag("dev")
        ->longFlag("prefer-dist");

    expect($command->flagCount())->toEqual(2);
});

test("returns number of options", function (): void {
    $command = new Command("composer");

    $command
        ->argument("require")
        ->argument("laravel/laravel")
        ->longOption("apcu-prefix", "flag")
        ->longOption("ignore-platform-req", "hhvm");

    expect($command->optionCount())->toEqual(2);
});
