#!/bin/bash
# This script zips up a copy of a wordpress plugin and places it in ./build ready for upload testing. 🤐

CURRENT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" >/dev/null && pwd )"
DEST_DIR=$CURRENT_DIR/release/trunk
RSYNC_CMD=$(which rsync)

#Zip Up the files excluding ./build 🚧
$RSYNC_CMD -av --exclude="build/" --exclude=".git/" --exclude="*.sh" --exclude=".svn/" --exclude=".gitignore" --exclude="LICENSE" --exclude="release/" . ./release/trunk

cd ./release
svn add trunk/*

#That was easy! 🍻
echo -e "🍻  \e[32mCompleted - You can now find your plugin in $DEST_DIR"
