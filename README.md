php artisan module:update
php artisan migrate

`admins` routes prefix required, works best with `inspania` theme, minimum `bootstrap 4` required

# Config
For Congifuration you can fire
- `php artisan vendor:publish` and select appropriate option which will generate file named `config/rightsmanagement.php` with variables
- You can generate file manually at `config/rightsmanagement.php` here are the list of
```
<?php
    return [
        'name' => 'RightsManagement',
        'routePrefix' => 'admins', // no trailing slash required
        'authGuard' => 'admin',
        'layoutIncludes' => 'admin.include' // no trailing fullstop required
    ];
```

# In Your Admin Model
please add `use HasRoles;` to your model
```
use Spatie\Permission\Traits\HasRoles;
class Admin extends Authenticatable
{
    use HasRoles;
```


# For Dev of this package

for versioning
replace `X` with next version
`git tag vX.X.X`
`git push origin vX.X.X`