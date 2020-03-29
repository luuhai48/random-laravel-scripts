# random-laravel-scripts
Some random scripts for laravel

### Created by [luuhai48](https://github.com/luuhai48)

### Website [luuviethai.com](https://luuviethai.com)

# File list
|     | File name      | Description                          | Instruction                                            |
|:---:|----------------|--------------------------------------|--------------------------------------------------------|
|  1  | MakeModule.php | Create scaffolding module for Laravel| - Put the file into the app/Console/Commands direcotry<br> - Add "Modules\\": "modules/" to composer.json, in autoload -> psr-4, then run composer dump-autoload<br> - Run the command: php artisan module:make Module_name<br> - Register the generated ModuleServiceProvider file in config/app.php |
