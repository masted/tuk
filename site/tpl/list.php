<div class="bookmarks">
  <? $this->tpl('cp/links', $d['bookmarks'])?>
</div>
<div class="colBody">
  <div id="items"><?= $d['html'] ?></div>
</div>
<script>
  new Ngn.DdoItemsEdit();
  Ngn.Btn.btn1('Добавить вещь', 'add').inject(document.getElement('.bookmarks')).addEvent('click', function() {
    new Ngn.Dialog.RequestForm({
      title: 'Добавление вещи',
      width: 300,
      url: '/?a=json_new',
      onOkClose: function() {
        window.location.reload();
      }
    });
  });
</script>
