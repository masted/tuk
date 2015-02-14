<div class="colBody blockText">
  <p>Телефон:<br><?= $d['user']['phone'] ?></p>
  <!--<a class="smIcons btn comments" href="#" id="sendUser"><i></i>Отправить SMS</a>-->
</div>
<div class="line"></div>
<!--
<script>
  $('sendUser').addEvent('click', function(e) {
    e.preventDefault();
    new Ngn.Dialog.RequestForm({
      width: 300,
      url: '/json_sendMsg/' + <?= $d['user']['id'] ?>
    });
  });
</script>
-->