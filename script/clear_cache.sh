#!/bin/bash

echo "clearing cache/*"
rm -f ../src/cache/*.*

echo "clearing admin/cache/*"
rm -f ../src/admin/cache/*.*

for DIR in `find ../src/cache/* -maxdepth 1 -type d`
do
    echo "clearing $DIR/*"
    rm -fr "$DIR/"*
done

for DIR in `find ../src/admin/cache/* -maxdepth 1 -type d`
do
    echo "clearing $DIR/*"
    rm -fr "$DIR/"*
done