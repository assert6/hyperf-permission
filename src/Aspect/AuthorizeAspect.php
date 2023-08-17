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
namespace Hyperf\Permission\Aspect;

use Hyperf\Di\Annotation\Aspect;
use Hyperf\Di\Aop\AbstractAspect;
use Hyperf\Di\Aop\ProceedingJoinPoint;
use Hyperf\Permission\Annotation\Authorize;
use Hyperf\Permission\Authorization;

#[Aspect]
class AuthorizeAspect extends AbstractAspect
{
    public array $annotations = [
        Authorize::class,
    ];

    public function process(ProceedingJoinPoint $proceedingJoinPoint)
    {
        $annotationMetadata = $proceedingJoinPoint->getAnnotationMetadata();
        /** @var Authorize $authorize */
        $authorize = $annotationMetadata->method[Authorize::class] ?? $annotationMetadata->class[Authorize::class];
        Authorization::set($authorize->token, true);
        try {
            return $proceedingJoinPoint->process();
        } finally {
            Authorization::set($authorize->token, false);
        }
    }
}