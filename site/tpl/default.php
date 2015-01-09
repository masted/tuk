<div id="preview"></div>

<script>
  Ngn.authorized = <?= Auth::get('id') ? 'true' : 'false' ?>;
  Ngn.tuk = {};
  <? if ($d['imagesLoadedForm']) { ?>
    Ngn.tuk.loadedImagesForm = <?= Arr::jsString($d['imagesLoadedForm']) ?>;
    f(Ngn.tuk.loadedImagesForm);
  <? } ?>
</script>
