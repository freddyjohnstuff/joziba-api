<p align="center">
    <a href="https://joziba.online/site/doc" target="_blank">
        <img src="https://dummyimage.com/60x40/fff/000.png&text=JZ" height="40px">
    </a>
    <h1 align="center">API Documentation</h1>
    <br>
</p>

Main models(will be transforms to endpoints)


ENTITY LIST
-------------------

      Ads                 main ad entity
      AdsStatus           ad type
      GoodsCategory       Good-Category
      controllers/        contains Web controller classes
      mail/               contains view files for e-mails
      models/             contains model classes
      runtime/            contains files generated during runtime
      tests/              contains various tests for the basic application
      vendor/             contains dependent 3rd-party packages
      views/              contains view files for the Web application
      web/                contains the entry script and Web resources



SING UP
------------
Send data py post to endpoint `/api/v1/sign-up`.

      POST /api/v1/sign-up
      body:
         email: mymail@domain.zone
         phone: +992981002030
         password1: {Upercase+lowercase+digits,8+ char}
         password2: {repeat of password1}

response [success]:

      {
         "code": 200,
         "data": {
            "message": "Client created"
         },
         "request": {
            "email": "mymail3@mail.ru",
            "phone": "+7666543266",
            "password1": "SXXsxx123!@#",
            "password2": "SXXsxx123!@#"
         }
      }
      
response [error]:
[on singing up with existing email or phone]
      
      {
      "message": "Something went wrong, Try again!"
      }

response [error]:
[on password validation]

      {
         "request": {
            "password1": "Password1 must be equal to \"Password2\"."
         }
      }

      {
         "request": {
            "password1": "Incorrect password(Uppercase, lowercase, digits, 8 symbols)"
         }
      }

response [error]:
[on skipping fields]

      {
         "request": {
            "email": "Email cannot be blank.",
            "phone": "Phone cannot be blank.",
            "password1": "Password1 cannot be blank.",
            "password2": "Password2 cannot be blank."
         }
      }


SING IN
------------
Send data py post to endpoint `/api/v1/sign-in`.


      POST /api/v1/sign-in
      body:
         email: mymail@domain.zone
         password: {Saved password on singing up}

response [success]:
[JWT-tokens]

      {
         "access": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ0b2tlbiI6ImJmNzBmMzAwZTU5MDU4ZjU5ZjkxYjgwYzE3MjY0MjY2YmM2ZjNkOGYiLCJleHAiOjE3MDgzOTY1Nzh9.wMU1Wo41OVPFrakgrQDPnkTBNeuudwk08AtrBt9ZGGk",
         "refresh": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ0b2tlbiI6IjA5NzYxNjA5NGIwOWU1ZDYyN2I2ZmY0ZmI1OTkwZWFjYzNmNmUxYTYiLCJleHAiOjE3MDgzOTY1Nzh9.LSDV1olcsX2Do21GjOdQ5oGdoF7m09fZ9SLJY-Epr4M"
      }

response [error]:

      {
         "request": {
            "password": "Incorrect username or password."
         }
      }


response [error]:
[on skipping fields]

      {
         "request": {
            "email": "Email cannot be blank.",
            "password": "Password cannot be blank."
         }
      }


LOG OUT 
-----------
Send post request to endpoint `/api/v1/log-out`
[with X-API-KEY In header]

      POST /api/v1/log-out

response [success]: 

      {
         "message": "Log Out successfully!"
      }

response [error]:

      {
         "message": "Something went wrong!"
      }



RENEW
-----------
Send post request to endpoint `/api/v1/renew` with X-RENEW-KEY in header

      POST /api/v1/renew

response [success]:

      {
         "access": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ0b2tlbiI6IjNiNTgzYWUwMmFiNzgwOGI5MTE1Y2ZhNGZlZmYxOWExYTFmNmE5ZDIiLCJleHAiOjE3MDg0MDI4NzV9.H1vDugUtoMyi3ULytzS041sDre8VIcp9gE7n4VBq7AA",
         "refresh": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ0b2tlbiI6ImRjNjMxOGYzNzBiY2FhM2IzYjFlYjhlNWUxODdiZTRjYTE5MGQ0ZGQiLCJleHAiOjE3MDg0MDI4NzV9.vivSZgHOmzBRZgfMkw9tfhR5KOs-k3pwm4_OCOO_duk"
      }

response [error]:

      {
         "message": "Some field sending incorrect"
      }

      {
         "message": "Refresh token expired!"
      }
      
      



RESET PASSWORD
------------

Send post request to endpoint `/api/v1/reset` with email in payload

      POST /api/v1/reset
      body:
         email: mymail@domain.zone


response [success]:

      {
          "message": "Message sent!"
      }

response [error]:

      {
         "message": "Some field sending incorrect"
      }

      {
         "message": "Something went wrong!"
      }


USER PROFILE DATA 
--------------

Get profile data

      GET /api/v1/my-data



      {
         "id": 2,
         "client_id": 6,
         "name": "Izzat Imon ibn Umar",
         "email": "dell@dell.com",
         "phone": "+15552046672"
      }


ADS Entity
------------

      GET /api/v1/ads
params:

   filters:

      filters:
         client_id:{number}
         status_id:{number}
         published:{boolean(true=1,false=0)}
         title:{string for filtering by condition LIKE}
         description:{string for filtering by condition LIKE}
         start_date:
         end_date:{publish_date beetwen this dates}

   orders:

      sort:
         -id|id
         -title|title


response:

      {
         "models": [
            {
               "id": 1,
               "client_id": 1,
               "status_id": 1,
               "published": 0,
               "title": "Goods of day!",
               "description": "Plumb for gas metrics.",
               "expired_date": "2024-03-09",
               "publish_date": "2024-02-08",
               "created_at": "2024-02-08 07:45:24",
               "updated_at": null,
               "expired_at": null
            },
            {
               "id": 2,
               "client_id": 6,
               "status_id": 1,
               "published": 1,
               "title": "Car at home Модгый",
               "description": "валододл тлд то отолт олт от о то т от т о то от от о",
               "expired_date": "2024-03-21",
               "publish_date": "2024-02-21",
               "created_at": "2024-02-21 09:57:03",
               "updated_at": null,
               "expired_at": null
            }
         ],
         "count": 2
      }


view one ads
      
      GET /api/v1/ads/{id} 

response [success]

      {
         "id": 1,
         "client_id": 1,
         "status_id": 1,
         "published": 0,
         "title": "Goods of day!",
         "description": "Plumb for gas metrics.",
         "expired_date": "2024-03-09",
         "publish_date": "2024-02-08",
         "created_at": "2024-02-08 07:45:24",
         "updated_at": null,
         "expired_at": null
      }

response [error]

      {
         "name": "Not Found",
         "message": "Object not found: 10",
         "code": 0,
         "status": 404,
         "type": "yii\\web\\NotFoundHttpException"
      }


create ads

      POST /api/v1/ads

payload [type=Raw/JSON]

      {
         "client_id": 1,
         "status_id": 1,
         "published": 0,
         "title": "Goods of day!",
         "description": "Plumb for gas metrics.",
         "expired_date": "2024-03-09",
         "publish_date": "2024-02-08",
      }

response [success]
      
      {
         "client_id": 1,
         "status_id": 1,
         "published": 1,
         "title": "Turka for name coffee!",
         "description": "Turka for name coffee. Advanced teapot.",
         "expired_date": "2024-03-09",
         "publish_date": "2024-02-08",
         "id": 3
      }

response [error]
      
      [
         {
            "field": "client_id",
            "message": "Client ID cannot be blank."
         },
         {
            "field": "status_id",
            "message": "Status ID cannot be blank."
         },
         {
            "field": "title",
            "message": "Title cannot be blank."
         }
      ]

update ads

      PUT /api/v1/ads/{id}



### Install via Composer

If you do not have [Composer](https://getcomposer.org/), you may install it by following the instructions
at [getcomposer.org](https://getcomposer.org/doc/00-intro.md#installation-nix).

You can then install this project template using the following command:

~~~
composer create-project --prefer-dist yiisoft/yii2-app-basic basic
~~~

Now you should be able to access the application through the following URL, assuming `basic` is the directory
directly under the Web root.

~~~
http://localhost/basic/web/
~~~

### Install from an Archive File

Extract the archive file downloaded from [yiiframework.com](https://www.yiiframework.com/download/) to
a directory named `basic` that is directly under the Web root.

Set cookie validation key in `config/web.php` file to some random secret string:

```php
'request' => [
    // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
    'cookieValidationKey' => '<secret random string goes here>',
],
```

You can then access the application through the following URL:

~~~
http://localhost/basic/web/
~~~


### Install with Docker

Update your vendor packages

    docker-compose run --rm php composer update --prefer-dist
    
Run the installation triggers (creating cookie validation code)

    docker-compose run --rm php composer install    
    
Start the container

    docker-compose up -d
    
You can then access the application through the following URL:

    http://127.0.0.1:8000

**NOTES:** 
- Minimum required Docker engine version `17.04` for development (see [Performance tuning for volume mounts](https://docs.docker.com/docker-for-mac/osxfs-caching/))
- The default configuration uses a host-volume in your home directory `.docker-composer` for composer caches


CONFIGURATION
-------------

### Database

Edit the file `config/db.php` with real data, for example:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2basic',
    'username' => 'root',
    'password' => '1234',
    'charset' => 'utf8',
];
```

**NOTES:**
- Yii won't create the database for you, this has to be done manually before you can access it.
- Check and edit the other files in the `config/` directory to customize your application as required.
- Refer to the README in the `tests` directory for information specific to basic application tests.


TESTING
-------

Tests are located in `tests` directory. They are developed with [Codeception PHP Testing Framework](https://codeception.com/).
By default, there are 3 test suites:

- `unit`
- `functional`
- `acceptance`

Tests can be executed by running

```
vendor/bin/codecept run
```

The command above will execute unit and functional tests. Unit tests are testing the system components, while functional
tests are for testing user interaction. Acceptance tests are disabled by default as they require additional setup since
they perform testing in real browser. 


### Running  acceptance tests

To execute acceptance tests do the following:  

1. Rename `tests/acceptance.suite.yml.example` to `tests/acceptance.suite.yml` to enable suite configuration

2. Replace `codeception/base` package in `composer.json` with `codeception/codeception` to install full-featured
   version of Codeception

3. Update dependencies with Composer 

    ```
    composer update  
    ```

4. Download [Selenium Server](https://www.seleniumhq.org/download/) and launch it:

    ```
    java -jar ~/selenium-server-standalone-x.xx.x.jar
    ```

    In case of using Selenium Server 3.0 with Firefox browser since v48 or Google Chrome since v53 you must download [GeckoDriver](https://github.com/mozilla/geckodriver/releases) or [ChromeDriver](https://sites.google.com/a/chromium.org/chromedriver/downloads) and launch Selenium with it:

    ```
    # for Firefox
    java -jar -Dwebdriver.gecko.driver=~/geckodriver ~/selenium-server-standalone-3.xx.x.jar
    
    # for Google Chrome
    java -jar -Dwebdriver.chrome.driver=~/chromedriver ~/selenium-server-standalone-3.xx.x.jar
    ``` 
    
    As an alternative way you can use already configured Docker container with older versions of Selenium and Firefox:
    
    ```
    docker run --net=host selenium/standalone-firefox:2.53.0
    ```

5. (Optional) Create `yii2basic_test` database and update it by applying migrations if you have them.

   ```
   tests/bin/yii migrate
   ```

   The database configuration can be found at `config/test_db.php`.


6. Start web server:

    ```
    tests/bin/yii serve
    ```

7. Now you can run all available tests

   ```
   # run all available tests
   vendor/bin/codecept run

   # run acceptance tests
   vendor/bin/codecept run acceptance

   # run only unit and functional tests
   vendor/bin/codecept run unit,functional
   ```

### Code coverage support

By default, code coverage is disabled in `codeception.yml` configuration file, you should uncomment needed rows to be able
to collect code coverage. You can run your tests and collect coverage with the following command:

```
#collect coverage for all tests
vendor/bin/codecept run --coverage --coverage-html --coverage-xml

#collect coverage only for unit tests
vendor/bin/codecept run unit --coverage --coverage-html --coverage-xml

#collect coverage for unit and functional tests
vendor/bin/codecept run functional,unit --coverage --coverage-html --coverage-xml
```

You can see code coverage output under the `tests/_output` directory.
