@extends('layout')

@section('content')
	<div x-data="stockMovementModal()" class="relative w-full px-4 py-3">
		<div class="min-h-screen w-full bg-white rounded-2xl p-6">

			<div class="flex flex-col gap-4">

				{{-- Header Table --}}
				<div class="flex justify-between items-center gap-4">
					<div class="flex items-center gap-2">
						<input type="text" placeholder="Cari Produk..."
							class="px-3 py-2 text-sm rounded-3xl border border-gray-300 focus:border-blue-400 focus:outline-none">
					</div>
					<div class="flex items-center gap-2">
						<button class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 cursor-pointer">
							<x-zondicon-printer class="w-5" />
						</button>
					</div>
				</div>
				{{-- End Header Table --}}

				{{-- Table Content --}}
				<div class="overflow-x-auto relative min-h-screen">
					<table class="w-full text-left border-collapse">
						<thead>
							<tr class="text-sm border-b text-gray-500">
								<th class="py-2 px-2">Product Name</th>
								<th class="py-2 px-2">Reference Type</th>
								<th class="py-2 px-2">Qty</th>
								<th class="py-2 px-2">Before</th>
								<th class="py-2 px-2">After</th>
								<th class="py-2 px-2">Movement Type</th>
								<th class="py-2 px-2">Created By</th>
								<th class="py-2 px-2 text-center">Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($stock_movement as $sm)
								<tr class="text-sm text-gray-700 border-b hover:bg-gray-50">
									<td class="py-2 px-2">{{ $sm->product->product_name }}</td>
									<td class="py-2 px-2">{{ $sm->reference_type }}</td>
									<td class="py-2 px-2">{{ $sm->qty }}</td>
									<td class="py-2 px-2">{{ $sm->before_qty }}</td>
									<td class="py-2 px-2">{{ $sm->after_qty }}</td>
									<td class="py-2 px-2 font-bold">
										<span
											class="px-2 py-1 text-xs rounded-lg
                                    {{ $sm->movement_type ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
											{{ $sm->movement_type ? 'IN' : 'OUT' }}
										</span>
									</td>
									<td class="py-2 px-2">{{ $sm->user->name }}</td>
									<td class="py-2 px-2 text-center" x-data="{ open: false }">
										<div class="relative ">
											<button @click="open = !open" class="p-1 text-gray-600 hover:text-gray-800 cursor-pointer">
												<x-tabler-dots />
											</button>

											{{-- Dropdown Aksi --}}
											<div x-show="open" @click.outside="open = false" x-transition
												x-anchor.bottom-end="$el.previousElementSibling"
												class="absolute overflow-visible text-left right-0 mt-1 w-40 bg-white shadow-lg rounded-lg border border-gray-100 z-100">
												<button @click="openModal({{ $sm->stock_m_id }}, 'view'); open = false"
													class="block text-left px-3 py-2 text-sm text-gray-700 w-full hover:bg-gray-100 cursor-pointer">
													Detail
												</button>
											</div>
										</div>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				{{-- End Table Content --}}
			</div>
		</div>
		<template x-if="showModal">
			<div x-show="showModal" x-transition.opacity class="fixed inset-0 flex items-center justify-center z-50">

				{{-- Overlay --}}
				<div class="absolute inset-0 bg-black/50" @click="closeModal()"></div>

				{{-- Modal Box --}}
				<div x-show="showModal" x-transition.scale class="relative bg-white rounded-md shadow-md p-8 w-[60%] z-10">

					<button @click="closeModal()"
						class="absolute top-2 right-3 text-gray-500 hover:text-gray-700 cursor-pointer">✕</button>

					{{-- Loading Spinner --}}
					<div x-show="loading" class="flex justify-center items-center h-40">
						<svg class="animate-spin h-8 w-8 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none"
							viewBox="0 0 24 24">
							<circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
							<path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
						</svg>
					</div>

					{{-- Konten Produk --}}
					<div x-show="!loading" x-html="modalContent"></div>
				</div>
			</div>
		</template>
	</div>

	<script>
		function stockMovementModal() {
			return {
				showModal: false,
				loading: false,
				modalContent: '',
				mode: 'view',

				async openModal(id, mode = 'view') {
					this.showModal = true;
					this.loading = true;
					this.mode = mode;
					this.modalContent = '';

					try {
						const response = await fetch(`/stock-movement/${id}?mode=${mode}`);
						if (!response.ok) throw new Error('Gagal memuat data produk');
						const html = await response.text();
						this.modalContent = html;
					} catch (e) {
						this.modalContent = `<p class='text-red-500 text-center'>${e.message}</p>`;
					} finally {
						this.loading = false;
					}
				},

				closeModal() {
					this.showModal = false;
					this.modalContent = '';
				}
			}
		}
	</script>
@endsection
