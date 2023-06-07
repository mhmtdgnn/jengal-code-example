<script>

    $(document).ready(function () {
        localStorage.clear();
    });

    /**
     * Genel Fonksiyon ve Ayarlar
     */
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    // input Mask
    Inputmask({
        "mask" : "(999) 999-9999",
        "placeholder": "(___) ___-____",
    }).mask("#called-phone");
    Inputmask({
        "mask" : "(999) 999-9999",
        "placeholder": "(___) ___-____",
    }).mask("#add_consumer_phone");
    
    // Verimor Popup
    $('#verimor-popup').click(function(event) {
        event.preventDefault();
        window.open($(this).attr("href"), "popupWindow", "width=400,height=575,scrollbars=no");
    });

    // Çağrı Başlat
    $('#start-call').on('click', function () {

        let phone = $('#called-phone').val();

        $.ajax({
            type: "POST",
            url: "{{ route('cm.startCall') }}",
            data: {
                _token : '{{ csrf_token() }}',
                phone : phone
            },
            success: function (data, textStatus, xhr) {
                if (xhr.status === 200) {
                    localStorage.setItem('active-call', data);
                    Toast.fire({
                        icon: 'info',
                        title: data,
                        position: 'top'
                    });
                } else {
                    localStorage.setItem('active-call', '');
                    Toast.fire({
                        icon: 'error',
                        title: data,
                        position: 'center'
                    });
                }
            }
        });
    });

    // Çağrı Sonlandır
    $('#close-call').on('click', function () {

        let uuid = localStorage.getItem('active-call');

        $.ajax({
            type: "POST",
            url: "{{ route('cm.closeCall') }}",
            data: {
                _token : '{{ csrf_token() }}',
                uuid : uuid
            },
            success: function (data, textStatus, xhr) {
                if (xhr.status === 200) {
                    localStorage.setItem('active-call', '');
                    console.log(data);
                    Toast.fire({
                        icon: 'info',
                        title: data,
                        position: 'top'
                    });
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: data,
                        position: 'center'
                    });
                }
            }
        });
    });

    // Numaradan tüketici/müşteri bul
    $('#called-phone').keypress(function (e) { 
        if(e.keyCode == 13)
        {
            $('#search-consumer').trigger('click');
        }
    });
    $('#search-consumer').on('click', function () {

        let phone = $('#called-phone').val();
        let button = $(this);
        var drawerEl = document.querySelector("#consumer_drawer");
        var drawer = KTDrawer.getInstance(drawerEl);
        button.attr("data-kt-indicator", "on");
        button.addClass('disabled');

        $('#consumers-list').html('');
        $('#consumer_drawer .searched-text').text(phone);

        $.ajax({
            type: "POST",
            url: "{{ route('cm.searchConsumers') }}",
            data: {
                _token: '{{ csrf_token() }}',
                phone: phone
            },
            success: function (response) {
                if (response.length > 0) {
                    $.each(response, function (index, item) { 
                        let template = $('#consumer-item-template .consumer-item').clone();

                        template.html(function(i, oldHTML) {
                            return oldHTML.replaceAll('[[name]]', item.firstName + ' ' + item.lastName)
                                .replaceAll('[[phone]]', item.phone)
                                .replaceAll('[[email]]', item.email)
                                .replaceAll('[[consumerID]]', item.id)
                                .replaceAll('[[symbol]]', item.firstName.slice(0,1));
                        });

                        $('#consumers-list').append(template);
                    });
                    drawer.show();
                } else {
                    Toast.fire({
                        icon: 'info',
                        title: 'Eşleşen sonuç bulunamadı.'
                    });
                    newConsumerForm();
                }
                button.removeAttr("data-kt-indicator");
                button.removeClass('disabled');
            }
        });
    });

    // İsim ya da Mail ile tüketici/müşteri bul
    $('#search_extra_text').keypress(function (e) { 
        if(e.keyCode == 13)
        {
            $('#search_extra_button').trigger('click');
        }
    });
    $('#search_extra_button').on('click', function () {
        let searchText = $('#search_extra_text').val();
        if (searchText.length > 5) {
            let button = $(this);
            var drawerEl = document.querySelector("#consumer_drawer");
            var drawer = KTDrawer.getInstance(drawerEl);
            button.attr("data-kt-indicator", "on");
            button.addClass('disabled');
    
            $('#consumers-list').html('');
            $('#consumer_drawer .searched-text').text(searchText);
    
            $.ajax({
                type: "POST",
                url: "{{ route('cm.searchConsumersWithText') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    text: searchText
                },
                success: function (response) {
                    if (response.length > 0) {
                        $.each(response, function (index, item) { 
                            let template = $('#consumer-item-template .consumer-item').clone();
    
                            template.html(function(i, oldHTML) {
                                return oldHTML.replaceAll('[[name]]', item.fullNameText)
                                    .replaceAll('[[phone]]', item.phone)
                                    .replaceAll('[[email]]', item.email)
                                    .replaceAll('[[consumerID]]', item.id)
                                    .replaceAll('[[symbol]]', item.fullName.slice(0,1));
                            });
    
                            $('#consumers-list').append(template);
                        });
                        drawer.show();
                    } else {
                        Toast.fire({
                            icon: 'info',
                            title: 'Eşleşen sonuç bulunamadı.'
                        });
                    }
                    button.removeAttr("data-kt-indicator");
                    button.removeClass('disabled');
                }
            });
        } else {
            Toast.fire({
                icon: 'warning',
                title: 'En az 5 karakter girmelisiniz.',
                position: 'center'
            });
        }
    });

    // Müşteri Seç
    $(document).on('click', '.consumer-select-button', function () {
        var drawerEl = document.querySelector("#consumer_drawer");
        var drawer = KTDrawer.getInstance(drawerEl);
        let selectedConsumerID = $(this).data('consumer-id');
        toastr.success('Kullanıcı Seçildi' + ' ' + selectedConsumerID);
        drawer.hide();
        getConsumerInfo(selectedConsumerID);
    });

    // Müşteri Bilgileri Çek - AJAX
    function getConsumerInfo(consumerID) {
        let spinnerTemplate = $('#spinner_tamplate .spinner-wrapper').clone();
        $('#ajax_dynamic_content').html(spinnerTemplate);

        $.ajax({
            type: "POST",
            url: "{{ route('cm.getActivities') }}",
            data: {
                _token: "{{ csrf_token() }}",
                consumer_id: consumerID,
                limit: 3
            },
            success: function (response) {
                if (response) {
                    /** 
                     * Bu adımda kullanıcı bilgileri ve son 3 aktivite bilgisi geliyor.
                     * Gelen bilgilerden kullanıcı bilgileri localstorage için kaydediliyor.
                    */
                    localStorage.setItem('selected-consumer-info', JSON.stringify(response.consumer));
                    let consumerInfoText = response.consumer.firstName + ' ' 
                        + response.consumer.lastName + ' - ' 
                        + response.consumer.phone;
                    $('.alert-consumer-info-text').text(consumerInfoText);
                    fillConsumerInfo(response);
                }
            }
        });
    }

    // Müşteri Bilgilerini Doldur
    function fillConsumerInfo(data) {
        let consumerProfile = $('#consumer_profile_template .consumer-profile').clone();

        consumerProfile.html(function(i, oldHTML) {
            return oldHTML.replaceAll('[[consumername]]', data.consumer.firstName + ' ' + data.consumer.lastName)
                .replaceAll('[[consumerfirstname]]', data.consumer.firstName)
                .replaceAll('[[consumerlastname]]', data.consumer.lastName)
                .replaceAll('[[consumerID]]', data.consumer.id)
                .replaceAll('[[consumerphone]]', data.consumer.phone)
                .replaceAll('[[consumermail]]', (data.consumer.email == null) ? '' : data.consumer.email);
        });

        $('#ajax_dynamic_content').html(consumerProfile);
        
        fillConsumerActivitiesList(data, '#ajax_dynamic_content .activities-content' );
    }

    function fillConsumerActivitiesList(data, containerClass) {
        if (data.consumer_acitivities.length > 0) {             
            $.each(data.consumer_acitivities, function (index, item) {

                let activityItemTemplate = $('#activity-item-template .activity-item').clone();
                let separator = $('#activity-item-template .separator').clone()[0].outerHTML;

                let activityItemIcon = '';
                let activitySenseIcon = '';

                switch (item.activity_open) {
                    case 0:
                        activityItemIcon = $('#activity-item-template .completed-icon .svg-icon').clone()[0].outerHTML;
                        break;
                    case 1:
                        activityItemIcon = $('#activity-item-template .continuing-icon .svg-icon').clone()[0].outerHTML;
                        break;
                }
              
                switch (item.activity_sense) {
                    case 1:
                        activitySenseIcon = $('#activity-sense-icon .activity-sense-1 i').clone()[0].outerHTML;
                        break;
                    case 2:
                        activitySenseIcon = $('#activity-sense-icon .activity-sense-2 i').clone()[0].outerHTML;
                        break;
                    case 3:
                        activitySenseIcon = $('#activity-sense-icon .activity-sense-3 i').clone()[0].outerHTML;
                        break;
                    case 4:
                        activitySenseIcon = $('#activity-sense-icon .activity-sense-4 i').clone()[0].outerHTML;
                        break;
                }

                activityItemTemplate.html(function(i, oldHTML) {
                    return oldHTML.replaceAll('[[activityIcon]]', activityItemIcon)
                        .replaceAll('[[activitySenseIcon]]', activitySenseIcon)
                        .replaceAll('[[activityID]]', item.id)
                        .replaceAll('[[activitySubject]]', item.activity_subject)
                        .replaceAll('[[activityChannel]]', item.activity_channel)
                        .replaceAll('[[activityCase]]', item.activity_case)
                        .replaceAll('[[activityDate]]', moment(item.created_at).format('YYYY MM DD'))
                        .replaceAll('[[activityTime]]', moment(item.created_at).format('h:mm'));
                });

                $(containerClass).append(activityItemTemplate);
                
                // if not lastElement
                if (index != data.consumer_acitivities.length -1) {
                    $(containerClass).append(separator);
                }
            });
        } else {
            let emptyResult = $('#activity-item-template .empty-result').clone();
            $(containerClass).append(emptyResult);
        }
    }

    // Müşterinin Tük Aktivitelerini Görüntüle
    $(document).on('click', '#consumer_all_activities_button', function () {
        var drawerEl = document.querySelector("#consumer_activities_drawer");
        var drawer = KTDrawer.getInstance(drawerEl);
        let consumerID = $(this).data('consumer-id');
        let button = $(this);
        let container = '#consumer_activities_drawer .consumers-activities-list';

        button.attr("data-kt-indicator", "on");

        $.ajax({
            type: "POST",
            url: "{{ route('cm.getActivities') }}",
            data: {
                _token: "{{ csrf_token() }}",
                consumer_id: consumerID,
            },
            success: function (response) {
                if (response) {
                    $(container).html('');
                    fillConsumerActivitiesList(response, container);
                    button.removeAttr("data-kt-indicator");
                    drawer.show();
                }
            }
        });
    });

    // Activite Detayı Getir
    $(document).on('click', '#ajax_dynamic_content .activity-item .clickable', function () {
        var activityID = $(this).data('activity-id');
        $('#ajax_dynamic_content .clickable').removeClass('bg-light');
        $('div[data-activity-id="'+ activityID +'"]').addClass('bg-light');
        getActivity(activityID);
    });
    $(document).on('click', '#consumer_activities_drawer .activity-item .clickable', function () {
        var activityID = $(this).data('activity-id');
        $('#ajax_dynamic_content .clickable').removeClass('bg-light');
        $('div[data-activity-id="'+ activityID +'"]').addClass('bg-light');
        getActivity(activityID);
        var drawerEl = document.querySelector("#consumer_activities_drawer");
        var drawer = KTDrawer.getInstance(drawerEl);
        drawer.hide();
    });

    // Activite Detayı Getir -- Function
    function getActivity(activityID) {
        let spinnerTemplate = $('#spinner_tamplate .spinner-wrapper').clone();
        $('#ajax_dynamic_content #consumer_activity_tab_contet').html(spinnerTemplate);
        $.ajax({
            type: "POST",
            url: "{{ route('cm.getActivity') }}",
            data: {
                _token: '{{ csrf_token() }}',
                activity_id: activityID
            },
            success: function (response) {
                if (response) {
                    fillActivityDetail(response);
                }
            }
        });
    }
    
    // Aktivite Detaylarını Doldur
    function fillActivityDetail(data) {
        let activityItemTemplate = $('#cosumer_tab_content_template .activity-detail-template').clone();
        let activityItemIcon = '';
        let activitySenseIcon = '';

        switch (data.activity.activity_open) {
            case 0:
                activityItemIcon = $('#activity-item-template .completed-icon .svg-icon').clone()[0].outerHTML;
                break;
            case 1:
                activityItemIcon = $('#activity-item-template .continuing-icon .svg-icon').clone()[0].outerHTML;
                break;
        }
        
        switch (data.activity.activity_sense) {
            case 1:
                activitySenseIcon = $('#activity_sense_big_icon_templates .activity-sense-1 i').clone()[0].outerHTML;
                break;
            case 2:
                activitySenseIcon = $('#activity_sense_big_icon_templates .activity-sense-2 i').clone()[0].outerHTML;
                break;
            case 3:
                activitySenseIcon = $('#activity_sense_big_icon_templates .activity-sense-3 i').clone()[0].outerHTML;
                break;
            case 4:
                activitySenseIcon = $('#activity_sense_big_icon_templates .activity-sense-4 i').clone()[0].outerHTML;
                break;
        }
        
        activityItemTemplate.html(function(i, oldHTML) {
            return oldHTML.replaceAll('[[activityID]]', data.activity.id)
                .replaceAll('[[ActivityAgent]]', data.activity.activity_agent)
                .replaceAll('[[activitySubject]]', data.activity.activity_subject)
                .replaceAll('[[activityChannel]]', data.activity.activity_channel)
                .replaceAll('[[activityCase]]', data.activity.activity_case)
                .replaceAll('[[activityNote]]', data.activity.activity_note)
                .replaceAll('[[activityDirection]]', (data.activity.activity_direction) == 0 ? 'Gelen' : 'Giden')
                .replaceAll('[[activityItemIcon]]', activityItemIcon)
                .replaceAll('[[activitySenseIcon]]', activitySenseIcon)
                .replaceAll('[[formDisabled]]', (data.activity.activity_open == 0) ? 'd-none' : '')
                .replaceAll('[[activityDate]]', moment(data.activity.created_at).format('YYYY MM DD'))
                .replaceAll('[[activityTime]]', moment(data.activity.created_at).format('h:mm'));
        });

        $('#consumer_activity_tab_contet').html(activityItemTemplate);
        
        
        fillActivityCalls(data.activity_calls);
        fillActivityAssignments(data.activity_assignments);
        fillActivityLogs(data.activity_logs);

        // Update modal content 
        let activityUpdateModalTemplate =$('#activity_update_modal_template .fields').clone();
        $('#activity_update_modal_form .modal-body').html(activityUpdateModalTemplate);
        if (data.activity.activity_direction == 0) {
            $('#activity_update_modal_form .inbound-radio-label').addClass('active');
            $('#activity_update_modal_form .inbound-radio').prop('checked', true);
        } else {
            $('#activity_update_modal_form .outbound-radio-label').addClass('active');
            $('#activity_update_modal_form .outbound-radio').prop('checked', true);
        }
        $('#activity_update_modal_form input[name="activity_sense"][value="' + data.activity.activity_sense + '"]').prop('checked', true);
        $('#activity_update_modal_form select[name="activity_subject"]').val(data.activity.activity_subject_id).change();
        $('#activity_update_modal_form select[name="activity_channel"]').val(data.activity.activity_channel_id).change();
        $('#activity_update_modal_form textarea[name="activity_note"]').val(data.activity.activity_note);
        $('#activity_update_modal_form input[name="activity_id"]').val(data.activity.id);
    }

    // Aktivite Çağrılarını Doldur
    function fillActivityCalls(data) {

        $('#ajax_dynamic_content .activity-calls-content').html('');

        $.each(data, function (index, item) { 

            let timelineItemTemplate = $('#activity_calls_template .timeline-item-template').clone();
            let callIconInbound = $('#call_icon_templates .inbound-call-icon').clone()[0].outerHTML;
            let callIconOutbound = $('#call_icon_templates .outbound-call-icon').clone()[0].outerHTML;
            let callSenseIconTemplate = '';
            let callerDifferentTemplate = '';
            
            if (item.caller_different != null && item.caller_different != '') {
                callerDifferentTemplate = $('#caller_different_template .caller-different').clone()[0].outerHTML;
            }

            switch (item.call_sense) {
                case 1: callSenseIconTemplate = $('#call_sense_icon_templates .icon-1').clone()[0].outerHTML;
                    break;
                case 2: callSenseIconTemplate = $('#call_sense_icon_templates .icon-2').clone()[0].outerHTML;
                    break;
                case 3: callSenseIconTemplate = $('#call_sense_icon_templates .icon-3').clone()[0].outerHTML;
                    break;
                case 4: callSenseIconTemplate = $('#call_sense_icon_templates .icon-4').clone()[0].outerHTML;
                    break;
            }

            timelineItemTemplate.html(function(i, oldHTML) {
                return oldHTML.replaceAll('[[callChannel]]', item.call_channel)
                    .replaceAll('[[callNote]]', item.call_note)
                    .replaceAll('[[callAgent]]', item.call_agent)
                    .replaceAll('[[callDirection]]', (item.call_direction) == 0 ? 'Gelen Çağrı' : 'Giden Cağrı')
                    .replaceAll('[[callIcon]]', (item.call_direction) == 0 ? callIconInbound : callIconOutbound)
                    .replaceAll('[[callSenseIcon]]', callSenseIconTemplate)
                    .replaceAll('[[callerDifferent]]', callerDifferentTemplate.replace('[[callerDifferentText]]', item.caller_different))
                    .replaceAll('[[callDate]]', moment(item.created_at).format('YYYY MM DD'))
                    .replaceAll('[[callTime]]', moment(item.created_at).format('h:mm'));
            });
            $('#ajax_dynamic_content .activity-calls-content').append(timelineItemTemplate);

        });
    }

    // Aktivite Yönlendirmelerini doldur
    function fillActivityAssignments(data) {
        $.each(data, function (index, item) {
            let activityAssignmentTemplate = $('#activity_assignmetn_item_template .assignment-item-template').clone();

            activityAssignmentTemplate.html(function(i, oldHTML) {
                return oldHTML.replaceAll('[[assignmentNote]]', item.assignment_note)
                    .replaceAll('[[assignmentFromUser]]', item.assignment_from_user)
                    .replaceAll('[[assignmentToUser]]', item.assignment_to_user)
                    .replaceAll('[[assignmentDate]]', moment(item.created_at).format('YYYY MM DD'))
                    .replaceAll('[[assignmentTime]]', moment(item.created_at).format('h:mm'));
            });

            $('#ajax_dynamic_content .activity-assignments-content').append(activityAssignmentTemplate);
        });
    }
    // Aktivite Loglarını doldur
    function fillActivityLogs(data) {
        $.each(data, function (index, item) {

            let activityLogTemplate = '';
            
            console.log(item.type_key);

            switch (item.type_key) {
                case 'start':
                    activityLogTemplate = $('#activity_logs_item_template .start-log-item').clone();
                    break;
                case 'call':
                    activityLogTemplate = $('#activity_logs_item_template .call-log-item').clone();
                    break;
                case 'assignment':
                    activityLogTemplate = $('#activity_logs_item_template .assignment-log-item').clone();
                    break;
                case 'end':
                    activityLogTemplate = $('#activity_logs_item_template .end-log-item').clone();
                    break;
            }


            activityLogTemplate.html(function(i, oldHTML) {
                return oldHTML.replaceAll('[[logNote]]', item.description)
                    .replaceAll('[[logDate]]', moment(item.created_at).format('YYYY MM DD'))
                    .replaceAll('[[logTime]]', moment(item.created_at).format('h:mm'));
            });

            $('#ajax_dynamic_content .activity-logs-content tbody').append(activityLogTemplate);
        });
    }

    // Çağrı Ekle 
    $(document).on('click', '#add_call_form_button', function () {
        let addCallForm = $('#add_call_form').serializeArray();
        let button = $(this);
        let activityID = $(this).data('activity-id');
        button.attr("data-kt-indicator", "on");

        addCallForm.push({name: 'activity_id', value: activityID});
        $.ajax({
            type: "POST",
            url: "{{ route('cm.addCall') }}",
            data: addCallForm,
            success: function (response) {
                if (response) {
                    getActivity(activityID);
                    button.removeAttr('data-kt-indicator');
                } else {
                    Toast.fire({
                        icon: 'danger', 
                        title: 'Bir Hata Oluştu.',
                        position: 'center'
                    });
                }
            }
        });
    });

    // Yorum Ekle
    $(document).on('click', '#add_assignment_form_button', function () {
        let addAssignmentForm = $('#add_assignment_form').serializeArray();
        let button = $(this);
        let activityID = $(this).data('activity-id');
        button.attr("data-kt-indicator", "on");

        addAssignmentForm.push({name: 'activity_id', value: activityID});

        console.log(addAssignmentForm);
        $.ajax({
            type: "POST",
            url: "{{ route('cm.addAssignment') }}",
            data: addAssignmentForm,
            success: function (response) {
                if (response) {
                    getActivity(activityID);
                    button.removeAttr('data-kt-indicator');
                } else {
                    Toast.fire({
                        icon: 'danger', 
                        title: 'Bir Hata Oluştu.',
                        position: 'center'
                    });
                }
            }
        });
    });

    //Aktiviteyi Kapat
    $(document).on('click', '#activity_completed_button', function () {
        
        let activityID = $(this).data('activity-id');
        
        Swal.fire({
            title: 'Emin misiniz?',
            text: "Bu işlemi geri alamazsınız!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#7239ea',
            cancelButtonColor: '#f1416c',
            confirmButtonText: 'Evet, aktiviteyi kapat.',
            cancelButtonText: 'İptal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('cm.activityCompleted') }}",
                        data: {
                            _token: '{{ csrf_token() }}',
                            activity_id: activityID
                        },
                        success: function (response) {
                            if (response) {
                                Swal.fire(
                                    'Tebrikler!',
                                    'Aktivite kapatıldı.',
                                    'success'
                                ).then(function () {  
                                    getActivity(activityID);
                                });
                            } else {
                                Swal.fire(
                                    'Hata!',
                                    'Bir sorun oluştu.',
                                    'error'
                                );
                            }
                        }
                    });
                }
            });
    });

    // Yeni Activite Case Seçimi.
    $(document).on('change', 'select[name="case"]', function () {
        let spinnerTemplate = $('#spinner_tamplate .mini-spinner').clone();
        $('.subcase-content').html(spinnerTemplate);
        $('.activity-case-content').html('');
        let selectedCaseID = $(this).val();

        $.ajax({
            type: "POST",
            url: "{{ route('cm.getSubCases') }}",
            data: {
                _token: '{{ csrf_token() }}',
                parent_id: selectedCaseID,
            },
            success: function (response) {
                if (response) {
                    let html = `<select name="case_subcase" class="form-select form-select-solid" required>
                        <option value="">Seçiniz</option>`;
                        $.each(response, function (index, item) { 
                             html += `<option value="${item.id}">${item.name}</option>`;
                        });
                    html += '</select>';
                    $('.subcase-content').html(html);
                    $('.activity-case-content').html('');
                }
            }
        });
    });
    $(document).on('change', 'select[name="case_subcase"]', function () {
        let spinnerTemplate = $('#spinner_tamplate .mini-spinner').clone();
        $('.activity-case-content').html(spinnerTemplate);
        let selectedCaseID = $(this).val();

        $.ajax({
            type: "POST",
            url: "{{ route('cm.getSubCases') }}",
            data: {
                _token: '{{ csrf_token() }}',
                parent_id: selectedCaseID,
            },
            success: function (response) {
                if (response) {
                    let html = `<select name="activity_case" class="form-select form-select-solid" required>
                        <option value="">Seçiniz</option>`;
                        $.each(response, function (index, item) { 
                             html += `<option value="${item.id}">${item.name}</option>`;
                        });
                    html += '</select>';
                    $('.activity-case-content').html(html);
                }
            }
        });
    });

    // Yeni Aktivite Modal Open
    $('#new-activity').on('click', function () {
        let addActivityModal = $('#add_activity_modal');
        let selectedConsumerInfo = JSON.parse(localStorage.getItem('selected-consumer-info'));
        console.log(selectedConsumerInfo);

        if (selectedConsumerInfo !== null ) {
            let consumerInfoText = '(' + selectedConsumerInfo.id + ')' 
                + ' ' + selectedConsumerInfo.firstName
                + ' ' + selectedConsumerInfo.lastName 
                + ' - ' + selectedConsumerInfo.phone
                + ' - ' + selectedConsumerInfo.email;
            $('#add_activity_modal .modal-title-consumer-info').text(consumerInfoText);
            addActivityModal.modal('show');
        } else {
            Toast.fire({
                icon: 'warning',
                title: 'Önce müşteri seçimi yapmalısın.',
                position: 'center'
            });
        }

    });
    
    // Yeni Müşteri Modal Open
    $('#new-consumer').on('click', function () {
        newConsumerForm();
    });
    //Yeni Müşteri Fonksiyonu
    function newConsumerForm() {
        let calledPhone = $('#called-phone').val().replace(/[^0-9\.]/g, '');

        if (calledPhone.length < 10) {
            Toast.fire({
                icon: 'error',
                title: 'Numara alanı boş bırakılamaz.',
                position: 'center'
            });
        } else {
            $('#add_consumer_modal').modal('show');
            $('#add_consumer_form #add_consumer_phone').val(calledPhone);
        }
    }

    // Yeni Aktivite Ekle
    function newActivity(button, activityClose = false) {
        button.attr("data-kt-indicator", "on");
        let createActivityForm = $('#add_activity_form');
        let formData = createActivityForm.serializeArray();
        let consumerID = JSON.parse(localStorage.getItem('selected-consumer-info')).id;

        if (activityClose) {
            formData.push({name: 'activity_close', value: true});
        }
        
        createActivityForm.validate({
            errorPlacement: function(){
                return false;
            },
        });

        if (createActivityForm.valid()) {
            formData.push({name: 'consumer_id', value: consumerID});
            if (activityClose) {
                Swal.fire({
                title: 'Aktiviteyi Kapat!',
                text: "Aktivite kapalı bir aktivite olarak kaydedilecektir.",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#7239ea',
                cancelButtonColor: '#f1416c',
                confirmButtonText: 'Evet, aktiviteyi kapat.',
                cancelButtonText: 'İptal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        newActivityAjax(createActivityForm, formData, button, consumerID);
                    } else {
                        button.removeAttr('data-kt-indicator');
                    }
                });
            } else {
                newActivityAjax(createActivityForm, formData, button, consumerID);
            }
        } else {
            button.removeAttr('data-kt-indicator');
            Toast.fire({
                icon: 'error',
                title: 'Lütfen tüm alanları eksiksiz doldurun.',
                position: 'center'
            });
        }
    }
    function newActivityAjax(form, formData, button, consumerID) {
        $.ajax({
            type: "POST",
            url: "{{ route('cm.createActivity') }}",
            data: formData,
            success: function (response) {
                console.log(response);
                form.trigger("reset");
                button.removeAttr("data-kt-indicator");
                $('.activity-assignment-field').addClass('d-none');
                $('#add_activity_form_button_2').removeClass('d-none');
                $('#add_activity_modal').modal('hide');
                getConsumerInfo(consumerID);
            }
        });
    }
    $(document).on('click', '#add_activity_form_button', function () {
        button = $(this);
        newActivity(button);
    });
    $(document).on('click', '#add_activity_form_button_2', function () {
        button = $(this);
        newActivity(button, true);
    });
    $(document).on('change', 'input[name="add_assignment"]', function () {
        let checked = $(this).is(':checked');

        if (checked) {
            $('.activity-assignment-field').removeClass('d-none');
            $('#add_activity_form_button_2').addClass('d-none');
        } else {
            $('.activity-assignment-field').addClass('d-none');
            $('#add_activity_form_button_2').removeClass('d-none');
        }
    });

    // Yeni Müşteri Ekle
    $(document).on('click', '#add_consumer_form_button', function () {
        let form = $('#add_consumer_form');
        let formData = form.serializeArray();
        button = $(this);
        button.attr("data-kt-indicator", "on");

        form.validate({
            errorPlacement: function(){
                return false;
            },
        })

        if (form.valid()) {
            $.ajax({
                type: "POST",
                url: "{{ route('consumer.createConsumer') }}",
                data: formData,
                success: function (response) {
                    if (response) {
                        console.log(response);
                        button.removeAttr("data-kt-indicator");
                        $('#add_consumer_modal').modal('hide');
                        toastr.success('Tebrikler! Müşteri kaydı eklendi.');
                        form.trigger("reset");
                        getConsumerInfo(response.id);
                    }
                }
            });
        } else {
            button.removeAttr('data-kt-indicator');
            Toast.fire({
                icon: 'error',
                title: 'Lütfen tüm alanları eksiksiz doldurun.',
                position: 'center'
            });
        }


    });

    // Aktivite Güncelle
    $(document).on('click', '#activity_update_modal_form_submit', function () {
        let button = $(this);
        let form = $('#activity_update_modal_form');
        let formData = form.serializeArray();
        let activityID = $('#activity_update_modal_form input[name="activity_id"]').val();
        button.attr("data-kt-indicator", "on");

        form.validate({
            errorPlacement: function(){
                return false;
            },
        });

        if (form.valid()) {
            $.ajax({
                type: "POST",
                url: "{{ route('cm.updateActivity') }}",
                data: formData,
                success: function (response) {
                    console.log(response);
                    button.removeAttr("data-kt-indicator");
                    $('#activity_update_modal').modal('hide');
                    getActivity(activityID);
                }
            });
        } else {
            button.removeAttr('data-kt-indicator');
            Toast.fire({
                icon: 'error',
                title: 'Lütfen tüm alanları eksiksiz doldurun.',
                position: 'center'
            });
        }
    });
    
    // Müşteri Bilgileri Güncelle
    $(document).on('click', '#update_consumer_form_button', function () {
        let button = $(this);
        let form = $('#update_consumer_form');
        let formData = form.serializeArray();
        let consumerID = button.data('consumer-id');

        button.attr("data-kt-indicator", "on");

        form.validate({
            errorPlacement: function(){
                return false;
            },
        });
        if (form.valid()) {
            $.ajax({
                type: "POST",
                url: "{{ route('consumer.updateConsumer') }}",
                data: formData,
                success: function (response) {
                    if (response) {
                        button.removeAttr("data-kt-indicator");
                        $('#update_consumer_modal').modal('hide');
                        getConsumerInfo(consumerID);
                    }
                }
            });
        } else {
            button.removeAttr('data-kt-indicator');
            Toast.fire({
                icon: 'error',
                title: 'Lütfen tüm alanları eksiksiz doldurun.',
                position: 'center'
            });
        }
    });

</script>
@if(Session::has('activity_id') && Session::has('consumer_id'))
    <script>
        $(document).ready(function () {
            getConsumerInfo({{ Session::get('consumer_id') }});
            getActivity({{ Session::get('activity_id') }});
        });
    </script>
@endif