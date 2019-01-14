# TheCookieManager

The Cookie Manager (TCM) is a web application to help manage the logistics of girl scout cookie ordering and delivery.

## Installation

* Get the git repository
* Copy 'config/.env.default' to config/.env' and edit it to reflect reflect your setup.
* Run: heroku create
* Run: heroku addons:add heroku-postgresql:hobby-dev 
* Go to the heroku UI and create Variables for the values in .env, set DEBUG=false.
* Run: heroku run bash
* In bash console run bin/cake migrations migrate
* Run: heroku open

Default login: admin/passwd


