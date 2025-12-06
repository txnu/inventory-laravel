<div class="flex flex-col gap-4">
	<h2 class="text-xl font-semibold mb-2">
		{{ $mode === 'edit' ? 'Edit Warehouse' : 'Warehouse Detail' }}
	</h2>

	<form action="{{ route('warehouse.update', $w->warehouse_id) }}" method="POST"
		class="grid grid-cols-1 md:grid-cols-2 gap-4">
		@csrf
		@method('PUT')


		<div>
			<label class="block text-sm text-gray-600">Warehouse code</label>
			<input type="text" name="warehouse_code"
				class="w-full px-3 py-2 border rounded-md focus:border-blue-400 focus:outline-none {{ $mode === 'view' ? 'bg-gray-100 text-gray-500 cursor-not-allowed' : 'bg-white' }}"
				value="{{ $w->warehouse_code }}" {{ $mode === 'view' ? 'readonly' : '' }}>
		</div>

		<div>
			<label class="block text-sm text-gray-600">Warehouse name</label>
			<input type="text" name="warehouse_name"
				class="w-full px-3 py-2 border rounded-md focus:border-blue-400 focus:outline-none {{ $mode === 'view' ? 'bg-gray-100 text-gray-500 cursor-not-allowed' : 'bg-white' }}"
				value="{{ $w->warehouse_name }}" {{ $mode === 'view' ? 'readonly' : '' }}>
		</div>

		<div>
			<label class="block text-sm text-gray-600">Address</label>
			<input type="text" name="address"
				class="w-full px-3 py-2 border rounded-md focus:border-blue-400 focus:outline-none {{ $mode === 'view' ? 'bg-gray-100 text-gray-500 cursor-not-allowed' : 'bg-white' }}"
				value="{{ $w->address }}" {{ $mode === 'view' ? 'readonly' : '' }}>
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
				<option value="{{ $w->province }}">Select province</option>
			</select>
		</div>

		<div>
			<label class="block text-sm text-gray-600">City</label>
			<select name="city" id="city"
				class="w-full px-3 py-2 border rounded-md focus:border-blue-500 focus:ring-blue-500" required>
				<option value="{{ $w->province }}">Select city</option>
			</select>
		</div>
		<div>
			<label class="block text-sm text-gray-600">Postal code</label>
			<input type="text" name="province"
				class="w-full px-3 py-2 border rounded-md focus:border-blue-400 focus:outline-none {{ $mode === 'view' ? 'bg-gray-100 text-gray-500 cursor-not-allowed' : 'bg-white' }}"
				value="{{ $w->postal_code }}" {{ $mode === 'view' ? 'readonly' : '' }}>
		</div>

		<div>
			<label class="block text-sm text-gray-600">Status</label>
			<select name="is_active"
				class="w-full px-3 py-2 border rounded-md focus:border-blue-400 focus:outline-none {{ $mode === 'view' ? 'bg-gray-100 text-gray-500 cursor-not-allowed' : 'bg-white' }}"
				{{ $mode === 'view' ? 'disabled' : '' }}>
				<option value="0" {{ $w->is_active == 0 ? 'selected' : '' }}>Inactive</option>
				<option value="1" {{ $w->is_active == 1 ? 'selected' : '' }}>Active</option>
			</select>
		</div>

		{{-- Address --}}
		<div class="md:col-span-2">
			<label class="block text-sm text-gray-600">Description</label>
			<textarea name="description" rows="3"
			 class="w-full px-3 py-2 border rounded-md focus:border-blue-400 focus:outline-none {{ $mode === 'view' ? 'bg-gray-100 text-gray-500 cursor-not-allowed' : 'bg-white' }}"
			 {{ $mode === 'view' ? 'readonly' : '' }}>{{ $w->description }}</textarea>
		</div>



		{{-- Action buttons --}}

		<div class="md:col-span-2 flex justify-end gap-4 mt-3">
			<button @click="closeModal()" class="px-3 py-2 border border-red-500 text-black rounded-md hover:bg-red-100">
				Cancel
			</button>
			<button type="submit"
				class="px-3 py-2 rounded-md font-medium transition-colors duration-150 {{ $mode === 'view' ? 'bg-blue-100 text-black cursor-not-allowed' : 'bg-blue-600 text-white hover:bg-blue-800 cursor-pointer' }}"
				@if ($mode === 'view') disabled @endif>
				Update
			</button>
		</div>

	</form>
	<script>
		document.addEventListener("DOMContentLoaded", function() {

			const country = document.getElementById("country");
			const province = document.getElementById("province");
			const city = document.getElementById("city");

			const selectedProvince = "{{ $w->province }}";
			const selectedCity = "{{ $w->city }}";

			// AUTO LOAD IF EDIT MODE
			if (country.value === "Indonesia") {
				loadProvinces().then(() => {
					if (selectedProvince) {
						province.value = selectedProvince;
						loadCities(selectedProvince).then(() => {
							if (selectedCity) {
								city.value = selectedCity;
							}
						});
					}
				});
			}

			country.addEventListener("change", function() {
				if (this.value === "Indonesia") {
					loadProvinces();
				}
			});

			function loadProvinces() {
				return fetch("https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json")
					.then(response => response.json())
					.then(data => {
						province.innerHTML = `<option value="">Select province</option>`;
						city.innerHTML = `<option value="">Select city</option>`;

						data.forEach(prov => {
							province.innerHTML += `<option value="${prov.id}">${prov.name}</option>`;
						});
					});
			}

			province.addEventListener("change", function() {
				let provID = this.value;
				if (provID) {
					loadCities(provID);
				}
			});

			function loadCities(provID) {
				return fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${provID}.json`)
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
