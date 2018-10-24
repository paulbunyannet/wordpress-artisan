<?php

namespace Pbc\WordpressArtisan;


class Helpers
{

    /**
     * Get a language key using the class name as a base for the translation file
     * @param $class
     * @param $key
     * @param array $params
     * @return string|\Symfony\Component\Translation\TranslatorInterface
     */
    public static function getLang($class, $key, $params = [])
    {
        return trans((strtolower(str_replace('\\', '/', $class) . '.' . $key)), $params);
    }

}