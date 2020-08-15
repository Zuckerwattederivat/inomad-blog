# inomad-blog
A blog for travel enthusiasts to tell their stories and to let users read about the adventures of other people to get inspiration.
It comes with a basic cms for admins to manage the blog and delete users or posts if needed. 
The site relies on Bootstrap, Jquery, popper.js, amcharts as well as PHP and MySQL.

# Set Up
1. Import SQL database found in the application's root directory under "app/backup/database.sql" to your MySQL server.

2. Rewrite the .htaccess file inside of the public folder, if you aren't using the server root or if you renamed the project folder. 
  - Inside the application's root directory open "public/.htaccess".
  - On line 4 change "RewriteBase /inomad-blog/public" to whatever directory and folder name you want to run it from. For example if you don't place the application folder in your server root dir but in another folder called "hello-world" which lives inside the server root the rewrite base would look like this: "RewriteBase /hello-world/inomad-blog/public".
  
3. Rewrite config.php.
  - Inside the application's root directory open "app/config/config.php".
  - Change database parameters on line 3-6 to your local server settings.
  - Change URLROOT constant on line 11 to your local server directory from which the app is started including the application's root folder name. For example: "http/localhost:8888/inomad-blog" if you want to start the app from localhost port 8888 root directory with the application folder name of inomad-blog.
  - Personalize the other constants in config.php so they fit your preffered data. You can define the site name, site title, backend title, version, email etc.
  
4. After successfully setting up the blog you should be able to run it via your server and login as admin with the following credentials:
  - email: admin@byom.de
  - password: 123456
 
5. You now have full control over the site, it's users and their published posts through the custom cms which can be reached by clicking on the top right user button after logging in as admin.