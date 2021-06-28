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
namespace Hyperf\Permission;

use Hyperf\Permission\Annotation\Permission;
use Hyperf\Utils\Traits\Container;

class Authorization
{
    use Container;

    public static function authorize(string $token)
    {
        self::set($token, true);
    }

    public function isAuthorized(Permission $permission): bool
    {
        return self::get($permission->token, false);
    }
}
