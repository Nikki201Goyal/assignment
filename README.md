<h3>
Hi, this is my backend task documentation stating how I created it and all. 
</h3>

<h5>so, here i have used mongodb as a database</h5>
to do this firstly i created a database using mongo atlas and then connected it with our mongodb compass .


to run this file the team should first enter thus two things in env.

#DB_DSN=mongodb+srv://tweb5167:test123@cluster0.tsaf6wl.mongodb.net/
#DB_DATABASE=Products

after that my architecture for this project was 

1) I used jenseegers/mongodb in laravel 
2) all the code was done in eloquent
3) I made folder structure like i made a DB folder inside app which will contain all the database part i.e. model, eloquentRepository, array Generators and this EQ and AG are then called in product model. 
4) Made a controller productController which contain index method to retrieve data here i have added paginaton as well an dthis method even contain serach functionality. I have added filter if used write abc then the product with named abc will be searched and similarly done for other search functionality as per the requirements.
5) similarly, it contain delete and update method which will delete product according to their id.
6) And at last it contain store method which will store product data. Also, i had added validation request file to validate it where id will be unique. (ProductRequest)

<h3> How can we run the code</h3>

1) Add the above said thing in env
2) Run the code using php artisan serve --port=8080
3) use admin-api as prefix in url 
for example smthg like this it will be 
localhost:8080/admin-api/products


