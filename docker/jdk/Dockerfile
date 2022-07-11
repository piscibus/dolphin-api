FROM eclipse-temurin:17-jdk

RUN apt-get update && apt-get -y upgrade
RUN apt-get install -y dos2unix

ENV HOME=/app
RUN mkdir -p $HOME
WORKDIR $HOME
