$(document).ready(function () {
  $('#template-short_name').change(function (e) {
    updateName();
  });

  $('#template-branch').change(function (e) {
    updateName();
  });

  $('#template-org_form').change(function (e) {
    updateName();
  });

  $('#template-emp_count').change(function (e) {
    updateName();
  });

  $('#template-is_new').change(function (e) {
    updateName();
  });


  $('#template-event_id').on('select2:select', function (e) {
    updateName();
  });

});

function updateName() {
  "use strict";

  var short_name = $('#template-short_name').val();

  var event = $('#select2-template-event_id-container').text();
  if (event == 'нет') {
    event = '';
  }

  var branch = $('#template-branch').val();
  branch = $('#template-branch option[value=\"' + branch + '\"]').text();

  var org_form = $('#template-org_form').val();
  org_form = $('#template-org_form option[value=\"' + org_form + '\"]').text();

  var emp_count = $('#template-emp_count').val();
  emp_count = $('#template-emp_count option[value=\"' + emp_count + '\"]').text();

  var client = $('#template-is_new').val();
  client = $('#template-is_new option[value=\"' + client + '\"]').text();

  var name = event + ' ' + branch + ' ' + org_form + ' ' + emp_count + ' ' + client + ' ' + short_name;

  $('#template-name').val(name.trim());
}