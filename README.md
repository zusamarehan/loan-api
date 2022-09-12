### Clone
`git clone https://github.com/zusamarehan/loan-api.git`

### Install Dependencies
- `composer install`
- `cp .env.example .env`
- Create a database with any name you like, and update the database name in the `.env` file with the username and password
- `php artisan migrate:fresh --seed`
    - This will create 1 admin user (admin@aspire.app/password)
    - Will create 10 customers

#### The Repo Contains the following Module
- **Authentication**
  - Login (available to: customer|admin)   
  - Logout (available to: customer|admin)
  - Register (available to: all)
- **Loan**
  - Submit Loan Request (available to: customer)
  - Loan Approval (available to: admin)
  - Loan Decline (available to: admin)
  - Loan Show (available to: customer|admin)
  - Loan List (available to: admin)
- **Repayment**
  - Repayment of the Loan (available to: customer)

Also, Feature Testing (using PHPUnit) of the above mention modules.

### Notes
- The repo using `Action Class` pattern, which makes the Controllers/Models shorter.
- The `Action Class` pattern, is more testable and re-usable (in Events/Queuing) as the logics are not tied to the controllers.

### Post API Collection:
Postman Collection JSON Link can be found here: https://www.getpostman.com/collections/bb3dc43f7694b63b2a5c
