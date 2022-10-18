@push('scripts')
<script src="{{ asset('assets/js/global.js') }}"></script>
<script>
    instruction_id = '{{Session::has("work_order_instruction") ? count(Session::get("work_order_instruction")) + 1 : 1}}' ?? localStorage.getItem('instruction_id') ?? 1;
    other_cost_id = '{{Session::has("work_order_other_cost") ? count(Session::get("work_order_other_cost")) + 1 : 1}}' ?? localStorage.getItem('other_cost_id') ?? 1;

    $(document).ready(() => {
        let url = location.href.replace(/\/$/, "");
        
        if (location.hash) {
            const hash = url.split("#");
            $('#tabWorkOrder a[href="#'+hash[1]+'"]').tab("show");
            
            url = location.href.replace(/\/#/, "#");
            history.replaceState(null, null, url);
            
            setTimeout(() => {
                $(window).scrollTop(0);
            }, 400);
        } 
        
        $('a[data-toggle="tab"]').on("click", function() {
            let newUrl;
            const hash = $(this).attr("href");
            if(hash == "#tab-instruction") {
            newUrl = url.split("#")[0];
            } else {
            newUrl = url.split("#")[0] + hash;
            }

            history.replaceState(null, null, newUrl);
        });

        let table = $('.data-table-parts').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('work.work_order.get.parts') }}",
            sorting: [],
            language: BaseList.lang(),
            lengthChange: false,
		    filter: false,
            columns: [
                {data: 'DT_RowIndex', name: '#', orderable: false, searchable: false },
                {data: 'part_code', name: 'ID Part'},
                {data: 'name', name: 'Name'},
                {data: 'action', name: 'Aksi', orderable: false, searchable: false},
            ]
        });

    });
    
    function showModal(element) {
        let id = $(element).data('bs-target');
        $(id).modal('show');
        addID(id);
    }

    function hideModal(id) {
        if(id == '#addInstructionModal'){
            $("input[name='instruction_input']").val('')
            $("#editInstruction").val('')
            $("#files_instruction").text('')

            $('.base-form--remove-temp-files').click()
        } else if(id == '#addOtherCostModal') {
            $("input[name='jumlah_other_cost']").val('')
            $("#editOtherCost").val('')
            $("#error_jumlah_other_cost").text('')
            $("#error_other_cost_id").text('')
            
            let option = `
                <option value="" selected></option>
            `

            $(`#other_cost_id`).append(option)

            $("input[name=jumlah_other_cost]").prop('disabled', false);
            $("#other_cost_id").prop('disabled', false);

            $('#submit-other-cost').show()
        }

        $(id).modal('hide');
    }

    function addID(id){
        if(id == '#addInstructionModal'){
            $(id+"data_id").val(instruction_id)
        } else if(id == '#addOtherCostModal') {
            $(id+"data_id").val(other_cost_id)
        }
    }

    //Instruction Method
    function submitInstruction(){
        event.preventDefault()

        let formData = new FormData();

        if($('#editInstruction').val() == 'true'){
            formData.append('id',  $('#addInstructionModal_data_id').val());
        
            let attachments_instruction = [];

            let name_temp = $("input[name='instruction_input']").val() ?? null;
            formData.append('instruction_input',  name_temp);

            let attachment_temp = $('#attachment_instruction_input')[0].files;
            if(attachment_temp.length > 0){
                for (let i = 0; i < attachment_temp.length; i++) {
                    attachments_instruction.push($('#attachment_instruction_input')[0].files[i]);
                }

                formData.append('attachments_instruction_input[]', attachments_instruction)

            } else {
                formData.append('attachments_instruction_input[]',  null);
            }
            

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                }
            });
            $.ajax({
                url: "{{route('work.work_order.update.instruction')}}",
                method: "post",
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,
                success: function(response) {
                    if(response.message == 'success'){
                        $("#instruction-table").load(location.href + " #instruction-table");

                        $("input[name='instruction_input']").val('')
                        $("#editInstruction").val('')

                        $('.base-form--remove-temp-files').click()
                        $('#addInstructionModal').modal('hide');
                    }
                },
            })
        } else {
            formData.append('id',  instruction_id);

            let attachments_instruction = [];

            let name_temp = $("input[name='instruction_input']").val() ?? null;
            formData.append('instruction_input',  name_temp);

            let attachment_temp = $('#attachment_instruction_input')[0].files;
            for (let i = 0; i < attachment_temp.length; i++) {
                attachments_instruction.push($('#attachment_instruction_input')[0].files[i]);
            }
       
            formData.append('attachments_instruction_input[]', attachments_instruction)

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                }
            });
            $.ajax({
                url: "{{route('work.work_order.create.instruction')}}",
                method: "post",
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,
                success: function(response) {
                    if(response.message == 'success'){
                        $("#instruction-table").load(location.href + " #instruction-table");
                        hideModal('#addInstructionModal');
                        ++instruction_id;
                    } else {
                        console.log(response.message)
                    }
                },
            })
        }
        
    };

    function updateInstruction(id, name, files) {
        $('#addInstructionModal').modal('show');
        $('#editInstruction').val(true);
        $("input[name='instruction_input']").val(name);
        $("#addInstructionModal_data_id").val(id);
        
        let arr_files = files;
        let files_name = null;

        if(arr_files.length > 0 && arr_files != '[]'){
            let result = arr_files.map(function(item){ return item.original_name; })
            files_name = result.join(",");
        }

        $("#files_instruction").text(files_name ? 'Files: '+ files_name : '');
    }

    function deleteInstruction(id) {
        let url = "{{ route('work.work_order.delete.instruction', ":id") }}";
        url = url.replace(':id', id);

        Swal.fire({
            title: 'Delete Instruction',
            text: 'Hapus Instruksi Kerja?',
            icon: 'error',
            showCancelButton: true,
            confirmButtonColor: '#3699FF',
            cancelButtonColor: '##FFFFFF',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    }
                });
                $.ajax({
                    url: url,
                    method: "get",
                    success: function(response) {
                        if(response.message == 'success'){
                            $("#instruction-table").load(location.href + " #instruction-table");
                        }
                    },
                })
            }
        })
    }

    //Other Cost Method
    function submitOtherCost(){
        event.preventDefault()

        let formData = new FormData();

        if($('#editOtherCost').val() == 'true'){
            formData.append('id',  $('#addOtherCostModal_data_id').val());
        
            let other_cost_id_val = $('select[name=other_cost_id] option').filter(':selected').val() ?? '';
            let other_cost_name =$('select[name=other_cost_id] option').filter(':selected').text() ?? '';
            let other_cost = {
                id: other_cost_id_val,
                name: other_cost_name
            }

            formData.append('other_cost',  other_cost_id_val ? JSON.stringify(other_cost) : '');

            let jumlah_other_cost = $("input[name='jumlah_other_cost']").val() ?? null;
            formData.append('jumlah',  jumlah_other_cost);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                }
            });
            $.ajax({
                url: "{{route('work.work_order.update.other_cost')}}",
                method: "post",
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,
                success: function(response) {
                    if(response.message == 'success'){
                        $("#other-cost-table").load(location.href + " #other-cost-table");
                        hideModal('#addOtherCostModal')
                    } else {
                        $("#error_jumlah_other_cost").text(response.errror.jumlah ? response.errror.jumlah[0] : '')
                        $("#error_other_cost_id").text(response.errror.other_cost ? response.errror.other_cost[0] : '')
                    }
                },
            })
        } else {
            formData.append('id',  other_cost_id);
        
            let other_cost_id_val = $('select[name=other_cost_id] option').filter(':selected').val() ?? '';
            let other_cost_name =$('select[name=other_cost_id] option').filter(':selected').text() ?? '';
            let other_cost = {
                id: other_cost_id_val,
                name: other_cost_name
            }

            console.log(other_cost_id_val);
            formData.append('other_cost',  other_cost_id_val ? JSON.stringify(other_cost) : '');

            let jumlah_other_cost = $("input[name='jumlah_other_cost']").val() ?? null;
            formData.append('jumlah',  jumlah_other_cost);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                }
            });
            $.ajax({
                url: "{{route('work.work_order.create.other_cost')}}",
                method: "post",
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,
                success: function(response) {
                    if(response.message == 'success'){
                        $("#other-cost-table").load(location.href + " #other-cost-table");
                        ++other_cost_id;

                        hideModal('#addOtherCostModal')
                    } else {
                        $("#error_jumlah_other_cost").text(response.errror.jumlah ? response.errror.jumlah[0] : '')
                        $("#error_other_cost_id").text(response.errror.other_cost ? response.errror.other_cost[0] : '')
                    }
                },
            })
        }
        
    };

    function updateOtherCost(id, other_cost_name, jumlah) {
        $('#addOtherCostModal').modal('show');

        let result = JSON.parse(other_cost_name);

        $('#editOtherCost').val(true);

        let option = `
            <option value="${result ? result.id : '' }" selected>${result ? result.name : ''}</option>
        `

        $(`#other_cost_id`).append(option)

        $("#addOtherCostModal_data_id").val(id);
        $("input[name=jumlah_other_cost]").val(jumlah);
    }

    function deleteOtherCost(id) {
        let url = "{{ route('work.work_order.delete.other_cost', ":id") }}";
        url = url.replace(':id', id);

        Swal.fire({
            title: 'Delete Other Cost',
            text: 'Hapus Biaya Lain?',
            icon: 'error',
            showCancelButton: true,
            confirmButtonColor: '#3699FF',
            cancelButtonColor: '##FFFFFF',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    }
                });
                $.ajax({
                    url: url,
                    method: "get",
                    success: function(response) {
                        if(response.message == 'success'){
                            $("#other-cost-table").load(location.href + " #other-cost-table");
                        }
                    },
                })
            }
        })
    }

    function showOtherCost(id, other_cost_name, jumlah) {
        $('#addOtherCostModal').modal('show');

        let result = JSON.parse(other_cost_name);

        $('#editOtherCost').val(true);

        let option = `
            <option value="${result ? result.id : '' }" selected>${result ? result.name : ''}</option>
        `

        $(`#other_cost_id`).append(option)

        $("#addOtherCostModal_data_id").val(id);
        $("input[name=jumlah_other_cost]").val(jumlah);

        $("input[name=jumlah_other_cost]").prop('disabled', true);
        $("#other_cost_id").prop('disabled', true);

        $('#submit-other-cost').hide()
    }

    $('#estimation_cost').keyup(function() {
       formatCurrency("estimation_cost", this.value)
    })
</script>
@endpush