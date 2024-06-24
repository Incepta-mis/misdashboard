<script>
    $.fn.select2.defaults.set("theme", "bootstrap");
    $('#file_img_upid').on('change', function (ev) {

        var self = this;
        $("#message_ta").empty(); // To remove the previous error message
        var file = this.files[0];
        // var width = 0; var height = 0;
        // var fileSize = parseInt(parseInt(file.size) / 1024);
        // console.log(fileSize);

        var imagefile = file.type;
        var match = ["image/jpeg", "image/jpg"];

        if (!(imagefile === match[0]) || (imagefile === match[1])) {
            $("#message_ta").html("<p id='error' style='color:red'>Please Select A valid Image File</p>" + "<b>Note</b>" +
                "<span id='error_message' style='color:red'>Only jpg,jpeg Image type allowed</span>");
            return false;
        // }
        // else if(fileSize > 300){
        //     $("#message_ta").html("<p id='error' style='color:red'>File size must be 300Kb</p>");
        //
        //     return  false;
        }else {
            ///////image  upload====================================
            // var imgCheck = new Promise(function (resolve,reject) {
            //     var img = new Image();
            //     img.src = window.URL.createObjectURL(file);
            //      var params = null;
            //     img.onload = function()  {
            //         if(img.width > 220 || img.height > 220){
            //            params = {width:img.width,height:img.height};
            //             resolve(params);
            //         }
            //     };
            // });

            // imgCheck.then(function (response) {
            //     if (parseInt(response.width) <= 220 || parseInt(response.height) <= 220){
            //         console.log(response);
                    var postData = new FormData();
                    postData.append('file', self.files[0]);

                    var reader = new FileReader();
                    reader.onload = function (ev) {
                        $('#img_prv').attr('src', ev.target.result)
                            .css('width', '200px').css('height', '200px');
                    };
                    reader.readAsDataURL(self.files[0]);

                    var imgurl = "{{url('ehf/ajaxImageUpload')}}";
                    $.ajax({
                        headers: {'X-CSRF-Token': $('meta[name=csrf_token]').attr('content')},
                        async: true,
                        type: "POST",
                        contentType: false, // high importance!
                        url: imgurl, // you need change it.
                        data: postData, // high importance!
                        processData: false, // high importance!
                        success: function (data) {
                            //do thing with data....
                            console.log(data.emp_img);
//                    propic_preview

                            var imgtypenameoe = data.emp_img;
                            var urlparamoe = '/' + imgtypenameoe;
                            var mainurloe = '{{url("/emp_history_img/")}}' + urlparamoe;

                            console.log(mainurloe);
                        }
                    });
                // }else{
                //     $("#message_ta").html("<p id='error' style='color:red'>File must be 220X220</p>");
                //     return  false;
                // }

            // });
        }
    });

    $('.pagefour_btn').attr('formtarget', '_blank');

    $(document).ready(function () {

        whole_div_url = "{{url('ehf/getWholeDistrict')}}";
        img_upload_url = "{{url('ehf/insertimage')}}";
        edu_deg_url = "{{url('ehf/getWholeGroup')}}";
        deg_grp_brd_url = "{{url('ehf/getWholeDegreeBoard')}}";


        var navListItems = $('div.setup-panel div a'),
            allWells = $('.setup-content'),
            allNextBtn = $('.nextBtn');

        allWells.hide();

        navListItems.click(function (e) {
            e.preventDefault();
            var $target = $($(this).attr('href')),
                $item = $(this);

            if (!$item.hasClass('disabled')) {
                navListItems.removeClass('btn-success').addClass('btn-default');
                $item.addClass('btn-success');
                allWells.hide();
                $target.show();
                $target.find('input:eq(0)').focus();
            }
        });

        //----------------------
        $.fn.serializeObject = function () {
            var o = {};
            var a = this.serializeArray();

            $.each(a, function () {
                if (o[this.name] !== undefined) {
                    if (!o[this.name].push) {
                        o[this.name] = [o[this.name]];
                    }
                    o[this.name].push(this.value || '');
                } else {
                    o[this.name] = this.value || '';
                }
            });
            var $radio = $('input[type=radio],input[type=checkbox]', this);
            $.each($radio, function () {
                if (!o.hasOwnProperty(this.name)) {
                    o[this.name] = '';
                }
            });

            return o;
        };

        $(document).on('click', '.nextBtn', function () {

            console.log("hello it" + $(this).hasClass('pageone_btn'));
            console.log($(this));
            var self = $(this);

            function doSteps(context) {
                var curStep = context.closest(".setup-content"),
                    curStepBtn = curStep.attr("id"),
                    nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
                    curInputs = curStep.find("input[type='text'],input[type='url']"),
                    isValid = true;


                $(".form-group").removeClass("has-error");
                for (var i = 0; i < curInputs.length; i++) {
                    if (!curInputs[i].validity.valid) {
                        isValid = false;
                        $(curInputs[i]).closest(".form-group").addClass("has-error");
                    }
                }

                if (isValid) nextStepWizard.removeAttr('disabled').trigger('click');
                $('html, body').animate({scrollTop: 0}, 800);
            }

            var statusOfPages = null;

            if ($(this).hasClass('pageone_btn')) {

                if ($('.emp_nid').val() && parseInt($('.emp_nid').val().length) !== 10
                    && parseInt($('.emp_nid').val().length) !== 17) {

                    toastr.error("Smart NID Must be 10 digit! / " +
                        "NID must be 17 digit!", {
                        "timeOut": "6000",
                        "extendedTImeout": "0"
                    });

                    $('html, body').animate({scrollTop: $(".emp_nid").position().top}, 800);
                    $('.emp_nid').focus();

                } else {

                    statusOfPages = pageOneValidation();
                    if(statusOfPages){
                        showMessage('one');
                        $('#page_one_error').css('display','initial');
                    }else{
                        $('#page_one_error').css('display','none');
                    }

                    var formData = $('#frm_pageone').serializeObject();
                    console.log("before formData: ");
                    console.log(formData);

                    // =====================present
                    if ('pread_bd_dis' in formData) {
                        console.log("yes there");

                    } else {
                        console.log("no there");
                        formData.pread_bd_dis = "";
                    }

                    if ('pread_bd_div' in formData) {
                        console.log("yes there");

                    } else {
                        console.log("no there");
                        formData.pread_bd_div = "";
                    }
                    //=========================permanent=================================================

                    if ('pd_bd_div' in formData) {
                        console.log("yes there");

                    } else {
                        console.log("no there");
                        formData.pd_bd_div = "";
                    }

                    if ('pd_bd_dis' in formData) {
                        console.log("yes there");

                    } else {
                        console.log("no there");
                        formData.pd_bd_dis = "";
                    }

                    //=========================emergency=========================

                    if ('emer_bd_div' in formData) {
                        console.log("yes there");

                    } else {
                        console.log("no there");
                        formData.emer_bd_div = "";
                    }

                    if ('emer_bd_dis' in formData) {
                        console.log("yes there");

                    } else {
                        console.log("no there");
                        formData.emer_bd_dis = "";
                    }

                    console.log("form formData-----------------------------------------------------: ");
                    console.log(formData);

                    $.ajax({
                        type: 'post',
                        url: route_config.routes.pageone_url,
                        data: {fd: formData, '_token': "{{csrf_token()}}"},
                        beforeSend: function () {
                            showToast('Saving.Please Wait..', route_config.routes.loader);
                        },
                        success: function (data) {
                            console.log("success data");
                            console.log(data);
                            doSteps(self);

                        },
                        error: function () {

                        },
                        complete: function () {
                            closeToast();
                        }
                    });
                }
            }

            else if ($(this).hasClass('pagetwo_btn')) {

                if(user.grades.indexOf(user.grade) !== -1 &&
                    (parseInt($('.emp_tin_noclss').val().length) < 12 ||parseInt($('.emp_tin_noclss').val().length) < 12)){
                    toastr.error("TIN Must be 12 digit!", {
                        "timeOut": "6000",
                        "extendedTImeout": "0"
                    });

                    $('html, body').animate({scrollTop: $(".emp_tin_noclss").position().top}, 800);
                    $('.emp_tin_noclss').focus();
                }else{

                    statusOfPages = pageTwoValidation();
                    if(statusOfPages){
                        showMessage('two');
                       $('#page_two_error').css('display','initial');
                    }else{
                        $('#page_two_error').css('display','none');
                    }

                    var formDatatwo = $('#frm_pagetwo').serializeObject();
                    console.log("before formData two: ");
                    console.log(formDatatwo);

                    $.each(formDatatwo, function (key, value) {
                        if (key.indexOf('[]') !== -1) {
                            var newKeyVal = key.substr(0, key.indexOf('[]'));
                            formDatatwo[newKeyVal] = value;
                            delete formDatatwo[key];
                        }
                    });
                    //
                    console.log('page 2 normal save..........');
                    console.log(formDatatwo);

                    $.ajax({
                        type: 'post',
                        url: route_config.routes.pagetwo_url,
                        data: {
                            fdtwo: formDatatwo,
                            '_token': "{{csrf_token()}}"
                        },
                        beforeSend: function () {
                            showToast('Saving.Please Wait..', route_config.routes.loader);
                        },
                        success: function (data) {
                            console.log(data);
                            doSteps(self);
                        },
                        error: function () {

                        },
                        complete: function () {
                            closeToast();
                        }
                    });
                }


            }

            else if ($(this).hasClass('pagethree_btn')) {
                var formDatathree = $('#frm_pagethree').serializeObject();
                console.log("before formData three: ");
                console.log(formDatathree);

                $.each(formDatathree, function (key, value) {
                    if (key.indexOf('[]') !== -1) {
                        var newKeyVal = key.substr(0, key.indexOf('[]'));
                        formDatathree[newKeyVal] = value;
                        delete formDatathree[key];
                    }
                });
                //
                console.log('after form data');
                console.log(formDatathree);


                $.ajax({
                    type: 'post',
                    url: route_config.routes.pagethree_url,
                    data: {
                        fdthree: formDatathree,
                        '_token': "{{csrf_token()}}"
                    },
                    beforeSend: function () {
                        showToast('Saving.Please Wait..', route_config.routes.loader);
                    },
                    success: function (data) {
                        console.log(data);
                        doSteps(self);
                    },
                    error: function () {

                    },
                    complete: function () {
                        closeToast();
                    }
                });

            }

            else if ($(this).hasClass('pagefour_btn')) {

                statusOfPages = pageFourValidation();
                if(statusOfPages){
                    showMessage('four');
                    $('#page_four_error').css('display','initial');
                }else{
                    $('#page_four_error').css('display','none');
                }

               // nominee share calculation
                var total_share = 0;

                $('.nominee_table tbody').find('tr').each(function (i,v) {
                    total_share += parseInt($(this).find('.nominee_share_clss').val());
                    console.log(total_share);
                });

                if(total_share !== 100){
                    toastr.error("Percent of share must be 100% ", {
                        "timeOut": "6000",
                        "extendedTImeout": "0"
                    });
                }else {

                var formDatafour = $('#frm_pagefour').serializeObject();
                console.log("before formData four: ");
                console.log(formDatafour);

                $.each(formDatafour, function (key, value) {
                    if (key.indexOf('[]') !== -1) {
                        var newKeyVal = key.substr(0, key.indexOf('[]'));
                        formDatafour[newKeyVal] = value;
                        delete formDatafour[key];
                    }
                });

                console.log('after form data');
                console.log(formDatafour);

                $.ajax({
                    type: 'post',
                    url: route_config.routes.pagefour_url,
                    data: {
                        fdfour: formDatafour,
                        '_token': "{{csrf_token()}}"
                    },
                    beforeSend: function () {
                        showToast('Saving.Please Wait..', route_config.routes.loader);
                    },
                    success: function (data) {
                        console.log(data);
                        doSteps(self);
                    },
                    error: function () {

                    },
                    complete: function () {
                        closeToast();
                    }

                });

            }

            } else {
                console.log("what msg: ");
            }


        });
        //------------------------------step button 4----------
        $(document).on('click', '.stepwizard-step-final', function () {

            var curStep = $(this).closest(".setup-content"),
                curStepBtn = curStep.attr("id"),
                nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
                curInputs = curStep.find("input[type='text'],input[type='url']"),
                isValid = true;


            $(".form-group").removeClass("has-error");
            for (var i = 0; i < curInputs.length; i++) {
                if (!curInputs[i].validity.valid) {
                    isValid = false;
                    $(curInputs[i]).closest(".form-group").addClass("has-error");
                }
            }

            if (isValid) nextStepWizard.removeAttr('disabled').trigger('click');
        });

        $('div.setup-panel div a.btn-success').trigger('click');

        $('#btn_submit_error').on('click', function () {

            $("#decision_err_emphis_id").modal('hide');

            var result = '';

            $('.err_input_empty').each(function (index, element) {
                console.log("glass found");
                console.log($(this).val());

                if ($(this).val()) {
                    console.log("find");
                    $(this).css('background-color', 'white');
                } else {
                    console.log("red============================================= ");
                    $(this).css('background-color', '#f8d7da');
                    console.log($(this).attr('id') + " id prob=========+++++++++++++++++++++++++++");

                    // permanent ----
                    if ($(this).attr('id') == 'pd_bd_div_id') {
                        $('#select2-pd_bd_div_id-container').css('background-color', '#f8d7da');
                    }
                    if ($(this).attr('id') == 'pd_bd_dis_id') {
                        $('#select2-pd_bd_dis_id-container').css('background-color', '#f8d7da');
                    }
                    // -----
                    if ($(this).attr('id') == 'emp_all_country_id') {
                        $('#select2-emp_all_country_id-container').css('background-color', '#f8d7da');
                    }

                    // birth of district
                    if ($(this).attr('id') == 'emp_bir_dis_id') {
                        $('#select2-emp_bir_dis_id-container').css('background-color', '#f8d7da');
                    }

                    if ($(this).attr('id') == 'pread_bd_div_id') {
                        $('#select2-pread_bd_div_id-container').css('background-color', '#f8d7da');
                    }
                    if ($(this).attr('id') == 'pread_bd_dis_id') {
                        $('#select2-pread_bd_dis_id-container').css('background-color', '#f8d7da');
                    }
                    //emergency================
                    if ($(this).attr('id') == 'emer_bd_div_id') {
                        $('#select2-emer_bd_div_id-container').css('background-color', '#f8d7da');
                    }
                    if ($(this).attr('id') == 'emer_bd_dis_id') {
                        $('#select2-emer_bd_dis_id-container').css('background-color', '#f8d7da');
                    }
                    result = 'fail2';
                }//endif

            });

            if (result === 'fail2') {
                swal({
                    type: 'error',
                    text: 'Please fill up all the * or mandatory fields !'
                });
            } else {
                $("#decision_emphis_id").modal('show');
            }
            //if not error then download pdf
        });

        $('#btn_submit_mail').on('click', function () {

            $("#decision_err_emphis_id").modal('hide');
            $('#mail_personal_id_pdf').val($('#emp_mail_personalid').val());
            $("#mail_emphis_id").modal('show');

        });

        $(document).on('click', '.final_sentmail', function () {

            $('#mail_emp_is').html("");
            var selected_m = $('#mail_personal_id_pdf').val();
            if (!(selected_m)) {
                $('#mail_emp_is').html('Empty Field');
            } else {
                console.log("selected_m " + selected_m);
                var login_emp_id = '{{Auth::user()->user_id}}';
                var l = Ladda.create(document.querySelector('.final_sentmail'));
                l.start();

                $.ajax({
                    type: 'get',
                    url: '{!! URL::to('ehf/Emphistory_mal')!!}',
                    data: {
                        mailaddress: selected_m,
                    },
                    success: function (data) {

                        console.log(data);


                        toastr["success"]("Successfully Send mail")

                        toastr.options = {
                            "closeButton": false,
                            "debug": false,
                            "newestOnTop": false,
                            "progressBar": false,
                            "positionClass": "toast-top-right",
                            "preventDuplicates": false,
                            "onclick": null,
                            "timeOut": "0",
                            "extendedTimeOut": "0"
                        }


                        l.stop();
                    },
                    error: function (data) {
                        toastr.error("Error!Please send mail again", {
                            "timeOut": "0",
                            "extendedTImeout": "0"
                        });
                        l.stop();
                    }
                });

            }
        });

    });
</script>
