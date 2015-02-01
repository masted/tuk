if (Ngn.authorized) {
  document.getElements('.items .item').each(function(eItem) {
    if (!Ngn.isAdmin && eItem.get('data-userId') != Ngn.authorized) return;
    Ngn.Btn.btn2('Редактировать', 'edit').inject(eItem, 'top').addEvent('click', function() {
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
}
