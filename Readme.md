# A simple MVC PSR framework.

Available mechanisms:

- Router
- Repository pattern (inMemory)

In this readme I show how to add routes and a controller for creating a blog.

### How to add a route:

Let's suppose that we want to create a system for blogs, the first part we need to define the routes.

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

1. Add a new `Blog` folder in the `App` folder.
2. Add a new `Controller` folder to the `App\Blog` folder
3. Add a new `BlogController.php` to the `App\Blog\Controller` folder 
4. Extend the `BlogController` with `CoreController` like this: `class BlogController extends CoreController`
5. Add the methods `index()` and `item()` to the `BlogController`

Great success! Now you successfully have a working PHP script using a simple router and adding a controller.

For an example of how to use the BlogRepository, take a look at `App\Blog\Controller\BlogController::index()`. 
