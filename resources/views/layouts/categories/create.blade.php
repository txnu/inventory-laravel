@extends('layout')

@section('content')
	<div class="w-full px-6 py-6">
		<div class="bg-white p-6 rounded-lg shadow-md">
			<h2 class="text-xl font-semibold mb-4">Add Category</h2>

			<form action="{{ route('category.store') }}" method="POST">
				@csrf

				<div class="grid grid-cols-2 gap-4">
					<div>
						<label class="block text-sm text-gray-600">Category Name</label>
						<input type="text" name="category_name"
							class="w-full px-3 py-2 border rounded-md focus:border-blue-500 focus:ring-blue-500 focus:outline-none" required>
					</div>
				</div>

				<div class="mt-4">
					<label class="block text-sm font-medium text-gray-700">Description</label>
					<textarea name="description" rows="3"
					 class="mt-1 block w-full px-3 py-2 rounded-md border border-black focus:ring-blue-500 focus:border-blue-500"></textarea>
				</div>

				<div class="mt-6 flex justify-end gap-2">
					<a href="{{ route('category.index') }}"
						class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">Cancel</a>
					<button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Add</button>
				</div>
			</form>
		</div>
	</div>
@endsection
