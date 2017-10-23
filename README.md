<!--h-->
# Menu Manager
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/3f2ff01a8dc04044a13c6f4fbb9e21bd)](https://www.codacy.com/app/laravel-enso/MenuManager?utm_source=github.com&utm_medium=referral&utm_content=laravel-enso/MenuManager&utm_campaign=badger)
[![StyleCI](https://styleci.io/repos/94800927/shield?branch=master)](https://styleci.io/repos/94800927)
[![License](https://poser.pugx.org/laravel-enso/menumanager/license)](https://https://packagist.org/packages/laravel-enso/menumanager)
[![Total Downloads](https://poser.pugx.org/laravel-enso/menumanager/downloads)](https://packagist.org/packages/laravel-enso/menumanager)
[![Latest Stable Version](https://poser.pugx.org/laravel-enso/menumanager/version)](https://packagist.org/packages/laravel-enso/menumanager)
<!--/h-->

Menu Manager dependency for [Laravel Enso](https://github.com/laravel-enso/Enso)

[![Screenshot](https://laravel-enso.github.io/menumanager/screenshots/Selection_027_thumb.png)](https://laravel-enso.github.io/menumanager/screenshots/Selection_027.png)

[![Watch the demo](https://laravel-enso.github.io/menumanager/screenshots/Selection_012_thumb.png)](https://laravel-enso.github.io/menumanager/videos/menu_reorder.webm)

<sup>click on the photo to view a short demo in compatible browsers</sup>

### Features

- allow for the easy management of the main (sidebar) menus of the application
- permits the creation, update, delete, ordering of the menus

### Under the Hood

- a menu element may have several roles attached and is rendered only for the users with the respective roles
- menu element attributes:
  - `parent_id`: the id of its parent menu, if he has a parent, or null
  - `name`: the label that is translated and visible in the UI
  - `icon`: the icon classes, visible in the UI
  - `order`: used for ordering the elements of the menu in the desired sequence
  - `link`: is the link that's going to be accessed when clicking on the menu
  - `has_children`: is a flag telling us if a menu element has children and is used when rendering the menu

### Publishes

- `php artisan vendor:publish --tag=menus-assets` - the VueJS pages and components
- `php artisan vendor:publish --tag=enso-assets` - a common alias for when wanting to update the VueJS assets,
once a newer version is released, can be used with the `--force` flag

### Notes

The [Laravel Enso Core](https://github.com/laravel-enso/Core) package comes with this package included.

Depends on:
 - [Core](https://github.com/laravel-enso/Core) for middleware
 - [Datatable](https://github.com/laravel-enso/Datatable) for displaying the list of menus 
 - [DbSyncMigrations](https://github.com/laravel-enso/DbSyncMigrations) for offering the possibility to generate migrations for the changes you make locally
 - [FormBuilder](https://github.com/laravel-enso/FormBuilder) for creating the forms when managing languages 
 - [Helpers](https://github.com/laravel-enso/Helpers) for timestamp formatting 
 - [RoleManager](https://github.com/laravel-enso/RoleManager) for the integration with the roles system 
 - [Structure manager](https://github.com/laravel-enso/StructureManager) for the migrations

<!--h-->
### Contributions

are welcome. Pull requests are great, but issues are good too.

### License

This package is released under the MIT license.
<!--/h-->