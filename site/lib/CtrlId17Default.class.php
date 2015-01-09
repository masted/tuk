<?php

class CtrlId17Default extends CtrlThemeFour {
  use DdCrudParamFilterCtrl;

  protected function id() {
    return $this->req['id'];
  }

  protected function getStrName() {
    return 'items';
  }

  protected function processIm(DdItemsManager $im) {
    $im->imageSizes['smW'] = '120';
    $im->imageSizes['smH'] = '100';
  }

  protected function init() {
    Sflm::frontend('js')->addPath('m/js/site.js');
    $this->d['layout'] = 'cols2';
    $this->d['menu'][] = [
      'title' => 'Товары',
      'link'  => '/list'
    ];
  }

  protected function getParamActionN() {
    return 0;
  }

  function action_default() {
    $this->d['topTpl'] = 'shortHomeText';
    $this->d['blocksTpl'] = 'upload';
    $this->d['tpl'] = 'default';
    Sflm::frontend('js')->addPath('i/js/ngn/form/init.js');
    $form = new Form([
      [
        'title'        => 'Фотографии ваших вещей',
        'name'         => 'images',
        'type'         => 'file',
        'multiple'     => true,
        'allowedMimes' => ['image/gif', 'image/jpeg', 'image/png', 'image/bmp']
      ]
    ], [
      'submitTitle' => 'Загрузить',
      'dataParams'  => [
        'class' => 'TukUploadForm'
      ],
      'id' => 'tukUpload'
    ]);
    UploadTemp::extendFormOptions($form, '/json_upload');
    if ($form->isSubmittedAndValid()) {
      if ($form->getData()) {
        // {...}
      }
    }
    $this->d['form'] = $form->html();
    if (($loadedImages = UserTemp::get())) {
      $this->d['imagesLoadedForm'] = $this->imagesLoadedForm($loadedImages);
    }
  }

  function action_json_upload() {
    $this->imageLoadedAction(UserTemp::moveFromRequest($this->req));
  }

  protected function imagesLoadedForm(array $imageUrls) {
    $protoFields = [
      ['type' => 'col'],
      [
        'type'     => 'staticText',
        'rowClass' => 'image',
        'text'     => '<a href="{url}" class="lightbox"><img src="{smUrl}"></a>'
      ],
      [
        'title'     => 'Описание',
        'type'      => 'textarea',
        'useTypeJs' => false,
        'name'      => 'descr'
      ],
      [
        'title'    => 'Категория',
        'type'     => 'ddTagsTreeMultiselectDialogable',
        'required' => true,
        'name'     => 'cat'
      ],
    ];
    $fields = [];
    $fields[] = [
      'type' => 'staticText',
      'text' => '<h2>Вы загрузили эти вещи, но ещё не добавили</h2>'
    ];
    foreach ($imageUrls as $n => $url) {
      $colFields = $protoFields;
      $colFields[1]['text'] = St::tttt($colFields[1]['text'], [
        'url'   => $url,
        'smUrl' => Misc::getFilePrefexedPath($url, 'sm_'),
      ]);
      $colFields[2]['name'] = $colFields[2]['name']."[$n]";
      $colFields[3]['name'] = $colFields[3]['name']."[$n]";
      foreach ($colFields as $f) $fields[] = $f;
    }
    if (Auth::get('id')) {
      $fields[] = [
        'type' => 'col',
        'name' => 'userInfo'
      ];
      $fields[] = [
        'type' => 'staticText',
        'text' => 'Вы добавляете это сообщения как '.Auth::get('login')
      ];
    }
    $form = new DdForm($fields, 'items', [
      'submitTitle' => 'Добавить предметы',
      'id' => 'tukItemsAdd'
    ]);
    $form->action = '/json_create';
    return $form->html();
  }

  protected function imageLoadedAction(array $imageUrls) {
    $this->json['form'] = $this->imagesLoadedForm($imageUrls);
  }

  function action_json_create() {
    $this->json['validated'] = 'ok';
    $im = DdCore::imDefault('items');
    $images = UserTemp::get();
    foreach ($this->req['descr'] as $n => $cat) {
      $im->create([
        'cat'   => $this->req['cat'][$n],
        'descr' => $this->req['descr'][$n],
        'image' => [
          'tmp_name' => WEBROOT_PATH.$images[$n]
        ]
      ]);
    }
  }

  function action_list() {
    $items = $this->items();
    $this->d['bookmarks'] = [
      [
        'title' => 'Общее',
        'link'  => '/list',
        'sel'   => !$this->curUser
      ],
    ];
    $mine = false;
    if (Auth::get('id')) {
      $mine = $this->curUser and $this->curUser['id'] == Auth::get('id');
      $this->d['bookmarks'][] = [
        'title' => 'Моё',
        'link'  => '/list/u.'.Auth::get('id'),
        'sel'   => $mine
      ];
    }
    if (!$mine and $this->curUser) {
      $this->d['bookmarks'][] = [
        'title' => $this->curUser['login'],
        'link'  => '/list/u.'.$this->curUser['id'],
        'sel'   => true
      ];
    }
    $this->d['blocksTpl'] = 'cat';
    $this->d['layout'] = 'cols2';
    $base = $mine ? '/list/mine' : '/list';
    $tags = DdTags::get('items', 'cat');
    $this->d['catTree'] = DdTagsHtml::treeUl( //
      $tags->getData(), //
      '`<a href="'.$base.'/t2.`.$groupName.`.`.$id.`"><i></i><span>`.$title.`<span>(`.$cnt.`)</span></a>`' //
    );
    $this->d['tpl'] = 'list';
    $this->d['html'] = (new Ddo('items', 'siteItems'))->setItems($items->getItems())->els();
  }

  function action_ajax_deleteItem() {
    DdCore::imDefault('items')->delete($this->req['id']);
  }

}