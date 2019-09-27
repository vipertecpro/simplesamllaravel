
## How to setup or configure

- Take clone
- Create database example : saml_db
- Run Following commands :-

      composer update
      composer dumpa
      php artisan migrate:refresh --seed
      
- Take a look into following files
     
      routes > web.php
      public > samllogin > saml.ini
      public > samllogin > metadata > saml20-idp-remote.php
