#!/bin/bash
# This script zips up a copy of a wordpress plugin and places it in ./build ready for upload testing. 🤐


while getopts m:s:ms:e option
do
    case "${option}"
        in
        m) MESSAGE=${OPTARG,,};;
        s) SSL=${OPTARG^^};;
    esac
done

if [ -z "$MESSAGE" ]; then
    echo "We require a commit message."
    exit
fi

CURRENT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" >/dev/null && pwd )"
DEST_DIR=$CURRENT_DIR/release/trunk
RSYNC_CMD=$(which rsync)

#Zip Up the files excluding ./build 🚧
$RSYNC_CMD -av --exclude="build/" --exclude=".git/" --exclude="*.sh" --exclude=".svn/" --exclude=".gitignore" --exclude="LICENSE" --exclude="release/" . ./release/trunk

cd ./release
svn add trunk/*

#That was easy! 🍻
echo -e "🍻  \e[32mCompleted - You can now find your plugin in $DEST_DIR"
