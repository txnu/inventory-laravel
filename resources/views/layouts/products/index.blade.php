@extends('layout')

@section('content')
	<div x-data="productModal()" class="relative w-full px-4 py-3">
		<div class="min-h-screen w-full bg-white rounded-2xl p-6">
			@if (session('success'))
				<div class="mb-4 p-5 text-green-800 bg-green-100 rounded-md">
					{{ session('success') }}
				</div>
			@endif

			<div class="flex flex-col gap-4">

				{{-- Header: Search & Print --}}
				<div class="flex justify-between items-center gap-4">
					<div class="flex items-center gap-2">
						<input type="text" placeholder="Cari produk..."
							class="px-3 py-2 text-sm rounded-3xl border border-gray-300 focus:border-blue-400 focus:outline-none">
						{{-- <button class="p-2 bg-blue-400 text-white rounded-3xl hover:bg-blue-500">
                        <x-zondicon-search class="w-6 "/>
                    </button> --}}
					</div>
					<div class="flex items-center gap-2">
						<button class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 cursor-pointer">
							<x-zondicon-printer class="w-5" />
						</button>
						<button class="px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-800 cursor-pointer">
							<x-heroicon-o-plus class="w-5" />
						</button>
					</div>
				</div>

				<div class="overflow-x-auto relative min-h-screen">
					<table class="w-full text-left border-collapse">
						<thead>
							<tr class="text-sm border-b text-gray-500">
								<th class="py-2 px-2">SKU</th>
								<th class="py-2 px-2">Product Name</th>
								<th class="py-2 px-2">Description</th>
								<th class="py-2 px-2">Category</th>
								<th class="py-2 px-2">Unit</th>
								<th class="py-2 px-2">Selling Price</th>
								<th class="py-2 px-2">Status</th>
								<th class="py-2 px-2 text-center">Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($products as $p)
								<tr class="text-sm text-gray-700 border-b hover:bg-gray-50">
									<td class="py-2 px-2">{{ $p->sku }}</td>
									<td class="py-2 px-2 overflow-hidden text-ellipsis whitespace-nowrap">{{ $p->product_name }}</td>
									<td class="py-2 px-2 overflow-hidden text-ellipsis whitespace-nowrap">{{ $p->description }}</td>
									<td class="py-2 px-2">{{ $p->category->category_name ?? 'Tidak Ada Kategori' }}</td>
									<td class="py-2 px-2">{{ $p->unit }}</td>
									<td class="py-2 px-2">{{ $p->selling_price }}</td>
									<td class="py-2 px-2">
										<span
											class="px-2 py-1 text-xs rounded-lg
                                    {{ $p->is_active ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
											{{ $p->is_active ? 'Active' : 'Inactive' }}
										</span>
									</td>
									<td class="py-2 px-2 text-center" x-data="{ open: false }">
										<div class="relative ">
											<button @click="open = !open" class="p-1 text-gray-600 hover:text-gray-800 cursor-pointer">
												<x-tabler-dots />
											</button>

											{{-- Dropdown Aksi --}}
											<div x-show="open" @click.outside="open = false" x-transition
												x-anchor.bottom-end="$el.previousElementSibling"
												class="absolute overflow-visible text-left right-0 mt-1 w-40 bg-white shadow-lg rounded-lg border border-gray-100 z-100">
												<button @click="openModal({{ $p->product_id }}, 'view'); open = false"
													class="block text-left px-3 py-2 text-sm text-gray-700 w-full hover:bg-gray-100 cursor-pointer">
													Detail
												</button>
												<button @click="openModal({{ $p->product_id }}, 'edit'); open = false"
													class="block text-left px-3 py-2 text-sm hover:bg-gray-100 w-full">
													Edit
												</button>
												<form action="{{ route('product.delete', $p->product_id) }}" method="POST"
													onsubmit="return confirm('Are you sure to delete this product?')">
													@csrf
													@method('DELETE')
													<button type="submit" class="w-full text-left px-3 py-2 text-sm hover:bg-red-100 text-red-600">
														Delete
													</button>
												</form>
											</div>
										</div>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>

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
		function productModal() {
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
						const response = await fetch(`/product/${id}?mode=${mode}`);
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
