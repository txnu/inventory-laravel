<div class="flex flex-col gap-4">
	<h2 class="text-xl font-semibold mb-2">
		{{ $mode === 'edit' ? 'Edit Product' : 'Product Detail' }}
	</h2>

	<form action="{{ route('product.update', $product->product_id) }}" method="POST"
		class="grid grid-cols-1 md:grid-cols-2 gap-4">
		@csrf
		@method('PUT')

		{{-- Product Name --}}
		<div>
			<label class="block text-sm text-gray-600">Product Name</label>
			<input type="text" name="product_name"
				class="w-full px-3 py-2 border rounded-md focus:border-blue-400 focus:outline-none {{ $mode === 'view' ? 'bg-gray-100 text-gray-500 cursor-not-allowed' : 'bg-white' }}"
				value="{{ $product->product_name }}" {{ $mode === 'view' ? 'readonly' : '' }}>
		</div>


		{{-- Category --}}
		<div>
			<label class="block text-sm text-gray-600">Category</label>
			@if ($mode === 'edit')
				<select name="category_id" class="w-full px-3 py-2 border rounded-md focus:border-blue-400 focus:outline-none">
					@foreach ($categories as $c)
						<option value="{{ $c->category_id }}" {{ $product->category_id == $c->category_id ? 'selected' : '' }}>
							{{ $c->category_name }}
						</option>
					@endforeach
				</select>
			@else
				<input type="text" class="w-full px-3 py-2 border rounded-md bg-gray-100"
					value="{{ $product->category->category_name ?? '-' }}" readonly>
			@endif
		</div>

		<div>
			<label class="block text-sm text-gray-600">Purchase price (Rp)</label>
			<input type="text" name="purchase_price"
				class="w-full px-3 py-2 border rounded-md focus:border-blue-400 focus:outline-none {{ $mode === 'view' ? 'bg-gray-100 text-gray-500 cursor-not-allowed' : 'bg-white' }}"
				value="{{ $product->purchase_price }}" {{ $mode === 'view' ? 'readonly' : '' }}>
		</div>

		<div>
			<label class="block text-sm text-gray-600">Selling price (Rp)</label>
			<input type="text" name="selling_price"
				class="w-full px-3 py-2 border rounded-md focus:border-blue-400 focus:outline-none {{ $mode === 'view' ? 'bg-gray-100 text-gray-500 cursor-not-allowed' : 'bg-white' }}"
				value="{{ $product->selling_price }}" {{ $mode === 'view' ? 'readonly' : '' }}>
		</div>

		<div>
			<label class="block text-sm text-gray-600">Status</label>
			<select name="is_active"
				class="w-full px-3 py-2 border rounded-md focus:border-blue-400 focus:outline-none {{ $mode === 'view' ? 'bg-gray-100 text-gray-500 cursor-not-allowed' : 'bg-white' }}"
				{{ $mode === 'view' ? 'disabled' : '' }}>
				<option value="0" {{ $product->is_active == 0 ? 'selected' : '' }}>Inactive</option>
				<option value="1" {{ $product->is_active == 1 ? 'selected' : '' }}>Active</option>
			</select>
		</div>

		<div>
			<label class="block text-sm text-gray-600">SKU</label>
			<input type="text" name="sku"
				class="uppercase w-full px-3 py-2 border rounded-md focus:border-blue-400 focus:outline-none {{ $mode === 'view' ? 'bg-gray-100 text-gray-500 cursor-not-allowed' : 'bg-white' }}"
				value="{{ $product->sku }}" readonly>
		</div>

		{{-- Description --}}
		<div class="md:col-span-2">
			<label class="block text-sm text-gray-600">Description</label>
			<textarea name="description" rows="3"
			 class="w-full px-3 py-2 border rounded-md focus:border-blue-400 focus:outline-none {{ $mode === 'view' ? 'bg-gray-100 text-gray-500 cursor-not-allowed' : 'bg-white' }}"
			 {{ $mode === 'view' ? 'readonly' : '' }}>{{ $product->description }}</textarea>
		</div>

		{{-- Barcode --}}
		<div class="md:col-span-2">
			<label class="block text-sm text-gray-600 ">Barcode</label>
			@if ($mode === 'view')
				<div class="mt-2">
					<img loading="lazy" src="{{ route('barcode.show', $product->barcode) }}" alt="barcode"
						class="h-12 {{ $mode === 'view' ? 'bg-gray-100 text-gray-500 cursor-not-allowed' : 'bg-white' }}">
				</div>
			@else
				<input type="text" name="barcode" value="{{ $product->barcode }}"
					class="w-full px-3 py-2 border rounded-md focus:border-blue-400 focus:outline-none ">
			@endif
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
