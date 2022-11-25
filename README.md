# news_cake
your daily dose of news


# How to setup the project?
Follow the instructions to setup project easily.

# Clone project
To get project on your local machine you will have to clone the project. 
- Go to the desired directory where you want to have the project.
- open terminal and write following command

> git clone https://github.com/abdulsamadtariq/news_cake.git

it will clone project in to news_cake directory

# How to setup environemnt for the project?
First go to the project directory.
> cd news_cake

then exectue following command to start installation of dependencies

> composer install

after it get finished, edit the .env file and replace db details at 

> DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=8&charset=utf8mb4"

Hit Save!

Now run following to complete the db setup.

> php bin/console doctrine:database:create

> php bin/console doctrine:schema:update --force

> php bin/console doctrine:fixtures:load

> php bin/console cache:clear

Now the setup is complete for the project.

## Start the server By running following command

> php bin/console server:run

Or 
> symfony serve

Navigate to your browser and open localhost url
http://127.0.0.1:8000/

### as we have seeded user data in above db commands so we can login.


with one of two roles: admin or moderator

#### ModeratorUser:
 Email: moderator@mail.com
 password: Moderator@4321

#### AdminUser:
 Email: admin@mail.com
 password: Admin@4321

#### the administrator can delete articles

# Thanks for reading
