Symfony2Base

Setup:

1. git clone git@github.com:LIME-Marketing/Symfony2Base.git
2. php app/init deploy


# Optional but Recommended
Install APC
1. sudo apt-get install php5-dev apache2-dev build-essential apache2-threaded-dev php-pear
2. sudo pecl install apc
3. Add the following to php.ini: extension=apc.so