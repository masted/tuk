<?php

db()->query("DELETE FROM users WHERE id>1");
print "deleted users\n";
Dir::clear('C:/1/captures');
print "C:/1/captures cleared\n";
