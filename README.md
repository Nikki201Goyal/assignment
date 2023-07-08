# Backend Task Documentation

This documentation provides an overview of the backend task, including the setup, architecture, and instructions for running the code.

## Database Setup

MongoDB was chosen as the database for this project. Follow these steps to set up the database:

1. Create a database using MongoDB Atlas.
2. Connect the database with MongoDB Compass.

## Environment Configuration

Before running the code, make sure to add the following environment variables to the `.env` file:

DB_DSN=mongodb+srv://<username>:<password>@cluster0.tsaf6wl.mongodb.net/<database>
DB_DATABASE=Products



## Project Architecture

The project follows a specific architecture to ensure maintainability and separation of concerns. Here is an overview of the architecture:

1. The `jenssegers/mongodb` package was utilized in Laravel.
2. All the code was implemented using Eloquent.
3. The `app/DB` folder contains the database-related components:

    - **Models**: Represents the database tables and their relationships.
    - **Eloquent Repositories**: Handles the database operations for each model.
    - **Array Generators**: Provides functionality for generating arrays.

   These components are utilized in the `Product` model.

4. The `ProductController` handles various operations related to products:

    - `index`: Retrieves product data with pagination and search functionality. Filtering is implemented to search for products based on their names.
    - `delete` and `update`: Perform deletion and update operations respectively, based on the product ID.
    - `store`: Stores new product data. A validation request file (`ProductRequest`) ensures that the ID is unique.

## Running the Code

To run the code, follow these steps:

1. Add the environment variables mentioned above to the `.env` file.
2. Run the code using the command: `php artisan serve --port=8080`.
3. Access the API endpoints with the `admin-api` prefix in the URL. For example: `localhost:8080/admin-api/products`.

Please ensure that you have set up a Laravel project and have installed the necessary dependencies before running the code.

Feel free to update this documentation with any additional instructions or details as needed.


