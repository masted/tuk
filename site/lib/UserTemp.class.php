<?php

class UserTemp {

  static function moveFromRequest(Req $req) {
    $id = Auth::get('id') ?: session_id();
    $f = "/temp/$id/";
    Dir::make(UPLOAD_PATH.$f);
    $image = new Image;
    $r = [];
    foreach ($req->files['images'] as $file) {
      $name = rand(100000, 999999);
      copy($file['tmp_name'], UPLOAD_PATH.$f.$name.'.png');
      $image->resizeAndSave(UPLOAD_PATH.$f.$name.'.png', UPLOAD_PATH.$f.'sm_'.$name.'.png', 100, 100);
      $r[] = '/'.UPLOAD_DIR.$f.$name.'.png';
    }
    return $r;
  }

  static function get() {
    $id = Auth::get('id') ?: session_id();
    return array_map(function($v) {
      return '/'.str_replace(UPLOAD_PATH, UPLOAD_DIR, $v);
    }, array_filter(glob(UPLOAD_PATH.'/temp/'.$id.'/*'), function($v) {
      return !Misc::hasPrefix('sm_', basename($v));
    }));
  }

}