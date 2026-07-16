@php use App\Models\BlogComment; @endphp

<div class="comment-item mb-20 @if($depth > 0) comment-reply @endif" id="comment-{{ $comment->id }}">
    <div class="d-flex justify-content-between align-items-start">
        <div class="d-flex gap-12 flex-wrap align-items-start">
            <div class="bg-main-25 rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                <i class="ph ph-user text-main-600 text-20"></i>
            </div>
            <div>
                <div class="d-flex align-items-center gap-8 flex-wrap mb-4">
                    <strong class="text-14">{{ $comment->user->name ?? 'Anonyme' }}</strong>
                    <span class="text-12 text-neutral-400">{{ $comment->created_at->format('d/m/Y H:i') }}</span>
                    @if($comment->is_approved)
                        <span class="badge bg-success-100 text-success-600 px-8 py-4 rounded-pill text-12">Approuvé</span>
                    @else
                        <span class="badge bg-warning-100 text-warning-600 px-8 py-4 rounded-pill text-12">En attente</span>
                    @endif
                </div>
                <div class="text-14 text-neutral-600 mb-8">{{ nl2br(e($comment->content)) }}</div>
                <div class="d-flex gap-12">
                    @if(!$comment->is_approved)
                        <form action="{{ route('manager.comments.approve', $comment) }}" method="POST" class="d-inline">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn bg-main-600 rounded-pill px-12 py-4 text-12">✅ Approuver</button>
                        </form>
                    @else
                        <form action="{{ route('manager.comments.disapprove', $comment) }}" method="POST" class="d-inline">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn bg-warning-600 rounded-pill px-12 py-4 text-12">⛔ Désapprouver</button>
                        </form>
                    @endif
                    <form action="{{ route('manager.comments.destroy', $comment) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ce commentaire ? Ses réponses aussi.')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn bg-danger-600 rounded-pill px-12 py-4 text-12">🗑️ Supprimer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Display replies recursively --}}
    @if($comment->replies && $comment->replies->count())
        <div class="replies-list mt-16">
            @foreach($comment->replies as $reply)
                @include('manager.blog.partials.comment-item', ['comment' => $reply, 'depth' => $depth + 1])
            @endforeach
        </div>
    @endif
</div>