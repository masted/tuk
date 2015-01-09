<div class="bookmarks">
  <? $this->tpl('cp/links', $d['bookmarks'])?>
</div>
<div class="colBody">
  <div id="items"><?= $d['html'] ?></div>
</div>

<!--<script>
  $$('#items .item').each(function(eItem) {
    new Element('button', {
      html: 'Удалить'
    }).inject(eItem).addEvent('click', function() {
      new Ngn.Request({
        url: '/ajax_deleteItem',
        onComplete: function() {
          eItem.dispose();
        }
      }).get({
          id: eItem.get('data-id')
        });
    });
  });
</script>-->