<?php

namespace src;

class Task8
{
    public function main(string $js): string
    {
        if (!$this->isJson($js)) {
            throw new \InvalidArgumentException();
        }
        $arr = json_decode($js);
        if ($arr != null) {
            return sprintf(
                "Title: %s\r\nAuthor: %s\r\nPublisher: %s",
                $arr->Title,
                $arr->Author,
                $arr->Detail->Publisher
            );
        } else {
            throw new \InvalidArgumentException();
        }
    }

    public function isJson($string): bool
    {
        return is_string($string) && is_array(json_decode($string, true)) ? true : false;
    }
}
