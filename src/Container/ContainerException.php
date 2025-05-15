<?php

namespace SlimCore\Container;
use RuntimeException;
use Psr\Container\ContainerExceptionInterface;

class ContainerException extends RuntimeException implements ContainerExceptionInterface
{
}