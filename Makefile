#!/usr/bin/make

export BASH=bash

up:
	./vendor/bin/sail up -d

down:
	./vendor/bin/sail down

