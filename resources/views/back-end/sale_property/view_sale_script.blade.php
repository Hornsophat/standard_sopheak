<script type="text/javascript">
       function view_payment(property,payment_schedule,customer){
            $('#contentPaymentModal').html('...');
            $.ajax({
                type:'get',
                url:"{{ route('sale_property.view_sale_first_payment') }}",
                data:{property:property, customer:customer, payment_schedule:payment_schedule},
                success:function(data){
                    $('#contentPaymentModal').html(data.html);
                },
                error:function(errors){
                    $('#contentPaymentModal').html('No Data!!!');
                }
            })
        }

        function view_loan_payment(payment_schedule){
            $('#contentPaymentModal').html('...');
            $.ajax({
                type:'get',
                url:"{{ route('sale_property.view_loan_payment') }}",
                data:{payment_schedule:payment_schedule},
                success:function(data){
                    $('#contentPaymentModal').html(data.html);
                },
                error:function(errors){
                    $('#contentPaymentModal').html('No Data!!!');
                }
            })
        }

        function view_loan_schedule(loan){
            $('#contentloanScheduleModal').html('...');
            $.ajax({
                type:'get',
                url:"{{ route('sale_property.view_loan_schedule') }}",
                data:{loan:loan},
                success:function(data){
                    $('#contentloanScheduleModal').html(data.html);
                },
                error:function(errors){
                    $('#contentloanScheduleModal').html('No Data!!!');
                }
            })
        }
        function view_schedule(loan){
            $('#contentScheduleModal').html('...');
            $('#loanIn').html('...');
            $.ajax({
                type:'get',
                url:"{{ route('sale_property.view_schedule') }}",
                data:{loan:loan},
                success:function(data){
                    $('#contentScheduleModal').html(data.data);
                    $('#loanIn').html(": $" +data.payment_schedule );
                },
                error:function(errors){
                    $('#contentScheduleModal').html('No Data!!!');
                }
            })
        }
        function confirmAlert(){
            var log = swal({
                title: "{{ __('item.confirm_cancel_payment') }}",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "{{ __('item.option_yes') }}",
                cancelButtonText: "{{ __('item.option_no') }}",
                closeOnConfirm: false,
                closeOnCancel: true
            });
        }
        function cancel_loan_payment(payment_transaction){
            swal({
                title: "{{ __('item.confirm_cancel_payment') }}",
                text: "",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "{{ __('item.option_yes') }}",
                cancelButtonText: "{{ __('item.option_no') }}",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(confirm) {
                if (confirm) {
                    $.ajax({
                        type:'get',
                        url:"{{ route('sale_property.cancel_loan_payment') }}",
                        data:{payment_transaction:payment_transaction},
                        success:function(data){
                            if(data.message==1){
                                swal({
                                    title: '{{ __('item.success_cancel_loan_payment') }}',
                                    type: "success",
                                    showCancelButton: false,
                                    confirmButtonText: "{{ __('item.ok') }}",
                                    closeOnConfirm: false,
                                    closeOnCancel: true
                                });
                                $('#paymentModal').modal('hide');
                                $('#loanScheduleModal').modal('hide');
                                $('#ScheduleModal').modal('hide');
                                setTimeout(function(){
                                    location.reload();
                                },2500)
                            }
                            else if(data.message==3){
                                swal({
                                    title: 'Please wait for administrator approval',
                                    type: "warning",
                                    showCancelButton: false,
                                    confirmButtonText: "{{ __('item.ok') }}",
                                    closeOnConfirm: false,
                                    closeOnCancel: true
                                });
                            }
                            else{
                                swal({
                                    title: '{{ __('item.error_cancel_loan_payment') }}',
                                    type: "warning",
                                    showCancelButton: false,
                                    confirmButtonText: "{{ __('item.ok') }}",
                                    closeOnConfirm: false,
                                    closeOnCancel: true
                                });
                            }
                        },
                        error:function(errors){
                            swal({
                                title: '{{ __('item.error_cancel_loan_payment') }}',
                                type: "error",
                                showCancelButton: false,
                                confirmButtonText: "{{ __('item.ok') }}",
                                closeOnConfirm: false,
                                closeOnCancel: true
                            });
                        }
                    })
                }else{
                    swal({
                        title: '{{ __('item.stop') }}',
                        type: "error",
                        showCancelButton: false,
                        confirmButtonText: "{{ __('item.ok') }}",
                        closeOnConfirm: false,
                        closeOnCancel: true
                    });
                }
            });
        }

        function cancel_loan(loan){
            swal({
                title: "{{ __('item.confirm_cancel_loan') }}",
                text: "",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "{{ __('item.option_yes') }}",
                cancelButtonText: "{{ __('item.option_no') }}",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(confirm) {
                if (confirm) {
                    $.ajax({
                        type:'get',
                        url:"{{ route('sale_property.cancel_loan') }}",
                        data:{loan:loan},
                        success:function(data){
                            if(data.message){
                                swal({
                                    title: '{{ __('item.success_cancel_loan') }}',
                                    type: "success",
                                    showCancelButton: false,
                                    confirmButtonText: "{{ __('item.ok') }}",
                                    closeOnConfirm: false,
                                    closeOnCancel: true
                                });
                                $('#paymentModal').modal('hide');
                                $('#loanScheduleModal').modal('hide');
                                $('#ScheduleModal').modal('hide');
                                setTimeout(function(){
                                    location.reload();
                                },2500)
                            }else{
                                swal({
                                    title: '{{ __('item.error_cancel_loan') }}',
                                    type: "warning",
                                    showCancelButton: false,
                                    confirmButtonText: "{{ __('item.ok') }}",
                                    closeOnConfirm: false,
                                    closeOnCancel: true
                                });
                            }
                        },
                        error:function(errors){
                            swal({
                                title: '{{ __('item.error_cancel_loan') }}',
                                type: "error",
                                showCancelButton: false,
                                confirmButtonText: "{{ __('item.ok') }}",
                                closeOnConfirm: false,
                                closeOnCancel: true
                            });
                        }
                    })
                }else{
                    swal({
                        title: '{{ __('item.stop') }}',
                        type: "error",
                        showCancelButton: false,
                        confirmButtonText: "{{ __('item.ok') }}",
                        closeOnConfirm: false,
                        closeOnCancel: true
                    });
                }
            });
        }

        function cancel_sale_payment(payment_transaction){
            swal({
                title: "{{ __('item.confirm_cancel_payment') }}",
                text: "",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "{{ __('item.option_yes') }}",
                cancelButtonText: "{{ __('item.option_no') }}",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(confirm) {
                if (confirm) {
                    $.ajax({
                        type:'get',
                        url:"{{ route('sale_property.cancel_sale_payment') }}",
                        data:{payment_transaction:payment_transaction},
                        success:function(data){
                            if(data.message){
                                swal({
                                    title: '{{ __('item.success_cancel_sale_payment') }}',
                                    type: "success",
                                    showCancelButton: false,
                                    confirmButtonText: "{{ __('item.ok') }}",
                                    closeOnConfirm: false,
                                    closeOnCancel: true
                                });
                                $('#paymentModal').modal('hide');
                                $('#loanScheduleModal').modal('hide');
                                $('#ScheduleModal').modal('hide');
                                setTimeout(function(){
                                    location.reload();
                                },2500)
                            }else{
                                swal({
                                    title: '{{ __('item.error_cancel_sale_payment') }}',
                                    type: "warning",
                                    showCancelButton: false,
                                    confirmButtonText: "{{ __('item.ok') }}",
                                    closeOnConfirm: false,
                                    closeOnCancel: true
                                });
                            }
                        },
                        error:function(errors){
                            swal({
                                title: '{{ __('item.error_cancel_sale_payment') }}',
                                type: "error",
                                showCancelButton: false,
                                confirmButtonText: "{{ __('item.ok') }}",
                                closeOnConfirm: false,
                                closeOnCancel: true
                            });
                        }
                    })
                }else{
                    swal({
                        title: '{{ __('item.stop') }}',
                        type: "error",
                        showCancelButton: false,
                        confirmButtonText: "{{ __('item.ok') }}",
                        closeOnConfirm: false,
                        closeOnCancel: true
                    });
                }
            });
        }

        function cancel_sale(sale){
            swal({
                title: "{{ __('item.confirm_cancel_sale') }}",
                text: "",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "{{ __('item.option_yes') }}",
                cancelButtonText: "{{ __('item.option_no') }}",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(confirm) {
                if (confirm) {
                    $.ajax({
                        method:'get',
                        url:"{{ route('sale_property.cancel_sale') }}",
                        data:{sale:sale},
                        success:function(data){
                            if(data.message){
                                swal({
                                    title: '{{ __('item.success_cancel_sale') }}',
                                    type: "success",
                                    showCancelButton: false,
                                    confirmButtonText: "{{ __('item.ok') }}",
                                    closeOnConfirm: false,
                                    closeOnCancel: true
                                });
                                // $('#paymentModal').modal('hide');
                                // $('#loanScheduleModal').modal('hide');
                                setTimeout(function(){
                                    location.href = "{{ route('property') }}";
                                },2500)
                            }else{
                                swal({
                                    title: '{{ __('item.error_cancel_sale') }}',
                                    type: "warning",
                                    showCancelButton: false,
                                    confirmButtonText: "{{ __('item.ok') }}",
                                    closeOnConfirm: false,
                                    closeOnCancel: true
                                });
                            }
                        },
                        error:function(errors){
                            swal({
                                title: '{{ __('item.error_cancel_sale') }}',
                                type: "error",
                                showCancelButton: false,
                                confirmButtonText: "{{ __('item.ok') }}",
                                closeOnConfirm: false,
                                closeOnCancel: true
                            });
                        }
                    })
                }else{
                    swal({
                        title: '{{ __('item.stop') }}',
                        type: "error",
                        showCancelButton: false,
                        confirmButtonText: "{{ __('item.ok') }}",
                        closeOnConfirm: false,
                        closeOnCancel: true
                    });
                }
            });
        }
        $('#contractModal').on('hidden.bs.modal', function (e) {
            $('#contractContentModal').html('');
        });
        $('#scheduleModal').on('hidden.bs.modal', function (e) {
            $('#scheduleContentModal').html('');
        })
        function view_contract(id){
            $.ajax({
                method:'get',
                url:"{{ route('sale_property.sale_contract') }}",
                data:{id:id},
                success:function(data){
                    $('#contractContentModal').html(data.html);
                }
            })
        }
        function print_schedule(id){
            $.ajax({
                method:'get',
                url:"{{ route('sale_property.print_schedule') }}",
                data:{id:id},
                success:function(data){
                    $('#scheduleContentModal').html(data.html);
                }
            })
        }

        function paidOff(url){
            swal({
                title: "Are you sure you want to paid off?",
                text: "",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "{{ __('item.option_yes') }}",
                cancelButtonText: "{{ __('item.option_no') }}",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(confirm) {
                if (confirm) {
                    window.location.href = url;
                }else{
                    swal({
                        title: '{{ __('item.stop') }}',
                        type: "error",
                        showCancelButton: false,
                        confirmButtonText: "{{ __('item.ok') }}",
                        closeOnConfirm: false,
                        closeOnCancel: true
                    });
                }
            });
        }

        function changeAddress(){
            var frm =  $('#frmChangeAddress');
            $.ajax({
                type:frm.attr('method'),
                url:frm.attr('action'),
                data:frm.serialize(),
                dataType:false,
                complete:function(response){
                    if(response.status==200){
                        swal({
                            title: response.responseJSON.message,
                            type: "success",
                            showCancelButton: false,
                            confirmButtonText: "{{ __('item.ok') }}",
                            closeOnConfirm: false,
                            closeOnCancel: true
                        });

                        $('.modal').modal('hide');
                    }
                },
                error:function(errors){
                    swal({
                        title: "Change address failed",
                        type: "error",
                        showCancelButton: false,
                        confirmButtonText: "{{ __('item.ok') }}",
                        closeOnConfirm: false,
                        closeOnCancel: true
                    });
                }
            })
        }
        function getChangePartner(){
            $.ajax({
                type:"GET",
                url:"{{ route('sale_item.getchange_partner') }}",
                data:{sale_item_id:"{{ $sale->id }}"},
                dataType:false,
                complete:function(response){
                    if(response.status==200){
                        $('#contentChangePartnerModal').html(response.responseJSON.html);
                        setTimeout(()=>$('body').find('#partner_id').select2({dropdownParent: $("#changePartnerModal")}),300)
                    }else{
                        swal({
                        title: "No Data Found!",
                        type: "warning",
                        showCancelButton: false,
                        confirmButtonText: "{{ __('item.ok') }}",
                        closeOnConfirm: false,
                        closeOnCancel: true
                    });
                    }
                },
                error:function(errors){
                    swal({
                        title: "Change partner failed",
                        type: "error",
                        showCancelButton: false,
                        confirmButtonText: "{{ __('item.ok') }}",
                        closeOnConfirm: false,
                        closeOnCancel: true
                    });
                }
            })
        }
        $('#changePartnerModal').on('hidden.bs.modal', function (e) {
            $('#contentChangePartnerModal').html('');
        });
        function changePartner(){
            var frm =  $('#frmChangePartner');
            $.ajax({
                type:frm.attr('method'),
                url:frm.attr('action'),
                data:frm.serialize(),
                dataType:false,
                complete:function(response){
                    if(response.status==200){
                        swal({
                            title: response.responseJSON.message,
                            type: "success",
                            showCancelButton: false,
                            confirmButtonText: "{{ __('item.ok') }}",
                            closeOnConfirm: false,
                            closeOnCancel: true
                        });

                        $('.modal').modal('hide');
                    }
                },
                error:function(errors){
                    swal({
                        title: "Change partner failed",
                        type: "error",
                        showCancelButton: false,
                        confirmButtonText: "{{ __('item.ok') }}",
                        closeOnConfirm: false,
                        closeOnCancel: true
                    });
                }
            })
        }
    </script>