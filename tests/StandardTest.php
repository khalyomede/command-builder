<?php

use Khalyomede\CommandBuilder\Standard;

test("have GNU style", function (): void {
    expect(Standard::GNU)->toEqual("GNU");
});

test("have POSIX style", function (): void {
    expect(Standard::POSIX)->toEqual("POSIX");
});
