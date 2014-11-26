<?php
namespace Mentordeveloper\Authentication\Middleware\Interfaces;

interface ConfigRepositoryInterface {
    public function setOption($key, $value);

    public function getOption($key);
}