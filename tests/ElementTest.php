<?php

use CommandBuilder\Element;
use CommandBuilder\Standard;

test("throws an exception if the element type is unknown", function (): void {
    expect(fn (): string => (string) new Element(Standard::GNU, "foo", "", "", false))
        ->toThrow(Exception::class, "Unknown element type foo.");
});
