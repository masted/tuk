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
      'title' => 'Вещи',
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
    Sflm::frontend('js')->addPath('i/js/ngn/form/domreadyInit.js');
    $form = new TukUploadForm;
    if ($form->isSubmittedAndValid()) throw new Exception('non-ajax form request is not allowed');
    $this->d['uploadForm'] = $form->html();
    if (($loadedImages = TukUserTemp::get())) {
      $this->d['itemsAddForm'] = (new TukItemsAddForm($loadedImages))->html();
    }
  }

  function action_json_upload() {
    $this->imageLoadedAction(array_merge(TukUserTemp::get(), TukUserTemp::moveFromRequest($this->req)));
  }

  protected function imageLoadedAction(array $imageUrls) {
    $this->json['itemsAddForm'] = '<div class="apeform">'.(new TukItemsAddForm($imageUrls))->html().'</div>';
  }

  function action_json_create() {
    $this->json['validated'] = 'ok';
    $images = Misc::checkEmpty(TukUserTemp::get(true), 'no temp images by userId "'.Auth::get('id').'"');
    foreach ($this->req['title'] as $n => $cat) {
      $this->getIm()->create([
        'cat'   => $this->req['cat'][$n],
        'title' => $this->req['title'][$n],
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
      '`<a href="'.$base.'/t2.`.$groupName.`.`.$id.`"><i></i><span><span class="tit">`.$title.`</span><span class="cnt">`.$cnt.`</span></a>`' //
    );
    $this->d['html'] = (new Ddo('items', 'siteItems'))->setItems($items->getItems())->els();
  }

  function action_item() {
    $this->d['layout'] = 'cols2';
    $this->d['blocksTpl'] = 'user';
    $this->d['tpl'] = 'item';
    $this->d['item'] = $this->items()->getItem($this->req->param(1));
    $this->d['user'] = DbModelCore::get('users', $this->d['item']['authorId']);
    $this->setPageTitle($this->d['item']['title']);
  }

  function action_json_sendMsg() {
    return $this->jsonFormAction(new Form([
      [
        'name' => 'text',
        'type' => 'textarea'
      ]
    ], [
      'title' => 'Отправка SMS на ' . DbModelCore::get('users', $this->req->param(1))['phone'],
      'submitTitle' => 'Отправить'
    ]));
  }

}