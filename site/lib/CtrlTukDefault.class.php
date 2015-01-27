<?php

class CtrlTukDefault extends CtrlThemeFour {
  use DdCrudParamFilterCtrl;

  protected function id() {
    return $this->req['id'];
  }

  protected function getStrName() {
    return 'items';
  }

  protected function _getIm() {
    $fields = new DdFields($this->getStrName());
    $fields->fields['cat']['type'] = 'ddTagsTreeMultiselectDialogable';
    $im = new DdItemsManager($this->items(), $this->objectProcess(new DdForm($fields, $this->getStrName()), 'form'));
    $im->imageSizes['smW'] = '120';
    $im->imageSizes['smH'] = '100';
    return $im;
  }

  protected function init() {
    Sflm::frontend('js')->addClass('Ngn.Dialog.RequestForm');
    Sflm::frontend('css')->addLib('icons');
    $this->d['layout'] = 'cols2';
    $this->d['menu'][] = [
      'title' => 'Товары',
      'link'  => '/list'
    ];
    $this->d['menu'][] = [
      'title' => 'О сервисе',
      'link'  => '/about',
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
      'id' => 'tukUpload',
      'dataParams'  => [
        'class' => 'TukUploadForm'
      ]
    ]);
    UploadTemp::extendFormOptions($form, '/json_upload');
    if ($form->isSubmittedAndValid()) throw new Exception('non-ajax form request is not allowed');
    $this->d['uploadForm'] = $form->html();
    if (($loadedImages = TukUserTemp::get())) {
      die2($loadedImages);
      $this->d['itemsAddForm'] = $this->itemsAddForm($loadedImages);
    }
  }

  function action_json_upload() {
    sleep(1);
    $this->imageLoadedAction(TukUserTemp::moveFromRequest($this->req));
  }

  protected function itemsAddForm(array $imageUrls) {
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
      'id' => 'tukItemsAdd',
    ]);
    $form->action = '/json_create';
    return $form->html();
  }

  protected function imageLoadedAction(array $imageUrls) {
    $this->json['form'] = $this->itemsAddForm($imageUrls);
  }

  function action_json_create() {
    $this->json['validated'] = 'ok';
    $im = DdCore::imDefault('items');
    $images = Misc::checkEmpty(TukUserTemp::get(true), 'no temp images by userId "'.Auth::get('id').'"');
    foreach ($this->req['descr'] as $n => $cat) {
      $im->create([
        'cat'   => $this->req['cat'][$n],
        'descr' => $this->req['descr'][$n],
        'image' => [
          'tmp_name' => WEBROOT_PATH.'/'.$images[$n]
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
      ]
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
    $this->d['layout'] = 'cols2';
    $this->d['blocksTpl'] = 'cat';
    $this->d['tpl'] = 'list';
    $base = $mine ? '/list/mine' : '/list';
    $tags = DdTags::get('items', 'cat');
    $this->d['catTree'] = DdTagsHtml::treeUl( //
      $tags->getData(),
      '`<a href="'.$base.'/t2.`.$groupName.`.`.$id.`"><i></i><span>`.$title.`<span>(`.$cnt.`)</span></a>`' //
    );
    $this->d['html'] = (new Ddo('items', 'siteItems'))->setItems($items->getItems())->els();
  }

  function action_item() {
    $this->d['layout'] = 'cols2';
    $this->d['blocksTpl'] = 'user';
    $this->d['tpl'] = 'item';
    $this->d['item'] = $this->items()->getItem($this->req->param(1));
    $this->d['user'] = DbModelCore::get('users', $this->d['item']['authorId']);
  }

}