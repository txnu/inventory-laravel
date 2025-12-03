<div class="flex flex-col gap-4">
	<h2 class="text-xl font-semibold mb-2">
		{{ $mode === 'edit' ? 'Edit Category' : 'Category Detail' }}
	</h2>

	<form action="{{ route('category.update', $category->category_id) }}" method="POST"
		class="grid grid-cols-1 md:grid-cols-2 gap-4">
		@csrf
		@method('PUT')

		{{-- Category Name --}}
		<div>
			<label class="block text-sm text-gray-600">Category Name</label>
			<input type="text" name="category_name"
				class="w-full px-3 py-2 border rounded-md focus:border-blue-400 focus:outline-none {{ $mode === 'view' ? 'bg-gray-100 text-gray-500 cursor-not-allowed' : 'bg-white' }}"
				value="{{ $category->category_name }}" {{ $mode === 'view' ? 'readonly' : '' }}>
		</div>

		{{-- Description --}}
		<div class="md:col-span-2">
			<label class="block text-sm text-gray-600">Description</label>
			<textarea name="description" rows="3"
			 class="w-full px-3 py-2 border rounded-md focus:border-blue-400 focus:outline-none {{ $mode === 'view' ? 'bg-gray-100 text-gray-500 cursor-not-allowed' : 'bg-white' }}"
			 {{ $mode === 'view' ? 'readonly' : '' }}>{{ $category->description }}</textarea>
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
