Abukai's Employee Management API using Native PHP.

## Setup Instructions
1. **Install Dependencies**
   Make sure you have Composer installed. Run the following command to install the required dependencies:
   ```bash
   composer install
   ```

2. **Configurations**
   Copy the `.env.example` file to a new one named `.env` then add your credentials

3. **Run the Application**
   You can use the built-in PHP server to run the application:
   ```bash
   php -S localhost:8000 -t public
   ```

4. **Run the Database Server**
   You can quickly start a MySQL server using Docker:

   ```bash
   docker run --name employee-mysql -e MYSQL_ROOT_PASSWORD=root -e MYSQL_DATABASE=abukai_employee_management_db -p 3306:3306 -d mysql:8
   ```

5. **Create Schema**
   ```
      CREATE TABLE employees (
         id INT AUTO_INCREMENT PRIMARY KEY,
         name VARCHAR(255),
         email VARCHAR(255) UNIQUE,
         position VARCHAR(255),
         salary DECIMAL(10,2),
         created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
      );
   ```

6. **Access the API**
   Open your browser or use a tool like Postman to access the API at `http://localhost:8000`.