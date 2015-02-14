<div class="bookmarks">
  <? $this->tpl('cp/links', $d['bookmarks'])?>
</div>
<div class="colBody">
  <div id="items"><?= $d['html'] ?></div>
</div>
<script>
  new Ngn.DdoItemsEdit();
</script>
