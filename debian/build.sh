#!/bin/bash

mkdir -p build/usr/share/php/gitrbug
mkdir -p build/usr/share/doc/gitrbug

cd build

# Setting this environment variable fixes Apple's modified GNU tar so that
# it won't make dot-underscore AppleDouble files. Google it for details...
export COPY_EXTENDED_ATTRIBUTES_DISABLE=1

tar czvf data.tar.gz usr etc
tar czvf control.tar.gz control postinst postrm

ar -r gitrbug-installer_0.1.deb debian-binary control.tar.gz data.tar.gz

mv *.deb ..
rm data.tar.gz control.tar.gz
cd ..
