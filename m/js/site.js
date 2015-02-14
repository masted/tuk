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
    if (!r.result || !r.result.form) throw new Error('no form in result');
    Ngn.Form.factory(Elements.from(r.result.form)[0].inject('itemsAdd'));
  }

});
