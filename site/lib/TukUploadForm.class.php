<?php

class TukUploadForm extends Form {

  function __construct() {
    parent::__construct([
      [
        'title'        => 'Фотографии ваших вещей',
        'name'         => 'images',
        'type'         => 'file',
        'multiple'     => true,
        'allowedMimes' => ['image/gif', 'image/jpeg', 'image/png', 'image/bmp']
      ]
    ], [
      'submitTitle' => 'Загрузить',
      'idByClass' => true,
      'jsClassById' => true
    ]);
    UploadTemp::extendFormOptions($this, '/json_upload');
  }

}