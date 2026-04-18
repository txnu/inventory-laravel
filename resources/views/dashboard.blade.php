@extends('layout')

@section('content')
	<section class="w-full px-6 py-6 space-y-6">
		<!-- Judul halaman -->
		<div class="flex items-center justify-between">
			<h1 class="text-2xl font-semibold text-gray-800">Dashboard Overview</h1>
			<p class="text-sm text-gray-500">Welcome back, {{ Auth::user()->name ?? 'User' }} 👋</p>
		</div>

		<!-- Statistik Ringkas -->
		<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
			<div class="bg-white rounded-2xl shadow-sm p-5 border border-gray-100 flex flex-col gap-2">
				<div class="flex items-center justify-between">
					<h2 class="text-sm text-gray-500">Total Products</h2>
					<i class="fa-solid fa-box text-blue-500"></i>
				</div>
				<p class="text-2xl font-semibold text-gray-800">{{ $product_count }}</p>
				<span class="text-xs text-green-600">+12% from last month</span>
			</div>

			<div class="bg-white rounded-2xl shadow-sm p-5 border border-gray-100 flex flex-col gap-2">
				<div class="flex items-center justify-between">
					<h2 class="text-sm text-gray-500">Total Sales</h2>
					<i class="fa-solid fa-money-bill-wave text-green-500"></i>
				</div>
				<p class="text-2xl font-semibold text-gray-800">Rp 22.900.000</p>
				<span class="text-xs text-green-600">+5% this week</span>
			</div>

			<div class="bg-white rounded-2xl shadow-sm p-5 border border-gray-100 flex flex-col gap-2">
				<div class="flex items-center justify-between">
					<h2 class="text-sm text-gray-500">Pending Orders</h2>
					<i class="fa-solid fa-clock text-yellow-500"></i>
				</div>
				<p class="text-2xl font-semibold text-gray-800">32</p>
				<span class="text-xs text-yellow-600">3 awaiting confirmation</span>
			</div>

			<div class="bg-white rounded-2xl shadow-sm p-5 border border-gray-100 flex flex-col gap-2">
				<div class="flex items-center justify-between">
					<h2 class="text-sm text-gray-500">Low Stock Items</h2>
					<i class="fa-solid fa-triangle-exclamation text-red-500"></i>
				</div>
				<p class="text-2xl font-semibold text-gray-800">8</p>
				<span class="text-xs text-red-600">Restock recommended</span>
			</div>
		</div>

		<!-- Recent Activity / Table -->
		<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
			<h2 class="text-lg font-semibold text-gray-800 mb-4">Recent Transactions</h2>
			<table class="w-full text-left border-collapse">
				<thead>
					<tr class="text-sm text-gray-400 border-b">
						<th class="py-2">Date</th>
						<th class="py-2">Customer</th>
						<th class="py-2">Items</th>
						<th class="py-2">Total</th>
						<th class="py-2 text-right">Status</th>
					</tr>
				</thead>
				<tbody class="text-sm text-gray-700">
					<tr class="border-b border-b-gray-300 hover:bg-gray-50">
						<td class="py-2">11 Oct 2025</td>
						<td class="py-2">PT. Nusantara</td>
						<td class="py-2">14</td>
						<td class="py-2">Rp 2.480.000</td>
						<td class="py-2 text-right text-green-600 font-medium">Completed</td>
					</tr>
					<tr class="border-b border-b-gray-300 hover:bg-gray-50">
						<td class="py-2">10 Oct 2025</td>
						<td class="py-2">Kedra Store</td>
						<td class="py-2">8</td>
						<td class="py-2">Rp 920.000</td>
						<td class="py-2 text-right text-yellow-600 font-medium">Pending</td>
					</tr>
					<tr class="hover:bg-gray-50">
						<td class="py-2">09 Oct 2025</td>
						<td class="py-2">CV. Mekar Abadi</td>
						<td class="py-2">5</td>
						<td class="py-2">Rp 550.000</td>
						<td class="py-2 text-right text-red-600 font-medium">Canceled</td>
					</tr>
				</tbody>
			</table>
		</div>
	</section>
@endsection
