<div class="flex flex-col gap-4">
	<h2 class="text-xl font-semibold mb-2">
		{{ $mode === 'edit' ? 'Edit Customer' : 'Customer Detail' }}
	</h2>

	<form action="{{ route('customer.update', $cs->customer_id) }}" method="POST"
		class="grid grid-cols-1 md:grid-cols-2 gap-4">
		@csrf
		@method('PUT')


		<div>
			<label class="block text-sm text-gray-600">Customer Name</label>
			<input type="text" name="customer_name"
				class="w-full px-3 py-2 border rounded-md focus:border-blue-400 focus:outline-none {{ $mode === 'view' ? 'bg-gray-100 text-gray-500 cursor-not-allowed' : 'bg-white' }}"
				value="{{ $cs->customer_name }}" {{ $mode === 'view' ? 'readonly' : '' }}>
		</div>

		<div>
			<label class="block text-sm text-gray-600">Email</label>
			<input type="email" name="email"
				class="w-full px-3 py-2 border rounded-md focus:border-blue-400 focus:outline-none {{ $mode === 'view' ? 'bg-gray-100 text-gray-500 cursor-not-allowed' : 'bg-white' }}"
				value="{{ $cs->email }}" {{ $mode === 'view' ? 'readonly' : '' }}>
		</div>

		<div>
			<label class="block text-sm text-gray-600">Phone number</label>
			<input type="number" name="phone"
				class="w-full px-3 py-2 border rounded-md focus:border-blue-400 focus:outline-none {{ $mode === 'view' ? 'bg-gray-100 text-gray-500 cursor-not-allowed' : 'bg-white' }}"
				value="{{ $cs->phone }}" {{ $mode === 'view' ? 'readonly' : '' }}>
		</div>


		<div>
			<label class="block text-sm text-gray-600">Status</label>
			<select name="status"
				class="w-full px-3 py-2 border rounded-md focus:border-blue-400 focus:outline-none {{ $mode === 'view' ? 'bg-gray-100 text-gray-500 cursor-not-allowed' : 'bg-white' }}"
				{{ $mode === 'view' ? 'disabled' : '' }}>
				<option value="0" {{ $cs->status == 0 ? 'selected' : '' }}>Inactive</option>
				<option value="1" {{ $cs->status == 1 ? 'selected' : '' }}>Active</option>
			</select>
		</div>

		{{-- Address --}}
		<div class="md:col-span-2">
			<label class="block text-sm text-gray-600">Address</label>
			<textarea name="address" rows="3"
			 class="w-full px-3 py-2 border rounded-md focus:border-blue-400 focus:outline-none {{ $mode === 'view' ? 'bg-gray-100 text-gray-500 cursor-not-allowed' : 'bg-white' }}"
			 {{ $mode === 'view' ? 'readonly' : '' }}>{{ $cs->address }}</textarea>
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
</div>
