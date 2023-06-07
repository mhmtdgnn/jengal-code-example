@section('footer_scripts')
<style>
    .select2-container--bootstrap5 .select2-selection--single .select2-selection__rendered {
        width: 100%;
    }
</style>
    <!--begin::Page Vendors Javascript(used by this page)-->
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js"></script>
    <!--end::Page Vendors Javascript-->
    <!--begin::Page Custom Javascript(used by this page)-->
    {{-- <script src="{{ asset('assets/js/custom/apps/customers/list/export.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/js/custom/apps/customers/list/list.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/js/custom/apps/customers/add.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/js/custom/widgets.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/js/custom/modals/create-transport-request.js') }}"></script> --}}
    <!--end::Page Custom Javascript-->

    <script>
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            // "positionClass": "toastr-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
    </script>

    <script>
        // KAYDET
        $('#transport_request_modal_button').on('click', function () {
            let button = $(this);
            let form = $('#transport_request_modal_form');
            let formData = form.serializeArray();

            if (form.valid()) {
                button.attr('data-kt-indicator', 'on');
                button.attr('disabled', 'disabled');
                $.ajax({
                    type: "POST",
                    url: "{{ route('bicozumExpress.store') }}",
                    data: formData,
                    success: function (response, text, xhr) {
                        console.log(response);
                        if (xhr.status == 200) {
                            toastr.success('Taşıma kaydı oluşturuldu');
                            button.removeAttr('data-kt-indicator');
                            button.removeAttr('disabled');
                            location.reload();
                        } else {
                            toastr.error('Bir hata oluştu!');
                            button.removeAttr('data-kt-indicator');
                            button.removeAttr('disabled');
                        }
                    }
                });
            }
        });
    </script>

    <script>
        $('#product_item_repeater').repeater({
            initEmpty: true,
            show: function () {
                $(this).slideDown();
                $('.product-data-ajax').select2({
                    minimumInputLength: 3,
                    ajax: {
                        url: '{{ route("products") }}',
                        dataType: 'json',
                        type: "POST",
                        delay: 250,
                        data: function (params) {
                            return {
                            _token: '{{ csrf_token() }}',
                            search: params.term // search term
                            };
                        },
                        processResults: function (response) {
                            return {
                                 results: response
                            };
                        },
                        cache: true
                    },
                    dropdownParent: $(this).parent(),//$('#transport_request_modal'),
                    templateResult: formatRepoX,
                    // templateSelection: formatRepoSelectionX
                });
            },
            hide: function (deleteElement) {
                $(this).slideUp(deleteElement);
            }
        });

        function formatRepoX (repo) {
            if (repo.loading) {
                return repo.text;
            }

            var $container = $(
                "<div class='select2-result-repository'>" +
                    "<div class='select2-result-repository__meta' data-id="+ repo.id +" >" +
                        "<div class='select2-result-product_name position-relative'>" 
                            + repo.text + 
                            "<small class='badge badge-danger ms-3 position-absolute top-50 end-0 translate-middle-y'>" + repo.company + "</small>" +
                        "</div>" +
                    "</div>" +
                "</div>"
            );
            
            return $container;
        };

        // $('.product-data-ajax').on('click', function () {
        //     $('.product-data-ajax').select2({
        //         ajax: {
        //             url: 'https://api.github.com/search/repositories',
        //             dataType: 'json'
        //             // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
        //         },
        //         dropdownParent: $('#transport_request_modal')
        //     });
        // });
    </script>

    <script>
        // BAŞLANGIÇ ADRESİ EKLE MODAL
        $(document).on('click', '.add-start-address', function () {
            let transport_id = $(this).data('id');
            $('#add_start_address_modal .transport-id').text(transport_id);
            $('#add_start_address_modal input[name="transport_id"]').val(transport_id);
            $('#add_start_address_modal').modal('show');
        });

        // BAŞLANGIÇ ADRESİ EKLE
        $('#add_start_address_form_button').on('click', function () {
            let formData = $('#add_start_address_form').serializeArray();
            let modal = $('#add_start_address_modal');
            let button = $(this);
            let transport_id = $('#add_start_address_form input[name="transport_id"]').val();

            console.log(formData);
            button.attr('data-kt-indicator', 'on');

            $.ajax({
                type: "POST",
                url: "{{ route('bicozumExpress.updateStartAddress') }}",
                data: formData,
                success: function (response, textStatus, xhr) {
                    if(xhr.status == 200) {
                        console.log(response);
                        button.removeAttr('data-kt-indicator');
                        modal.find('form').trigger('reset');
                        modal.find('.form-select').val('').trigger('change');
                        modal.modal('hide');
                        let addressValue = '<small>' + response.city + '/' + response.town + '</small>';
                        $('tr.transport-request-' + transport_id + ' td.start-address').html(addressValue);
                    }
                }
            });
        });

        // TESLİMAT ADRESİ EKLE MODAL
        $(document).on('click', '.add-delivery-address', function () {
            let transport_id = $(this).data('id');
            $.ajax({
                type: "POST",
                url: "{{ route('bicozumExpress.getRequestByID') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    transport_id: transport_id
                },
                async: true,
                success: function (response) {
                    console.log(response);
                    if (response) {
                        $('#add_delivery_address_modal .transport-id').text(transport_id);
                        $('#add_delivery_address_modal input[name="transport_id"]').val(transport_id);
                        $('#add_delivery_address_modal select[name="city"]').val(response.to_city_id);
                        $('#add_delivery_address_modal select[name="city"]').trigger('change').trigger({type: 'select2:select'});
                        setTimeout(() => {
                            $('#add_delivery_address_modal select[name="town"]').val(response.to_town_id);
                            $('#add_delivery_address_modal select[name="town"]').trigger('change');
                        }, 300);
                        $('#add_delivery_address_modal textarea[name="address"]').val(response.to_address);
                        $('#add_delivery_address_modal').modal('show');
                    }
                },
            });
        });

        // TESLİMAT ADRESİ EKLE
        $('#add_delivery_address_form_button').on('click', function () {
            let formData = $('#add_delivery_address_form').serializeArray();
            let modal = $('#add_delivery_address_modal');
            let button = $(this);
            let transport_id = $('#add_delivery_address_form input[name="transport_id"]').val();

            console.log(formData);
            button.attr('data-kt-indicator', 'on');

            $.ajax({
                type: "POST",
                url: "{{ route('bicozumExpress.updateDeliveryAddress') }}",
                data: formData,
                success: function (response, textStatus, xhr) {
                    if(xhr.status == 200) {
                        console.log(response);
                        button.removeAttr('data-kt-indicator');
                        modal.find('form').trigger('reset');
                        modal.find('.form-select').val('').trigger('change');
                        modal.modal('hide');
                        let addressValue = '<small>' + response.city + '/' + response.town + '</small>';
                        $('tr.transport-request-' + transport_id + ' td.delivery-address').html(addressValue);
                    }
                }
            });
        });
        
        // SEFER PLAN TARİHİ EKLE 
        $(document).on('click', '.add-planned-date', function () {
            let button = $(this);
            let transport_id = button.data('id');

            const { value: date } = Swal.fire({
                title: 'Randevu tarihi seçin',
                input: 'select',
                inputOptions: {!! $datePeriod !!},
                inputPlaceholder: 'Randevu Tarihi Seçiniz',
                confirmButtonText: 'Kaydet',
                inputValidator: (value) => {
                    return new Promise((resolve) => {
                        if (value) {
                            //tarih güncelleme işlemleri...
                            $.ajax({
                                type: "POST",
                                url: "{{ route('bicozumExpress.updateAppointmentDate') }}",
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    appointment_date: value,
                                    transport_id: transport_id
                                },
                                success: function (response, textStatus, xhr) {
                                    if (xhr.status == 200) {
                                        let dateContent = '<small class="text-info">' + response.message + '</small>';
                                        button.parent('td').html(dateContent);
                                        resolve();
                                    }
                                }
                            });
                        } else {
                            resolve('Tarih seçmelisiniz');
                        }
                    })
                }
            });
        });

        // SEFER PLANLAMA MODAL
        $(document).on('click', '.trip-plan-button', function () {
            let button = $(this);
            let transport_id = $(this).data('id');
            button.attr('data-kt-indicator', 'on');

            $.ajax({
                type: "POST",
                url: "{{ route('bicozumExpress.getRequestByID') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    transport_id: transport_id
                },
                success: function (response) {
                    if (response) {
                        console.log(response);
                        $('#trip_plan_modal .request-content #transport_code').html(response.transport_code);
                        $('#trip_plan_modal .request-content #reference_number').html(response.reference_number);
                        $('#trip_plan_modal .request-content #type').html(response.type);
                        $('#trip_plan_modal .request-content #payment_at_door').html(response.payment_at_door = 0 ? 'HAYIR' : 'EVET');
                        $('#trip_plan_modal .request-content #delivery_type').html((response.delivery_type == 0) ? 'TESLİM AL' : 'TESLİM ET');
                        $('#trip_plan_modal .delivery-address-content .contact-name').html(response.contact_name);
                        $('#trip_plan_modal .delivery-address-content .contact-number').html(response.contact_number);
                        $('#trip_plan_modal .delivery-address-content address').html(response.to_address);
                        $('#trip_plan_modal .delivery-address-content .city-town').html((response.to_city || '').toUpperCase() + '/' + (response.to_town || ''));
                        $('#trip_plan_modal .transport-id').text(transport_id);
                        $('#trip_plan_modal input[name="transport_id"]').val(transport_id);
                        $('#trip_plan_modal input[name="transport_type_id"]').val(response.type_id);
                        $('#trip_plan_modal input[name="transport_reference_number"]').val(response.reference_number);
                        $('#trip_plan_modal textarea[name="operation_note"]').val(response.operation_note);
                        $('#trip_plan_modal #log_items tbody').html('');
                        $.map(response.logs, function (item, index) {
                            let html = `<tr>
                                <td class="w-75px"><span class="badge badge-light-primary">${item.type_key}</span></td>
                                <td>${item.description}</td>
                                <td class="w-75px text-center"><span class="badge badge-light-info">${item.user_name ?? ''}</span></td>
                                <td class="w-125px text-end">
                                    <small>${moment(item.created_at).format('YYYY-MM-DD')}</small>
                                    <small class="text-gray-600">${moment(item.created_at).format('h:mm')}</small>
                                </td>
                            </tr>`;
                            $('#trip_plan_modal #log_items tbody').append(html);
                        });
                        button.removeAttr('data-kt-indicator');
                        $('#trip_plan_modal').modal('show');
                    }
                }
            });
        });

        // SEFER PLANLA
        $(document).on('click', '#trip_plan_form_button', function () {
            let button = $(this);
            let form = $('#trip_plan_form');
            let formData = form.serializeArray();
            let modal = $('#trip_plan_modal');
            let transport_id = form.find('input[name="transport_id"]').val();

            if (form.valid()) {
                button.attr('data-kt-indicator', 'on');
                button.attr('disabled', 'disabled');

                $.ajax({
                    type: "POST",
                    url: "{{ route('bicozumExpress.scheduleTransport') }}",
                    data: formData,
                    success: function (response, textStatus, xhr) {
                        console.log(response);
                        if (xhr.status == 200) {
                            toastr.success("Tebrikler! Sefer planlandı.");
                            form.trigger('reset');
                            modal.find('.form-select').val('').trigger('change');
                            modal.modal('hide');
                            button.removeAttr('data-kt-indicator');
                            button.removeAttr('disabled');
                            $('tr.transport-request-' + transport_id).fadeOut(300, function(){ $(this).remove()});
                        }
                    },
                    error: function () {
                        toastr.error("Bir hata oluştu!");
                        button.removeAttr('data-kt-indicator');
                        button.removeAttr('disabled');
                    }
                });
            }
        });

        // SEFER İPTAL İŞLEMİ
        $(document).on('click', '.trip-cancel-button', function () {
            let button = $(this);
            let transport_id = $(this).data('id');

            Swal.fire({
                html: `<strong>Dikkat!</strong> Seçtiğiniz talep <strong>iptal</strong> edilecek.
                     <strong class="text-danger">Bu işlem geri alınamaz.</strong> Onaylıyor musunuz?`,
                icon: "info",
                buttonsStyling: false,
                showCancelButton: true,
                confirmButtonText: "Evet, iptal edilsin!",
                cancelButtonText: 'Hayır',
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: 'btn btn-danger'
                }
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('bicozumExpress.transportCancel') }}",
                        data: {
                            _token: '{{ csrf_token() }}',
                            transport_id: transport_id
                        },
                        success: function (response, text, xhr) {
                            if (xhr.status == 200) {
                                // toastr.success('Kayıt İptal Edildi');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Talep iptal edildi.',
                                    showConfirmButton: false,
                                    timer: 1000
                                }).then(() => {
                                    $('tr.transport-request-' + transport_id).fadeOut(300, function(){ $(this).remove()});
                                });
                            };
                        },
                        error: function (param) {
                            Swal.fire({
                                icon: 'error',
                                title: 'HATA! İşlem sırasında bir sorun oluştu.',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    });
                }
            });
        });
    </script>

    <script>
        // AJAX From town 
        $(document).on('change', 'select[name="from_city"]', function () {
            
            $('select[name="from_town"]').empty();
            
            let city_id = $(this).val();
            
            $.ajax({
                type: "post",
                url: "/get-towns",
                data: {
                    _token: '{{ csrf_token() }}',
                    city_id: city_id
                },
                // dataType: "dataType",
                success: function (response) {
                    // console.log(response);
                    $('select[name="from_town"]').select2({ data: response });
                }
            });
        });
        // AJAX To Town 
        $(document).on('change', 'select[name="to_city"]', function () {
            
            $('select[name="to_town"]').empty();
            
            let city_id = $(this).val();
            
            $.ajax({
                type: "post",
                url: "/get-towns",
                data: {
                    _token: '{{ csrf_token() }}',
                    city_id: city_id
                },
                // dataType: "dataType",
                success: function (response) {
                    // console.log(response);
                    $('select[name="to_town"]').select2({ data: response });
                }
            });
        });

        $('#warranty').on('change', function() {
            if(this.value == 1) {
                var dt = new Date();
                dt.setDate(dt.getDate() - 730);
    
                var nowDate = new Date();
                var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
                $("#saleDate").daterangepicker({
                    singleDatePicker: true,
                    showDropdowns: true,
                    minDate: dt,
                    maxDate: today,
                    maxYear: parseInt(moment().format("YYYY"),10),
                    locale: {
                        format: 'YYYY-M-DD'
                    }
                });
            } else {
                $("#saleDate").daterangepicker({
                    singleDatePicker: true,
                    showDropdowns: true,
                    minDate: 1901,
                    maxYear: parseInt(moment().format("YYYY"),10),
                    locale: {
                        format: 'YYYY-M-DD'
                    }
                });
            }
        });

        $('select[name="type"]').on('change', function (e) {
            var transport = $(this).val();
            
            if(transport == 1) {
                $("#employees").removeClass("d-none");
            } else {
                $("#employees").addClass("d-none");
            }
        });

        $('#plan_button').click(function() {
            var count = $('input:checkbox:checked').length;
            if(count > 0) {
                var choosen = [];
                $(".choosen").each(function(){
                    if ($(this).is(":checked")) {
                        choosen.push($(this).val());
                    }
                });
                choosen = choosen.toString();
                $('#transport_request_ids').val(choosen);
            } else {
                alert('Lütfen seçim yapınız!');
            }
        });
    </script>
    <script>
        // Ürün Ara
        $("#searchProduct").select2({
            ajax: {
                // url: "https://api.github.com/search/repositories",
                url: "{{ route('productSearch') }}",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term, // search term
                        // page: params.page
                    };
                },
                processResults: function (data, params) {
                    console.log(data);
                    return {
                        results: data,
                    };
                }
            },
            dropdownParent: $("#searchProduct").parent(),
            placeholder: 'Ürün bulmak için tıklayın.',
            minimumInputLength: 4,
            templateResult: formatRepo,
            templateSelection: formatRepoSelection
        });
    
        // Ürün Seç
        $("#searchProduct").on('select2:select', function (e) {
            $('.searched-product').hide();
            var data = e.params.data;
            $('#product_id').val(data.id);
            $('.searched-product').slideDown(500);
            $('.searched-product-name').text(data.product_name);
            $('.searched-product-code').text(data.product_code);
            $('button[data-kt-stepper-action="next"]').removeAttr('disabled');
        });
    
        function formatRepo (repo) {
            if (repo.loading) {
                return repo.text;
            }
    
            var $container = $(
                "<div class='select2-result-repository'>" +
                    "<div class='select2-result-repository__meta' data-id="+ repo.id +" >" +
                        "<div class='select2-result-product_name'>" + repo.product_name + "</div>" +
                        "<div class='select2-result-product_code text-gray-400'>"+ repo.product_code +"</div>" +
                    "</div>" +
                "</div>"
            );
            
            return $container;
        };
        function formatRepoSelection (repo) {
            return repo.product_code || repo.text;
        };
    </script>

    <script>
        // Format options
        const optionFormatDate = (item) => {
            if (!item.id) {
                return item.text;
            }

            var span = document.createElement('span');
            var template = '';

            template += '<div class="d-flex align-items-center">';
            template += '<i class="far fa-calendar-alt text-info fs-2x me-4"></i>';
            template += '<div class="d-flex flex-column">'
            template += '<span class="fs-5 fw-bold lh-1">' + item.text + '</span>';
            template += '<span class="text-muted fs-5 mt-1"><small>Biçözüm Express</small></span>';
            template += '</div>';
            template += '</div>';

            span.innerHTML = template;

            return $(span);
        }

        // Init Select2 --- more info: https://select2.org/
        $('#select_planned_date').select2({
            placeholder: "Select an option",
            minimumResultsForSearch: Infinity,
            templateSelection: optionFormatDate,
            templateResult: optionFormatDate
        });

        // Format options
        const optionFormatTruck = (item) => {
            if (!item.id) {
                return item.text;
            }

            var span = document.createElement('span');
            var template = '';

            template += '<div class="d-flex align-items-center position-relative w-100">';
            template += '<i class="fas fa-truck text-info fs-2x me-4"></i>';
            template += '<div class="d-flex flex-column">';
            template += '<span class="fs-3 fw-bold lh-1">' + item.text + '</span>';
            template += '<span>';
            template += '<small class="text-info p-1">' + item.element.getAttribute('data-kt-rich-content-driver') + '</small>';
            template += '<small class="text-muted">' + item.element.getAttribute('data-kt-rich-content-subcontent') + '</small>';
            template += '</span>';
            template += '</div>';
            // template += '<div class="position-absolute top-50 end-0 translate-middle-y text-center me-3">'
            // template += '53 <br> NOKTA';
            // template += '</div>';
            template += '</div>';

            span.innerHTML = template;

            return $(span);
        }

        // Init Select2 --- more info: https://select2.org/
        $('#select_vehicle').select2({
            placeholder: "Select an option",
            minimumResultsForSearch: Infinity,
            templateSelection: optionFormatTruck,
            templateResult: optionFormatTruck
        });
    </script>
    <script>
        // ADD ADRESS MODAL SELECT 2 CONFIG
        $('#add_destination_address_cities').select2({
            dropdownParent: $("#add_destination_address_cities").parent()
        });
        $('#add_destination_address_towns').select2({
            dropdownParent: $("#add_destination_address_towns").parent()
        });
        $('#add_destination_address_cities').on("select2:select", function(e) { 
            let city_id = $(this).select2('val');
            fillTowns(city_id, '#add_destination_address_towns');
        });


        $('#add_start_address_cities').select2({
            dropdownParent: $("#add_start_address_cities").parent()
        });
        $('#add_start_address_towns').select2({
            dropdownParent: $("#add_start_address_towns").parent()
        });
        $('#add_start_address_cities').on("select2:select", function(e) { 
            let city_id = $(this).select2('val');
            fillTowns(city_id, '#add_start_address_towns');
        });

        $('#add_delivery_address_cities').select2({
            dropdownParent: $("#add_delivery_address_cities").parent()
        });
        $('#add_delivery_address_towns').select2({
            dropdownParent: $("#add_delivery_address_towns").parent()
        });
        $('#add_delivery_address_cities').on("select2:select", function(e) { 
            let city_id = $(this).select2('val');
            fillTowns(city_id, '#add_delivery_address_towns');
        });
        function fillTowns(id, container) {
            $.ajax({
                type: "POST",
                url: "{{ route('getTowns') }}",
                data:{
                    _token: '{{ csrf_token() }}',
                    city_id: id
                } ,
                success: function (response) {
                    if (response) {
                        console.log(response);
                        let html = '<option value="">İlçe seçiniz</option>';
                        $.each(response, function (index, item) { 
                            html += `<option value=${item.id}>${item.text}</option>`;
                        });
                        $(container).html(html);
                    }
                }
            });
        }

        // Select2 focus
        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });
    </script>
@endsection