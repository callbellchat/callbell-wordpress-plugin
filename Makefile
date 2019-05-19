release:
	zip -r dist/callbell-widget.zip . -x '*.git*' -x '*.DS_Store*' -x '*dist*' -x '*README.md' -x '*docker-compose.yml' -x '*Makefile*' -x '*svn*'

