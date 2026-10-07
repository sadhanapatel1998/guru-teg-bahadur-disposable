@extends('layouts.admin')

@section('title', 'Reviews')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-700 mb-0">Reviews</h5>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">

    <div class="table-responsive">
        <table class="table table-hover align-middle">

            <thead>
                <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th>User</th>
                    <th>Rating</th>
                    <th>Title</th>
                    <th>Review</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th width="180">Action</th>
                </tr>
            </thead>

            <tbody>

                @forelse($reviews as $review)

                    <tr>

                        <td>{{ $review->id }}</td>

                        <td>
                            {{ $review->product->name ?? 'N/A' }}
                        </td>

                        <td>
                            {{ $review->user->name ?? 'Guest' }}
                        </td>

                        <td>
                            @for($i=1; $i<=5; $i++)
                                @if($i <= $review->rating)
                                    <i class="bi bi-star-fill text-warning"></i>
                                @else
                                    <i class="bi bi-star text-secondary"></i>
                                @endif
                            @endfor
                        </td>

                        <td>
                            {{ $review->title }}
                        </td>

                        <td style="max-width:250px;">
                            {{ Str::limit($review->body, 80) }}
                        </td>

                        <td>
                            @if($review->status == 'approved')
                                <span class="badge bg-success">
                                    Approved
                                </span>
                            @elseif($review->status == 'pending')
                                <span class="badge bg-warning text-dark">
                                    Pending
                                </span>
                            @else
                                <span class="badge bg-danger">
                                    Rejected
                                </span>
                            @endif
                        </td>

                        <td>
                            {{ $review->created_at->format('d M Y') }}
                        </td>

                      <td>
                        <div class="d-flex align-items-center gap-2">

                            <form action="{{ route('admin.reviews.status',$review) }}"
                                method="POST">
                                @csrf
                                @method('PATCH')

                                <select name="status"
                                        onchange="this.form.submit()"
                                        class="form-select form-select-sm"
                                        style="width:130px;">
                                    <option value="pending" {{ $review->status=='pending' ? 'selected':'' }}>
                                        Pending
                                    </option>
                                    <option value="approved" {{ $review->status=='approved' ? 'selected':'' }}>
                                        Approved
                                    </option>
                                    <option value="rejected" {{ $review->status=='rejected' ? 'selected':'' }}>
                                        Rejected
                                    </option>
                                </select>
                            </form>

                            <form action="{{ route('admin.reviews.destroy',$review) }}"
                                method="POST"
                                onsubmit="return confirm('Delete this review?')">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>

                        </div>
                    </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="9" class="text-center py-4">
                            No reviews found.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>
    </div>

    <div class="mt-3">
        {{ $reviews->links() }}
    </div>

</div>
</div>

@endsection
