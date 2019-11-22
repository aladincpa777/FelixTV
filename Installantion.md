# FelixTV Installantion

## Requirements

- Web server - Apache2 + MySQL + PHP (You can also use Nginx, but don't forget to apply URL Rewrite rules)
- Stream server - Apache2/Nginx, CURL, PHP

## Configuration Web-side
 ###### Import FELIX.sql into your SQL Table
 ###### Edit config.php in \application\config and put right Domain
 ###### Edit database.php in \application\config and change creds into your SQL Database
 ###### Edit home.php in \application\views\front_end\ and Edit SQL Creds
 ###### Edit watch.php and tvseries_watch.php in \application\views\front_end\ and Change s.felixtv.cz into your Own Stream server
 ###### Download Video Thumbs [here](https://mega.nz/#!SKQwFajb!ByusgX_CQ-oAhOiXg3UA_TxgcfYbR1gRFZgBto7WQRw) and extract it (with folder video_thumb) into uploads\

## Configuration Stream-side
 ###### Put files from /stream/ into your /www/ directory then install Requirements and edit PHP-Curl limits
 ###### Edit `web_stream.php` and replace USERNAME with your Username on Streamuj.tv
 ###### Edit `web_stream.php` and replace hashxxxxXXXXxxxxx with your Streamuj.tv HASH, you can find it here
 | *Aladin237 = USERNAME* |  <br />
 | *0b.. = HASH* | 
 ![Streamuj tv HASH](https://github.com/zgruza/FelixTV/blob/master/ScreenShots/where_can_i_find_streamujtv_hash.png?raw=true)


## Fast Documentation
![Flags+Streamuj url](https://github.com/zgruza/FelixTV/blob/master/ScreenShots/phpmyadmin.png?raw=true)

Adding recently added Movies is really simple.
You can get recently added movies in `/MOVIE-SERIALS-MINER/recentlyadded.php`
![Adding recently added movies](https://github.com/zgruza/FelixTV/blob/master/ScreenShots/Adding_Recently_Added.png?raw=true)

You can add also Single movie `/MOVIE-SERIALS-MINER/search.php?q=Simpson..`
![Adding One movie](https://github.com/zgruza/FelixTV/blob/master/ScreenShots/Add_Single_Movie.png?raw=true)

Adding TV Shows is more complicated, you must specify episode_id in real_episode_id
![Adding TV Show episode](https://github.com/zgruza/FelixTV/blob/master/ScreenShots/SQL_IDes.png?raw=true)
