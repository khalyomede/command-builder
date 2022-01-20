<?php

namespace CommandBuilder;

use Exception;

final class Element
{
    private string $standard;

    private string $elementType;

    private string $name;

    private string $value;

    private bool $long;

    public function __construct(string $standard, string $elementType, string $name, string $value)
    {
        $this->standard = $standard;
        $this->elementType = $elementType;
        $this->name = $name;
        $this->value = $value;
        $this->long = false;
    }

    public function __toString()
    {
        if ($this->elementType === ElementType::ARGUMENT) {
            return $this->value;
        }

        if ($this->elementType === ElementType::FLAG) {
            return ($this->long ? "--" : "-") . $this->name;
        }

        if ($this->elementType === ElementType::OPTION) {
            return ($this->long ? "--" : "-") . $this->name . ($this->standard === Standard::GNU ? "=" : " ") . $this->getValue();
        }

        throw new Exception("Unknown element type {$this->elementType}.");
    }

    public function isArgument(): bool
    {
        return $this->elementType === ElementType::ARGUMENT;
    }

    public function isFlag(): bool
    {
        return $this->elementType === ElementType::FLAG;
    }

    public function isOption(): bool
    {
        return $this->elementType === ElementType::OPTION;
    }

    public function long(): self
    {
        $this->long = true;

        return $this;
    }

    public function name(): string
    {
        return $this->name;
    }

    private function getValue(): string
    {
        if ($this->valueContainsDoubleQuotes()) {
            return $this->getDoubleQuoteEscapedValue();
        } elseif ($this->valueContainsSpace()) {
            return $this->getSpaceEscapedValue();
        } else {
            return $this->value;
        }
    }

    private function valueContainsSpace(): bool
    {
        return str_contains($this->value, ' ');
    }

    private function valueContainsDoubleQuotes(): bool
    {
        return str_contains($this->value, '"');
    }

    private function getSpaceEscapedValue(): string
    {
        return '"' . $this->value . '"';
    }

    private function getDoubleQuoteEscapedValue(): string
    {
        return '"' . str_replace('"', '\\"', $this->value) . '"';
    }
}
