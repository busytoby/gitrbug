#!/bin/bash

# This script should be run from within the directory with the wav files.

# First, create the empty tree under a new "build" directory
# (the name "build" is completely arbitrary here)
mkdir -p build/usr/share/php/gitrbug
mkdir -p build/usr/share/doc/gitrbug

cd build

# Setting this environment variable fixes Apple's modified GNU tar so that
# it won't make dot-underscore AppleDouble files. Google it for details...
export COPY_EXTENDED_ATTRIBUTES_DISABLE=1

# create the data tarball
# (the tar options "czvf" mean create, zip, verbose, and filename.)
tar czvf data.tar.gz usr etc

# create the control tarball
tar czvf control.tar.gz control preinst postinst postrm

# create the debian-binary file
echo 2.0 > debian-binary

# create the ar (deb) archive
ar -r gitrbug-installer_0.1.deb debian-binary control.tar.gz data.tar.gz

# move the new deb up a directory
mv *.deb ..

# remove the tarballs, and cd back up to where we started
rm data.tar.gz control.tar.gz
cd ..
