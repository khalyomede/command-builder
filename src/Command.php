<?php

namespace Khalyomede\CommandBuilder;

final class Command
{
    private string $executable;

    private string $style;

    /**
     * @var array<Element>
     */
    private array $elements;

    public function __construct(string $executable, string $style = Standard::GNU)
    {
        $this->elements = [];
        $this->executable = $executable;
        $this->style = $style;
    }

    public function __toString()
    {
        return $this->executable . (count($this->elements) === 0 ? "" : " " . implode(" ", $this->elements));
    }

    public function argument(string $value): self
    {
        $this->elements[] = new Element($this->style, ElementType::ARGUMENT, "", $value);

        return $this;
    }

    public function argumentCount(): int
    {
        return count(array_filter($this->elements, fn (Element $element): bool => $element->isArgument()));
    }

    public function option(string $name, string $value): self
    {
        $this->elements[] = new Element($this->style, ElementType::OPTION, $name, $value);

        return $this;
    }

    public function longOption(string $name, string $value): self
    {
        $this->elements[] = (new Element($this->style, ElementType::OPTION, $name, $value))->long();

        return $this;
    }

    public function hasOption(string $short, string $long): bool
    {
        return count(array_filter($this->elements, fn (Element $element): bool => $element->isOption() && in_array($element->name(), [$short, $long], true))) === 1;
    }

    public function optionCount(): int
    {
        return count(array_filter($this->elements, fn (Element $element): bool => $element->isOption()));
    }

    public function flag(string $name): self
    {
        $this->elements[] = new Element($this->style, ElementType::FLAG, $name, "");

        return $this;
    }

    public function longFlag(string $name): self
    {
        $this->elements[] = (new Element($this->style, ElementType::FLAG, $name, ""))->long();

        return $this;
    }

    public function hasFlag(string $short, string $long): bool
    {
        return count(array_filter($this->elements, fn (Element $element): bool => $element->isFlag() && in_array($element->name(), [$short, $long], true))) === 1;
    }

    public function flagCount(): int
    {
        return count(array_filter($this->elements, fn (Element $element): bool => $element->isFlag()));
    }
}
