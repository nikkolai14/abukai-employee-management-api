Abukai's Employee Management API using Native PHP.

## Setup Instructions
1. **Install Dependencies**
   Make sure you have Composer installed. Run the following command to install the required dependencies:
   ```bash
   composer install
   ```

2. **Configure Database**
   Update the `config/database.php` file with your database connection settings.

3. **Run the Application**
   You can use the built-in PHP server to run the application:
   ```bash
   php -S localhost:8000 -t public
   ```

4. **Run the Database Server**
   You can quickly start a MySQL server using Docker:

   ```bash
   docker run --name employee-mysql -e MYSQL_ROOT_PASSWORD=yourpassword -e MYSQL_DATABASE=employee_db -p 3306:3306 -d mysql:8
   ```

   Replace `yourpassword` and `employee_db` with your desired root password and database name.

5. **Access the API**
   Open your browser or use a tool like Postman to access the API at `http://localhost:8000`.