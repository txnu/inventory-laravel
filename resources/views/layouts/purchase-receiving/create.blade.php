@extends('layout')

@section('content')
	<div class="w-full px-6 py-6">
		<div class="bg-white p-6 rounded-lg shadow-md">
			<h2 class="text-xl font-semibold mb-4">Create purchase receiving</h2>

			<form action="{{ route('purchase-receiving.store') }}" method="POST" enctype="multipart/form-data">
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
						<select id="po_id" name="po_id"
							class="w-full px-3 py-2 border rounded-md focus:border-blue-400 focus:outline-none">
							<option value="0">Select PO</option>
							@foreach ($purchase_orders as $po)
								<option value="{{ $po->po_id }}">
									{{ $po->po_code }}
								</option>
							@endforeach
						</select>
					</div>

					{{-- Receiving code --}}
					<div>
						<label class="block text-sm text-gray-600">Receiving code</label>
						<input type="text" name="receiving_code" value="{{ $receiving_code }}"
							class="uppercase cursor-not-allowed bg-gray-200 w-full px-3 py-2 border rounded-md focus:border-blue-500 focus:ring-blue-500 focus:outline-none"
							readonly>
					</div>

					{{-- Receiving date --}}
					<div>
						<label class="block text-sm text-gray-600">Receiving date</label>
						<input type="date" name="receiving_date" value="{{ date('Y-m-d') }}"
							class="w-full px-3 py-2 border bg-gray-100 cursor-not-allowed rounded-md focus:border-blue-500 focus:ring-blue-500 focus:outline-none"
							readonly>
					</div>

					{{-- Receiving by --}}
					<div>
						<label class="block text-sm text-gray-600">Receiving by</label>
						<select name="supplier_id" class="w-full px-3 py-2 border rounded-md focus:border-blue-400 focus:outline-none">
							@foreach ($users as $u)
								<option value="{{ $u->user_id }}">
									{{ $u->name }}
								</option>
							@endforeach

						</select>
					</div>
				</div>

				{{-- PO Items --}}

				<div id="po-details" class="hidden mt-6">
					<h3 class="text-lg font-semibold my-3">PO Details</h3>

					<div id="supplier_name" class="mb-2"></div>
					<div id="order_date" class="mb-3"></div>

					<table class="w-full text-sm" id="po-items-table">
						<thead class="bg-gray-100 text-left items-start">
							<tr class="border-t border-b border-gray-400">
								<th class="px-2 py-2 w-1/3">Product</th>
								<th class="px-2 py-2 w-24">Ordered</th>
								<th class="px-2 py-2 w-24">Received</th>
								<th class="px-2 py-2 w-32">Receive Now</th>
								<th class="px-2 py-2 w-32">Note</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>

				<div class="mt-6 flex justify-end gap-2">
					<a href="{{ route('purchase-receiving.index') }}"
						class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">Cancel</a>
					<button type="submit"
						class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 cursor-pointer">Add</button>
				</div>
			</form>
			<!-- Alpine.js Component -->
			<script>
				document.getElementById("po_id").addEventListener("change", function() {
					let id = this.value;
					if (!id) return;

					fetch(`/purchase-receiving/get-po/${id}`)
						.then(res => res.json())
						.then(data => {
							console.log(data);

							if (!data.status) {
								alert("PO Code not found");
								return;
							}

							let po = data.po;

							document.getElementById("po-details").classList.remove("hidden");

							document.getElementById("supplier_name").innerHTML =
								`<strong>Supplier: </strong> ${po.supplier.supplier_name}`;

							document.getElementById("order_date").innerHTML =
								`<strong>Order Date: </strong> ${po.order_date}`;

							let tbody = document.querySelector("#po-items-table tbody");
							tbody.innerHTML = "";

							po.items.forEach((item, index) => {
								tbody.innerHTML += `

					<tr class="border-b border-gray-400">
						<td class="px-2 py-2" value="${item.product.product_id}">${item.product.product_name}</td>
						<td class="px-2 py-2">${item.qty_ordered}</td>
						<td class="px-2 py-2">${item.qty_received}</td>
						<td class="px-2 py-2">
                            <input type="hidden"
								name="items[${index}][po_item_id]" value="${item.po_item_id}">
							<input type="number"
								name="items[${index}][qty_received_now]"
								min="0"
								max="${item.qty_ordered - item.qty_received}"
								class="border rounded px-2 py-1 w-24">
						</td>
                        <td class="px-2 py-2">
						    <input type="text" name="items[${index}][note]" class="border rounded px-2 py-1 w-full">
                        </td>
					</tr>
				`;
							});
						});
				});
			</script>
		</div>
	</div>

@endsection
