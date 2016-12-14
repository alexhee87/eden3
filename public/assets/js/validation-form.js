var Validate = function () {
	var handleInstall = function() {
   		$('.install-form').validate({
	            errorElement: 'span',
	            errorClass: 'help-block',
	            focusInvalid: true,
	            rules: {
	                email: {
	                    required: true,
	                    email: true
	                },
	                password: {
	                    required: true,
	                    minlength: 6,
	                },
	                username: {
	                    required: true,
	                    minlength: 4,
	                },
	                mysql_username: {
	                    required: true,
	                },
	                mysql_password: {
	                    required: true,
	                },
	                hostname: {
	                    required: true,
	                },
	                mysql_database: {
	                    required: true,
	                },
	                envato_username: {
	                    required: true,
	                },
	                purchase_code: {
	                    required: true,
	                },
	                first_name: {
	                    required: true,
	                },
	                last_name: {
	                    required: true,
	                },
	            },

	            highlight: function (element) {
	                $(element)
	                    .closest('.form-group').addClass('has-error');
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
	            },

	            submitHandler: function (form) {
	                form.submit();
	            }
	        });
	}

	var handleUpdate = function() {
   		$('.update-app-form').validate({
	            errorElement: 'span',
	            errorClass: 'help-block',
	            focusInvalid: true,
	            rules: {
	                mysql_username: {
	                    required: true,
	                },
	                mysql_password: {
	                    required: true,
	                },
	                hostname: {
	                    required: true,
	                },
	                mysql_database: {
	                    required: true,
	                },
	                purchase_code: {
	                    required: true,
	                },
	            },

	            highlight: function (element) {
	                $(element)
	                    .closest('.form-group').addClass('has-error');
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
	            },

	            submitHandler: function (form) {
	                form.submit();
	            }
	        });
	}

	var handleLogin = function() {
   		$('.login-form').validate({
	            errorElement: 'span',
	            errorClass: 'help-block',
	            focusInvalid: true,
	            rules: {
	                username: {
	                    required: true,
	                },
	                password: {
	                    required: true,
	                }
	            },

	            highlight: function (element) {
	                $(element)
	                    .closest('.form-group').addClass('has-error');
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
	            },

	            submitHandler: function (form) {
	                form.submit();
	            }
	        });
	}

	var handleForgot = function() {
   		$('.forgot-form').validate({
	            errorElement: 'span',
	            errorClass: 'help-block',
	            focusInvalid: true,
	            rules: {
	                email: {
	                    required: true,
	                    email: true,
	                }
	            },

	            highlight: function (element) {
	                $(element)
	                    .closest('.form-group').addClass('has-error');
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
	            },

	            submitHandler: function (form) {
	                form.submit();
	            }
	        });
	}

	var handleResetPassword = function() {
   		$('.reset-password-form').validate({
	            errorElement: 'span',
	            errorClass: 'help-block',
	            focusInvalid: true,
	            rules: {
	                email: {
	                    required: true,
	                    email: true,
	                },
	                password: {
	                	required: true,
	                    minlength: 6
	                },
	                password_confirmation: {
	                	required: true,
	                    equalTo: "#password"
	                }
	            },

	            highlight: function (element) {
	                $(element)
	                    .closest('.form-group').addClass('has-error');
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
	            },

	            submitHandler: function (form) {
	                form.submit();
	            }
	        });
	}

	var handleLanguageEntry = function() {
   		$('.language-entry-form').validate({
	            errorElement: 'span',
	            errorClass: 'help-block',
	            focusInvalid: true,
	            rules: {
	                key: {
	                    required: true,
	                },
	                text: {
	                    required: true,
	                },
	                module: {
	                    required: true,
	                }
	            },

	            highlight: function (element) {
	                $(element)
	                    .closest('.form-group').addClass('has-error');
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
	            },

	            submitHandler: function (form) {
	                form.submit();
	            }
	        });
	}

	var handleJobSearch = function() {

   		$('.job-search-form').validate({
	            errorElement: 'span',
	            errorClass: 'help-block',
	            focusInvalid: true,
	            rules: {
	                country: {
	                    required: true,
	                },
	                query: {
	                    required: true,
	                }
	            },

	            highlight: function (element) {
	                $(element)
	                    .closest('.form-group').addClass('has-error');
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
	            },

	            submitHandler: function (form) {
	                form.submit();
	            }
	        });
	}

	var handleJobApplicationStatus = function() {

   		$('.job-application-status-form').validate({
	            errorElement: 'span',
	            errorClass: 'help-block',
	            focusInvalid: true,
	            rules: {
	                status: {
	                    required: true,
	                },
	                user_id: {
	                    required: true,
	                },
	                interview_date: {
	                    required: true,
	                }
	            },

	            highlight: function (element) {
	                $(element)
	                    .closest('.form-group').addClass('has-error');
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
	            },

	            submitHandler: function (form) {
	                form.submit();
	            }
	        });
	}

    return {
        init: function () {
            handleInstall();
            handleLogin();
            handleForgot();
            handleResetPassword();
            handleLanguageEntry();
            handleJobSearch();
            handleJobApplicationStatus();
            // handleUpdate();
        }
    };
}();
