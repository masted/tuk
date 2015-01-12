Ngn.TukUploadForm = new Class({
  Extends: Ngn.Form,

  submitedAndUploaded: function(r) {
    if (!r.result.form) throw new Error('no form in result');
    Ngn.Form.factory(Elements.from(r.result.form)[0].inject('itemsAdd'));
  }

});
