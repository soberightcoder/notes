# composer

>仓库 ：https://packagist.org/packages/laravel/laravel
>
>packagist 包装师
>
>

---

## 修改为国内的镜像！！！

```bash
composer config -g repo.packagist composer https://packagist.phpcomposer.com
```

---

## composer.json

`````php
{
    "name": "laravel/laravel",
    "description": "The Laravel Framework.",
    "keywords": ["framework", "laravel"],
    "license": "MIT",
    "type": "project",
    "require": {
        "php": ">=5.5.9",
        "laravel/framework": "5.2.*"
    },
    "config": {
        "preferred-install": "dist"
    },
    "repositories": {
        "packagist": {
            "type": "composer",
            "url": "https://packagist.phpcomposer.com"
        }
    }
}
`````





## laravel8的实际操作！！！

---

