@extends('layout')

@section('content')
	<div class="w-full px-6 py-6">
		<div class="bg-white p-6 rounded-lg shadow-md">
			<h2 class="text-xl font-semibold mb-4">Create new supplier</h2>

			<form action="{{ route('supplier.store') }}" method="POST" enctype="multipart/form-data">
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
					<div>
						<label class="block text-sm text-gray-600">Supplier name</label>
						<input type="text" name="supplier_name"
							class="w-full px-3 py-2 border rounded-md focus:border-blue-500 focus:ring-blue-500 focus:outline-none" required>
					</div>
					<div>
						<label class="block text-sm text-gray-600">Contact name</label>
						<input type="text" name="contact_name"
							class="uppercase w-full px-3 py-2 border rounded-md focus:border-blue-500 focus:ring-blue-500 focus:outline-none"
							required>
					</div>

					<div>
						<label class="block text-sm text-gray-600">Email</label>
						<input type="email" name="email"
							class="w-full px-3 py-2 border rounded-md focus:border-blue-500 focus:ring-blue-500 focus:outline-none">
					</div>

					<div>
						<label class="block text-sm text-gray-600">Number phone</label>
						<input type="number" name="selling_price"
							class="w-full px-3 py-2 border rounded-md focus:border-blue-500 focus:ring-blue-500 focus:outline-none" required>
					</div>

					<div>
						<label class="block text-sm text-gray-600">Status</label>
						<select name="is_active" class="w-full px-3 py-2 border rounded-md focus:border-blue-400 focus:outline-none">
							<option value="0">Inactive</option>
							<option value="1">Active</option>
						</select>
					</div>
				</div>


				<div class="mt-4">
					<label class="block text-sm font-medium text-gray-700">Address</label>
					<textarea name="address" rows="3"
					 class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
					 required></textarea>
				</div>

				<div class="mt-6 flex justify-end gap-2">
					<a href="{{ route('supplier.index') }}"
						class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">Cancel</a>
					<button type="submit"
						class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 cursor-pointer">Add</button>
				</div>
			</form>
		</div>
	</div>
@endsection
