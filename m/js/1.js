$('items').getElements('.item').each(function(eItem) {
  Ngn.btn2('Редактировать', 'edit').inject(eItem, 'top').addEvent('click', function() {
    new Ngn.Dialog.RequestForm({
      title: 'Редактирование вещи',
      width: 300,
      url: '/?a=json_edit&id=' + eItem.get('data-id'),
      onOkClose: function() {
        window.location.reload();
      }
    });
  });
});