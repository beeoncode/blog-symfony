# Symfony3 tutorial - Creating a blog in Symfony3, admin dashboard and Rest API 


## Installing

 1. Clone the repository
 2. Rename 'app/config/parameters.yml.dist' to 'app/config/parameters.yml'
 3. Run composer install
 4. Install the assets with 'php bin/console assets:install web'
 5. Create the database with 'php bin/console doctrine:database:create'
 6. Update schema with 'php bin/console doctrine:schema:create'
 7. Load fixtures with 'php bin/console doctrine:fixtures:load'
 
 ## Access
 Admin Dashboard Url : yourdomain.com/admin
 access : project/app/config/security.yml
 
 ## Rest API request
 yourdomain.com/api/rest/
 
 and 
   
 yourdomain.com/api/rest/{$id}
 