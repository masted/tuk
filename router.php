<?php

if (preg_match('/\.(?:png|jpg|jpg|gif|css|js)(?:\?\d+|)$/', $_SERVER["REQUEST_URI"])) {
  return false;
} else { 
  require 'index.php';
}