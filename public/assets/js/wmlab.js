$(document).ready(function(){
  var toastr_position = $('#js-var').attr('data-toastr-position');
  var something_error_message = $('#js-var').attr('data-something-error-message');
  var character_remaining = $('#js-var').attr('data-character-remaining');
  var textarea_limit = $('#js-var').attr('data-textarea-limit');
  var calendar_language = $('#js-var').attr('data-calendar-language');
  var datatable_language = $('#js-var').attr('data-datatable-language');

	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    function ajaxSubmit(){
      $("form").on('submit', function(event) {

        var formDetails = $('#'+ $(this).attr('id'));
        $(formDetails).find('.onoffswitch-checkbox').each(function() {
          if(!$(this).is(':checked') && $(this).attr('data-off-value') == 0)
            var field = '<input type="hidden" name="'+$(this).attr('name')+'" value="0" />';
            $(formDetails).append(field);
        });
   
        if (formDetails.attr('data-submit') != 'noAjax'){
          event.preventDefault();  
          ajaxProcess(formDetails);
        }
      });   
    }

    function ajaxProcess(formDetails){
      formDetails.find(':submit').prop('disabled',true);
      toastr.info('Processing..','',{"positionClass": toastr_position});
      var fd = new FormData($('#'+formDetails.attr('id'))[0]);
      fd.append("ajax_submit", 1);
      $.ajax({
      url: formDetails.attr('action'),
      type: "post",
      contentType: false,
      processData: false,
      data: fd,
      success: function(response){
        toastr.clear();
        if (response.status == "error"){
          toastr.error(response.message,'',{"positionClass": toastr_position});
        }
        else {
            if(response.message){
                toastr.success(response.message,'',{"positionClass": toastr_position});
            }
            $('#myModal').modal('hide');
            if($('.datatable').length > 0)
              reloadDataTable();
            if(formDetails.attr('data-refresh'))
              refreshContent(formDetails.attr('data-refresh'));
            if(!formDetails.attr('data-no-form-clear'))
              clearForm(formDetails);
        }
      },
      error: function(response){
        toastr.clear();
        if( response.status === 422 ) {
          var errors = JSON.parse(response.responseText);
          var errorsHtml = '';
          $.each( errors, function( key, value ) {
              errorsHtml += value[0] + '<br />'; 
          });
          toastr.error(errorsHtml,'',{"positionClass": toastr_position});
        } else
        toastr.error(something_error_message,'',{"positionClass": toastr_position});
        },
        complete: function(response){
          formDetails.find(':submit').prop('disabled',false);
        }
      });  
    }

    function clearForm(ele) {
		$(ele).find(':input').each(function() {
			switch(this.type) {
				case 'email':
				case 'url':
				case 'number':
				case 'password':
				case 'select-multiple':
				case 'select-one':
				case 'text':
				case 'textarea':
				case 'file':
				$(this).val('');
        $(ele).find(".select2me").select2({ allowClear: true,theme: "bootstrap" });
				break;
				case 'checkbox':
				case 'radio':
				this.checked = false;
        $('.icheck').iCheck({'uncheckedClass':'',
          checkboxClass: 'icheckbox_flat-blue',
          radioClass: 'iradio_flat-blue',
          increaseArea: '20%' });
			}
		});
    if($('.summernote').length > 0)
    $('.summernote').summernote('reset');
  }

	$("#myModal").on("show.bs.modal", function(e) {
        var link = $(e.relatedTarget);
        if(link.attr('data-href'))
        $.get(link.attr("data-href"), function(data) {
            $('#myModal').find(".modal-content").html(data);
            $('#myModal').modal('show');
            loadModalPlugin(); 
        },'html');
    });
    function loadModalPlugin(){
      $('#myModal .switch-input').bootstrapSwitch();
      $('#myModal .select2me').select2({theme: "bootstrap",allowClear: true});
      initIcheck('#myModal .icheck');
      initDatepicker('#myModal .datepicker');
      if($('#myModal .summernote').length)
      $('#myModal .summernote').summernote({ height: 100 });
      if($('.fileinput').length)
      $('#myModal .fileinput').filestyle();

      textareaCounter();
      resizeTextarea();
      $('#myModal .select2dynamictag').select2({ multiple: true, tags:[], allowClear: true });
  		var form = $('#myModal').find('form');
  		$('#myModal').find('form').on('submit',function(event){
  			if ($(form).attr('data-submit') != 'noAjax'){
  				event.preventDefault();
  				ajaxProcess($(form));
  			}
  		});
      $('#myModal .password-strength').pwstrength();
    }

    function datatablePostData(table_id){
      var postData;
      if($('#'+table_id).attr('data-form'))
        postData = $('#'+$('#'+table_id).attr('data-form')).serialize();
      else
        postData = {'_token':CSRF_TOKEN};
      return postData;
    }

    function getDtBtn(table_id){
      return [
            {
                extend: 'print',
                text: '<i class="fa fa-print"></i>',
                title:$('#'+table_id).attr('data-table-title'),
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'excel',
                text: '<i class="fa fa-file-excel-o"></i>',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'pdf',
                text: '<i class="fa fa-file-pdf-o"></i>',
                title:$('#'+table_id).attr('data-table-title'),
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'copy',
                text: '<i class="fa fa-files-o"></i>',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'colvis',
                text: '<i class="fa fa-columns"></i>'
            }
        ];
    }

    function reloadDataTable(){
      $('.datatable').each(function(key,value){
      var table_id = $(this).attr('id');
        oTable[table_id].ajax.reload();
      });
    }
    
    var oTable = [];
    if($('.datatable').length > 0)
    $('.datatable').each(function(key,value){
      var table_id = $(this).attr('id');
      oTable[table_id] = $('#'+table_id).DataTable({
          dom: '<"html5buttons"B>lTfgitp',
          buttons: getDtBtn(table_id),
          "language": {
          "url": datatable_language
        },
        "ajax": {
          "url": $('#'+table_id).attr('data-table-source')+"/lists",
          "type": "post",
          "data": function(d){
            return datatablePostData(table_id);
          },
        },
        "ordering": true,
        "autoWidth": true,
        "order": ($('#'+table_id).attr('data-disable-sorting')) ? [] : [[ 1, "asc" ]],
        "columnDefs": ($('#'+table_id).attr('data-disable-sorting')) ? [] : [
            { "orderable": false, "targets": 0 }
        ]
      });
      $('#'+table_id).on('xhr.dt', function (e,setting,response) {
        if(response.foot){
          var foot = $('#'+table_id).find('tfoot');
          if (!foot.length) foot = $('<tfoot>').appendTo('#'+table_id); 
          foot.html(response.foot);
        }
      });
    });

    ajaxSubmit();
    $('.switch-input').bootstrapSwitch();
    $('.password-strength').pwstrength();
    $('.select2me').select2({theme: "bootstrap",allowClear: true});
    initDatepicker('.datepicker');
    initIcheck('.icheck');
    if($('.summernote').length)
    $('.summernote').summernote({ height: 100 });
    if($('.fileinput').length)
    $('.fileinput').filestyle();
    
    if($('#form-wizard').length)
      $('#form-wizard').bootstrapWizard();

    function initIcheck(field){
      $(field).iCheck({
      checkboxClass: 'icheckbox_flat-blue',
      radioClass: 'iradio_flat-blue',
      increaseArea: '20%' 
      }); 
    }

    $('form').on('keyup keypress', function(e) {
      var keyCode = e.keyCode || e.which;
      if (keyCode === 13 && $(this).attr('data-disable-enter-submission')) { 
        e.preventDefault();
        return false;
      }
    });

    $(document).on("click", "[data-submit-confirm-text]", function(e) {
        e.preventDefault();
        var $el = $(this);
        bootbox.confirm("Are you sure?", function(result) {
          if (result) {
            var formDetails = $el.closest('form');
            if (formDetails.attr('data-submit') != 'noAjax')
              ajaxProcess(formDetails);
            else
            $(formDetails).submit();
          }
        });
    });

    function textareaCounter(){
      $('textarea').on("propertychange keyup input paste",
        function () {
          if($(this).attr('data-show-counter') > 0){
            var limit = ($(this).attr('data-limit')) ? ($(this).data('limit')) : textarea_limit;
            var remainingChars = limit - $(this).val().length;
            if (remainingChars <= 0) {
                $(this).val($(this).val().substring(0, limit));
            }
            $(this).next('span').text((remainingChars<=0?0:remainingChars) + ' ' + character_remaining);
          }
      });
    }
    textareaCounter();

    function resizeTextarea(){
        $.each($('textarea[data-autoresize]'), function() {
            var offset = this.offsetHeight - this.clientHeight;
         
            var resizeTextarea = function(el) {
                $(el).css('height', 'auto').css('height', el.scrollHeight + offset);
            };
            $(this).on('keyup input', function() { resizeTextarea(this); }).removeAttr('data-autoresize');
        });
    }
    resizeTextarea();

    $('.custom-field-option').hide();
    $(document).on('change', '#type', function(){
      var field = $('#custom-field-form #type').val();
      if(field == 'select' || field == 'radio' || field == 'checkbox')
        $('.custom-field-option').show();
      else
        $('.custom-field-option').hide();
    });

    function showHideMailConfig(){
      mail_driver = $('#mail_driver').val();
      $('.mail_config').hide();
      if(mail_driver == 'smtp')
        $('#smtp_configuration').show();
      else if(mail_driver == 'mandrill')
        $('#mandrill_configuration').show();
      else if(mail_driver == 'mailgun')
        $('#mailgun_configuration').show();
      else
        $('.mail_config').hide();
    }

    showHideMailConfig();
    $('#mail_driver').on('change',function(){
      showHideMailConfig();
    });

    if ($('#render_calendar').length > 0){
      $('#render_calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        events: calendar_events,
        eventRender: function(event, element) {
              $(element).tooltip({title: event.title});             
          }
      });
    }

    function initDatepicker(field){
      if($(field).length > 0){
        $(field).attr("readonly","readonly");
        $(field).datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            multidate: false,
            clearBtn: true,
            todayHighlight: true,
        });
      }
    }
    $(".show-table td:last-child").addClass("text-right");
    $('.textAvatar').nameBadge();
    $(document).tooltip({
      selector: "[data-toggle=tooltip]",
      container: "body"
    })
    
    $(document.body).on('click','a',function(event){
        if($(this).attr('data-ajax')){
          event.preventDefault();
          ajaxGet(this);
        }
    });

    function ajaxGet(obj){
      var postData = 'ajax_submit=1' + $(obj).attr('data-extra');
      $.ajax({
         url: $(obj).attr('data-source'),
         data: postData,
         dataType: 'json',
         type: 'post',
         error: function(response) {
          toastr.error(something_error_message,'',{"positionClass": toastr_position});
         },
         success: function(response) {
            if (response.status == "error")
              toastr.error(response.message,'',{"positionClass": toastr_position});
            else{
              if($('.datatable').length > 0)
                reloadDataTable();
              if($(obj).attr('data-refresh'))
                refreshContent($(obj).attr('data-refresh'));
              if(response.message)
                toastr.success(response.message,'',{"positionClass": toastr_position});
            }
         },
      });
    }

    function fetchChatMessages(){
      $.ajax({
         url: '/fetch-chat',
         error: function(data) {
         },
         dataType: 'html',
         success: function(data) {
            $('#chat-messages').html(data);
            $('#chat-messages .textAvatar').nameBadge();
            $('#chat-box').animate({scrollTop:$('.chat-panel').height()}, 'fast');
         },
         type: 'POST'
      });
    }

    function loadMessage(){
      var postData = 'token=' + $('#load-message').attr('data-token');
      $.ajax({
         url: '/load-message',
         error: function(data) {
         },
         data: postData,
         dataType: 'html',
         success: function(data) {
            $('#load-message').html(data);
            $('#load-message .textAvatar').nameBadge();
         },
         type: 'POST'
      });
    }

    if($('#chat-messages').length){
      fetchChatMessages();
      if($('#chat-messages').attr('data-chat-refresh') > 0){
        setInterval(function() {
          fetchChatMessages();
        }, $('#chat-messages').attr('data-chat-refresh-duration')*1000);
      }
    }
    
    function refreshContent(field){
      if(field == 'chat-messages')
        fetchChatMessages();
      else if(field == 'load-message')
        loadMessage();
    }

    if($('#load-message').length)
      loadMessage();

    $('.login-as').on('click',function(){
        $("input[name='username']").val($(this).attr('data-username'));
        $("input[name='email']").val($(this).attr('data-email'));
        $("input[name='password']").val($(this).attr('data-password'));
    });

    //sidebar active
    var pathName = (window.location.pathname).replace(/^\//, "").split('/')[0];
    $('li.'+pathName).addClass('active');
    $('li.'+pathName).children('ul').removeClass('collapse');
    $('li#'+pathName).addClass('active');


    //activate chosen
    $('.chosen-select').chosen({width: "100%"});
});