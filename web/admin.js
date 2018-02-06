$(function() {

  /**
   * выбрать все посты для удаление
   */
  $('#deleteAll').on('click', function() {
      $('.del_chkbox').prop('checked', $(this).is(':checked'));
  });
});