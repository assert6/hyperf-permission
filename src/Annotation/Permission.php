<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */
namespace Hyperf\Permission\Annotation;

use Hyperf\Di\Annotation\AbstractAnnotation;

/**
 * @Annotation
 * @Target({"CLASS", "METHOD"})
 */
class Permission extends AbstractAnnotation
{
    /**
     * @var string
     */
    public $token;

    public function __construct($value = null)
    {
        parent::__construct($value);
        $this->bindMainProperty('token', $value);
    }

    public function collectClass(string $className): void
    {
        $this->token = $this->token ?? $className;
        parent::collectClass($className);
    }

    public function collectMethod(string $className, ?string $target): void
    {
        $this->token = $this->token ?? "{$className}::{$target}";
        parent::collectMethod($className, $target);
    }
}
