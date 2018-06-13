function addFieldGroup(group) {
  'use strict';

  var selector = "." + group + ":last input";
  var lastInputs = $(selector);
  var count = lastInputs.length;

  var names = [], ids = [], labels = [];
  var len, name, id;

  for (var i = 0; i < count; i++) {
    name = lastInputs[i].attributes.name.value.slice(0, -2);
    len = name.length;
    id = +lastInputs[i].attributes.id.value.slice(len);
    names.push(name);
    ids.push(++id);
    labels.push(lastInputs[i].parentElement.previousElementSibling.textContent);
  }

  var html = '<div class="' + group + '">\n<hr>\n';
  html += '<h4>Группа ' + group + ', строка ' + (id + 1) + '</h4>\n';

  for (i = 0; i < count; i++) {
    html += '<div class="form-group">\n' +
      '<label class="control-label col-sm-2" for="' + names[i] + ids[i] + '">' + labels[i] + '</label>\n' +
      '<div class="col-sm-10">\n' +
      '<input id="' + names[i] + ids[i] + '" class="form-control" name="' + names[i] + '[]" type="text">\n' +
      '</div>\n' +
      '</div>\n';
  }

  html += '<a id="delete-field-group-' + id + '" class="btn btn-danger" href="javascript:void(0)"' +
    ' onclick="deleteFieldGroup(\'delete-field-group-' + id + '\')" style="margin-bottom: 15px">Удалить поля</a>\n';

  html += '</div>\n';
  $("." + group + ":last").after(html);
}

function deleteFieldGroup(id) {
  'use strict';
  $("#" + id).parent().remove();
}