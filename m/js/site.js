Locale.define('ru-RU', 'FormValidator', 'required', 'выберите');

window.addEvent('domready', function() {
  Ngn.addBtnAction('a.auth', function() {
    new Ngn.Dialog.Auth();
  });
});


Ngn.TukItemsAddForm = new Class({

  initialize: function(eForm) {
    var options = {
      ajaxSubmit: true,
      onComplete: function() {
        window.location = '/list';
      }
    };
    if (!Ngn.authorized) {
      new Ngn.AuthDdForm(eForm, options);
    } else {
      new Ngn.DdForm(eForm, options);
    }
  }

});


Ngn.TukUploadForm = new Class({
  Extends: Ngn.Form,

  submitedAndUploaded: function(r) {
    if (!r.result.form) throw new Error('no form in result');
    Ngn.Form.factory(Elements.from(r.result.form)[0].inject('itemsAdd'));
  }

});
