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

use Hyperf\Permission\Annotation\Permission;
use Hyperf\Permission\Authorization;
use Hyperf\Permission\Exception\PermissionException;
use Hyperf\Di\Annotation\Aspect;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Di\Aop\AbstractAspect;
use Hyperf\Di\Aop\ProceedingJoinPoint;


#[Aspect]
class PermissionAspect extends AbstractAspect
{
    public $annotations = [
        Permission::class,
    ];

    #[Inject]
    protected Authorization $authorization;

    public function process(ProceedingJoinPoint $proceedingJoinPoint)
    {
        $annotationMetadata = $proceedingJoinPoint->getAnnotationMetadata();
        /** @var Permission $permission */
        $permission = $annotationMetadata->method[Permission::class] ?? $annotationMetadata->class[Permission::class];
        if (! $this->authorization->isAuthorized($permission)) {
            throw new PermissionException(sprintf('Calling %s::%s requires token "%s"', $proceedingJoinPoint->className, $proceedingJoinPoint->methodName, $permission->token));
        }
        return $proceedingJoinPoint->process();
    }
}
