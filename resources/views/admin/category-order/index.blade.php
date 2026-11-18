@extends('admin.layout')

@section('title', 'Category Order')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h1 class="text-3xl font-bold text-white">Category Order</h1>
            <p class="text-gray-400 mt-1">Drag and drop to customize main category and subcategory menu order. URLs stay the same.</p>
        </div>
        <div id="order-status" class="text-sm text-gray-400"></div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
        {{-- Main categories --}}
        <div class="bg-gray-800/60 border border-gray-700 rounded-xl p-5">
            <div class="flex items-center justify-between mb-4 gap-2">
                <h2 class="text-lg font-semibold text-white">Main categories</h2>
                <button type="button" id="reset-main-btn"
                        class="text-xs px-3 py-1.5 rounded-lg border border-gray-600 text-gray-300 hover:border-[#f59e0b] hover:text-[#f59e0b] transition-colors">
                    Reset to default
                </button>
            </div>
            <p class="text-xs text-gray-500 mb-3">Drag rows to reorder the site menu and category index.</p>
            <ul id="main-category-list" class="space-y-2">
                @foreach($mainCategories as $category)
                    <li data-id="{{ $category->id }}"
                        class="sortable-item flex items-center gap-3 px-3 py-3 bg-gray-900/80 border border-gray-700 rounded-lg cursor-grab active:cursor-grabbing">
                        <span class="text-gray-500 select-none" aria-hidden="true">⠿</span>
                        <div class="flex-1 min-w-0">
                            <div class="text-sm font-medium text-white truncate">{{ $category->name }}</div>
                            <div class="text-xs text-gray-500 truncate">{{ $category->slug }}</div>
                        </div>
                        <a href="{{ route('admin.category-order.index', ['parent' => $category->id]) }}"
                           class="text-xs text-[#f59e0b] hover:underline whitespace-nowrap {{ ($selectedParent?->id ?? null) == $category->id ? 'font-bold' : '' }}">
                            Subcategories
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- Subcategories --}}
        <div class="bg-gray-800/60 border border-gray-700 rounded-xl p-5">
            <div class="flex items-center justify-between mb-4 gap-2">
                <h2 class="text-lg font-semibold text-white">
                    Subcategories
                    @if($selectedParent)
                        <span class="text-gray-400 font-normal text-sm">— {{ $selectedParent->name }}</span>
                    @endif
                </h2>
                <button type="button" id="reset-sub-btn"
                        class="text-xs px-3 py-1.5 rounded-lg border border-gray-600 text-gray-300 hover:border-[#f59e0b] hover:text-[#f59e0b] transition-colors disabled:opacity-40"
                        @if(!$selectedParent) disabled @endif
                        data-parent-id="{{ $selectedParent?->id }}">
                    Reset to default
                </button>
            </div>
            <p class="text-xs text-gray-500 mb-3">Select a main category, then drag its subcategories.</p>

            @if($subcategories->isEmpty())
                <div class="text-sm text-gray-500 py-8 text-center border border-dashed border-gray-700 rounded-lg">
                    No subcategories for this category.
                </div>
            @else
                <ul id="sub-category-list" class="space-y-2" data-parent-id="{{ $selectedParent->id }}">
                    @foreach($subcategories as $sub)
                        <li data-id="{{ $sub->id }}"
                            class="sortable-item flex items-center gap-3 px-3 py-3 bg-gray-900/80 border border-gray-700 rounded-lg cursor-grab active:cursor-grabbing">
                            <span class="text-gray-500 select-none" aria-hidden="true">⠿</span>
                            <div class="flex-1 min-w-0">
                                <div class="text-sm font-medium text-white truncate">{{ $sub->name }}</div>
                                <div class="text-xs text-gray-500 truncate">{{ $sub->slug }}</div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script>
(function () {
    const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    const statusEl = document.getElementById('order-status');

    function setStatus(message, ok) {
        if (!statusEl) return;
        statusEl.textContent = message;
        statusEl.className = 'text-sm ' + (ok ? 'text-green-400' : 'text-red-400');
    }

    async function postJson(url, body) {
        const res = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrf,
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: JSON.stringify(body),
        });
        const data = await res.json().catch(() => ({}));
        if (!res.ok || !data.success) {
            throw new Error(data.message || 'Save failed');
        }
        return data;
    }

    function orderedIds(listEl) {
        return [...listEl.querySelectorAll('[data-id]')].map(li => parseInt(li.dataset.id, 10));
    }

    const mainList = document.getElementById('main-category-list');
    if (mainList && window.Sortable) {
        Sortable.create(mainList, {
            animation: 150,
            handle: '.sortable-item',
            onEnd: async function () {
                try {
                    setStatus('Saving main order…', true);
                    const data = await postJson(@json(route('admin.category-order.reorder-main')), {
                        ordered_ids: orderedIds(mainList),
                    });
                    setStatus(data.message, true);
                } catch (e) {
                    setStatus(e.message || 'Failed to save', false);
                }
            },
        });
    }

    const subList = document.getElementById('sub-category-list');
    if (subList && window.Sortable) {
        Sortable.create(subList, {
            animation: 150,
            handle: '.sortable-item',
            onEnd: async function () {
                try {
                    setStatus('Saving subcategory order…', true);
                    const data = await postJson(@json(route('admin.category-order.reorder-sub')), {
                        parent_id: parseInt(subList.dataset.parentId, 10),
                        ordered_ids: orderedIds(subList),
                    });
                    setStatus(data.message, true);
                } catch (e) {
                    setStatus(e.message || 'Failed to save', false);
                }
            },
        });
    }

    document.getElementById('reset-main-btn')?.addEventListener('click', async function () {
        if (!confirm('Reset main category order to config defaults?')) return;
        try {
            const data = await postJson(@json(route('admin.category-order.reset-main')), {});
            setStatus(data.message, true);
            window.location.reload();
        } catch (e) {
            setStatus(e.message || 'Reset failed', false);
        }
    });

    document.getElementById('reset-sub-btn')?.addEventListener('click', async function () {
        const parentId = parseInt(this.dataset.parentId || '0', 10);
        if (!parentId) return;
        if (!confirm('Reset subcategory order for this category to defaults?')) return;
        try {
            const data = await postJson(@json(route('admin.category-order.reset-sub')), { parent_id: parentId });
            setStatus(data.message, true);
            window.location.reload();
        } catch (e) {
            setStatus(e.message || 'Reset failed', false);
        }
    });
})();
</script>
@endpush
