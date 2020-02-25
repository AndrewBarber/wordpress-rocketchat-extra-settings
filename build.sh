#!/bin/bash
# This script zips up a copy of a wordpress plugin and places it in ./build ready for upload testing. 🤐

CURRENT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" >/dev/null && pwd )"
DEST_DIR=$CURRENT_DIR/build
ZIP_CMD=$(which zip)
PLUGIN_NAME=${PWD##*/}
DEST_FILE=$DEST_DIR/$PLUGIN_NAME.zip

#If ./build dir doesn't exist then create it. 🆕
[[ -d $DEST_DIR ]] || mkdir $DEST_DIR

#If a zip of the plugin exists then delete it. 🗑️
rm $DEST_FILE

#Zip Up the files excluding ./build 🚧
$ZIP_CMD -r $DEST_FILE . -x "./build*" -x "./release*" -x ".git/*" -x ".svn/*" -x ".gitignore" -x "LICENSE"

#That was easy! 🍻
echo -e "🍻  \e[32mCompleted - You can now find your plugin in ./build"