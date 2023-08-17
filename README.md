#调用权
```php
class Test
{
    #[Permission]
    public function test()
    {
        return [1111];
    }
}
```
```php
class TestController
{
    #[Inject]
    protected Test $test;

    #[Authorize('App\Test::test')]
    public function test()
    {
        // Authorization::authorize('App\Test::test');
        return $this->test->test();
    }
}
```
> 当调用`#[Permission]`声明的代码时, 需要`#[Authorize]`或`Authorization::authorize()`授权, 否则抛`PermissionException`