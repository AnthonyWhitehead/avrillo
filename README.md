# Installation
### Prerequisites
- composer (globally installed)
- docker
- docker-compose

### Steps
1. Clone the repository
2. cd into project
3. $ composer install
4. $ ./vendor/bin/sail up -d
5. $ ./vendor/bin/sail artisan migrate
6. copy .env.example to .env
7. add a 32 character random string to PASSPHRASE in .env
8. add a 16 character random string to IV in .env
9. add a time in minutes to TOKEN_EXPIRY in .env to set token expiry time

# Usage
- To use this api you can either use postman or you can do it directly from the swagger ui (see below)
- You must first make a request to /api/token to get a token
- Then you can use this token to access the other routes
- To clean up expired tokens you can run the command: $ sail artisan tokens:delete-expired
- I've also set up a cron job to run this command every day at midnight to keep the db clean
- Quotes are all cached for speed
- See swagger docs for detailed instructions for each endpoint

# Api Documentation
- Swagger documentation can be found at http://localhost/api/documentation
- YAML file for swagger docs is here: /storage/api-docs/swagger.yaml

# Testing
- $ ./vendor/bin/sail artisan test --parallel

# Notes

### Authentication
- As there are no users for this app this api feels like it should be a machine to machine api and
  therefore I have implemented authentication in the style of Oauth 2.0 client_credentials grant type as specified here: https://oauth2.thephpleague.com/authorization-server/which-grant/
- Tokens are created using openssl_encrypt and currently can be implemented with two different encryption methods using the either the CbcDriver or GcmDriver:
  - AES-256-CBC
  - AES-256-GCM
- To create a token you must send a post request to /api/token (details in swagger docs)
- Each route is protected by middleware which will check for a `token`variable in the header
- Tokens last for one hour by default or whatever you set TOKEN_EXPIRY to in the .env file

### Manager pattern implementation
- There are two examples of manager pattern implementations in this app
  - Quotes
    - Quotes can be created using either the Kanye api or Laravel's Illuminate\Foundation\Inspiring;
    - The default driver is Kanye but if you would like to use Laravel quotes you can change the driver in app/Http/Controllers/QuoteController.php
      by adding driver to facade call e.g. QuoteFacade::driver('inspirational')->getQuotes()
  - Tokens
    - As mentioned above there are two encryption algorithms that can be used to create tokens
    - The default driver is AES-256-CBC but you can change this by updating the driver in app/Http/Controllers/TokenController.php
       e.g. TokenFacade::driver('gcm')->createToken()

### Testing
- All routes have been feature tested and the middleware has been unit tested
- The App could definitely have more tests however I feel this has shown enough of my testing ability for this project

### Where to look for things
- app/Managers -  contains the manager pattern implementations
- app/Drivers - contains the drivers for the manager pattern implementations
- app/Providers/AppServiceProvider.php - contains the singleton bindings for the manager pattern implementations
- app/Interfaces - contains the interfaces for the manager and driver classes
- app/Facades - contains all the custom facades
- app/Http/Middleware/ValidateToken.php - contains the middleware for validating tokens
- app/Http/Requests/CreateTokenRequest.php - contains the request validation for creating tokens
- app/Http/Resources - contains the resources for the api
- routes/console.php - Where the cron job is triggered to clear expired tokens
- Tests - where you'd usually expect them
- app/Traits/OpenSslTrait.php - openssl implementation for encryption
- everything else - Where you'd expect to find it in a laravel project :)

### Future Improvements
- Create a docker image and store in a repo for use instead of cloning project and having to run composer install
- The authentication could be improved by replicating Laravel Passport Client credentials grant type, i.e. using 
  an oauth_client table with uuid and secret. 
- Use of JWT tokens. I was tempted to write my own JWT implementation but though it was out of scope for this project. 
  I could have also used https://github.com/firebase/php-jwt (which is what Laravel passport uses) however was conscious
  of the request in the spec to not use any packages.
- There are no examples in this test of laravel ORM and relationships which would have been nice to show
- If this was a production app and not a test I'd use Laravel Passport for client credentials grant type or Sanctum for 
  SPA authentication. 
  