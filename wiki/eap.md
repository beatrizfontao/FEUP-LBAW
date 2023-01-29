# EAP: Architecture Specification and Prototype 

## A7 - Web Resources Specification

This artifact goal is to explain the architecture of our web application. It includes the set of used web resources, their modules and respective permissions. The API specification is presented at the end following the OpenAPI Standard using YAML.

### 1. Overview

| Identification | Description |
| --- | --- |
| M01: Authentication and Individual Profile | Web resources associated with user authentication and individual profile management. Includes the following system features: login/logout, registration, credential recovery, view and edit personal profile information. |
| M02: Products | Web resources associated with listing, searching and filtering products. |
| M03: Product and Reviews| Web resources associated with a single product and its reviews. Includes the following system features: add, delete and edit reviews and see the product's information. |
| M04: Wishlist and Shopping cart | Web resources associated with the user's wishlist and shopping cart. Includes the following system features: add, delete and edit products (wishlist and shopping cart) and checkout (shopping cart). |
| M05: Management | Web resources associated with management. Includes the following system features: ban users, add, remove and edit products, alter the stages of orders and manage user accounts. | 
| M06: Static Pages | Web resources associated with the static pages - About Us and Contacts. |

### 2. Permissions


| Identifier | Identification | Description |
| --- | --- | --- |
| **PUB** | Public | Users without privileges |
| **USR** | User | Authenticated users |
| **OWN** | Owner | Group of users who own something (e.g. own profile) |
| **ADM** | Administrator | System administrators |

### 3. OpenAPI Specification


https://app.swaggerhub.com/apis/UP202005460_1/LBAW/EAP
```yaml
openapi: 3.0.0

info:
 version: 1.0.0-oas3
 title: 'LBAW SmokeyGlass Web API'
 description: 'Web Resources Specification (A7) for SmokeyGlass'

servers:
- url: http://lbaw.fe.up.pt
  description: Production server

externalDocs:
 description: Find more info here.
 url: https://git.fe.up.pt/lbaw/lbaw2223/lbaw2213/-/wikis/eap

tags:
 - name: 'M01: Authentication and Individual Profile'
 - name: 'M02: Products'
 - name: 'M03: Product and Reviews'
 - name: 'M04: Wishlist and Shopping cart'
 - name: 'M05: Management'
 - name: 'M06: Static Pages'
paths:
 /login:
   get:
     operationId: R101
     summary: 'R101: Login Form'
     description: 'Provide login form. Access: PUB'
     tags:
       - 'M01: Authentication and Individual Profile'
     responses:
       '200':
         description: 'Ok. Show Log-in UI'
   post:
     operationId: R102
     summary: 'R102: Login Action'
     description: 'Processes the login form submission. Access: PUB'
     tags:
       - 'M01: Authentication and Individual Profile'
     requestBody:
       required: true
       content:
         application/x-www-form-urlencoded:
           schema:
             type: object
             properties:
               username:        
                 type: string
               password:
                 type: string
             required:
                  - username
                  - password

     responses:
       '302':
         description: 'Redirect after processing the login credentials.'
         headers:
           Location:
             schema:
               type: string
             examples:
               302Success:
                 description: 'Successful authentication. Redirect to  main page.'
                 value: '/mainpage'
               302Error:
                 description: 'Failed authentication. Redirect to login form.'
                 value: '/login'
 /logout:
   post:
     operationId: R103
     summary: 'R103: Logout Action'
     description: 'Logout the current authenticated user. Access: USR, ADM'
     tags:
       - 'M01: Authentication and Individual Profile'
     responses:
       '302':
         description: 'Redirect after processing logout.'
         headers:
           Location:
             schema:
               type: string
             examples:
               302Success:
                 description: 'Successful logout. Redirect to mainpage.'
                 value: '/mainpage'
 /register:
   get:
     operationId: R104
     summary: 'R104: Register Form'
     description: 'Provide new user registration form. Access: PUB'
     tags:
       - 'M01: Authentication and Individual Profile'
     responses:
       '200':
         description: 'Ok. Show Sign-Up UI'

   post:
     operationId: R105
     summary: 'R105: Register Action'
     description: 'Processes the new user registration form submission. Access: PUB'
     tags:
       - 'M01: Authentication and Individual Profile'

     requestBody:
       required: true
       content:
         application/x-www-form-urlencoded:
           schema:
             type: object
             properties:
               username:
                 type: string
               email:
                 type: string
               password:
                 type: string
               gender:
                 type: string
               date_of_birth:
                 type: string
               picture:
                 type: string
                 format: binary
             required:
                    - username
                    - email
                    - password
                    - date_of_birth
                    - picture
     responses:
       '302':
         description: 'Redirect after processing the new user information.'
         headers:
           Location:
             schema:
               type: string
             examples:
               302Success:
                 description: 'Successful authentication. Redirect to main page.'
                 value: '/mainpage'
               302Failure:
                 description: 'Failed authentication. Redirect to register form.'
                 value: '/register'
 /users/{id}:
   get:
     operationId: R106
     summary: 'R106: View user profile'
     description: 'Show the individual user profile. Access: USR'
     tags:
       - 'M01: Authentication and Individual Profile'

     parameters:
       - in: path
         name: id
         schema:
           type: integer
         required: true

     responses:
       '200':
         description: 'Ok. Show User Profile UI'
 /users/{id}/edit:
    parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true
    
    get:
      operationId: R107
      summary: 'R107: Edit Profile Form'
      description: 'Provide edit profile form. Access: USR'
      tags:
        - 'M01: Authentication and Individual Profile'
      responses:
        '200':
          description: 'Ok. Show Edit Profile Form UI'

    put:
      operationId: R108
      summary: 'R108: Edit Profile Action'
      description: 'Processes the edit profile form submission. Access: USR'
      tags:
        - 'M01: Authentication and Individual Profile'

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
               username:
                 type: string
               email:
                 type: string
               password:
                 type: string
               gender:
                 type: string
               date_of_birth:
                 type: string
               picture:
                 type: string
                 format: binary

      responses:
        '302':
          description: 'Redirect after processing the new user information.'
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Successful edit. Redirect to user profile.'
                  value: '/users/{id}'
                302Failure:
                  description: 'Failed edit. Redirect to user profile.'
                  value: '/users/{id}/edit'  
 /product/{id}:
    parameters:
      - in: path
        name: id
        schema:
          type: integer
        required: true
        
    get:
      operationId: R301
      summary: 'R301: View product page'
      description: 'Show the individual product page. Access: PUB'

      tags:
        - 'M03: Product and Reviews'

      responses:
        '200':
          description: 'Ok. Show Product Page UI'
        '404':
          description: 'Product not found!'
 /api/product/{id}:  
    parameters:
      - in: path
        name: id
        schema:
          type: integer
        required: true
    post:
      operationId: R402
      summary: 'R402: Add product to shopping cart'
      description: "Adds the selected product to the shopping cart. Access: PUB"
      tags:
        - 'M04: Wishlist and Shopping cart'
        
      requestBody:
       required: true
       content:
         application/x-www-form-urlencoded:
           schema:
             type: object
             properties:
               id:
                type: number
             required:
                    - id
      responses:
        '302':
          description: 'Redirect after processing the new user information.'
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Successful added items. Redirect to product page.'
                  value: '/product/{id}'
                302Failure:
                  description: 'Failed to add items. Redirect to product page.'
                  value: '/product/{id}'
    delete:
      operationId: R403
      summary: 'R403: Remove product from shopping cart'
      description: "Removes the selected product from the shopping cart. Access: PUB"
      tags:
        - 'M04: Wishlist and Shopping cart'
      responses:
        '302':
          description: 'Redirect after processing the new user information.'
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Successful added items. Redirect to product page.'
                  value: '/product/{id}'
                302Failure:
                  description: 'Failed to add items. Redirect to product page.'
                  value: '/product/{id}'    
 /:
    get:
      operationId: R201
      summary: 'R201: List Products'
      description: 'Lists some products to show in mainpage. Access: PUB.'

      tags: 
        - 'M02: Products'
      responses:
        '200':
          description: Success
          content:
            application/json:
              schema:
                type: array
                items:
                  type: object
                  properties:
                    id:
                      type: integer
                    name:
                      type: string
                    description:
                      type: string
                    price:
                      type: number
                    stock:
                      type: integer
                    id_category:
                      type: integer
                    id_brand:
                      type: integer
                    details:
                      type: array
                      items:
                        type: array
                        items: 
                          type: string
 /search:
    get:
      operationId: R202
      summary: 'R202: Search products'
      description: 'Searches for products and returns the results. Access: PUB.'

      tags: 
        - 'M02: Products'

      parameters:
        - in: query
          name: query
          description: 'String to use for full-text search'
          schema:
            type: string
          required: false
      responses:
        '200':
          description: Success
          content:
            application/json:
              schema:
                type: array
                items:
                  type: object
                  properties:
                    id:
                      type: integer
                    name:
                      type: string
                    description:
                      type: string
                    price:
                      type: number
                    stock:
                      type: integer
                    id_category:
                      type: integer
                    id_brand:
                      type: integer
 /shopping_cart:
   get:
     operationId: R401
     summary: 'R401: View user shopping cart'
     description: 'Show the individual user shopping cart. Access: USR'
     tags:
        - 'M04: Wishlist and Shopping cart'
     responses:
        '200':
          description: Success
          content:
            application/json:
              schema:
                type: array
                items:
                  type: object
                  properties:
                    name:
                      type: string
                    description:
                      type: string
                    price:
                      type: number
                    quantity:
                      type: number
 /checkout:
   post:
     operationId: R404
     summary: 'R404: Checkout'
     description: 'Create a order with the shopping cart. Access: USR'
     tags:
        - 'M04: Wishlist and Shopping cart'
     requestBody:
       required: true
       content:
         application/x-www-form-urlencoded:
           schema:
             type: object
             properties:
               id:
                type: number
             required:
                    - id
     responses:
        '302':
          description: 'Redirect after processing the new information.'
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Successful added items. Redirect to product page.'
                  value: '/mainpage'
                302Failure:
                  description: 'Failed to add items. Redirect to product page.'
                  value: '/api/shoppingCart'
 /management:
    get:
      operationId: R501
      summary: 'R501: Management main page'
      description: "Shows the admin's options. Access: ADM"
      tags:
        - 'M05: Management'
      responses:
        '200':
           description: 'Ok. Show Management Main Page UI' 
 /api/users:
    get:
      operationId: R502
      summary: 'R502: Search users API'
      description: "Searches for users and returns the result as JSON. Access: ADM"
      tags:
        - 'M05: Management'
      parameters:
        - in: query
          name: query
          description: 'String to use for full-text search'
          schema:
            type: string
          required: false  
      responses:
       '200':
         description: Success
         content:
           application/json:
             schema:
               type: array
               items:
                 type: object
                 properties:
                    id:
                      type: integer
                    username:
                      type: string
                    picture:
                      type: string
                      format: binary
  
 /management/users/{id}:
   get:
     operationId: R503
     summary: 'R503: View another user profile'
     description: 'Show the individual user profile. Access: ADM'
     tags:
       - 'M05: Management'

     parameters:
       - in: path
         name: id
         schema:
           type: integer
         required: true

     responses:
       '200':
         description: 'Ok. Show User Profile UI'

 /management/users/{id}/edit:
    parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true
    
    get:
      operationId: R504
      summary: 'R504: Edit Profile Form'
      description: 'Provide edit profile form. Access: ADM'
      tags:
        - 'M05: Management'
      responses:
        '200':
          description: 'Ok. Show Edit Profile Form UI'

    put:
      operationId: R505
      summary: 'R505: Edit Profile Action'
      description: 'Processes the edit profile form submission. Access: ADM'
      tags:
        - 'M05: Management'

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
               username:
                 type: string
               email:
                 type: string
               password:
                 type: string
               gender:
                 type: string
               date_of_birth:
                 type: string
               picture:
                 type: string
                 format: binary

      responses:
        '302':
          description: 'Redirect after processing the new user information.'
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Successful edit. Redirect to user profile.'
                  value: '/management/users/{id}'
                302Failure:
                  description: 'Failed edit. Redirect to profile edit form.'
                  value: '/management/users/{id}/edit' 
                  
                  
 /management/users/create:
   get:
     operationId: R506
     summary: 'R506: Create User Form'
     description: 'Create User Form. Access: ADM'
     tags:
       - 'M05: Management'
     responses:
       '200':
         description: 'Ok. Show Create User Form UI'

   post:
     operationId: R507
     summary: 'R507: Create User Action'
     description: 'Processes the new user information in the form. Access: ADM'
     tags:
       - 'M05: Management'

     requestBody:
       required: true
       content:
         application/x-www-form-urlencoded:
           schema:
             type: object
             properties:
               username:
                 type: string
               email:
                 type: string
               password:
                 type: string
               gender:
                 type: string
               date_of_birth:
                 type: string
               picture:
                 type: string
                 format: binary
             required:
                    - username
                    - email
                    - password
                    - date_of_birth
                    - picture
     responses:
       '302':
         description: 'Redirect after processing the new user information.'
         headers:
           Location:
             schema:
               type: string
             examples:
               302Success:
                 description: 'Successful authentication. Redirect to new user page.'
                 value: '/management/users/{id}'
               302Failure:
                 description: 'Failed authentication. Redirect to create user form.'
                 value: '/management/users/create'   
         
 /about_us:
    get:
      operationId: R601
      summary: 'R601: View About Us page'
      description: 'Shows some information about the company. Access: PUB.'
      tags: 
        - 'M06: Static Pages'
      responses:
        '200':
          description: 'Ok. Show About Us Page UI'  
 /contact_us:
    get:
      operationId: R602
      summary: 'R602: View Contact Us page'
      description: 'Shows the contacts of the company. Access: PUB.'
      tags: 
        - 'M06: Static Pages'
      responses:
        '200':
          description: 'Ok. Show Contact Us Page UI'
```

---

## A8: Vertical Prototype

This artifact goal is to present the vertical prototype developed, more precisely, the user interface created, the solutions used to manipulate data, the control of permissions and the resolution of errors. 

### 1. Implemented Features

### 1.1 Implemented User Stories



| Identifier | Name | Priority | Description |
|---|---|---|---|
| US01       | View Products List   | high | As a User, I want to be able to view to shop's products list, so that I choose something to buy. |
| US02       | View  Product Details  | high  | As a User, I want to view a single product page, so that I can see it's details. |
| US03       | Add Product to Shopping Cart | high | As a User, I want to add products to the shopping cart, so that I can later buy them. |
| US04       | Manage Shopping Cart | high | As a User, I want to be able to manage the shopping cart, so that I can view the products I added before. |
| US05       | Search Products | high | As a User, I want to search products on a search bar, so that I can easily find what I need. |
| US08       | Remove Product From Shopping Cart | medium | As a User, I want to remove products from the shopping cart, so that I can delete something I accidentally added. |
| US11      | Log In Account | high | As a Visitor, I want to login to my account, so that I can have access to all the features of the app. |
| US12       | Create An Account | high | As a Visitor, I want to register me in the system, so that I can later authenticate myself. |
| US21  | View Profile | high  | As a Customer, I want to check my profile, so that I can have access to all the features of the app.  |
| US22  | Edit Profile  | high  | As a Customer, I want to be able to edit my profile, so that I can change my personal information.  |
| US23  | Logout From Account | high  | As a Customer, I want to be able logout, so that I exit my account.  |
| US24  | View Purchase History | high  | As a Customer, I want to view my purchase history, so that I can see what I previously bought.  |
| US25  | Checkout | high  | As a Customer, I want to checkout, so that I can pay for the products I choose and ship them to the selected address.  |
| US26  | View Current orders | high  | As a Customer, I want to view my orders, so that I can see what I bought. |
| US27  | View Own Addresses | high  | As a Customer, I want to view my addresses, so that I can see where I can receive my orders.  |
| US51 | Search for other User Accounts | high | As an Administrator, I want to search for other users' accounts, so that I find the user I'm looking for.  |
| US52 | View other User Accounts | high | As an Administrator, I want to view another users' accounts, so that I see what they are doing.  |
| US53 | Edit other User Accounts | high | As an Administrator, I want to edit other users' accounts, so that I remove any improper information.  |
| US54 | Create user account | high | As an Administrator, I want to Add and Delete Products, so that I can control what products are being sold.  |

### 1.2 Implemented Web Resources


**Module M01**: Authentication and Individual Profile

| Web Resource Reference | URL |
| --- | --- |
| R101: Login Form | GET /login |
| R102: Login Action | POST /login |
| R103: Logout Action | POST /logout |
| R104: Register Form | GET /register |
| R105: Register Action | POST /register |
| R106: View Profile | GET /user/{id} |
| R107: Register Form | GET /user/{id}/edit |
| R108: Register Action | PUT /edit_user |
| R109: View Own Addresses | GET /addresses/{id} |
| R110: View Order History | GET /past_orders/{id} |
| R111: View Orders | GET /orders/{id} |
| R112: View Individual Order | GET /order/{id} |

**Module M02**: Products

| Web Resource Reference | URL |
| --- | --- |
| R201: List Products | GET / |
| R202: Search products | GET /search |

**Module M03**: Product and Reviews

| Web Resource Reference | URL |
| --- | --- |
| R301: View Product | GET /product/{id} |

**Module M04**: Wishlist and Shopping cart

| Web Resource Reference | URL |
| --- | --- |
| R401: View Shopping Cart | GET /shopping_cart |
| R402: Add product to shopping cart | POST /api/product/{id} |
| R403: Remove product from shopping cart | DELETE /api/product/{id} |
| R404: Checkout | POST /checkout | 

**Module M05**: Management

| Web Resource Reference | URL |
| --- | --- |
| R501: Management main page | GET /management |
| R502: Search users API | GET /api/users |
| R503: View another user profile | GET /management/users/{id} |
| R504: Edit Profile Form | GET /management/users/{id}/edit |
| R505: Edit Profile Action | PUT /management/users/{id}/edit |
| R506: Create User Form | GET /management/users/create |
| R507: Create User Action | POST /management/users/create |

**Module M06**: Static Pages

| Web Resource Reference | URL |
| --- | --- |
| R601: View About Page | GET /about |
| R602: View Contact Us Page | GET /contact |

## 2. Prototype

The prototype is available at [link].

Credentials: 
- Email: maria@mail.com Password: 123456 -> Customer
- Email: luis@mail.com Password: 123456 -> Admin

The code is available at: https://git.fe.up.pt/lbaw/lbaw2223/lbaw2213.

## Revision History
Change made to the first submission:
1. Added user stories US26 e US27
2. Addes to module M01 routes R109, R110, R111 and R112.

GROUP2213, 22/11/2022

- Ana Beatriz Fontão, up202003574 - editor
- Henrique Seabra Ferreira, up202007044 - editor
- José Pedro Ramos, up202005460 - editor