# Menu Manager
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/3f2ff01a8dc04044a13c6f4fbb9e21bd)](https://www.codacy.com/app/laravel-enso/MenuManager?utm_source=github.com&utm_medium=referral&utm_content=laravel-enso/MenuManager&utm_campaign=badger)
[![StyleCI](https://styleci.io/repos/94800927/shield?branch=master)](https://styleci.io/repos/94800927)
[![Total Downloads](https://poser.pugx.org/laravel-enso/menumanager/downloads)](https://packagist.org/packages/laravel-enso/menumanager)
[![Latest Stable Version](https://poser.pugx.org/laravel-enso/menumanager/version)](https://packagist.org/packages/laravel-enso/menumanager)

Menu Manager dependency for [Laravel Enso](https://github.com/laravel-enso/Enso)

![Screenshot](https://laravel-enso.github.io/menumanager/screenshots/Selection_027.png)

[![Watch the demo](https://laravel-enso.github.io/menumanager/screenshots/Selection_012.png)](https://laravel-enso.github.io/menumanager/videos/menu_reorder.webm)

<sup>click on the photo to view a short demo in compatible browsers</sup>
### Details

- allow for the easy management of the main (sidebar) menus of the application
- permits the creation, update, delete, reordering of the menus
- comes with a VueJS component that offers the capability to reorder menus through drag-and-drop
- offers the functionality to automatically generate breadcrumbs based on the current route

### Publishes

- `php artisan vendor:publish --tag=menus-component` - the VueJS component
- `php artisan vendor:publish --tag=enso-update` - a common alias for when wanting to update the VueJS component, 
once a newer version is released

### Contributions

are welcome