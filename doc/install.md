setfacl -dR -m u:"$HTTPDUSER":rwX -m u:$(whoami):rwX INSTALL_PATH/vendor/ezyang/htmlpurifier/library/HTMLPurifier/DefinitionCache/Serializer
setfacl -R -m u:"$HTTPDUSER":rwX -m u:$(whoami):rwX INSTALL_PATH/vendor/ezyang/htmlpurifier/library/HTMLPurifier/DefinitionCache/Serializer
