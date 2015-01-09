<?php

class TestUiTuk extends ProjectTestCase {

  function test() {
    Casper::runFile(PROJECT_PATH.'/casper/upload');
  }

}