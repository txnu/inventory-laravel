@php
	$locked = in_array($po->status, ['received', 'closed', 'canceled']);
	$itemsJson = json_encode($items, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
@endphp


<div class="flex flex-col gap-4 max-h-[80vh] overflow-y-auto">
	<h2 class="text-xl font-semibold mb-2">
		Edit Purchase Order
	</h2>

	<form action="{{ route('purchase-order.update', $po->po_id) }}" method="POST"
		class="grid grid-cols-1 md:grid-cols-2 gap-4">
		@csrf
		@method('PUT')

		{{-- Po code --}}
		<div>
			<label class="block text-sm text-gray-600">PO Code</label>
			<input type="text" name="po_code"
				class="w-full px-3 py-2 border border-gray-400 rounded-md focus:border-blue-400 focus:outline-none bg-gray-100 text-gray-500 cursor-not-allowed"
				value="{{ $po->po_code }}" readonly>
		</div>


		{{-- Supplier --}}
		<div>
			<label class="block text-sm text-gray-600">Supplier Name</label>
			<select name="supplier_id"
				class="w-full px-3 py-2 border border-gray-400 rounded-md focus:border-blue-400 focus:outline-none">
				@foreach ($supplier as $s)
					<option value="{{ $s->supplier_id }}" {{ $po->supplier_id == $s->supplier_id ? 'selected' : '' }}>
						{{ $s->supplier_name }}
					</option>
				@endforeach
			</select>
		</div>

		{{-- Order date --}}
		<div>
			<label class="block text-sm text-gray-600">Order date</label>
			<input type="date" name="order_date"
				class="w-full px-3 py-2 border border-gray-400 rounded-md focus:border-blue-400 focus:outline-none bg-white"
				value="{{ $po->order_date }}">
		</div>

		{{-- Delivery date --}}
		<div>
			<label class="block text-sm text-gray-600">Delivery date</label>
			<input type="date" name="delivery_date"
				class="w-full px-3 py-2 border border-gray-400 rounded-md focus:border-blue-400 focus:outline-none bg-white"
				value="{{ $po->delivery_date }}">
		</div>

		{{-- Status --}}
		<div>
			<label class="block text-sm text-gray-600">Status</label>
			<select name="status" class="w-full px-3 py-2 border border-gray-400 rounded-md">
				@foreach (['draft', 'ordered', 'received', 'closed', 'canceled'] as $status)
					<option value="{{ $status }}" {{ $po->status === $status ? 'selected' : '' }}>
						{{ ucfirst($status) }}
					</option>
				@endforeach
			</select>
		</div>

		{{-- Note --}}
		<div class="md:col-span-2">
			<label class="block text-sm text-gray-600">Notes</label>
			<textarea name="notes" rows="3"
			 class="w-full px-3 py-2 border border-gray-400 rounded-md focus:border-blue-400 focus:outline-none bg-white">{{ $po->notes }}</textarea>
		</div>

		<div x-data='poItems({!! $itemsJson !!})' class="mt-8 md:col-span-2">

			<h3 class="text-lg font-semibold mb-2">Purchase Order Items</h3>

			<div class="max-h-[50vh] overflow-y-auto">
				<table class="w-full text-sm">
					<thead class="bg-gray-100">
						<tr class="border-t border-gray-400">
							<th class="px-2 py-2 w-1/3">Product</th>
							<th class="px-2 py-2 w-24">Qty</th>
							<th class="px-2 py-2 w-32">Price</th>
							<th class="px-2 py-2 w-32">Total (Rp)</th>
							<th class="px-2 py-2 w-16">#</th>
						</tr>
					</thead>

					<tbody>
						<template x-for="(item, index) in items" :key="index">
							<tr class="border-t border-b border-gray-400">
								<td class="px-2 py-2">
									<select x-model="item.product_id" :name="`items[${index}][product_id]`"
										class="w-full border border-gray-400 rounded-md px-2 py-1" {{ $locked ? 'disabled' : '' }}>
										<option value="">Select Product</option>
										@foreach ($product as $p)
											<option value="{{ $p->product_id }}">
												{{ $p->product_name }}
											</option>
										@endforeach
									</select>
								</td>

								<td class="px-2 py-2">
									<input type="number" min="1" x-model="item.qty_ordered" @input="updateRow(index)"
										:name="`items[${index}][qty_ordered]`" class="w-full border border-gray-400 rounded-md px-2 py-1"
										{{ $locked ? 'disabled' : '' }}>
								</td>

								<td class="px-2 py-2">
									<input type="number" min="0" x-model="item.price" @input="updateRow(index)"
										:name="`items[${index}][price]`" class="w-full border border-gray-400 rounded-md px-2 py-1"
										{{ $locked ? 'disabled' : '' }}>
								</td>

								<td class="px-2 py-2">
									<input type="number" x-model="item.total" :name="`items[${index}][total]`"
										class="w-full border border-gray-400 rounded-md px-2 py-1 bg-gray-100" readonly>
								</td>

								<td class="px-2 py-2 text-center">
									<button type="button" @click="removeRow(index)" class="text-center text-red-500 font-bold cursor-pointer"
										{{ $locked ? 'disabled' : '' }}>
										<x-heroicon-o-trash class="w-5 h-5" />
									</button>
								</td>
							</tr>
						</template>
					</tbody>
				</table>
			</div>

			@if (!$locked)
				<button type="button" @click="addRow()" class="mt-3 px-3 py-1 bg-blue-600 text-white rounded-md">
					+ Add Item
				</button>
			@endif

			<div class="mt-4 text-right">
				<p class="text-lg font-semibold">
					Grand Total: Rp
					<span x-text="grandTotal.toLocaleString()"></span>
				</p>
				<input type="hidden" name="total_amount" x-model="grandTotal">
			</div>

		</div>


		{{-- Action buttons --}}

		<div class="md:col-span-2 flex justify-end gap-4 mt-3">
			<button @click="closeModal()" class="px-3 py-2 border border-red-500 text-black rounded-md hover:bg-red-100">
				Cancel
			</button>
			<button type="submit"
				class="px-3 py-2 rounded-md font-medium transition-colors duration-150 bg-blue-600 text-white hover:bg-blue-800  {{ $locked ? 'cursor-not-allowed' : 'cursor-pointer' }}"
				{{ $locked ? 'disabled' : '' }}>
				Update
			</button>
		</div>

	</form>
</div>

{{-- <pre>{{ json_encode($items, JSON_PRETTY_PRINT) }}</pre> --}}
