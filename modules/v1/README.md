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

      /ads                  main ad entity
      /ads-status           ad type
      /goods-category       Good-Category
      /good-helpers         Good helpers
      /good-helpers-value   Value of Good-helpers
      /helper-type          Type of heprers
      /media                Media resourse
      /profile              Profile
      /service-goods        connector for ads, category, goods


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

response [success]

      {
         "id": 2,
         "client_id": 6,
         "name": "Izzat Imon ibn Umar",
         "email": "dell@dell.com",
         "phone": "+15552046672"
      }


response [error]

      {
         "message": "Profile not created"
      }

Change profile data [name & phone]
    
    POST /api/v1/my-data

body:

    phone: +79775552202
    name: Vladislav Popov

response [success]

     {
          "message": "Updated data!"
     }

response [error]

     {
          "message": "Something went wrong"
     }



Create ADS
------------

     POST /api/v1/ads

body:
     
     category_id:{number, required},
     title:{string, required},
     description:{sring, required}
     helpers:{
          id:value,
          id:value,
          ...
     } {optional}
     expired [2,4,12] {number, required}
     images [
          {file}
          ...
     ] {optional}


response [success]

     {
         "message": "Ads created",
         "ads": 11,
         "serviceGoods": 5,
         "helperCreated": 3,
         "uploadedMedia": 1
     }

response [error]

     {
          "message": "You skipped some fields"
     }



UPDATE ADS
------------
     
     PUT /api/v1/ads/{id}


body: [required one of this fields]

     category_id:{number, optional},
     title:{string, optional},
     description:{sring, optional}
     helpers:{
          id:value,
          id:value,
          ...
     } {optional}
     expired [2,4,12] {number, optional}
     images [
          {file}
          ...
     ] {optional}

PS: for remove image(s) use different endpoint `/api/v1/media`


response [success]

          {
               "message": "Ads updated",
               "ads": 13,
               "serviceGoods": 6,
               "helperCreated": 0,
               "uploadedMedia": 0
          }


response [error]

     {
          "message": "At least one parameter should be sent"
     }




















<p align="center"><h1 align="center">PUBLIC PART</h1></p>


ADS Entity
------------

      GET /api/v1/ads
params:

filters:

      filters:
         category_id:{number}
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

response [success]:

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

Category
---------

      GET /api/v1/goods-category
params:
          
     path:{string} for retrieve one node by path.

orders:

      sort:
         -id|id
         -fld_label|fld_label

response [success]:

        [
            {
                "id": 1,
                "parent_id": 0,
                "fld_key": "nedvizhimost",
                "fld_label": "Недвижимость",
                "fld_order": 0,
                "fld_breadcrumb": "/nedvizhimost"
            },
        ]


view one ads

      GET /api/v1/goods-category/{id} 

response [success]

        {
            "id": 1,
            "parent_id": 0,
            "fld_key": "nedvizhimost",
            "fld_label": "Недвижимость",
            "fld_order": 0,
            "fld_breadcrumb": "/nedvizhimost"
        }

response [error]

      {
         "name": "Not Found",
         "message": "Object not found: 10",
         "code": 0,
         "status": 404,
         "type": "yii\\web\\NotFoundHttpException"
      }



Goods-Helper
-----------

     GET /api/v1/goods-helpers

params:

     category_id:{integer}
     type_id:{integer}
     fld_name:{string}

orders:

      sort:
         -id|id
         -fld_name|fld_name


response: [success]

     {
          "models": [
               {
                    "id": 8,
                    "category_id": 2,
                    "type_id": 2,
                    "fld_name": "square",
                    "fld_label": "Плошадь",
                    "fld_default": "0",
                    "fld_parameters": null
               },
          ],
          "count": 5
     }


reponse: [error]

     {
          "message": "Something went wrong"
     }
