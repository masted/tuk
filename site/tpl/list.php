<div class="bookmarks">
  <? $this->tpl('cp/links', $d['bookmarks'])?>
</div>
<div class="colBody">
  <div id="items"><?= $d['html'] ?></div>
</div>
<script>
  if (Ngn.authorized) {
    document.getElements('.items .item').each(function(eItem) {
      if (!Ngn.isAdmin && eItem.get('data-userId') != Ngn.authorized) return;
      Ngn.Btn.btn2('Редактировать', 'edit').inject(eItem, 'top').addEvent('click', function() {
        new Ngn.Dialog.RequestForm({
          title: 'Редактирование вещи',
          width: 300,
          url: '/?a=json_edit&id=' + eItem.get('data-id'),
          onOkClose: function() {
            window.location.reload();
          }
        });
      });
    });
  }
</script>
