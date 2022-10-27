<?php

namespace Application\Lib;

class Validator implements TwigImplementer
{
    private array $params;

    private string $errorMessage = '';

    private string $methodName;

    private string|null $argument = null;

    public function __construct(array $params = [])
    {
        $this->params = $params;
    }

    public function validate(): bool
    {
        unset($_SESSION['user']);
        foreach ($this->params as $param => $implodedRules) {
            $rules = explode('|', $implodedRules);
            $this->getRule($rules, $param);
        }
        return $this->isEmptySession();
    }

    private function getRule(array $rules, string $param): void
    {
        foreach ($rules as $rule) {
            $this->methodName = $rule;
            $this->getMethodAndArgument($rule);
            $this->callMethodAndCheckValid($param);
        }
    }

    private function getMethodAndArgument(string $rule): void
    {
        if (str_contains($rule, ':')) {
            $methodData = explode(':', $rule);
            $this->methodName = $methodData[0];
            $this->argument = $methodData[1];
        }
    }

    private function callMethodAndCheckValid(string $param): void
    {
        $methodName = $this->methodName;
        $isValid = self::$methodName($_POST[$param], $this->argument);

        if (!$isValid) {
            $this->createErrorSession($param);
            unset($_SESSION['user']['correctField'][$param]);
        } else {
            $this->createSuccessSession($param);
        }
    }

    private function createErrorSession(string $param): void
    {
        if (is_array($_SESSION['user']['errorMessage'][$param])) {
            $_SESSION['user']['errorMessage'][$param][] = $this->errorMessage;
        } else {
            $_SESSION['user']['errorMessage'][$param] = [$this->errorMessage];
        }
    }

    private function createSuccessSession(string $param): void
    {
        if (is_array($_SESSION['user']['correctField'][$param])) {
            $_SESSION['user']['correctField'][$param][] = $_POST[$param];
        } else {
            $_SESSION['user']['correctField'][$param] = [$_POST[$param]];
        }
    }

    private function isEmptySession(): bool
    {
        return empty($_SESSION['user']);
    }

    private function upperCase(string $param, int $value = null): bool
    {
        if ((preg_match_all('/[A-Z]/', $param)) < $value) {
            $this->errorMessage = "Your string must contain " . $value . " uppercase character.";
            return false;
        }
        return true;
    }

    private function lowerCase(string $param, int $value = null): bool
    {
        if ((preg_match_all('/[a-z]/', $param)) < $value) {
            $this->errorMessage = "Your string must contain " . $value . " lowercase character.";
            return false;
        }
        return true;
    }

    private function checkDigit(string $param, int $value = null): bool
    {
        if ((preg_match_all('/[0-9]/', $param)) < $value) {
            $this->errorMessage = "Your string must contain " . $value . " digit character.";
            return false;
        }
        return true;
    }

    private function specialCharacter(string $param, int $value = null): bool
    {
        if ((preg_match_all("/[\[^\'£$%^&*()}{@:\'#~?><>,;@\|\-_+\-¬\`\]]/", $param)) < $value) {
            $this->errorMessage = "Your string must contain " . $value . " special character.";
            return false;
        }
        return true;
    }

    private function length(string $param, int $value = null): bool
    {
        if (strlen($param) < $value) {
            $this->errorMessage = "Your string must to be length " . $value . ".";
            return false;
        }
        return true;
    }

    private function onlyString(string $param): bool
    {
        if (!preg_match('/^[A-z]*$/', $param)) {
            $this->errorMessage = "Your string must contain only letters.";
            return false;
        }
        return true;
    }

    private function isEmail(string $param): bool
    {
        if (!filter_var($param, FILTER_VALIDATE_EMAIL)) {
            $this->errorMessage = "Your email is not correct.";
            return false;
        }
        return true;
    }

    private function emailExist(string $param, string $value): bool
    {
        if ($value > 0) {
            $this->errorMessage = "This email is already in use.";
            return false;
        }
        return true;
    }

    private function isEqualTo(string $param, string $value): bool
    {
        if ($param != $value) {
            $this->errorMessage = "Fields are not equal.";
            return false;
        }
        return true;
    }

    public function addFunctions(&$twig)
    {
        $twig->addGlobal('session', $_SESSION);
    }
}
