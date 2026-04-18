@php
	$locked = in_array($pr->status, ['received', 'closed', 'canceled', 'partial']);
	$itemsJson = json_encode($items, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
@endphp


<div class="flex flex-col gap-4">
	<h2 class="text-xl font-semibold mb-2">
		Detail Purchase Receiving
	</h2>

	<form action="{{ route('purchase-receiving.update', $pr->pr_id) }}" method="POST"
		class="grid grid-cols-1 md:grid-cols-2 gap-4">
		@csrf
		@method('PUT')

		{{-- Po code --}}
		<div>
			<label class="block text-sm text-gray-600">PR Code</label>
			<input type="text" name="po_code"
				class="w-full px-3 py-2 border rounded-md focus:border-blue-400 focus:outline-none bg-gray-100 text-gray-500 cursor-not-allowed"
				value="{{ $pr->receiving_code }}" readonly>
		</div>

		{{-- Delivery date --}}
		<div>
			<label class="block text-sm text-gray-600">Delivery date</label>
			<input type="date" name="delivery_date"
				class="w-full px-3 py-2 border rounded-md focus:border-blue-400 focus:outline-none bg-gray-100 text-gray-500 cursor-not-allowed"
				value="{{ $pr->receiving_date }}" readonly>
		</div>



		{{-- Status --}}
		<div>
			<label class="block text-sm text-gray-600">Status</label>
			<input type="text" name="status"
				class="w-full px-3 py-2 border rounded-md bg-gray-100 text-gray-500 cursor-not-allowed"
				value="{{ ucfirst($pr->status) }}" readonly>

		</div>

		{{-- Status --}}
		<div>
			<label class="block text-sm text-gray-600">Status</label>
			<input type="text" name="status"
				class="w-full px-3 py-2 border rounded-md bg-gray-100 text-gray-500 cursor-not-allowed"
				value="{{ ucfirst($pr->status) }}" readonly>

		</div>

		<div x-data='prItems({!! $itemsJson !!})' class="mt-8 md:col-span-2">

			<h3 class="text-lg font-semibold mb-2">Purchase Receiving Items</h3>

			<table class="w-full text-sm">
				<thead class="bg-gray-100">
					<tr class="border-t border-b border-gray-300">
						<th class="px-2 py-2 w-1/3">Product</th>
						<th class="px-2 py-2 w-24">Qty Received</th>
						<th class="px-2 py-2 w-32">Note</th>
					</tr>
				</thead>

				<tbody>
					<template x-for="(item, index) in items" :key="index">
						<tr>
							<td class="border-t border-b border-gray-300 px-2 py-2">
								<select x-model="item.product_id" :name="`items[${index}][product_id]`"
									class="w-full border border-gray-300 rounded-md px-2 py-1 bg-gray-100 text-gray-500 cursor-not-allowed"
									{{ $locked ? 'disabled' : '' }} disabled>
									@foreach ($product as $p)
										<option value="{{ $p->product_id }}">
											{{ $p->product_name }}
										</option>
									@endforeach
								</select>
							</td>

							<td class="border-t border-b border-gray-300 px-2 py-2">
								<input type="number" min="1" x-model="item.qty_received" @input="updateRow(index)"
									:name="`items[${index}][qty_received]`"
									class="w-full border border-gray-300  rounded-md px-2 py-1 bg-gray-100 text-gray-500 cursor-not-allowed"
									{{ $locked ? 'disabled' : '' }} readonly>
							</td>

							<td class="border-t border-b border-gray-300 px-2 py-2">
								<input type="text" x-model="item.note" :name="`items[${index}][note]`"
									class="w-full border border-gray-300 rounded-md px-2 py-1 bg-gray-100 text-gray-500 cursor-not-allowed"
									readonly>
							</td>
						</tr>
					</template>
				</tbody>
			</table>

			<div class="mt-4 text-right">
				<p class="text-lg font-semibold">
					Grand Total:
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
		</div>

	</form>
</div>
