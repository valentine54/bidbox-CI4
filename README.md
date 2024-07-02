

[![GitHub license](https://img.shields.io/github/license/codeigniter4/CodeIgniter4)](https://github.com/codeigniter4/CodeIgniter4/blob/develop/LICENSE)

# BidBox
An online luxury auctioning platform that connects buyers with unique luxury items through auctions.

## Description
BidBox is a web-based platform designed to facilitate online luxury auctions. Users can browse, bid on, and purchase high-end luxury items from various categories. The platform aims to provide a seamless and secure auction experience for both buyers and sellers.The platform has auctioneers who approve and disapprove bids.

## Project Setup/Installation Instructions

### Dependencies
- PHP >= 8.1
- CodeIgniter 4.x
- MySQL
- Composer

### Installation Steps
1. *Clone the Repository:*
   git clone https://github.com/Valentine54/bidbox-CI4.git
   cd bidbox-CI4.git

2. *Install Composer Dependencies:*
   composer install

3. *Set Up Environment Variables:*
   - Duplicate the env file and rename it to .env.
   - Configure your database settings and other environment variables in the .env file.

4. *Migrate the Database:*
   php spark migrate

5. *Start the Development Server:*
   php spark serve

## Usage Instructions

### How to Run
1. *Start your local server environment:*
   Ensure your local server (e.g., XAMPP, MAMP) with PHP and MySQL is running.

2. *Access the Application:*
   Open your web browser and navigate to [http://localhost:8080](http://localhost:8080).

### Examples
- *Browse Auction Items:*
  Visit the homepage to view available auction items and their details.
  (http://localhost:8080/)

- *Auctioneer to view a Bid:*
  Click on view bids after successful login.
  ( http://localhost:8080/index.php/auctioneer/view-bidders)
  

### Input/Output
- *Input:* User actions such as browsing items, placing bids, and updating account details.
- *Output:* Updated auction status, bid history, and user details.

## Project Structure

### Overview
- *app/Controllers:* Contains all controller files, including AdminController.php.
- *app/Models:* Contains model files like UserModel.php for database interactions.
- *app/Views:* Contains view files for frontend rendering, organized by auction item categories.
- *public/:* Publicly accessible files like CSS, JS, and uploaded item images and profile images.
- *writable/uploads:* Directory where uploaded application images are stored but cannot be viewed publicly.

### Key Files
- *app/Controllers/AdminController.php:* Handles all the operations an admin is able to do in a system.Admin has some of the most important roles
- *app/Models/productModel.php:* Interacts with the database to save and retrieve auction item data.
- *app/Views/home.php:* Main view file for displaying auction items and managing bids.
- *public/css/auction.css:* Contains custom styles for the auction interface.

## Additional Sections

### Project Status
This project is actively in development.

### Known Issues
- Improved validation and error handling for bid submissions.
- Enhancements for scalability and performance under high traffic conditions.
- Better handle applications of users to join the system

### License
This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

### Acknowledgements
- CodeIgniter 4 Documentation
- Bootstrap
- Php Storm IDE

### Contact Information
For questions or feedback, please contact us through the issues section of the repository.





