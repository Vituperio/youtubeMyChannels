# Youtube My Channels

YoutubeMychannels is a collector of yours favorite youtube channels.

## Installation

```git
git clone https://github.com/FB-Devel/youtubeMyChannels.git
```

```mysql
CREATE DATABASE youtubeMyChannels;
CREATE TABLE channel_names ( cid int unsigned not null auto_increment, cname varchar(255) not null, ctype varchar(255) not null, primary key (cid) );
CREATE TABLE channel_type ( ctid int unsigned not null auto_increment, ctname varchar(255) not null,  primary key (ctid) );
```


Insert database parameters in **php/script.php** file:
```php
$server = '';
$user = '';
$passwd = '';
```


## How to use
* **You need a valid google account to use the utility**
* Click on *login* link at the right-top of the page
* Put *username* and *password* in the input fields
* Create the type to associate with the channel by *Aggiungi > + Categoria* item menu
* Copy the channel's name from youtube
* Create the channel by clicking on *Aggiungi > + Canale* item menu
* Reload homepage to see result
