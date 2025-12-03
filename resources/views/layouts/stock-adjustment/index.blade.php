@extends('layout')

@section('content')
	<div class="relative w-full px-4 py-3">
		<div class="min-h-screen w-full bg-white rounded-2xl p-6">
			@if (session('success'))
				<div class="mb-4 px-5 py-3 text-green-800 bg-green-100 rounded-md">
					{{ session('success') }}
				</div>
			@endif

			<div class="flex flex-col gap-4">

				{{-- Header Table --}}
				<div class="flex justify-between items-center gap-4">
					<div class="flex items-center gap-2">
						<input type="text" placeholder="Cari Produk..."
							class="px-3 py-2 text-sm rounded-3xl border border-gray-300 focus:border-blue-400 focus:outline-none">
					</div>
					<div class="flex items-center gap-2">
						<button class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 cursor-pointer">
							<x-zondicon-printer class="w-5" />
						</button>
						<a href="{{ route('stock-adjustment.create') }}"
							class="px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-800 cursor-pointer">
							<x-heroicon-o-plus class="w-5" />
						</a>
					</div>
				</div>
				{{-- End Header Table --}}

				{{-- Table Content --}}
				<div class="overflow-x-auto relative min-h-screen">
					<table class="w-full text-left border-collapse">
						<thead>
							<tr class="text-sm border-b text-gray-500">
								<th class="py-2 px-2">Date</th>
								<th class="py-2 px-2">Product Name</th>
								<th class="py-2 px-2">System Qty</th>
								<th class="py-2 px-2">Physical Qty</th>
								<th class="py-2 px-2">Difference</th>
								<th class="py-2 px-2">Reason</th>
								<th class="py-2 px-2">Author</th>

							</tr>
						</thead>
						<tbody>
							@foreach ($stock_adjustment as $sa)
								<tr class="text-sm text-gray-700 border-b hover:bg-gray-50">
									<td class="py-2 px-2">{{ $sa->created_at }}</td>
									<td class="py-2 px-2">{{ $sa->product->product_name }}</td>
									<td class="py-2 px-2">{{ $sa->system_qty }}</td>
									<td class="py-2 px-2">{{ $sa->physical_qty }}</td>
									<td class="py-2 px-2">{{ $sa->difference }}</td>
									<td class="py-2 px-2">{{ $sa->reason }}</td>
									<td class="py-2 px-2">{{ $sa->performedBy->name }}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				{{-- End Table Content --}}

			</div>
		</div>
	</div>
@endsection
