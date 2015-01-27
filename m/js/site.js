Locale.define('ru-RU', 'FormValidator', 'required', 'выберите');

Ngn.Form.registerFactory('tukItemsAdd', function(eForm) {
  var options = {
    ajaxSubmit: true,
    onComplete: function() {
      window.location = '/list';
    }
  };
  if (!Ngn.authorized) {
    return new Ngn.AuthDdForm(eForm, options);
  } else {
    return new Ngn.DdForm(eForm, options);
  }
});

Ngn.TukUploadForm = new Class({
  Extends: Ngn.Form,

  submitedAndUploaded: function(r) {
    c('1111111111111');
    if (!r.result || !r.result.form) throw new Error('no form in result');
    c('2222222222222');
    Ngn.Form.factory(Elements.from(r.result.form)[0].inject('itemsAdd'));
  }

});

document.addEvent('domready', function() {
  new Ngn.Request({
    url: '/ajax_slow',
    onComplete: function() {
      c(Ngn.Request.inProgress);
    }
  }).send();
  c(Ngn.Request.inProgress);
});