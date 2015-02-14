<div class="bookmarks">
  <?= $d['item']['title'] ?>
</div>
<div class="colBody">
  <div class="itemContent a">
    <a href="<?= $d['item']['image'] ?>" class="lightbox thumb"><img src="<?= $d['item']['md_image'] ?>"></a>
  </div>
  <div class="itemContent b">
    <? if ($d['item']['descr']) { ?>
      <?= $d['item']['descr'] ?>
    <? } else { ?>
      <div class="info" style="display: inline-block">Описание отсутствует</div>
    <? } ?>
  </div>
</div>
