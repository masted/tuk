Locale.define('ru-RU', 'FormValidator', 'required', 'выберите');

Ngn.AuthDdForm = new Class({
  Extends: Ngn.DdForm,
  submit: function() {
    if (!this.validator.validate()) return false;
    var f = this;
    new Ngn.Dialog.Auth({
      reloadOnAuth: false,
      onAuthComplete: function() {
        f.fireEvent('submit');
        f.disable(true);
        f.submitAjax();
      }.bind(this)
    });
  }
});

var f = function(html) {
  html = Elements.from(html);
  for (var i=0; i<html.length; i++) html[i].inject($('preview'));
  var opts = {
    ajaxSubmit: true,
    onComplete: function(r) {
      window.location = '/list';
    }
  };
  var eForm = $('preview').getElement('form');
  c('authorized: ' + Ngn.authorized);
  if (!Ngn.authorized) {
    new Ngn.AuthDdForm(eForm, opts);
  } else {
    new Ngn.DdForm(eForm, opts);
  }
  Ngn.Milkbox.add(eForm.getElements('a.lightbox'));
};

Ngn.TukUploadForm = new Class({
  Extends: Ngn.Form,

  submitedAndUploaded: function(r) {
    if (!r.result.form) throw new Error('no form in result');
    f(r.result.form);
  }

});

window.addEvent('domready', function() {
  document.getElements('a.auth').each(function(el) {
    el.addEvent('click', function(e) {
      e.preventDefault();
      new Ngn.Dialog.Auth();
    });
  });
});

// for testing
//  new Ngn.Request.JSON({
//    url: '/json_uploadTest', //
//    onComplete: function(r) {
//      $('preview').set('html', r.form);
//      new Ngn.DdForm($('preview').getElement('form'), {
//        ajaxSubmit: true,
//        onComplete: function(r) {
//          c('items added');
//        }
//      });
//    }
//  }).send();


