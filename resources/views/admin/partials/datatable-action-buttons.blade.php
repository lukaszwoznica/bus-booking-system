<form action="{{ $destroyRoute }}" method="POST" id="{{ "delete{$id}" }}">
    @csrf
    @method('DELETE')
    <div class="d-flex justify-content-center">
        @if(!empty($showRoute))
            <a href="{{ $showRoute }}" class="btn btn-secondary btn-sm mr-1" data-toggle="tooltip" data-placement="top"
               title="View">
                <i class="fas fa-fw fa-eye"></i>
            </a>
        @endif
        <a href="{{ $editRoute }}" class="btn btn-success btn-sm mr-1" data-toggle="tooltip" data-placement="top"
           title="Edit">
            <i class="fas fa-fw fa-edit"></i>
        </a>
        <button class="btn btn-danger btn-sm" type="button" data-toggle="tooltip" data-placement="top" title="Delete"
                onclick="deleteConfirm('{{ "delete$id" }}', '{{ $itemName }}')">
            <i class="fas fa-fw fa-trash-alt"></i>
        </button>
    </div>
</form>
