<?php

Ngn::addBasePath(NGN_ENV_PATH.'/thm/four', 4);

Ngn::addEvent('auth', function($user) {
  TukUserTemp::moveSessionToAuth($user['id']);
});
