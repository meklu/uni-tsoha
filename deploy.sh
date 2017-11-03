#!/bin/sh
cd "$(dirname "$(readlink -f "$0")")"

rsync -pvihurtz \
	--progress \
	--exclude ".git" \
	--links --copy-unsafe-links --delete \
	./ melker@users2017.cs.helsinki.fi:~/htdocs/"$(basename "$PWD")"/
