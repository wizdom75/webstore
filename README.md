# websore
A bespoke shopping cart

Installation instructions:

1. Use the webstore.sql file to create a database and add tables therein.
2. Copy all files to a server root.
3. CD to the webstore directory and run npm install to install all dependancies.
4. Update the .env file with you DB details and other required settings.
5. Create an account using the register link on the navbar.
6. You will need to usse your DB management client to set your account as admin by updating the record in the DB to state that the role of the user is 'admin'
7. The cart comes configured to use the stripe payments module.
