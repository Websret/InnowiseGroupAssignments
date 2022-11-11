<?php

namespace Application\Lib\Validation;

use Application\Repositories\ProductRepository;

class Validator
{
    private array $params;

    private string $errorMessage = '';

    private string $methodName;

    private string|null $argument = null;

    private ProductRepository $productRepository;

    public function __construct(array $params = [])
    {
        $this->params = $params;
        $this->productRepository = new ProductRepository();
    }

    public function validate(): bool
    {
        unset($_SESSION['data']);
        foreach ($this->params as $param => $implodedRules) {
            $rules = explode('|', $implodedRules);

            if (in_array('required', $rules)) {
                if (!$this->checkRequiredParam($param, $rules)) {
                    continue;
                }
            } else {
                if (!isset($_POST[$param])) continue;
            }

            $this->runRules($rules, $param);
        }
        return $this->isErrorsEmpty();
    }

    private function checkRequiredParam($param, &$rules): bool
    {
        unset($rules[array_search('required', $rules)]);
        if (!isset($_POST[$param])) {
            $this->errorMessage = "$param fields is required.";
            $this->createErrorSession($param);
            return false;
        }
        return true;
    }

    private function runRules(array $rules, string $param): void
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
        }
    }

    private function createErrorSession(string $param): void
    {
        if (isset($_SESSION['data']['errorMessage'][$param])) {
            $_SESSION['data']['errorMessage'][$param][] = $this->errorMessage;
        } else {
            $_SESSION['data']['errorMessage'][$param] = [$this->errorMessage];
        }
    }

    private function isErrorsEmpty(): bool
    {
        return empty($_SESSION['data']['errorMessage']);
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

    private function min(string $param, int $value = null): bool
    {
        if ($param < $value) {
            $this->errorMessage = "Your query must to be more " . $value . ".";
            return false;
        }
        return true;
    }

    private function minLength(string $param, int $value = null): bool
    {
        if (strlen($param) < $value) {
            $this->errorMessage = "Your string must to be length " . $value . ".";
            return false;
        }
        return true;
    }

    private function max(int $param, int $value): bool
    {
        if ($param > $value) {
            $this->errorMessage = "Your query must to be less " . $value . ".";
            return false;
        }
        return true;
    }

    private function maxLength(string $param, int $value = null): bool
    {
        if (strlen($param) > $value) {
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

    private function onlyInt(int $param): bool
    {
        if (!preg_match('/^[0-9]+$/', $param)) {
            $this->errorMessage = "Your query must contain only numbers.";
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

    private function isEqualTo(string $param, string $value): bool
    {
        if ($param != $value) {
            $this->errorMessage = "Fields are not equal.";
            return false;
        }
        return true;
    }

    private function getMethodProduct(string $param): array
    {
        return $this->productRepository->getProduct($param);
    }

    private function productExist(int $param, string $value): bool
    {
        $row = $this->getMethodProduct($param);

        if (empty($row)) {
            $this->errorMessage = "Resource not found.";
            return false;
        }
        return true;
    }

    private function getMethodFindProduct(string $param, string $value): array
    {
        $data = explode(',', $value);
        $dbField = $data[1];
        $model = new $data[0];
        return $model
            ->select('products.id', 'name', 'manufactures', 'release_date', 'cost', 'type_name')
            ->join('product_types', 'product_types.id', '=', 'products.product_type')
            ->where('name = :name')
            ->get([$dbField => $param]);
    }

    private function findProduct(string $param, string $value): bool
    {
        $row = $this->getMethodFindProduct($param, $value);

        if (!empty($row)) {
            $this->errorMessage = "This product exist.";
            return false;
        }
        return true;
    }

    private function getMethodService(array $params): array
    {
        return $this->productRepository->getAllServices($params[2]);
    }

    private function productServiceExist(int $param, string $value): bool
    {
        $params = explode('/',$_SERVER['REQUEST_URI']);
        $row = $this->getMethodService($params);

        $findKey = --$param;
        if (!array_key_exists($findKey, $row)) {
            $this->errorMessage = "Service not found.";
            return false;
        }
        return true;
    }

    private function serviceExist(string $param): bool
    {
        if ($param == 0) {
            $this->errorMessage = "Service not found.";
            return false;
        }
        return true;
    }
}
