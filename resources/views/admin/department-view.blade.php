<li>
    @if (is_array($department))
        <a href="javascript:void(0);" onclick="loadEmployees('{{ route('department.employees', ['department' => $department['deptName']]) }}', '{{ $department['deptName'] }}')">
            {{ $department['deptName'] }}
        </a>
    @endif

    @if (!empty($department['children']) && is_array($department['children']))
        <ul>
            @foreach ($department['children'] as $child)
                @include('admin.department-view', ['department' => $child])
            @endforeach
        </ul>
    @endif
</li>

<script>
    function loadEmployees(url, department) {
        $.ajax({
            url: url,
            type: 'GET',
            success: function(data) {
                $('#employees-datatable').DataTable().ajax.url(url).load();
                window.location.href = "{{ route('department.employees', ['department' => ':department']) }}".replace(':department', department);
            },
            error: function(data) {
                console.log('Error: ', data);
            }
        });
    }
</script>
