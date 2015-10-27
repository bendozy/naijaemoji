[![Build Status](https://travis-ci.org/andela-cijeomah/naijaemoji.svg?branch=master)](https://travis-ci.org/andela-cijeomah/naijaemoji)

#NaijaEmoji

NaijaEmoji is RESTful API for CRUD operations on the common emojis reimagined
for Nigerians. The API uses simple token based authentication and is developed
[The PHP League way](https://thephpleague.com/). A demo is hosted at
[naija-emoji.herokuapps.com](http://naija-emoji.herokuapps.com/)


#Testing
 The phpspec framework for testing is used to perform
 unit test on the classes. The TDD principle has been
 employed

 Run this on bash to execute the tests
 ```````bash
 bin/phpspec run --format=pretty
`````````

#Install   

- To install this package, PHP 5.5.9+ and Composer are required

````bash

git clone https://github.com/andela-cijeomah/naijaemoji.git

composer install

php -S localhost:8080

``````

## Usage

Create mysql database with users and emojis tables. Use "test" and "password" as your username and 
password respectively. Do not forget to enable utf8-mb4 charset encoding on the database and each table.

If you need help with enabling utf8-mb4, here is a [guide](https://mathiasbynens.be/notes/mysql-utf8mb4).
 

## Change log
Please refer to [CHANGELOG](CHANGELOG.mds) file for information on what has changed recently.

## Contributing
Please check out [CONTRIBUTING](CONTRIBUTING.md) file for detailed contribution guidelines.

## Credits
Naija Emoji is maintained by [Chidozie Ijeomah](https://github.com/andela-cijeomah).

## License
Naija Emoji is released under the MIT Licence. See the bundled [LICENSE](LICENSE.md) file for details.


