FROM ubuntu

RUN apt-get update && apt-get upgrade -y
RUN apt-get install -y python-software-properties software-properties-common
RUN LC_ALL=C.UTF-8 add-apt-repository ppa:ondrej/php
RUN apt-get update

RUN apt-get install -y php7.0
