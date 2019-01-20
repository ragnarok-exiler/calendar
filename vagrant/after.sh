#!/bin/sh

# If you would like to do some extra provisioning you may
# add any commands you wish to this file and they will
# be run after the Homestead machine is provisioned.
#
# If you have user-specific configurations you would like
# to apply, you may also create user-customizations.sh,
# which will be run after this script.


sudo cat > /etc/php/7.2/fpm/conf.d/20-xdebug.ini << EOF
zend_extension=xdebug.so
xdebug.default_enable=1
xdebug.remote_enable=1
xdebug.remote_handler=dbgp
xdebug.remote_connect_back=1
xdebug.remote_port=9000
xdebug.remote_autostart=1
EOF

php /home/vagrant/code/yii migrate --interactive=0
php /home/vagrant/code/yii migrate --migrationPath=@yii/rbac/migrations --interactive=0