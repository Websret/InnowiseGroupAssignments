<?php

namespace Application\Lib;

class Validator implements TwigImplementer
{
    private array $params;

    private string $errorMessage = '';

    public function __construct(array $params = [])
    {
        $this->params = $params;
    }

    public function validate(): bool
    {
        unset($_SESSION['user']);
        foreach ($this->params as $param => $implodedRules) {
            $rules = explode('|', $implodedRules);

            foreach ($rules as $rule) {
                $methodName = $rule;
                $argument = null;

                if (str_contains($rule, ':')) {
                    $methodData = explode(':', $rule);
                    $methodName = $methodData[0];
                    $argument = $methodData[1];
                }

                $isValid = self::$methodName($_POST[$param], $argument);

                if (!$isValid) {
                    if (is_array($_SESSION['user']['errorMessage'][$param])) {
                        $_SESSION['user']['errorMessage'][$param][] = $this->errorMessage;
                    } else {
                        $_SESSION['user']['errorMessage'][$param] = [$this->errorMessage];
                    }
                }
            }
        }

        return $this->isEmptySession();
    }

    private function isEmptySession(): bool
    {
        if (empty($_SESSION['user'])){
            return true;
        }
        return false;
    }

    private function upperCase($param, $value = null): bool
    {
        if ((preg_match_all('/[A-Z]/', $param)) < $value) {
            $this->errorMessage = "Your string must contain " . $value . " uppercase character.";
            return false;
        }
        return true;
    }

    private function lowerCase($param, $value = null): bool
    {
        if ((preg_match_all('/[a-z]/', $param)) < $value) {
            $this->errorMessage = "Your string must contain " . $value . " lowercase character.";
            return false;
        }
        return true;
    }

    private function checkDigit($param, $value = null): bool
    {
        if ((preg_match_all('/[0-9]/', $param)) < $value) {
            $this->errorMessage = "Your string must contain " . $value . " digit character.";
            return false;
        }
        return true;
    }

    private function specialCharacter($param, $value = null): bool
    {
        if ((preg_match_all("/[\[^\'£$%^&*()}{@:\'#~?><>,;@\|\-_+\-¬\`\]]/", $param)) < $value) {
            $this->errorMessage = "Your string must contain " . $value . " special character.";
            return false;
        }
        return true;
    }

    private function length($param, $value = null): bool
    {
        if (strlen($param) < $value) {
            $this->errorMessage = "Your string must to be length " . $value . ".";
            return false;
        }
        return true;
    }

    private function onlyString($param): bool
    {
        if (!preg_match('/[A-z]/', $param)) {
            $this->errorMessage = "Your string must contain only letters.";
            return false;
        }
        return true;
    }

    private function isEmail($param): bool
    {
        if (!filter_var($param, FILTER_VALIDATE_EMAIL)){
            $this->errorMessage = "Your email is not correct.";
            return false;
        }
        return true;
    }

    private function emailExist($param, $value): bool
    {
        if ($value > 0){
            $this->errorMessage = "This email is already in use.";
            return false;
        }
        return true;
    }

    private function isEqualTo($param, $value): bool
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
