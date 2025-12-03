@extends('layout')

@section('content')
	<div class="w-full px-6 py-6">
		<div class="bg-white p-6 rounded-lg shadow-md">
			<h2 class="text-xl font-semibold mb-4">Stock Adjustment</h2>

			<form action="{{ route('stock-adjustment.store') }}" method="POST">
				@csrf

				@if ($errors->any())
					<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-md mb-4">
						<ul>
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				@endif


				<div class="grid grid-cols-2 gap-4">
					<div>
						<label class="block text-sm text-gray-600">Product Name</label>
						<select name="product_id" class="w-full px-3 py-2 border rounded-md focus:border-blue-400 focus:outline-none">
							<option value="0">
								Select Product
							</option>
							@foreach ($product as $p)
								<option value="{{ $p->product_id }}">
									{{ $p->product_name }}
								</option>
							@endforeach
						</select>
					</div>

					<div>
						<label class="block text-sm text-gray-600">System Qty</label>
						<input type="number" id="system_qty" name="system_qty" class="w-full px-3 py-2 border rounded-md" disabled>
					</div>

					<div>
						<label class="block text-sm text-gray-600">Physical Qty</label>
						<input type="number" name="physical_qty"
							class="w-full px-3 py-2 border rounded-md focus:border-blue-500 focus:ring-blue-500 focus:outline-none" required>
					</div>

					<div>
						<label class="block text-sm text-gray-600">Quantity</label>
						<input type="number" name="qty_on_hand"
							class="w-full px-3 py-2 border rounded-md focus:border-blue-500 focus:ring-blue-500 focus:outline-none">
					</div>
				</div>

				<div class="mt-4">
					<label class="block text-sm font-medium text-gray-700">Reason</label>
					<textarea name="reason" rows="3"
					 class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
					 required></textarea>
				</div>

				<div class="mt-6 flex justify-end gap-2">
					<a href="{{ route('stock-adjustment.index') }}"
						class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">Cancel</a>
					<button type="submit"
						class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 cursor-pointer">Add</button>
				</div>
			</form>
		</div>
	</div>

	<script>
		document.querySelector('select[name="product_id"]').addEventListener('change', function() {
			let productId = this.value;

			fetch(`/stock/get-qty/${productId}`)
				.then(res => res.json())
				.then(data => {
					document.getElementById('system_qty').value = data.qty;
				});
		});
	</script>

@endsection
