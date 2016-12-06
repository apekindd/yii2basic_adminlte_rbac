Yii 2 Basic with AdminLTE and rbac
===============================
```
composer self-update
composer update
```

```
yii migrate
```

rbac
```
php yii migrate --migrationPath=@yii/rbac/migrations/
```
How to use
```
Yii::$app->user->can('nameOfPermission')
```