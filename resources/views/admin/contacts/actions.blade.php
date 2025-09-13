<div class="btn-group" role="group">
    <a href="{{ route('admin.contacts.show', $contact) }}" 
       class="btn btn-sm btn-info" 
       title="View Details" style="height: fit-content !important;">
        <i class="bx bx-show"></i>
    </a>
    <form action="{{ route('admin.contacts.destroy', $contact) }}" 
          method="POST" 
          class="d-inline"
          onsubmit="return confirm('Are you sure you want to delete this contact submission?')">
        @csrf
        @method('DELETE')
        <button type="submit" 
                class="btn btn-sm btn-danger" 
                title="Delete">
            <i class="bx bx-trash"></i>
        </button>
    </form>
</div>
