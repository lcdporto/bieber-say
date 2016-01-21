# Bieber Say #

A simple WEB API to control LCD's public address system. A small component in a very elaborate and intricate master plan.

This API generate json responses. 


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
npm install
```
3) Start the server. You can use the PHP built-in webserver. Example:
```
npm start
```



## Using the API ##
Running the server will print both the API usage and the API Explorer URL.
Use the API Explorer URL to check the API usage documentation.