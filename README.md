# Bieber Say #

A simple web api to control LCD's public address system. A small component in a very elaborate and intricate master plan.

## Beware ##

* When using apache under the www-data user do not forget to add www-data to the audio group
* GNUStep creates a folder in the home of the user that is running the command, make sure this folder is writable

## Testing Instructions ##

- sudo apt-get install gnustep-gui-runtime
- php -S 0.0.0.0:8080 index.php

POST localhost:8080
Raw Body: 
{
  "message": "What you want to say"
}
