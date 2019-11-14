# Camagru

_[PHP/MySQL/JavaScript/AJAX]_\
\
Small web photo application which lets an user register, log in, then select camera filters and take pictures directly trough their webcam (or file upload).
The app lets you comment, like and dislike other users' pictures.
As privacy is an important topic, the user can also delete their account (all content will be supressed, no data will be held back).


## Registration

* Valid e-mail address
* Username
* Secure password (8 characters minimum, one capital letter, one small letter, one digit and one special character : `!@#$%^&*-`)
* Password confirmation

The account is then created (and a unique token generated), but unverified. A verification e-mail will then be sent to the input e-mail address, with the specified token in the URL.

## 'Snapshot' page (only for the logged-in user)

The user can try out filters then take a picture through his webcam, or a regular file upload if a direct stream is unavailable.

## 'Gallery' page (homepage if logged-in)

Global photo gallery with pagination, sorted by the most recent pictures taken.
* Navigate to a picture/post
* Comment picture/post (handled with AJAX)
* Like/dislike content (handled with AJAX)

## User page (only for the logged-in user)

The personnal user page, which contains all their information.\
There, they can change :
* Their username
* Their e-mail address
* Their password\

They can also delete their account (*all content will be disappear, no data will be kept*).
