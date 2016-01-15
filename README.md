# Bieber Say #

A simple web api to control LCD's public address system. A small component in a very elaborate and intricate master plan.

This API generate json responses following JSend specifications. More information at: http://labs.omniti.com/labs/jsend


## Installing Instructions ##

### Text to Speech dependency ###
First things first, you'll need to install the gnustep-gui-runtime. This is the text-to-speech (tts) used to convert text into audio
```
sudo apt-get install gnustep-gui-runtime
```

**Beware**
* If you're planning on using apache to serve the API under the www-data user, do not forget to add www-data to the audio group
* GNUStep creates a folder in the home of the user that is running the command, make sure this folder is writable


### Installing the API ###
1) Clone the repository
2) Install dependencies
```
php composer.phar install
```
3) Start the server. You can use the PHP built-in webserver. Example:
```
php -S 0.0.0.0:8080 index.php
```



## Using the API ##

### Say something ###
Send a POST request to localhost:8080

Raw Body: 
```
{
  "message": "What you want to say"
}
```




### Template System
#### Get a list of templates available:
GET localhost:8080/templates

#### Run a template:
GET localhost:8080/templates/{templateName}?var=value
You can replace placeholders by sending it's name and the value to be replaced as query strings

#### Create a template:
POST localhost:8080/templates
Raw body:
```
{
	"name": "This_is_the_template_name",
    "message": "This is the template message. It supports {{Placeholders}} to be replaced later"
}
```