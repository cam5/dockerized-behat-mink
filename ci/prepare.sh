#!/bin/bash

if [[ ! -f var/cache/prod ]]; then
 mkdir -p var/cache/prod
fi;

chmod +w var/cache/prod && chmod g+x var/cache/prod

if [[ ! -f var/logs/prod ]]; then
 mkdir -p var/logs/prod
fi;

chmod g+w var/logs/prod

if [[ ! -f var/sessions/prod ]]; then
 mkdir -p var/sessions/prod
fi;

chmod g+w var/sessions/prod
