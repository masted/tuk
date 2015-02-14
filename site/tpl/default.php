<?/*
<style>
  #dropZone {
    height: 200px;
    border: 1px solid #d9d8c9;
    background: #f6f5e9;
    text-align: center;
    line-height: 200px;
    margin: 10px 50px;
    color: #a9a89c;
  }
</style>
<div id="dropZone">Или перетащите их сюда</div>
*/
?>
<?/*
<style>
  .present {
    margin-left: 30px;
    position: relative;
    font-size: 20px;
    font-family: Boblic;
  }
  .present .slide {
    opacity: 0;
    left: 0;
    position: absolute;
  }
  .present .slideText {
    top: 100px;
    width: 200px;
  }
  .present .slideRText {
    text-align: right;
  }
  .present .slideMasha, .present .slideMashaIntro, .present .slideProblem {
    left: 400px;
  }
  .present .slideShoes {
    top: 150px;
  }
  .present .slideShoesText {
    top: 50px;
  }
</style>

<div class="present">
  <div class="slide slideMisha"><img src="/m/img/present/boy.png"/></div>
  <div class="slide slideShoes"><img src="/m/img/present/shoes.png"/></div>
  <div class="slide slideText slideRText slideMishaIntro">Это Миша</div>
  <div class="slide slideText slideRText slideShoesText">У Миши от бабушки остались старые калоши, которые некому носить
  </div>
  <div class="slide slideMasha"><img src="/m/img/present/sad-girl.png"/></div>
  <div class="slide slideText slideMashaIntro">А это Маша</div>
  <div class="slide slideText slideProblem">Сегодня дождь, а у неё совсем не в чем пойти на работу</div>
</div>

<script>
  new Fx.Morph(document.getElement('.present .slideMisha'), {
    onComplete: function() {
      var fx = new Fx.Morph(document.getElement('.present .slideMishaIntro')).start({
        left: '250px',
        opacity: 1
      }).chain(function() {
        this.start.delay(1000, fx, {
          opacity: 0
        });
      }).chain(function() {
        var shoesShown = false;
        var fx = new Fx.Morph(document.getElement('.present .slideShoesText'), {
          onComplete: function() {
            if (shoesShown) return;
            shoesShown = true;
            new Fx.Morph(document.getElement('.present .slideShoes')).set({
              left: '200px'
            }).start({
              opacity: 1,
              left: '370px'
            });
          }
        }).start({
          'left': '220px',
          'opacity': 1
        }).chain(function() {
          this.start.delay(3000, fx, {
            opacity: 0
          })
        }).chain(function() {
          new Fx.Morph(document.getElement('.present .slideMasha'), {
            onComplete: function() {
              var fx = new Fx.Morph(document.getElement('.present .slideMashaIntro')).set({'left': '140px'}).start({
                'left': '140px',
                'opacity': 1
              }).chain(function() {
                this.start.delay(1500, fx, {
                  opacity: 0
                });
              }).chain(function() {
                new Fx.Morph(document.getElement('.present .slideProblem'), {}).start({
                  left: '150px',
                  opacity: 1
                });
              });
            }
          }).start({
              'left': '0px',
              'opacity': 1
            });
        })
      });
    }
  }).start({
      left: '440px',
      opacity: 1
    });
</script>
*/?>
<div id="itemsAdd">
  <? if ($d['itemsAddForm']) { ?>
    <div class="apeform">
      <?= $d['itemsAddForm'] ?>
    </div>
  <? } ?>
</div>
