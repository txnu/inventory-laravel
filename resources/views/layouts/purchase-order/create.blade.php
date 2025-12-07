@extends('layout')

@section('content')
	<div class="w-full px-6 py-6">
		<div class="bg-white p-6 rounded-lg shadow-md">
			<h2 class="text-xl font-semibold mb-4">Tambah Produk Baru</h2>

			<form action="{{ route('purchase-order.store') }}" method="POST" enctype="multipart/form-data">
				@csrf

				@if ($errors->any())
					<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
						<ul class="list-disc list-inside">
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				@endif

				<div class="grid grid-cols-2 gap-4">

					{{-- PO Code --}}
					<div>
						<label class="block text-sm text-gray-600">PO Code</label>
						<input type="text" name="po_code"
							class="uppercase w-full px-3 py-2 border rounded-md focus:border-blue-500 focus:ring-blue-500 focus:outline-none"
							required>
					</div>

					{{-- Supplier --}}
					<div>
						<label class="block text-sm text-gray-600">Supplier</label>
						<select name="supplier_id" class="w-full px-3 py-2 border rounded-md focus:border-blue-400 focus:outline-none">
							@foreach ($supplier as $s)
								<option value="{{ $s->supplier_id }}">
									{{ $s->supplier_name }}
								</option>
							@endforeach
						</select>
					</div>

					{{-- Order date --}}
					<div>
						<label class="block text-sm text-gray-600">Order date</label>
						<input type="date" name="order_date"
							class="w-full px-3 py-2 border rounded-md focus:border-blue-500 focus:ring-blue-500 focus:outline-none">
					</div>

					{{-- Delivery date --}}
					<div>
						<label class="block text-sm text-gray-600">Delivery date</label>
						<input type="date" name="delivery_date"
							class="w-full px-3 py-2 border rounded-md focus:border-blue-500 focus:ring-blue-500 focus:outline-none" required>
					</div>

					{{-- Status --}}
					<div>
						<label class="block text-sm text-gray-600">Status</label>
						<select name="status" class="w-full px-3 py-2 border rounded-md">
							@foreach (['draft', 'ordered', 'received', 'closed', 'canceled'] as $status)
								<option value="{{ $status }}">
									{{ ucfirst($status) }}
								</option>
							@endforeach
						</select>
					</div>
				</div>

				<div class="mt-4">
					<label class="block text-sm font-medium text-gray-700">Notes</label>
					<textarea name="notes" rows="3"
					 class="mt-1 block w-full border  rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500" required></textarea>
				</div>

				{{-- PO Items --}}

				<div x-data="poItems()" class="mt-8">

					<h3 class="text-lg font-semibold mb-2">Purchase Order Items</h3>

					<table class="w-full  text-sm">
						<thead class="bg-gray-100">
							<tr class="border-t border-b">
								<th class="px-2 py-2 w-1/3">Product</th>
								<th class="px-2 py-2 w-24">Qty</th>
								<th class="px-2 py-2 w-32">Price</th>
								<th class="px-2 py-2 w-32">Total</th>
								<th class="px-2 py-2 w-16">#</th>
							</tr>
						</thead>

						<tbody>
							<template x-for="(item, index) in items" :key="index">
								<tr>
									<!-- Product -->
									<td class="border-t border-b px-2 py-2">
										<select x-model="item.product_id" :name="`items[${index}][product_id]`"
											class="w-full border border-gray-400 rounded-md px-2 py-1" required>
											<option value="">Select Product</option>
											@foreach ($product as $p)
												<option value="{{ $p->product_id }}">{{ $p->product_name }}</option>
											@endforeach
										</select>
									</td>

									<!-- Qty -->
									<td class="border px-2 py-2">
										<input type="number" min="1" x-model="item.qty" @input="updateRow(index)"
											:name="`items[${index}][qty_ordered]`" class="w-full border border-gray-400 rounded-md px-2 py-1" required>
									</td>

									<!-- Price -->
									<td class="border px-2 py-2">
										<input type="number" min="0" x-model="item.price" @input="updateRow(index)"
											:name="`items[${index}][price]`" class="w-full border border-gray-400 rounded-md px-2 py-1" required>
									</td>

									<!-- Total -->
									<td class="border px-2 py-2">
										<input type="number" x-model="item.total" :name="`items[${index}][total]`"
											class="w-full border border-gray-400 rounded-md px-2 py-1 bg-gray-100" readonly>
									</td>

									<!-- Remove -->
									<td class="border px-2 py-2 text-center">
										<button type="button" @click="removeRow(index)" class="text-red-500 hover:text-red-700 font-bold">X</button>
									</td>
								</tr>
							</template>
						</tbody>
					</table>

					<button type="button" @click="addRow()" class="mt-3 px-3 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-700">
						+ Add Item
					</button>

					<!-- Summary -->
					<div class="mt-4 text-right">
						<p class="text-lg font-semibold">
							Grand Total:
							<span x-text="grandTotal.toLocaleString()"></span>
						</p>
						<input type="hidden" name="total_amount" x-model="grandTotal">
					</div>
				</div>

				<div class="mt-6 flex justify-end gap-2">
					<a href="{{ route('purchase-order.index') }}"
						class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">Cancel</a>
					<button type="submit"
						class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 cursor-pointer">Add</button>
				</div>
			</form>

		</div>

		<!-- Alpine.js Component -->
		<script>
			function poItems() {
				return {
					items: [{
						product_id: '',
						qty: 1,
						price: 0,
						total: 0
					}],

					addRow() {
						this.items.push({
							product_id: '',
							qty: 1,
							price: 0,
							total: 0
						});
					},

					removeRow(index) {
						this.items.splice(index, 1);
						this.calculateGrandTotal();
					},

					updateRow(index) {
						let item = this.items[index];
						item.total = item.qty * item.price;
						this.calculateGrandTotal();
					},

					get grandTotal() {
						return this.items.reduce((sum, item) => sum + Number(item.total), 0);
					},

					calculateGrandTotal() {
						// simply triggers computed getter
					}
				}
			}
		</script>

	</div>
@endsection
