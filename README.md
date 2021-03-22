# Installation

In order to install all the project dependencies, please make sure to run `composer install`.
This project was made in [Homestead](https://laravel.com/docs/8.x) box that uses **PHP 8.0|7.4** particularly which makes of it the ideal environment to test with.

To install and compile frontend assets `npm isntall && npm run dev`

# Tests

Tests can be executed by running the following command `vendor/bin/phpunit tests/`

# Send mail API

to send a mail, you need to send a **POST** request to `/mails` endpoint. Below are the all the inputs informations.

| params        | required    |   Description |
| -----------   | ----------- |--------------|
| sender        | true        |The sender of the email|
| recipient     | true        |The recipient of the email|
| subject       | false       |The subject of the email|
| text_content  | false       |The text version of the email|
| html_content  | false       |The html version of the email|
| attachments[] | false       |The attachments you want to join with the email|

## POSTMAN collection
You can import the following [collection](mailersend-postman-collection.json) to postman to have everything ready. 
**Do not forget to change environment host variable**


# What could be done better

Definitely the frontend design and UI. Additionally, the ability to add 'cc' and the possibility to program the mail for a later send.

# Final word
Thank you for giving me the chance to apply to this position.