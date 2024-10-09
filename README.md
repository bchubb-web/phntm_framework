# phntm
A lightweight framework designed to feel like magic; blending aspects of laravel and nextjs for the best developer experience.

## Installation

To create a phntm project, you can use the composer create-project command
```bash
composer create-project bchubbweb/phntm_framework myproject
```

## Setup

Phntm uses docker to run the application, so you will need to have docker installed on your machine.

To get started locally, you need to create a .env file in the root of your project, and set the DEP_ENV variable to local.
You can also copy .env.example to .env which already has some configuration set up.

### Build the image
```bash
docker build -t myproject .
```

### And run the container
```bash
docker run -p 8080:80 -e DEP_ENV={local|staging|production} myproject
```

## Routing

Routing within phntm is done using PSR-0 namespaces, so the directory structure of your pages directory will be used to determine a given route, and is handled by the router using its namespace thanks to the composer autoloader.

the below diagram shows the default directory structure for a new phntm project.
```
pages/
├── Page.php
├── view.twig
└── User/
    └── Id/
        ├── Page.php
        └── view.twig
```

The above structure would allow you to access the index page at /, and what looks like /user/id, but this is actually a dynamic route, and the id is a parameter that can be accessed in the page class, which we will cover later. but that means you can access pages like /user/1 or /user/24

Directories without a Page.php file are not registered as routes, and are not reachable.

## Pages

As a Page.php within the pages directory allows that route to become reachable, the view.twig file will be used to render any content for that page.


Lets look at how to add an /about page

pages/About/Page.php
```php
<?php

namespace Pages\About;

use Bchubbweb\PhntmFramework\Pages\AbstractPage;
use Symfony\Component\HttpFoundation\Request;

class Page extends AbstractPage
{
    protected function preRender(Request $request): void
    {
        $this->title('About');

        $this->renderWith([
            'access_time' => date('Y-m-d H:i:s'),
        ]);
    }
}
```

Lets break down the above code
 - The namespace is used to determine the route, so this page will be accessible at /about
 - The Page class extends AbstractPage, which is a base class that provides some helper methods for rendering the page.
 - We write our code in the preRender method, which allows the page to be rendered with the data we provide.
 - The title method is used to set the title tag in the head of the page.
 - To pass data to our view we use renderWith(); which takes an array of data to be passed to the view, this call merges the data with any other previously set data, allowing you to overwrite or add to the data.

pages/About/view.twig
```twig
<h1>About</h1>
<p>This is the about page.</p>
<p>Accessed at: {{ access_time }}</p>
```

which will render the following html
```html
<!DOCTYPE html>
<html>
    <head>
        <title>About</title>
    </head>
    <body class="">
        <h1>About</h1>
        <p>This is the about page.</p>
        <p>Accessed at: 2024-01-01 00:00:00</p>
    </body>
</html>
```

note the empty class attribute on the body tag, there are methods to add classes to the body tag, but this is not covered here.

## The document

As you may have noticed, when creating the /about page, we never wrote the boilerplate html like the doctype, head, and body tags, this is because phntm wraps a pages view in a document template, which is located at /phntm/View/Document.twig, here you can see how data is inserted into the template.
