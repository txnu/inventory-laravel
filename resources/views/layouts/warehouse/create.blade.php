@extends('layout')

@section('content')
	<div class="w-full px-6 py-6">
		<div class="bg-white p-6 rounded-lg shadow-md">
			<h2 class="text-xl font-semibold mb-4">Create new warehouse</h2>

			<form action="{{ route('warehouse.store') }}" method="POST" enctype="multipart/form-data">
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
						<label class="block text-sm text-gray-600">Warehouse code</label>
						<input type="text" name="warehouse_code" value="{{ $wr_code }}"
							class="uppercase w-full px-3 py-2 border rounded-md bg-gray-200 focus:border-blue-500 focus:ring-blue-500 focus:outline-none"
							readonly required>
					</div>
					<div>
						<label class="block text-sm text-gray-600">Warehouse name</label>
						<input type="text" name="warehouse_name"
							class=" w-full px-3 py-2 border rounded-md focus:border-blue-500 focus:ring-blue-500 focus:outline-none" required>
					</div>

					<div>
						<label class="block text-sm text-gray-600">Description</label>
						<input type="text" name="description"
							class="w-full px-3 py-2 border rounded-md focus:border-blue-500 focus:ring-blue-500 focus:outline-none">
					</div>

					<div>
						<label class="block text-sm text-gray-600">Country</label>
						<select name="country" id="country"
							class="w-full px-3 py-2 border rounded-md focus:border-blue-500 focus:ring-blue-500" required>
							<option value="">Select Country</option>
							<option value="Indonesia">Indonesia</option>
						</select>
					</div>

					<div>
						<label class="block text-sm text-gray-600">Province</label>
						<select name="province" id="province"
							class="w-full px-3 py-2 border rounded-md focus:border-blue-500 focus:ring-blue-500" required>
							<option value="">Select province</option>
						</select>
					</div>

					<div>
						<label class="block text-sm text-gray-600">City</label>
						<select name="city" id="city"
							class="w-full px-3 py-2 border rounded-md focus:border-blue-500 focus:ring-blue-500" required>
							<option value="">Select city</option>
						</select>
					</div>

					<div>
						<label class="block text-sm text-gray-600">Postal code</label>
						<input type="number" name="postal_code"
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
					<a href="{{ route('warehouse.index') }}"
						class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">Cancel</a>
					<button type="submit"
						class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 cursor-pointer">Add</button>
				</div>
			</form>
			<script>
				document.addEventListener("DOMContentLoaded", function() {

					const country = document.getElementById("country");
					const province = document.getElementById("province");
					const city = document.getElementById("city");

					// Jika memilih negara "Indonesia"
					country.addEventListener("change", function() {
						if (this.value === "Indonesia") {
							loadProvinces();
						}
					});

					// Load daftar provinsi
					function loadProvinces() {
						fetch("https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json")
							.then(response => response.json())
							.then(data => {
								province.innerHTML = `<option value="">Select province</option>`;
								city.innerHTML = `<option value="">Select city</option>`;

								data.forEach(prov => {
									province.innerHTML += `<option value="${prov.id}">${prov.name}</option>`;
								});
							});
					}

					// Ketika memilih provinsi → load kota otomatis
					province.addEventListener("change", function() {
						let provID = this.value;
						if (provID) {
							loadCities(provID);
						}
					});

					// Load daftar kota berdasarkan provinsi
					function loadCities(provID) {
						fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${provID}.json`)
							.then(response => response.json())
							.then(data => {
								city.innerHTML = `<option value="">Select city</option>`;
								data.forEach(kota => {
									city.innerHTML += `<option value="${kota.id}">${kota.name}</option>`;
								});
							});
					}
				});
			</script>

		</div>
	</div>
@endsection
