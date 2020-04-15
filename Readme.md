# A simple MVC PSR framework.

Available mechanisms:

- Router
- Repository pattern (inMemory)
- Support for Twig templating

In this readme I show how to add routes and a controller for creating a blog.

## Installation

- Composer should be installed on your system
- From the root directory type `composer install`

This framework uses several packages and it is required to have a couple of
folders in place to store cache:

From the root directory, you need to add the following folders
- `../var/cache` 
- `../var/twigcache`

Both folders need to have write permissions (e.g. 775). 

### How to add a route

Let's suppose that we want to create a system for blogs. First we need to define routes.

When we want to have an overview of blogs, obviously we want the following URI: `/blogs` 

And to view a specific blog `/blogs/{id}`

We need to define the routes in /routes/web.php:

```php
return [
    'blog' => 'BlogController@index',
    'blog/{id}' => 'BlogController@item',
];
```

Great! Now we have routes defined, now what? We need to create a BlogController.

### How to add a BlogController

1. Add a new `Blog` folder in the `App` folder.
2. Add a new `Controller` folder to the `App\Blog` folder
3. Add a new `BlogController.php` to the `App\Blog\Controller` folder 
4. Extend the `BlogController` with `CoreController` like this: `class BlogController extends CoreController`
5. Add the methods `index()` and `item()` to the `BlogController`

Great success! Now you successfully have a working PHP script using a simple router and adding a controller.

For an example of how to use the BlogRepository, take a look at `App\Blog\Controller\BlogController::index()`. 

### How to show the view

This framework comes with Twig 3.0. All templates are hosted in the root /views.

If you would like to define your own paths where Twig should look for views, the configuration is stored here:
`App\Core\Resource\twig\paths.php`:

As you can see, there already is a template created for you: `/views/blog/index.html.twig`.

This template is called by the BlogController:
```php
try {
    $blog = $repository->findById($blogId);
    return View::render('blog/index.html.view', compact('blog'));
} catch (OutOfBoundsException $e) {
    echo $e->getMessage();
}
```
