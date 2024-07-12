<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Ajax-crud-laravel-10
  Ajax operations in laravel needs csrf token added to header when sending request because laravel validates csrf-token for every route.

# Steps : 

1. If you want to use ajax you need csrf token : you can add csrf token in your `<meta>` tag in `<head>` section and use it later
    ```html
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    ```
    Example : 
    ```html
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <title>Document</title>
        <!-- other imports -->
    </head>
    ```

2. Usage - 
    
    ## with Fetch API : 
    - first get the token from meta tag
    ```js
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    ```
    - then set the csrf token into header of your request
    ```js
    fetch('/your-endpoint', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'x-csrf-token': csrfToken
        },
        body: JSON.stringify({ key: 'value' })
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
    })
    .catch(error => {
        console.error('Error:', error);
    });
    ```

    ## with XMLHttpRequest : 
     - first get the token from meta tag
    ```js
   const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    ```
    - then set the csrf token into header of your request
    ```js
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "/your-endpoint", true);
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.setRequestHeader("x-csrf-token", csrfToken);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log(xhr.responseText);
        }
    };

    const data = JSON.stringify({ key: 'value' });
    xhr.send(data);
    ```

    ## with JQuery : 
    while using jquery it will add the `csrf-token` on header at once using `ajaxSetup` function. you don't need to add the `csrf-token` in every ajax call 
     - first get the token from meta tag
    ```js
   const csrfToken = $('meta[name="csrf-token"]').attr('content');
    ```
    - then set the csrf token into header of your request
    ```js
     $.ajaxSetup({
        headers: {
            'x-csrf-token': csrfToken 
        }
    });

    $.ajax({
        url: '/your-endpoint',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({ key: 'value' }),
        success: function(response) {
            console.log(response);
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    }); 
    ```

3. Other stuff like routes, controller, model, migrations are non-changed (same)

4. Done...

# Installation
 If you are downloading this repo - here are step to follow
- run the command `composer install` to install all vendor libraries
- create mysql database named `ajax-crud-laravel-10` 
- run migrations by running command `php artisan migrate`
- run the application `php artisan serve`

<br />
<p align="center">⭐️ Star my repositories if you find it helpful.</p>
